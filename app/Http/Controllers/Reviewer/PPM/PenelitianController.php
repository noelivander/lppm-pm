<?php
namespace App\Http\Controllers\Reviewer\PPM;

use Mpdf\Mpdf;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penelitian;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota;
use App\Models\Review;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Timeline;
use App\Models\FormPenilaianLaporanKemajuan;
use App\Models\LaporanKemajuanReview;


class PenelitianController extends Controller
{
    public function index(Request $request)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        // Hanya tampilkan proposal awal (bukan entitas revisi)
        // DAN hanya yang ditugaskan ke reviewer ini
        $baseQuery = Penelitian::where('is_draft', false)
            ->where('is_revised', false)
            ->whereHas('assignedReviewers', function ($q) {
                $q->where('user_id', Auth::id());
            });

        $filterSkemas = (clone $baseQuery)->select('skema')
            ->whereNotNull('skema')
            ->distinct()
            ->orderBy('skema')
            ->pluck('skema');

        $filterYears = (clone $baseQuery)->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        // Opsi status yang ditampilkan di filter
        // Pending  : proposal yang BELUM pernah direview oleh reviewer ini DAN belum penuh 2 review
        // Selesai  : proposal yang SUDAH direview oleh reviewer ini (minimal 1 review oleh reviewer ini)
        $statuses = ['Pending', 'Selesai'];

        if ($search = $request->get('search')) {
            $baseQuery->where('judul', 'like', '%' . $search . '%');
        }

        // Review yang sudah dibuat oleh reviewer saat ini (per proposal)
        $myReviewedIds = Review::where('reviewer_id', auth()->id())
            ->whereNotNull('penelitian_id')
            ->pluck('penelitian_id')
            ->toArray();

        // Proposal yang sudah memiliki >= 2 review (oleh siapa pun)
        $fullReviewedIds = Review::whereNotNull('penelitian_id')
            ->selectRaw('penelitian_id, COUNT(*) as total')
            ->groupBy('penelitian_id')
            ->havingRaw('COUNT(*) >= 2')
            ->pluck('penelitian_id')
            ->toArray();

        if ($status = $request->get('status')) {
            if ($status === 'Selesai') {
                // Proposal yang sudah saya review (apapun status lanjutannya)
                $baseQuery->whereIn('id', $myReviewedIds);
            } elseif ($status === 'Pending') {
                // Proposal yang belum saya review
                $baseQuery->whereNotIn('id', $myReviewedIds);
            }
        }

        if ($skema = $request->get('skema')) {
            $baseQuery->where('skema', $skema);
        }

        if ($year = $request->get('year')) {
            $baseQuery->whereYear('created_at', $year);
        }

        $proposals = $baseQuery->orderByDesc('updated_at')
            ->paginate(10)
            ->withQueryString();

        // Data tambahan untuk tampilan
        $reviews = $myReviewedIds;
        $existingReviews = Review::all();

        // Data sudah tidak dienkripsi, tidak perlu dekripsi

        $filters = $request->only(['search', 'status', 'skema', 'year']);

        return view('reviewer.ppm.penelitian.index', compact(
            'proposals',
            'reviews',
            'existingReviews',
            'timeline',
            'currentDate',
            'filterSkemas',
            'filterYears',
            'statuses',
            'filters'
        ));
    }

    public function revisiIndex(Request $request)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        $reviewerId = Auth::id();

        // Semua reviewer dapat melihat semua proposal revisi
        $baseQuery = Penelitian::with(['user'])
            ->where('is_draft', false)
            ->where('is_revised', true);

        $filterSkemas = (clone $baseQuery)->select('skema')
            ->whereNotNull('skema')
            ->distinct()
            ->orderBy('skema')
            ->pluck('skema');

        $filterYears = (clone $baseQuery)->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        // Untuk reviewer: status filter hanya Pending dan Selesai
        $statuses = ['Pending', 'Selesai'];

        $filters = [
            'search' => $request->get('search'),
            'skema' => $request->get('skema'),
            'year' => $request->get('year'),
            'status' => $request->get('status'),
        ];

        if ($filters['search']) {
            $baseQuery->where('judul', 'like', '%' . $filters['search'] . '%');
        }

        if ($filters['skema']) {
            $baseQuery->where('skema', $filters['skema']);
        }

        if ($filters['year']) {
            $baseQuery->whereYear('created_at', $filters['year']);
        }

        if ($filters['status']) {
            if ($filters['status'] === 'Pending') {
                $baseQuery->whereIn('status', ['Pending', 'Diproses']);
            } else {
                $baseQuery->where('status', $filters['status']);
            }
        }

        // Proposal revisi yang sudah pernah diberi komentar revisi oleh reviewer yang login
        $reviewedRevisionIds = Review::whereNotNull('revision_comment')
            ->where('reviewer_id', auth()->id())
            ->whereNotNull('penelitian_id')
            ->pluck('penelitian_id')
            ->toArray();

        // Proposal revisi yang sudah dikomentari oleh 2 reviewer (penuh)
        $fullReviewedIds = Review::whereNotNull('revision_comment')
            ->whereNotNull('penelitian_id')
            ->select('penelitian_id')
            ->groupBy('penelitian_id')
            ->havingRaw('COUNT(*) >= 2')
            ->pluck('penelitian_id')
            ->toArray();

        $proposals = $baseQuery->orderByDesc('updated_at')
            ->paginate(10)
            ->withQueryString();

        return view('reviewer.ppm.penelitian.revisi.index', compact(
            'proposals',
            'timeline',
            'currentDate',
            'filterSkemas',
            'filterYears',
            'statuses',
            'filters',
            'reviewedRevisionIds',
            'fullReviewedIds'
        ));
    }

    /**
     * Tampilkan form review untuk proposal yang sudah direvisi dosen.
     * Fokus hanya pada ringkasan, tim, dan RAB + keputusan ACC/Tolak & komentar.
     */
    public function revisiReview($id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        $proposal = Penelitian::with(['anggota', 'rab', 'reviews.reviewer', 'revisionParent.reviews.reviewer'])
            ->where('is_revised', true)
            ->findOrFail($id);

        // Batasi maksimal 2 reviewer yang memberi komentar revisi
        $existingRevisionReviews = Review::where('penelitian_id', $proposal->id)
            ->whereNotNull('revision_comment')
            ->get();

        $currentReviewerReview = $existingRevisionReviews
            ->firstWhere('reviewer_id', Auth::id());

        if (!$currentReviewerReview && $existingRevisionReviews->count() >= 2) {
            return redirect()
                ->route('penelitian-rev.revisi.index')
                ->with('error', 'Proposal revisi ini sudah dikomentari oleh 2 reviewer. Anda tidak dapat lagi melakukan peninjauan revisi.');
        }

        // Gunakan proposal asli (sebelum revisi) untuk membaca review & komentar admin
        $originalProposal = $proposal->revisionParent ?: $proposal;

        $proposalYear = $originalProposal->created_at ? $originalProposal->created_at->format('Y') : null;

        [$reviewStart, $reviewEnd] = $this->getReviewWindow($timeline, $proposal);

        // Cek apakah bisa melakukan review revisi:
        // - dalam periode review revisi, dan
        // - period pada timeline sama dengan tahun pembuatan proposal
        $canReview = $timeline &&
            $reviewStart &&
            $reviewEnd &&
            $currentDate >= $reviewStart &&
            $currentDate <= $reviewEnd &&
            $proposalYear &&
            (string) $timeline->period === (string) $proposalYear;

        $anggotaList = $proposal->anggota ?? collect();
        $rabItems = $proposal->rab ?? collect();

        $ketuaTim = Anggota::where('penelitian_id', $id)
            ->where('peran', 'ketua')
            ->first();

        $ketuaTimName = $ketuaTim ? $ketuaTim->nama : '';
        $nidn = $ketuaTim ? $ketuaTim->nidn : '';
        $jabatan = $ketuaTim ? $ketuaTim->jabatan : '';

        $anggotaTim = Anggota::where('penelitian_id', $id)
            ->where('peran', 'anggota')
            ->get();

        $anggotaNames = $anggotaTim->map(function ($anggota) {
            return $anggota->nama;
        })->join(', ');

        $judul = $proposal->judul;
        $biayaUsulan = $proposal->biaya_diusulkan;

        // Tampilkan dokumen proposal revisi
        $fileUrl = Storage::url($proposal->dokumen_proposal);

        // Hasil review revisi untuk reviewer saat ini (jika sudah pernah diisi)
        $review = Review::where('penelitian_id', $id)
            ->where('reviewer_id', Auth::id())
            ->first();

        // Review awal dari kedua reviewer melekat pada proposal asli
        $allReviews = $originalProposal->reviews ?? collect();
        $initialReview = $allReviews->firstWhere('reviewer_id', Auth::id());

        return view('reviewer.ppm.penelitian.revisi.review', [
            'proposal' => $proposal,
            'originalProposal' => $originalProposal,
            'judul' => $judul,
            'biayaUsulan' => $biayaUsulan,
            'fileUrl' => $fileUrl,
            'anggotaList' => $anggotaList,
            'rabItems' => $rabItems,
            'ketuaTimName' => $ketuaTimName,
            'nidn' => $nidn,
            'jabatan' => $jabatan,
            'anggotaNames' => $anggotaNames,
            'timeline' => $timeline,
            'currentDate' => $currentDate,
            'canReview' => $canReview,
            'review' => $review,
            'allReviews' => $allReviews,
            'initialReview' => $initialReview,
        ]);
    }

    /**
     * Simpan komentar review terhadap proposal revisi (tanpa ACC/Tolak).
     */
    public function revisiReviewStore(Request $request, $id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        $proposal = Penelitian::with(['anggota', 'rab'])
            ->where('is_revised', true)
            ->findOrFail($id);

        // Batasi maksimal 2 reviewer yang memberi komentar revisi
        $existingRevisionReviews = Review::where('penelitian_id', $proposal->id)
            ->whereNotNull('revision_comment')
            ->get();

        $currentReviewerReview = $existingRevisionReviews
            ->firstWhere('reviewer_id', Auth::id());

        if (!$currentReviewerReview && $existingRevisionReviews->count() >= 2) {
            return redirect()
                ->route('penelitian-rev.revisi.index')
                ->with('error', 'Proposal revisi ini sudah dikomentari oleh 2 reviewer. Anda tidak dapat lagi menyimpan peninjauan revisi.');
        }

        $proposalYear = $proposal->created_at ? $proposal->created_at->format('Y') : null;

        [$reviewStart, $reviewEnd] = $this->getReviewWindow($timeline, $proposal);

        if (
            !$timeline ||
            !$proposalYear ||
            (string) $timeline->period !== (string) $proposalYear ||
            !$reviewStart ||
            !$reviewEnd ||
            $currentDate < $reviewStart ||
            $currentDate > $reviewEnd
        ) {
            return redirect()
                ->route('penelitian-rev.revisi.index')
                ->with('error', 'Periode review revisi untuk proposal ini telah berakhir atau belum dimulai.');
        }

        $validated = $request->validate([
            'revision_comment' => 'required|string|max:2000',
        ]);

        $review = Review::firstOrCreate(
            [
                'penelitian_id' => $proposal->id,
                'reviewer_id' => Auth::id(),
            ],
            [
                'type' => 'penelitian',
                'reviewer_name' => Auth::user()->name,
                'judul_kegiatan' => $proposal->judul,
                'ketua_tim' => $proposal->ketua_tim ?? null,
                'nidn' => $proposal->nidn ?? null,
                'jabatan' => $proposal->jabatan ?? null,
                'anggota' => null,
                'biaya_usulan' => $proposal->biaya_diusulkan,
            ]
        );

        $review->revision_comment = $validated['revision_comment'];
        $review->save();

        // Hitung total reviewer yang sudah memberi komentar revisi
        $totalRevisionComments = Review::where('penelitian_id', $proposal->id)
            ->whereNotNull('revision_comment')
            ->count();

        // Update status proposal revisi:
        // 1 komentar -> Diproses, 2 komentar -> Selesai
        if ($totalRevisionComments >= 2) {
            $proposal->status = 'Selesai';
        } elseif ($totalRevisionComments === 1 && $proposal->status === 'Pending') {
            $proposal->status = 'Diproses';
        }
        $proposal->save();

        return redirect()
            ->route('penelitian-rev.revisi.index')
            ->with('success', 'Komentar peninjauan revisi berhasil disimpan.');
    }

    public function review($id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        $proposal = Penelitian::with(['anggota', 'rab'])->findOrFail($id);
        $proposalYear = $proposal->created_at ? $proposal->created_at->format('Y') : null;

        [$reviewStart, $reviewEnd] = $this->getReviewWindow($timeline, $proposal);

        // Cek apakah bisa melakukan review:
        // - dalam periode review yang sesuai (proposal awal atau revisi), dan
        // - period pada timeline sama dengan tahun pembuatan proposal
        $canReview = $timeline &&
            $reviewStart &&
            $reviewEnd &&
            $currentDate >= $reviewStart &&
            $currentDate <= $reviewEnd &&
            $proposalYear && (string) $timeline->period === (string) $proposalYear;

        // Cek apakah reviewer saat ini sudah pernah review
        $review = Review::where('penelitian_id', $id)->where('reviewer_id', Auth::id())->first();

        // Jika reviewer belum pernah review, cek apakah sudah ada 2 reviewer
        if (!$review) {
            $totalReviews = Review::where('penelitian_id', $id)->count();
            if ($totalReviews >= 2) {
                return redirect()->route('penelitian-rev.index')
                    ->with('error', 'Proposal ini sudah direview lengkap oleh 2 reviewer. Anda tidak dapat melakukan review lagi.');
            }
        }

        $anggotaList = $proposal->anggota ?? collect();
        $rabItems = $proposal->rab ?? collect();

        $ketuaTim = Anggota::where('penelitian_id', $id)
            ->where('peran', 'ketua')
            ->first();

        $anggotaTim = Anggota::where('penelitian_id', $id)
            ->where('peran', 'anggota')
            ->get();

        $ketuaTimName = $ketuaTim ? $ketuaTim->nama : '';
        $nidn = $ketuaTim ? $ketuaTim->nidn : '';
        $jabatan = $ketuaTim ? $ketuaTim->jabatan : '';

        $anggotaNames = $anggotaTim->map(function ($anggota) {
            return $anggota->nama;
        })->join(', ');

        $judul = $proposal->judul;
        $biayaUsulan = $proposal->biaya_diusulkan;
        $sintaIndex = $proposal->sinta_index;

        // Buat URL publik untuk file proposal
        $fileUrl = Storage::url($proposal->dokumen_proposal);

        // Get active form review criteria for current review (if editing)
        // If review exists, use forms that were active when review was created
        if ($review) {
            // Get existing review criteria scores first
            $reviewKriteria = \App\Models\ReviewKriteria::where('review_id', $review->id)
                ->with('formPenilaianReview')
                ->get()
                ->keyBy('form_penilaian_review_id');

            // Get form criteria that were active when review was created
            if ($reviewKriteria->count() > 0) {
                // Get form IDs from review_kriteria
                $formIds = $reviewKriteria->pluck('form_penilaian_review_id')->toArray();

                // Get forms that were active on review creation date
                $allFormsForDate = \App\Models\FormPenilaianReview::getActiveFormsForDate('penelitian', $review->created_at);

                // Filter to only include forms that were used in this review
                $formKriteria = $allFormsForDate->filter(function ($form) use ($formIds) {
                    return in_array($form->id, $formIds);
                })->sortBy(function ($form) use ($formIds) {
                    return array_search($form->id, $formIds);
                })->values();
            } else {
                // Fallback: use active forms if no review_kriteria exists
                $formKriteria = \App\Models\FormPenilaianReview::where('jenis', 'penelitian')
                    ->where('is_active', true)
                    ->orderBy('urutan')
                    ->get();
            }

            return view('reviewer.ppm.penelitian.edit_review', compact(
                'proposal',
                'review',
                'ketuaTimName',
                'fileUrl',
                'nidn',
                'anggotaNames',
                'jabatan',
                'judul',
                'biayaUsulan',
                'sintaIndex',
                'anggotaList',
                'rabItems',
                'timeline',
                'currentDate',
                'canReview',
                'formKriteria',
                'reviewKriteria'
            ));
        } else {
            // For new review, use currently active forms
            $formKriteria = \App\Models\FormPenilaianReview::where('jenis', 'penelitian')
                ->where('is_active', true)
                ->orderBy('urutan')
                ->get();

            return view('reviewer.ppm.penelitian.review', compact(
                'proposal',
                'formKriteria',
                'ketuaTimName',
                'nidn',
                'fileUrl',
                'anggotaNames',
                'jabatan',
                'judul',
                'biayaUsulan',
                'sintaIndex',
                'anggotaList',
                'rabItems',
                'timeline',
                'currentDate',
                'canReview'
            ));
        }
    }


    public function view_pdf($penelitian_id)
    {
        $review = Review::where('penelitian_id', $penelitian_id)
            ->where('reviewer_id', auth()->id()) // Pastikan reviewer yang login yang sesuai
            ->first();

        if (!$review) {

            return redirect()->route('penelitian-rev.index')->with('error', 'Review tidak ditemukan atau Anda tidak memiliki akses.');
        }

        // Get existing review criteria scores first
        $reviewKriteria = \App\Models\ReviewKriteria::where('review_id', $review->id)
            ->with('formPenilaianReview')
            ->get()
            ->keyBy('form_penilaian_review_id');

        // Get form criteria that were active when review was created
        // Use forms that exist in review_kriteria to ensure historical data integrity
        if ($reviewKriteria->count() > 0) {
            // Get form IDs from review_kriteria
            $formIds = $reviewKriteria->pluck('form_penilaian_review_id')->toArray();

            // Get forms that were active on review creation date
            $allFormsForDate = \App\Models\FormPenilaianReview::getActiveFormsForDate('penelitian', $review->created_at);

            // Filter to only include forms that were used in this review
            $formKriteria = $allFormsForDate->filter(function ($form) use ($formIds) {
                return in_array($form->id, $formIds);
            })->sortBy(function ($form) use ($formIds) {
                return array_search($form->id, $formIds);
            })->values();
        } else {
            // Fallback: use active forms if no review_kriteria exists (backward compatibility)
            $formKriteria = \App\Models\FormPenilaianReview::where('jenis', 'penelitian')
                ->where('is_active', true)
                ->orderBy('urutan')
                ->get();
        }

        $html = view('pdf.review_template', compact('review', 'formKriteria', 'reviewKriteria'))->render();

        $mpdf = new \Mpdf\Mpdf([
            'format' => [215.9, 330.2],
            'margin_left' => 25.4,
            'margin_right' => 25.4,
            'margin_top' => 25.4,
            'margin_bottom' => 25.4,
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function store(Request $request)
    {
        $timeline = $this->getActiveTimeline();
        $currentDate = now();
        $proposal = Penelitian::findOrFail($request->penelitian_id);
        $proposalYear = $proposal->created_at ? $proposal->created_at->format('Y') : null;

        [$reviewStart, $reviewEnd] = $this->getReviewWindow($timeline, $proposal);

        if (
            !$timeline ||
            !$proposalYear ||
            (string) $timeline->period !== (string) $proposalYear ||
            !$reviewStart ||
            !$reviewEnd ||
            $currentDate < $reviewStart ||
            $currentDate > $reviewEnd
        ) {
            return redirect()->route('penelitian-rev.index')
                ->with('error', 'Periode review untuk proposal ini telah berakhir atau belum dimulai.');
        }

        // Validasi: cek apakah sudah ada 2 reviewer
        $totalReviews = Review::where('penelitian_id', $request->penelitian_id)->count();
        if ($totalReviews >= 2) {
            return redirect()->route('penelitian-rev.index')
                ->with('error', 'Proposal ini sudah direview lengkap oleh 2 reviewer. Anda tidak dapat melakukan review lagi.');
        }

        // Validasi: cek apakah reviewer ini sudah pernah review proposal ini
        $existingReview = Review::where('penelitian_id', $request->penelitian_id)
            ->where('reviewer_id', auth()->id())
            ->first();
        if ($existingReview) {
            return redirect()->route('penelitian-rev.index')
                ->with('error', 'Anda sudah melakukan review untuk proposal ini. Silakan edit review yang sudah ada.');
        }

        $review = new Review();

        $review->penelitian_id = $request->penelitian_id;
        $review->reviewer_id = auth()->id();
        $review->reviewer_name = auth()->user()->name;
        $review->judul_kegiatan = $request->judul_kegiatan;
        $review->ketua_tim = $request->ketua_tim;
        $review->nidn = $request->nidn;
        $review->jabatan = $request->jabatan;
        $review->scopus = $request->scopus;
        $review->anggota = $request->anggota;
        $review->biaya_usulan = $request->biaya_usulan;
        $review->disarankan = $request->disarankan;

        // Handle dynamic form review or fallback to hardcoded
        if ($request->has('skor') && is_array($request->skor)) {
            // Dynamic form review - save to review_kriteria
            $review->save();

            foreach ($request->skor as $kriteriaId => $skor) {
                $kriteria = \App\Models\FormPenilaianReview::find($kriteriaId);
                if ($kriteria) {
                    $nilai = $skor * $kriteria->bobot;
                    \App\Models\ReviewKriteria::create([
                        'review_id' => $review->id,
                        'form_penilaian_review_id' => $kriteriaId,
                        'skor' => $skor,
                        'nilai' => $nilai,
                    ]);
                }
            }
        } else {
            // Fallback to hardcoded form
            $review->skor_1 = $request->skor_1;
            $review->skor_2 = $request->skor_2;
            $review->skor_3 = $request->skor_3;
            $review->skor_4 = $request->skor_4;
            $review->skor_5 = $request->skor_5;
            $review->save();
        }

        $review->komentar = $request->komentar;
        $review->save();

        $penelitian = Penelitian::findOrFail($request->penelitian_id);
        $totalReviews = Review::where('penelitian_id', $penelitian->id)->count();

        // Jika reviewer pertama mulai review, ubah status menjadi Diproses
        if ($totalReviews == 1 && $penelitian->status === 'Pending') {
            $penelitian->status = 'Diproses';
            $penelitian->save();
        }

        return redirect()->route('penelitian-rev.index')->with('status', 'Review berhasil disubmit!');
    }

    public function updateReview(Request $request, $id)
    {
        $timeline = $this->getActiveTimeline();
        $currentDate = now();
        $review = Review::findOrFail($id);
        $proposal = Penelitian::findOrFail($review->penelitian_id);
        $proposalYear = $proposal->created_at ? $proposal->created_at->format('Y') : null;

        [$reviewStart, $reviewEnd] = $this->getReviewWindow($timeline, $proposal);

        if (
            !$timeline ||
            !$proposalYear ||
            (string) $timeline->period !== (string) $proposalYear ||
            !$reviewStart ||
            !$reviewEnd ||
            $currentDate < $reviewStart ||
            $currentDate > $reviewEnd
        ) {
            return redirect()->route('penelitian-rev.index')
                ->with('error', 'Periode review untuk proposal ini telah berakhir atau belum dimulai.');
        }
        // Validasi hanya field yang benar-benar bisa diedit di form Edit Review
        $rules = [
            'scopus' => 'nullable|string|max:255',
            'disarankan' => 'nullable|string|max:255',
            'komentar' => 'nullable|string',
        ];

        // Dynamic validation based on form review or hardcoded
        if ($request->has('skor') && is_array($request->skor)) {
            // Dynamic form review
            foreach ($request->skor as $kriteriaId => $skor) {
                $rules["skor.{$kriteriaId}"] = 'required|integer|min:1|max:7';
            }
        } else {
            // Fallback to hardcoded form
            $rules['skor_1'] = 'required|integer|min:1|max:7';
            $rules['skor_2'] = 'required|integer|min:1|max:7';
            $rules['skor_3'] = 'required|integer|min:1|max:7';
            $rules['skor_4'] = 'required|integer|min:1|max:7';
            $rules['skor_5'] = 'required|integer|min:1|max:7';
        }

        $validatedData = $request->validate($rules);

        // Update hanya field penilaian, jangan mengubah metadata judul/ketua/NIDN, dll.
        $review->scopus = $validatedData['scopus'] ?? $review->scopus;
        $review->disarankan = $validatedData['disarankan'] ?? $review->disarankan;

        // Handle dynamic form review or fallback to hardcoded
        if ($request->has('skor') && is_array($request->skor)) {
            // Dynamic form review - update review_kriteria
            // Delete existing review_kriteria
            \App\Models\ReviewKriteria::where('review_id', $review->id)->delete();

            // Create new review_kriteria
            foreach ($request->skor as $kriteriaId => $skor) {
                $kriteria = \App\Models\FormPenilaianReview::find($kriteriaId);
                if ($kriteria) {
                    $nilai = $skor * $kriteria->bobot;
                    \App\Models\ReviewKriteria::create([
                        'review_id' => $review->id,
                        'form_penilaian_review_id' => $kriteriaId,
                        'skor' => $skor,
                        'nilai' => $nilai,
                    ]);
                }
            }
        } else {
            // Fallback to hardcoded form
            $review->skor_1 = $validatedData['skor_1'] ?? null;
            $review->skor_2 = $validatedData['skor_2'] ?? null;
            $review->skor_3 = $validatedData['skor_3'] ?? null;
            $review->skor_4 = $validatedData['skor_4'] ?? null;
            $review->skor_5 = $validatedData['skor_5'] ?? null;
        }

        $review->komentar = $validatedData['komentar'] ?? $review->komentar;
        $review->save();

        // Status proposal tetap Diproses/Selesai sesuai logika sebelumnya – tidak diubah di sini

        return redirect()->route('penelitian-rev.index')->with('success', 'Review berhasil diperbarui.');
    }

    public function editReview($id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        $proposal = Penelitian::with(['anggota', 'rab'])->findOrFail($id);
        $proposalYear = $proposal->created_at ? $proposal->created_at->format('Y') : null;

        [$reviewStart, $reviewEnd] = $this->getReviewWindow($timeline, $proposal);

        // Cek apakah bisa melakukan review:
        // - dalam periode review, dan
        // - period pada timeline sama dengan tahun pembuatan proposal
        $canReview = $timeline &&
            $reviewStart &&
            $reviewEnd &&
            $currentDate >= $reviewStart &&
            $currentDate <= $reviewEnd &&
            $proposalYear && (string) $timeline->period === (string) $proposalYear;

        $anggotaList = $proposal->anggota ?? collect();
        $rabItems = $proposal->rab ?? collect();
        $review = Review::where('penelitian_id', $id)->where('reviewer_id', Auth::id())->first();

        $ketuaTim = Anggota::where('penelitian_id', $id)
            ->where('peran', 'ketua')
            ->first();

        $anggotaTim = Anggota::where('penelitian_id', $id)
            ->where('peran', 'anggota')
            ->get();

        $ketuaTimName = $ketuaTim ? $ketuaTim->nama : '';
        $nidn = $ketuaTim ? $ketuaTim->nidn : '';
        $jabatan = $ketuaTim ? $ketuaTim->jabatan : '';

        $anggotaNames = $anggotaTim->map(function ($anggota) {
            return $anggota->nama;
        })->join(', ');

        $judul = $proposal->judul;
        $biayaUsulan = $proposal->biaya_diusulkan;
        $sintaIndex = $proposal->sinta_index;

        // Buat URL publik untuk file proposal
        $fileUrl = Storage::url($proposal->dokumen_proposal);

        if ($review) {
            // Get existing review criteria scores first
            $reviewKriteria = \App\Models\ReviewKriteria::where('review_id', $review->id)
                ->with('formPenilaianReview')
                ->get()
                ->keyBy('form_penilaian_review_id');

            // Get form criteria that were active when review was created
            if ($reviewKriteria->count() > 0) {
                // Get form IDs from review_kriteria
                $formIds = $reviewKriteria->pluck('form_penilaian_review_id')->toArray();

                // Get forms that were active on review creation date
                $allFormsForDate = \App\Models\FormPenilaianReview::getActiveFormsForDate('penelitian', $review->created_at);

                // Filter to only include forms that were used in this review
                $formKriteria = $allFormsForDate->filter(function ($form) use ($formIds) {
                    return in_array($form->id, $formIds);
                })->sortBy(function ($form) use ($formIds) {
                    return array_search($form->id, $formIds);
                })->values();
            } else {
                // Fallback: use active forms if no review_kriteria exists
                $formKriteria = \App\Models\FormPenilaianReview::where('jenis', 'penelitian')
                    ->where('is_active', true)
                    ->orderBy('urutan')
                    ->get();
            }

            return view('reviewer.ppm.penelitian.edit_review', compact(
                'proposal',
                'review',
                'fileUrl',
                'judul',
                'ketuaTimName',
                'nidn',
                'anggotaNames',
                'jabatan',
                'biayaUsulan',
                'sintaIndex',
                'anggotaList',
                'rabItems',
                'timeline',
                'currentDate',
                'canReview',
                'formKriteria',
                'reviewKriteria'
            ));
        } else {
            return redirect()->back()->with('error', 'Review not found.');
        }
    }

    public function laporanKemajuanIndex(Request $request)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();
        $reviewerId = Auth::id();

        // Semua reviewer dapat melihat semua laporan kemajuan
        $baseQuery = Penelitian::with([
            'laporanKemajuan' => function ($query) {
                $query->orderByDesc('created_at');
            },
            'revisionParent',
            'user',
        ])
            ->where('is_draft', false)
            ->where('is_revised', true)
            ->whereNotNull('revised_from_id')
            ->whereHas('laporanKemajuan');

        $filterSkemas = (clone $baseQuery)->select('skema')
            ->whereNotNull('skema')
            ->distinct()
            ->orderBy('skema')
            ->pluck('skema');

        $filterYears = (clone $baseQuery)->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $statusOptions = ['Pending', 'Draft', 'Selesai'];

        if ($search = $request->get('search')) {
            $baseQuery->where('judul', 'like', '%' . $search . '%');
        }

        if ($skema = $request->get('skema')) {
            $baseQuery->where('skema', $skema);
        }

        if ($year = $request->get('year')) {
            $baseQuery->whereYear('created_at', $year);
        }

        if ($status = $request->get('status')) {
            $normalizedStatus = strtolower(trim($status));
            if ($normalizedStatus === 'pending') {
                // Belum ada review oleh reviewer ini
                $baseQuery->whereDoesntHave('laporanKemajuan.reviews', function ($q) use ($reviewerId) {
                    $q->where('reviewer_id', $reviewerId);
                });
            } elseif ($normalizedStatus === 'draft') {
                $baseQuery->whereHas('laporanKemajuan.reviews', function ($q) use ($reviewerId) {
                    $q->where('reviewer_id', $reviewerId)
                        ->whereRaw("LOWER(TRIM(status)) = 'draft'");
                });
            } elseif ($normalizedStatus === 'selesai') {
                $baseQuery->whereHas('laporanKemajuan.reviews', function ($q) use ($reviewerId) {
                    $q->where('reviewer_id', $reviewerId)
                        ->whereRaw("LOWER(TRIM(status)) = 'selesai'");
                });
            }
        }

        $proposals = $baseQuery->orderByDesc('updated_at')
            ->paginate(10)
            ->withQueryString();

        $filters = $request->only(['search', 'skema', 'year', 'status']);

        // Hanya hitung review yang benar-benar selesai (untuk status selesai/penguncian)
        $myCompletedLaporanIds = LaporanKemajuanReview::where('reviewer_id', $reviewerId)
            ->whereRaw("LOWER(TRIM(status)) = 'selesai'")
            ->pluck('laporan_kemajuan_id')
            ->toArray();

        // Draft milik reviewer ini
        $myDraftLaporanIds = LaporanKemajuanReview::where('reviewer_id', $reviewerId)
            ->whereRaw("LOWER(TRIM(status)) = 'draft'")
            ->pluck('laporan_kemajuan_id')
            ->toArray();

        // Hitung review selesai per laporan (untuk kunci setelah 2 review)
        $allLaporanReviews = LaporanKemajuanReview::whereRaw("LOWER(TRIM(status)) = 'selesai'")
            ->get()
            ->groupBy('laporan_kemajuan_id');

        return view('reviewer.ppm.penelitian.laporan-kemajuan.index', compact(
            'proposals',
            'timeline',
            'currentDate',
            'filterSkemas',
            'filterYears',
            'statusOptions',
            'filters',
            'myCompletedLaporanIds',
            'myDraftLaporanIds',
            'allLaporanReviews'
        ));
    }

    public function laporanKemajuanCreate($id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();
        $reviewerId = Auth::id();

        $hasProgressReviewWindow = $timeline && $timeline->progress_review_start_date && $timeline->progress_review_end_date;
        $isWithinProgressReviewWindow = $hasProgressReviewWindow
            && $currentDate->between($timeline->progress_review_start_date, $timeline->progress_review_end_date);

        $proposal = Penelitian::with([
            'laporanKemajuan' => function ($query) {
                $query->orderByDesc('created_at');
            },
            'revisionParent.reviews',
            'reviews',
            'user',
            'anggota',
            'bidangPenelitian',
        ])
            ->where('id', $id)
            ->where('is_revised', true)
            ->whereHas('laporanKemajuan')
            ->firstOrFail();

        $latestLaporan = $proposal->laporanKemajuan->first();

        if (!$latestLaporan) {
            return redirect()->route('penelitian-rev.laporan-kemajuan.index')
                ->with('error', 'Tidak ada laporan kemajuan untuk proposal ini.');
        }

        // Semua reviewer dapat mengakses laporan kemajuan
        // Tidak perlu validasi assignment lagi

        // Ambil form penilaian laporan kemajuan (penelitian) yang aktif
        $formPenelitian = FormPenilaianLaporanKemajuan::where('jenis', 'penelitian')
            ->where('is_active', true)
            ->with('subKomponen')
            ->orderBy('urutan')
            ->get();

        $existingReview = LaporanKemajuanReview::with('items')
            ->where('laporan_kemajuan_id', $latestLaporan->id)
            ->where('reviewer_id', $reviewerId)
            ->first();

        $existingKomentar = $existingReview
            ? $existingReview->items
                ->filter(function ($item) {
                    return !$item->form_penilaian_laporan_kemajuan_sub_id;
                })
                ->pluck('komentar', 'form_penilaian_laporan_kemajuan_id')
                ->toArray()
            : [];

        // Get ketua peneliti
        $ketuaPeneliti = $proposal->anggota->where('peran', 'Ketua')->first()
            ?? $proposal->anggota->where('peran', 'ketua')->first();

        // Get bidang penelitian
        $bidangPenelitian = $proposal->bidangPenelitian
            ? $proposal->bidangPenelitian->nama
            : ($proposal->bidang_penelitian_nama ?? '-');

        // Get skema
        $skema = optional($proposal->revisionParent)->skema ?? $proposal->skema ?? '-';

        // Get jurusan/prodi dari ketua
        $jurusanProdi = '-';
        if ($ketuaPeneliti) {
            $jurusan = $ketuaPeneliti->jurusan_nama ?? null;
            $prodi = $ketuaPeneliti->program_studi_nama ?? null;
            if ($jurusan && $prodi) {
                $jurusanProdi = $jurusan . ' / ' . $prodi;
            } elseif ($jurusan) {
                $jurusanProdi = $jurusan;
            } elseif ($prodi) {
                $jurusanProdi = $prodi;
            }
        }

        // Get lama penelitian
        $lamaPenelitian = $proposal->lama_penelitian ?? '-';

        return view('reviewer.ppm.penelitian.laporan-kemajuan.create', compact(
            'proposal',
            'latestLaporan',
            'timeline',
            'currentDate',
            'isWithinProgressReviewWindow',
            'formPenelitian',
            'existingReview',
            'existingKomentar',
            'ketuaPeneliti',
            'bidangPenelitian',
            'skema',
            'jurusanProdi',
            'lamaPenelitian'
        ));
    }

    public function laporanKemajuanStore(Request $request, $id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();
        $reviewerId = Auth::id();

        $hasProgressReviewWindow = $timeline && $timeline->progress_review_start_date && $timeline->progress_review_end_date;
        $isWithinProgressReviewWindow = $hasProgressReviewWindow
            && $currentDate->between($timeline->progress_review_start_date, $timeline->progress_review_end_date);

        $proposal = Penelitian::with([
            'laporanKemajuan' => function ($query) {
                $query->orderByDesc('created_at');
            },
            'revisionParent.reviews',
            'reviews',
            'user',
        ])
            ->where('id', $id)
            ->where('is_revised', true)
            ->whereHas('laporanKemajuan')
            ->firstOrFail();

        $latestLaporan = $proposal->laporanKemajuan->first();

        if (!$latestLaporan) {
            return redirect()->route('penelitian-rev.laporan-kemajuan.index')
                ->with('error', 'Tidak ada laporan kemajuan untuk proposal ini.');
        }

        if (!$isWithinProgressReviewWindow) {
            return redirect()->route('penelitian-rev.laporan-kemajuan.index')
                ->with('error', 'Periode review laporan kemajuan belum dimulai atau sudah berakhir.');
        }

        $formPenelitian = \App\Models\FormPenilaianLaporanKemajuan::where('jenis', 'penelitian')
            ->where('is_active', true)
            ->with('subKomponen')
            ->orderBy('urutan')
            ->get();

        $action = $request->input('action', 'draft');
        $targetStatus = $action === 'submit' ? 'selesai' : 'draft';

        $rules = [
            'komentar' => 'array',
            'catatan_umum' => 'nullable|string',
        ];

        if ($action === 'submit') {
            foreach ($formPenelitian as $item) {
                // Komentar wajib diisi jika submit
                $rules['komentar.' . $item->id] = 'required|string|min:3';
            }
        }

        $validated = $request->validate($rules);
        $komentarInput = $validated['komentar'] ?? [];

        $review = \App\Models\LaporanKemajuanReview::updateOrCreate(
            [
                'laporan_kemajuan_id' => $latestLaporan->id,
                'reviewer_id' => $reviewerId,
            ],
            [
                'jenis' => 'penelitian',
            ]
        );

        $review->status = $targetStatus;
        $review->catatan_umum = $validated['catatan_umum'] ?? null;
        $review->submitted_at = $targetStatus === 'selesai' ? now() : null;
        $review->save();

        // Hapus item lama dan buat baru
        $review->items()->delete();

        foreach ($formPenelitian as $item) {
            $comment = $komentarInput[$item->id] ?? null;

            if ($comment !== null && $comment !== '') {
                $review->items()->create([
                    'form_penilaian_laporan_kemajuan_id' => $item->id,
                    'form_penilaian_laporan_kemajuan_sub_id' => null,
                    'komentar' => $comment,
                    'nilai' => 0,
                ]);
            }
        }

        // Tentukan status laporan berdasarkan jumlah review selesai (2 -> Selesai, 1 -> Diproses, 0 -> Draft)
        $completedCount = \App\Models\LaporanKemajuanReview::where('laporan_kemajuan_id', $latestLaporan->id)
            ->where('jenis', 'penelitian')
            ->whereRaw("LOWER(TRIM(status)) = 'selesai'")
            ->count();
        $latestStatus = $completedCount >= 2 ? 'Selesai' : ($completedCount >= 1 ? 'Diproses' : 'Draft');
        $latestLaporan->status = $latestStatus;
        $latestLaporan->save();

        $message = $targetStatus === 'selesai'
            ? 'Penilaian laporan kemajuan berhasil disimpan dan ditandai selesai.'
            : 'Draft penilaian laporan kemajuan berhasil disimpan.';

        return redirect()
            ->route('penelitian-rev.laporan-kemajuan.index')
            ->with('success', $message);
    }

    public function laporanKemajuanPdf($id)
    {
        $reviewerId = Auth::id();

        $proposal = Penelitian::with([
            'laporanKemajuan' => function ($query) {
                $query->orderByDesc('created_at');
            },
            'revisionParent.reviews',
            'reviews',
            'user',
            'anggota',
            'bidangPenelitian',
        ])
            ->where('id', $id)
            ->where('is_revised', true)
            ->whereHas('laporanKemajuan')
            ->firstOrFail();

        $latestLaporan = $proposal->laporanKemajuan->first();

        if (!$latestLaporan) {
            return redirect()->route('penelitian-rev.laporan-kemajuan.index')
                ->with('error', 'Tidak ada laporan kemajuan untuk proposal ini.');
        }

        $existingReview = LaporanKemajuanReview::with(['items.formPenilaianLaporanKemajuan', 'reviewer'])
            ->where('laporan_kemajuan_id', $latestLaporan->id)
            ->where('reviewer_id', $reviewerId)
            ->where('status', 'selesai')
            ->first();

        if (!$existingReview) {
            return redirect()->route('penelitian-rev.laporan-kemajuan.index')
                ->with('error', 'Review laporan kemajuan belum selesai atau tidak ditemukan.');
        }

        $formPenelitian = FormPenilaianLaporanKemajuan::where('jenis', 'penelitian')
            ->where('is_active', true)
            ->orderBy('urutan')
            ->get();

        $ketuaPeneliti = $proposal->anggota->where('peran', 'Ketua')->first()
            ?? $proposal->anggota->where('peran', 'ketua')->first();

        $bidangPenelitian = $proposal->bidangPenelitian
            ? $proposal->bidangPenelitian->nama
            : ($proposal->bidang_penelitian_nama ?? '-');

        $skema = optional($proposal->revisionParent)->skema ?? $proposal->skema ?? '-';

        $jurusanProdi = '-';
        if ($ketuaPeneliti) {
            $jurusan = $ketuaPeneliti->jurusan_nama ?? null;
            $prodi = $ketuaPeneliti->program_studi_nama ?? null;
            if ($jurusan && $prodi) {
                $jurusanProdi = $jurusan . ' / ' . $prodi;
            } elseif ($jurusan) {
                $jurusanProdi = $jurusan;
            } elseif ($prodi) {
                $jurusanProdi = $prodi;
            }
        }

        $lamaPenelitian = $proposal->lama_penelitian ?? '-';

        $reviewerName = optional($existingReview->reviewer)->name ?? Auth::user()->name ?? '-';

        $html = view('pdf.laporan-kemajuan-penelitian', compact(
            'proposal',
            'latestLaporan',
            'existingReview',
            'formPenelitian',
            'ketuaPeneliti',
            'bidangPenelitian',
            'skema',
            'jurusanProdi',
            'lamaPenelitian',
            'reviewerName'
        ))->render();

        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'margin_left' => 25,
            'margin_right' => 25,
            'margin_top' => 20,
            'margin_bottom' => 20,
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Laporan_Kemajuan_Penelitian_' . $proposal->id . '.pdf', 'I');
    }

    protected function getReviewWindow(?Timeline $timeline, Penelitian $proposal): array
    {
        if (!$timeline) {
            return [null, null];
        }

        if ($proposal->is_revised) {
            return [$timeline->revision_review_start_date, $timeline->revision_review_end_date];
        }

        return [$timeline->review_start_date, $timeline->review_end_date];
    }

    protected function getActiveTimeline()
    {
        return Timeline::active()
            ->orderBy('period', 'desc')
            ->ordered()
            ->first();
    }

    public function laporanAkhirIndex(Request $request)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();
        $reviewerId = Auth::id();

        // Semua reviewer dapat melihat semua laporan akhir
        $baseQuery = Penelitian::with([
            'laporanAkhir' => function ($query) {
                $query->orderByDesc('created_at');
            },
            'revisionParent',
            'user',
        ])
            ->where('is_draft', false)
            ->where('is_revised', true)
            ->whereNotNull('revised_from_id')
            ->whereHas('laporanAkhir');

        $filterSkemas = (clone $baseQuery)->select('skema')
            ->whereNotNull('skema')
            ->distinct()
            ->orderBy('skema')
            ->pluck('skema');

        $filterYears = (clone $baseQuery)->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $statusOptions = ['Pending', 'Draft', 'Selesai'];

        if ($search = $request->get('search')) {
            $baseQuery->where('judul', 'like', '%' . $search . '%');
        }

        if ($skema = $request->get('skema')) {
            $baseQuery->where('skema', $skema);
        }

        if ($year = $request->get('year')) {
            $baseQuery->whereYear('created_at', $year);
        }

        if ($status = $request->get('status')) {
            $normalizedStatus = strtolower(trim($status));
            if ($normalizedStatus === 'pending') {
                // Belum ada review oleh reviewer ini
                $baseQuery->whereDoesntHave('laporanAkhir.reviews', function ($q) use ($reviewerId) {
                    $q->where('reviewer_id', $reviewerId);
                });
            } elseif ($normalizedStatus === 'draft') {
                $baseQuery->whereHas('laporanAkhir.reviews', function ($q) use ($reviewerId) {
                    $q->where('reviewer_id', $reviewerId)
                        ->whereRaw("LOWER(TRIM(status)) = 'draft'");
                });
            } elseif ($normalizedStatus === 'selesai') {
                $baseQuery->whereHas('laporanAkhir.reviews', function ($q) use ($reviewerId) {
                    $q->where('reviewer_id', $reviewerId)
                        ->whereRaw("LOWER(TRIM(status)) = 'selesai'");
                });
            }
        }

        $proposals = $baseQuery->orderByDesc('updated_at')
            ->paginate(10)
            ->withQueryString();

        $filters = $request->only(['search', 'skema', 'year', 'status']);

        // Hanya hitung review yang benar-benar selesai
        $myCompletedLaporanIds = \App\Models\LaporanAkhirReview::where('reviewer_id', $reviewerId)
            ->where('jenis', 'penelitian')
            ->whereRaw("LOWER(TRIM(status)) = 'selesai'")
            ->pluck('laporan_akhir_id')
            ->toArray();

        // Draft milik reviewer ini
        $myDraftLaporanIds = \App\Models\LaporanAkhirReview::where('reviewer_id', $reviewerId)
            ->where('jenis', 'penelitian')
            ->whereRaw("LOWER(TRIM(status)) = 'draft'")
            ->pluck('laporan_akhir_id')
            ->toArray();

        // Hitung review selesai per laporan
        $allLaporanReviews = \App\Models\LaporanAkhirReview::whereRaw("LOWER(TRIM(status)) = 'selesai'")
            ->where('jenis', 'penelitian')
            ->get()
            ->groupBy('laporan_akhir_id');

        return view('reviewer.ppm.penelitian.laporan-akhir.index', compact(
            'proposals',
            'timeline',
            'currentDate',
            'filterSkemas',
            'filterYears',
            'statusOptions',
            'filters',
            'myCompletedLaporanIds',
            'myDraftLaporanIds',
            'allLaporanReviews'
        ));
    }

    public function laporanAkhirCreate($id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();
        $reviewerId = Auth::id();

        // Use final_review_start_date
        $hasFinalReviewWindow = $timeline && $timeline->final_review_start_date && $timeline->final_review_end_date;
        $isWithinFinalReviewWindow = $hasFinalReviewWindow
            && $currentDate->between($timeline->final_review_start_date, $timeline->final_review_end_date);

        $proposal = Penelitian::with([
            'laporanAkhir' => function ($query) {
                $query->orderByDesc('created_at');
            },
            'revisionParent.reviews',
            'reviews',
            'user',
            'anggota',
            'bidangPenelitian',
        ])
            ->where('id', $id)
            ->where('is_revised', true)
            ->whereHas('laporanAkhir')
            ->firstOrFail();

        $latestLaporan = $proposal->laporanAkhir; // FIX: hasOne usage
        \Illuminate\Support\Facades\Log::info("DEBUG STORE PENELITIAN: Proposal {$proposal->id}, Laporan {$latestLaporan->id}");

        if (!$latestLaporan) {
            return redirect()->route('penelitian-rev.laporan-akhir.index')
                ->with('error', 'Tidak ada laporan akhir untuk proposal ini.');
        }

        // Ambil form penilaian laporan akhir
        $formPenelitian = \App\Models\FormPenilaianLaporanAkhir::where('jenis', 'penelitian')
            ->where('is_active', true)
            ->with('subKomponen')
            ->orderBy('urutan')
            ->get();

        // Prepare existing selected items
        $existingStatus = [];
        $existingGrades = [];

        $existingReview = \App\Models\LaporanAkhirReview::with(['items.subChoice'])
            ->where('laporan_akhir_id', $latestLaporan->id)
            ->where('reviewer_id', $reviewerId)
            ->where('jenis', 'penelitian')
            ->first();

        if ($existingReview) {
            foreach ($existingReview->items as $item) {
                if ($item->subChoice) {
                    if ($item->subChoice->tipe === 'status') {
                        $existingStatus[$item->form_penilaian_id] = $item->sub_id;
                    } elseif ($item->subChoice->tipe === 'item') {
                        $existingGrades[$item->form_penilaian_id][$item->sub_id] = $item->nilai;
                    }
                }
                // Fallback or legacy handling if needed
            }
        }

        $existingKomentar = $existingReview ? $existingReview->items->pluck('catatan', 'form_penilaian_id')->toArray() : [];

        $ketuaPeneliti = $proposal->anggota->where('peran', 'Ketua')->first()
            ?? $proposal->anggota->where('peran', 'ketua')->first();

        $bidangPenelitian = $proposal->bidangPenelitian
            ? $proposal->bidangPenelitian->nama
            : ($proposal->bidang_penelitian_nama ?? '-');

        $skema = optional($proposal->revisionParent)->skema ?? $proposal->skema ?? '-';

        $jurusanProdi = '-';
        if ($ketuaPeneliti) {
            $jurusan = $ketuaPeneliti->jurusan_nama ?? null;
            $prodi = $ketuaPeneliti->program_studi_nama ?? null;
            if ($jurusan && $prodi) {
                $jurusanProdi = $jurusan . ' / ' . $prodi;
            } elseif ($jurusan) {
                $jurusanProdi = $jurusan;
            } elseif ($prodi) {
                $jurusanProdi = $prodi;
            }
        }

        $lamaPenelitian = $proposal->lama_penelitian ?? '-';

        return view('reviewer.ppm.penelitian.laporan-akhir.create', compact(
            'proposal',
            'latestLaporan',
            'timeline',
            'currentDate',
            'isWithinFinalReviewWindow',
            'formPenelitian',
            'existingReview',
            'existingStatus',
            'existingGrades',
            'existingKomentar',
            'ketuaPeneliti',
            'bidangPenelitian',
            'skema',
            'jurusanProdi',
            'lamaPenelitian'
        ));
    }

    public function laporanAkhirStore(Request $request, $id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();
        $reviewerId = Auth::id();

        $hasFinalReviewWindow = $timeline && $timeline->final_review_start_date && $timeline->final_review_end_date;
        $isWithinFinalReviewWindow = $hasFinalReviewWindow
            && $currentDate->between($timeline->final_review_start_date, $timeline->final_review_end_date);

        $proposal = Penelitian::with([
            'laporanAkhir' => function ($query) {
                $query->orderByDesc('created_at');
            },
            'revisionParent.reviews',
            'reviews',
            'user',
        ])
            ->where('id', $id)
            ->where('is_revised', true)
            ->whereHas('laporanAkhir')
            ->firstOrFail();

        $latestLaporan = $proposal->laporanAkhir;

        if (!$latestLaporan) {
            return redirect()->route('penelitian-rev.laporan-akhir.index')
                ->with('error', 'Tidak ada laporan akhir untuk proposal ini.');
        }

        if (!$isWithinFinalReviewWindow) {
            return redirect()->route('penelitian-rev.laporan-akhir.index')
                ->with('error', 'Periode review laporan akhir belum dimulai atau sudah berakhir.');
        }

        $formPenelitian = \App\Models\FormPenilaianLaporanAkhir::where('jenis', 'penelitian')
            ->where('is_active', true)
            ->with([
                'subKomponen' => function ($q) {
                    $q->orderBy('urutan');
                }
            ])
            ->orderBy('urutan')
            ->get();

        $action = $request->input('action', 'draft');
        $targetStatus = $action === 'submit' ? 'selesai' : 'draft';

        $rules = [
            'sub_komponen' => 'array',
            'sub_komponen.*' => 'nullable|exists:form_penilaian_laporan_akhir_subs,id',
            'catatan_umum' => 'nullable|string',
        ];

        // Validate selection requirement for submit
        if ($action === 'submit') {
            foreach ($formPenelitian as $komponen) {
                // Check for Status (Parent)
                $statusSubs = $komponen->subKomponen->where('tipe', 'status');
                if ($statusSubs->count() > 0) {
                    $rules['status.' . $komponen->id] = 'required';
                }

                // Check for Items (Grades)
                $itemSubs = $komponen->subKomponen->where('tipe', 'item');
                if ($itemSubs->count() > 0) {
                    foreach ($itemSubs as $item) {
                        $rules['grades.' . $komponen->id . '.' . $item->id] = 'required';
                    }
                }
            }
        }

        $validated = $request->validate($rules);
        // $selectedSubKomponen no longer needed for Penelitian logic here
        // as we access status/grades directly from request


        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $existingReview = \App\Models\LaporanAkhirReview::where('laporan_akhir_id', $latestLaporan->id)
                ->where('reviewer_id', $reviewerId)
                ->where('jenis', 'penelitian')
                ->first();

            $review = \App\Models\LaporanAkhirReview::updateOrCreate(
                [
                    'laporan_akhir_id' => $latestLaporan->id,
                    'reviewer_id' => $reviewerId,
                    'jenis' => 'penelitian',
                ],
                [
                    'status' => $targetStatus,
                    'catatan_umum' => $validated['catatan_umum'] ?? null,
                    'submitted_at' => $targetStatus === 'selesai' ? now() : null,
                ]
            );

            // Refresh items
            $review->items()->delete();

            foreach ($formPenelitian as $komponen) {
                // 1. Process Status Selection
                if (isset($request->status[$komponen->id])) {
                    $statusSubId = $request->status[$komponen->id];
                    $statusSub = \App\Models\FormPenilaianLaporanAkhirSub::find($statusSubId);

                    if ($statusSub) {
                        $review->items()->create([
                            'form_penilaian_id' => $komponen->id,
                            'sub_id' => $statusSubId,
                            'nilai' => $statusSub->skor, // Base score from status
                            'catatan' => null
                        ]);
                    }
                }

                // 2. Process Item Grades
                if (isset($request->grades[$komponen->id])) {
                    foreach ($request->grades[$komponen->id] as $itemSubId => $gradeScore) {
                        // Validate item belongs to form (optional but good practice)
                        $itemSub = \App\Models\FormPenilaianLaporanAkhirSub::find($itemSubId);
                        if ($itemSub && $itemSub->form_penilaian_laporan_akhir_id == $komponen->id) {
                            $review->items()->create([
                                'form_penilaian_id' => $komponen->id,
                                'sub_id' => $itemSubId, // Referencing the Item Sub-Component
                                'nilai' => $gradeScore, // The score given by reviewer (100, 75, etc.)
                                'catatan' => null
                            ]);
                        }
                    }
                }
            }

            \Illuminate\Support\Facades\DB::commit();

            $completedCount = \App\Models\LaporanAkhirReview::where('laporan_akhir_id', $latestLaporan->id)
                ->where('jenis', 'penelitian')
                ->whereRaw("LOWER(TRIM(status)) = 'selesai'")
                ->count();
            $latestStatus = $completedCount >= 2 ? 'Selesai' : ($completedCount >= 1 ? 'Diproses' : 'Draft');
            $latestLaporan->status = $latestStatus;
            $latestLaporan->save();

            $message = $targetStatus === 'selesai'
                ? 'Penilaian laporan akhir berhasil disimpan dan ditandai selesai.'
                : 'Draft penilaian laporan akhir berhasil disimpan.';

            return redirect()
                ->route('penelitian-rev.laporan-akhir.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan penilaian: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function laporanAkhirPdf($id)
    {
        $reviewerId = Auth::id();

        $proposal = Penelitian::with([
            'laporanAkhir' => function ($query) {
                $query->orderByDesc('created_at');
            },
            'revisionParent.reviews',
            'reviews',
            'user',
            'anggota',
            'bidangPenelitian',
        ])
            ->where('id', $id)
            ->where('is_revised', true)
            ->whereHas('laporanAkhir')
            ->firstOrFail();

        $latestLaporan = $proposal->laporanAkhir;

        if (!$latestLaporan) {
            return redirect()->route('penelitian-rev.laporan-akhir.index')
                ->with('error', 'Tidak ada laporan akhir untuk proposal ini.');
        }

        $existingReview = \App\Models\LaporanAkhirReview::with([
            'items.formPenilaian',
            'items.subChoice', // Updated to match new saving logic
            'reviewer'
        ])
            ->where('laporan_akhir_id', $latestLaporan->id)
            ->where('reviewer_id', $reviewerId)
            ->where('jenis', 'penelitian')
            // Allow printing drafts for the reviewer who owns it
            ->when($reviewerId != Auth::id() && !Auth::user()->hasRole('admin'), function ($q) {
                $q->where('status', 'selesai');
            })
            ->orderByDesc('updated_at')
            ->first();

        if (!$existingReview) {
            return redirect()->route('penelitian-rev.laporan-akhir.index')
                ->with('error', 'Review laporan akhir belum ditemukan.');
        }

        $formPenelitian = \App\Models\FormPenilaianLaporanAkhir::where('jenis', 'penelitian')
            ->where('is_active', true)
            ->with('subKomponen')
            ->orderBy('urutan')
            ->get();

        $ketuaPeneliti = $proposal->anggota->where('peran', 'Ketua')->first()
            ?? $proposal->anggota->where('peran', 'ketua')->first();

        $bidangPenelitian = $proposal->bidangPenelitian
            ? $proposal->bidangPenelitian->nama
            : ($proposal->bidang_penelitian_nama ?? '-');

        $skema = optional($proposal->revisionParent)->skema ?? $proposal->skema ?? '-';

        $jurusanProdi = '-';
        if ($ketuaPeneliti) {
            $jurusan = $ketuaPeneliti->jurusan_nama ?? null;
            $prodi = $ketuaPeneliti->program_studi_nama ?? null;
            if ($jurusan && $prodi) {
                $jurusanProdi = $jurusan . ' / ' . $prodi;
            } elseif ($jurusan) {
                $jurusanProdi = $jurusan;
            } elseif ($prodi) {
                $jurusanProdi = $prodi;
            }
        }

        $lamaPenelitian = $proposal->lama_penelitian ?? '-';
        $reviewerName = optional($existingReview->reviewer)->name ?? Auth::user()->name ?? '-';

        $html = view('pdf.laporan-akhir-penelitian', compact(
            'proposal',
            'latestLaporan',
            'existingReview',
            'formPenelitian',
            'ketuaPeneliti',
            'bidangPenelitian',
            'skema',
            'jurusanProdi',
            'lamaPenelitian',
            'reviewerName'
        ))->render();

        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'margin_left' => 25,
            'margin_right' => 25,
            'margin_top' => 20,
            'margin_bottom' => 20,
            'tempDir' => storage_path('app/mpdf'), // Ensure temp dir exists
        ]);

        $mpdf->WriteHTML($html);

        // Prevent caching
        $filename = 'Laporan_Akhir_Penelitian_' . $proposal->id . '_' . time() . '.pdf';

        return response($mpdf->Output($filename, 'S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->header('Cache-Control', 'private, max-age=0, must-revalidate');
    }
}
