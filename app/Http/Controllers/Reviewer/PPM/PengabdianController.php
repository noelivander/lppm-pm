<?php
namespace App\Http\Controllers\Reviewer\PPM;

use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengabdian;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota_pengabdian;
use App\Models\Timeline;
use App\Models\Review;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\FormPenilaianLaporanKemajuan;
use App\Models\FormPenilaianLaporanKemajuanSub;
use App\Models\LaporanKemajuanReview;

class PengabdianController extends Controller
{
    public function index(Request $request)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        // Hanya tampilkan proposal awal (bukan entitas revisi)
        $baseQuery = Pengabdian::where('is_draft', false)
            ->where('is_revised', false);

        $filterSkemas = (clone $baseQuery)->select('skema')
            ->whereNotNull('skema')
            ->distinct()
            ->orderBy('skema')
            ->pluck('skema');

        $filterYears = (clone $baseQuery)->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $statuses = ['Pending', 'Selesai'];

        if ($search = $request->get('search')) {
            $baseQuery->where('judul', 'like', '%' . $search . '%');
        }

        // Get reviews by current reviewer first
        $reviews = Review::where('reviewer_id', auth()->id())->pluck('pengabdian_id')->toArray();

        if ($status = $request->get('status')) {
            if ($status === 'Selesai') {
                // Filter proposal yang sudah direview oleh reviewer ini
                $baseQuery->whereIn('id', $reviews);
            } elseif ($status === 'Pending') {
                // Filter proposal yang belum direview oleh reviewer ini
                $baseQuery->whereNotIn('id', $reviews);
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
        
        // Get reviews for display (if not already set)
        if (!isset($reviews)) {
            $reviews = Review::where('reviewer_id', auth()->id())->pluck('pengabdian_id')->toArray();
        }
        $existingReviews = Review::all();

        // Data sudah tidak dienkripsi, tidak perlu dekripsi
    
        $filters = $request->only(['search', 'status', 'skema', 'year']);

        return view('reviewer.ppm.pengabdian.index', compact(
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
        $baseQuery = Pengabdian::with(['user'])
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
            ->whereNotNull('pengabdian_id')
            ->pluck('pengabdian_id')
            ->toArray();

        // Proposal revisi yang sudah dikomentari oleh 2 reviewer (penuh)
        $fullReviewedIds = Review::whereNotNull('revision_comment')
            ->whereNotNull('pengabdian_id')
            ->select('pengabdian_id')
            ->groupBy('pengabdian_id')
            ->havingRaw('COUNT(*) >= 2')
            ->pluck('pengabdian_id')
            ->toArray();

        $proposals = $baseQuery->orderByDesc('updated_at')
            ->paginate(10)
            ->withQueryString();

        return view('reviewer.ppm.pengabdian.revisi.index', compact(
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
     * Tampilkan form review untuk proposal pengabdian yang sudah direvisi dosen.
     * Fokus pada data proposal sampai RAB + keputusan ACC/Tolak & komentar.
     */
    public function revisiReview($id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        $proposal = Pengabdian::with(['anggota', 'rab', 'reviews.reviewer', 'revisionParent.reviews.reviewer'])
            ->where('is_revised', true)
            ->findOrFail($id);

        // Batasi maksimal 2 reviewer yang memberi komentar revisi
        $existingRevisionReviews = Review::where('pengabdian_id', $proposal->id)
            ->whereNotNull('revision_comment')
            ->get();

        $currentReviewerReview = $existingRevisionReviews
            ->firstWhere('reviewer_id', Auth::id());

        if (!$currentReviewerReview && $existingRevisionReviews->count() >= 2) {
            return redirect()
                ->route('pengabdian-rev.revisi.index')
                ->with('error', 'Proposal revisi ini sudah dikomentari oleh 2 reviewer. Anda tidak dapat lagi melakukan peninjauan revisi.');
        }

        // Gunakan proposal asli (sebelum revisi) untuk membaca review & komentar admin
        $originalProposal = $proposal->revisionParent ?: $proposal;

        $proposalYear = $originalProposal->created_at ? $originalProposal->created_at->format('Y') : null;

        [$reviewStart, $reviewEnd] = $this->getReviewWindow($timeline, $proposal);

        $canReview = $timeline &&
            $reviewStart &&
            $reviewEnd &&
            $currentDate >= $reviewStart &&
            $currentDate <= $reviewEnd &&
            $proposalYear &&
            (string) $timeline->period === (string) $proposalYear;

        $anggotaList = $proposal->anggota ?? collect();
        $rabItems = $proposal->rab ?? collect();

        $ketuaTim = Anggota_pengabdian::where('pengabdian_id', $id)
            ->where('peran', 'ketua')
            ->first();

        $ketuaTimName = $ketuaTim ? $ketuaTim->nama : '';
        $nidn = $ketuaTim ? $ketuaTim->nidn : '';
        $jabatan = $ketuaTim ? $ketuaTim->jabatan : '';

        $anggotaTim = Anggota_pengabdian::where('pengabdian_id', $id)
            ->where('peran', 'anggota')
            ->get();

        $anggotaNames = $anggotaTim->map(function ($anggota) {
            return $anggota->nama;
        })->join(', ');

        $judul = $proposal->judul;
        $biayaUsulan = $proposal->biaya_diusulkan;

        // Tampilkan dokumen proposal revisi
        $fileUrl = Storage::url($proposal->dokumen_proposal);

        $review = Review::where('pengabdian_id', $id)
            ->where('reviewer_id', Auth::id())
            ->first();

        // Review awal dari kedua reviewer melekat pada proposal asli
        $allReviews = $originalProposal->reviews ?? collect();
        $initialReview = $allReviews->firstWhere('reviewer_id', Auth::id());

        return view('reviewer.ppm.pengabdian.revisi.review', [
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
     * Simpan komentar review revisi untuk pengabdian (tanpa ACC/Tolak).
     */
    public function revisiReviewStore(Request $request, $id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        $proposal = Pengabdian::with(['anggota', 'rab'])
            ->where('is_revised', true)
            ->findOrFail($id);

        // Batasi maksimal 2 reviewer yang memberi komentar revisi
        $existingRevisionReviews = Review::where('pengabdian_id', $proposal->id)
            ->whereNotNull('revision_comment')
            ->get();

        $currentReviewerReview = $existingRevisionReviews
            ->firstWhere('reviewer_id', Auth::id());

        if (!$currentReviewerReview && $existingRevisionReviews->count() >= 2) {
            return redirect()
                ->route('pengabdian-rev.revisi.index')
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
                ->route('pengabdian-rev.revisi.index')
                ->with('error', 'Periode review revisi untuk proposal ini telah berakhir atau belum dimulai.');
        }

        $validated = $request->validate([
            'revision_comment' => 'required|string|max:2000',
        ]);

        $review = Review::firstOrCreate(
            [
                'pengabdian_id' => $proposal->id,
                'reviewer_id' => Auth::id(),
            ],
            [
                'type' => 'pengabdian',
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
        $totalRevisionComments = Review::where('pengabdian_id', $proposal->id)
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
            ->route('pengabdian-rev.revisi.index')
            ->with('success', 'Komentar peninjauan revisi berhasil disimpan.');
    }

    public function review($id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();
        
        $proposal = Pengabdian::with(['anggota', 'rab'])->findOrFail($id);
        $proposalYear = $proposal->created_at ? $proposal->created_at->format('Y') : null;
        
        [$reviewStart, $reviewEnd] = $this->getReviewWindow($timeline, $proposal);

        // Cek apakah bisa melakukan review:
        // - dalam periode review (awal atau revisi), dan
        // - period pada timeline sama dengan tahun pembuatan proposal
        $canReview = $timeline && 
                     $reviewStart && 
                     $reviewEnd &&
                     $currentDate >= $reviewStart && 
                     $currentDate <= $reviewEnd &&
                     $proposalYear && (string) $timeline->period === (string) $proposalYear;
        
        // Cek apakah reviewer saat ini sudah pernah review
        $review = Review::where('pengabdian_id', $id)->where('reviewer_id', Auth::id())->first();
        
        // Jika reviewer belum pernah review, cek apakah sudah ada 2 reviewer
        if (!$review) {
            $totalReviews = Review::where('pengabdian_id', $id)->count();
            if ($totalReviews >= 2) {
                return redirect()->route('pengabdian-rev.index')
                    ->with('error', 'Proposal ini sudah direview lengkap oleh 2 reviewer. Anda tidak dapat melakukan review lagi.');
            }
        }
        
        $anggotaList = $proposal->anggota ?? collect();
        $rabItems = $proposal->rab ?? collect();
        
        $ketuaTim = Anggota_pengabdian::where('pengabdian_id', $id)
                            ->where('peran', 'ketua')
                            ->first();
        
        $anggotaTim = Anggota_pengabdian::where('pengabdian_id', $id)
                             ->where('peran', 'anggota')
                             ->get();
        
        $ketuaTimName = $ketuaTim ? $ketuaTim->nama : '';
        $nidn = $ketuaTim ? $ketuaTim->nidn : '';
        $jabatan = $ketuaTim ? $ketuaTim->jabatan : '';

        $anggotaNames = $anggotaTim->map(function($anggota) {
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
                $allFormsForDate = \App\Models\FormPenilaianReview::getActiveFormsForDate('pengabdian', $review->created_at);
                
                // Filter to only include forms that were used in this review
                $formKriteria = $allFormsForDate->filter(function($form) use ($formIds) {
                    return in_array($form->id, $formIds);
                })->sortBy(function($form) use ($formIds) {
                    return array_search($form->id, $formIds);
                })->values();
            } else {
                // Fallback: use active forms if no review_kriteria exists
                $formKriteria = \App\Models\FormPenilaianReview::where('jenis', 'pengabdian')
                    ->where('is_active', true)
                    ->orderBy('urutan')
                    ->get();
            }

            return view('reviewer.ppm.pengabdian.edit_review', compact(
                'proposal',
                'review',
                'ketuaTimName',
                'nidn',
                'anggotaNames',
                'judul',
                'jabatan',
                'biayaUsulan',
                'sintaIndex',
                'anggotaList',
                'rabItems',
                'fileUrl',
                'timeline',
                'currentDate',
                'canReview',
                'formKriteria',
                'reviewKriteria'
            ));
        } else {
            // For new review, use currently active forms
            $formKriteria = \App\Models\FormPenilaianReview::where('jenis', 'pengabdian')
                ->where('is_active', true)
                ->orderBy('urutan')
                ->get();
            
            return view('reviewer.ppm.pengabdian.review', compact(
                'proposal',
                'ketuaTimName',
                'nidn',
                'anggotaNames',
                'jabatan',
                'judul',
                'biayaUsulan',
                'sintaIndex',
                'anggotaList',
                'rabItems',
                'fileUrl',
                'timeline',
                'currentDate',
                'canReview',
                'formKriteria'
            ));
        }
    }
    

    public function view_pdf($pengabdian_id)
    {
        $review = Review::where('pengabdian_id', $pengabdian_id)
                        ->where('reviewer_id', auth()->id())
                        ->first();
    
        if (!$review) {
            return redirect()->route('pengabdian-rev.index')->with('error', 'Review tidak ditemukan atau Anda tidak memiliki akses.');
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
            $allFormsForDate = \App\Models\FormPenilaianReview::getActiveFormsForDate('pengabdian', $review->created_at);
            
            // Filter to only include forms that were used in this review
            $formKriteria = $allFormsForDate->filter(function($form) use ($formIds) {
                return in_array($form->id, $formIds);
            })->sortBy(function($form) use ($formIds) {
                return array_search($form->id, $formIds);
            })->values();
        } else {
            // Fallback: use active forms if no review_kriteria exists (backward compatibility)
            $formKriteria = \App\Models\FormPenilaianReview::where('jenis', 'pengabdian')
                ->where('is_active', true)
                ->orderBy('urutan')
                ->get();
        }
    
        $html = view('pdf.review_pengabdian', compact('review', 'formKriteria', 'reviewKriteria'))->render();
    
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
        $proposal = Pengabdian::findOrFail($request->pengabdian_id);
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
            return redirect()->route('pengabdian-rev.index')
                ->with('error', 'Periode review untuk proposal ini telah berakhir atau belum dimulai.');
        }
        
        // Validasi: cek apakah sudah ada 2 reviewer
        $totalReviews = Review::where('pengabdian_id', $request->pengabdian_id)->count();
        if ($totalReviews >= 2) {
            return redirect()->route('pengabdian-rev.index')
                ->with('error', 'Proposal ini sudah direview lengkap oleh 2 reviewer. Anda tidak dapat melakukan review lagi.');
        }
        
        // Validasi: cek apakah reviewer ini sudah pernah review proposal ini
        $existingReview = Review::where('pengabdian_id', $request->pengabdian_id)
            ->where('reviewer_id', auth()->id())
            ->first();
        if ($existingReview) {
            return redirect()->route('pengabdian-rev.index')
                ->with('error', 'Anda sudah melakukan review untuk proposal ini. Silakan edit review yang sudah ada.');
        }
        
        $review = new Review();
    
        $review->pengabdian_id = $request->pengabdian_id;
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

        $pengabdian = Pengabdian::findOrFail($request->pengabdian_id);
        $totalReviews = Review::where('pengabdian_id', $pengabdian->id)->count();

        if ($totalReviews == 1) {
            $pengabdian->status = 'Diproses';
        } elseif ($totalReviews >= 2) {
            $pengabdian->status = 'Selesai';
        }
        $pengabdian->save();
    
        return redirect()->route('pengabdian-rev.index')->with('status', 'Review berhasil disubmit!');
    }

    public function updateReview(Request $request, $id)
    {
        $timeline = $this->getActiveTimeline();
        $currentDate = now();
        $review = Review::findOrFail($id);
        $proposal = Pengabdian::findOrFail($review->pengabdian_id);
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
            return redirect()->route('pengabdian-rev.index')
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

        return redirect()->route('pengabdian-rev.index')->with('success', 'Review berhasil diperbarui.');
    }

    public function editReview($id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();
        
        $proposal = Pengabdian::with(['anggota', 'rab'])->findOrFail($id);
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
        $review = Review::where('pengabdian_id', $id)->where('reviewer_id', Auth::id())->first();

        $ketuaTim = Anggota_pengabdian::where('pengabdian_id', $id)
        ->where('peran', 'ketua')
        ->first();

        $anggotaTim = Anggota_pengabdian::where('pengabdian_id', $id)
                ->where('peran', 'anggota')
                ->get();

        $ketuaTimName = $ketuaTim ? $ketuaTim->nama : '';
        $nidn = $ketuaTim ? $ketuaTim->nidn : '';
        $jabatan = $ketuaTim ? $ketuaTim->jabatan : '';
                
        $anggotaNames = $anggotaTim->map(function($anggota) {
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
                $allFormsForDate = \App\Models\FormPenilaianReview::getActiveFormsForDate('pengabdian', $review->created_at);
                
                // Filter to only include forms that were used in this review
                $formKriteria = $allFormsForDate->filter(function($form) use ($formIds) {
                    return in_array($form->id, $formIds);
                })->sortBy(function($form) use ($formIds) {
                    return array_search($form->id, $formIds);
                })->values();
            } else {
                // Fallback: use active forms if no review_kriteria exists
                $formKriteria = \App\Models\FormPenilaianReview::where('jenis', 'pengabdian')
                    ->where('is_active', true)
                    ->orderBy('urutan')
                    ->get();
            }

            return view('reviewer.ppm.pengabdian.edit_review', compact(
                'proposal',
                'review',
                'ketuaTimName',
                'nidn',
                'judul',
                'anggotaNames',
                'jabatan',
                'biayaUsulan',
                'sintaIndex',
                'anggotaList',
                'rabItems',
                'fileUrl',
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
        $baseQuery = Pengabdian::with([
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
            $baseQuery->whereHas('laporanKemajuan', function ($query) use ($status) {
                $query->where('status', $status);
            });
        }

        $proposals = $baseQuery->orderByDesc('updated_at')
            ->paginate(10)
            ->withQueryString();

        $filters = $request->only(['search', 'skema', 'year', 'status']);

        // Get all laporan kemajuan reviews to check which ones current reviewer has reviewed
        $reviewedLaporanIds = LaporanKemajuanReview::where('reviewer_id', $reviewerId)
            ->whereIn('status', ['draft', 'selesai'])
            ->pluck('laporan_kemajuan_id')
            ->toArray();

        // Get all laporan kemajuan reviews to check which ones are fully reviewed (2 reviewers)
        $allLaporanReviews = LaporanKemajuanReview::whereIn('status', ['draft', 'selesai'])
            ->get()
            ->groupBy('laporan_kemajuan_id');

        return view('reviewer.ppm.pengabdian.laporan-kemajuan.index', compact(
            'proposals',
            'timeline',
            'currentDate',
            'filterSkemas',
            'filterYears',
            'statusOptions',
            'filters',
            'reviewedLaporanIds',
            'allLaporanReviews'
        ));
    }

    public function laporanKemajuanCreate($id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();
        $reviewerId = Auth::id();

        $proposal = Pengabdian::with([
                'laporanKemajuan' => function ($query) {
                    $query->orderByDesc('created_at');
                },
                'revisionParent.reviews',
                'reviews',
                'user',
                'anggota',
            ])
            ->where('id', $id)
            ->where('is_revised', true)
            ->whereHas('laporanKemajuan')
            ->firstOrFail();

        $latestLaporan = $proposal->laporanKemajuan->first();

        if (!$latestLaporan) {
            return redirect()->route('pengabdian-rev.laporan-kemajuan.index')
                ->with('error', 'Tidak ada laporan kemajuan untuk proposal ini.');
        }

        // Semua reviewer dapat mengakses laporan kemajuan
        // Tidak perlu validasi assignment lagi

        // Ambil form penilaian laporan kemajuan (pengabdian) yang aktif
        $formPengabdianRaw = FormPenilaianLaporanKemajuan::where('jenis', 'pengabdian')
            ->with('subKomponen')
            ->where('is_active', true)
            ->orderBy('urutan', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        // Group by kategori seperti di admin (1 kategori -> banyak komponen -> banyak sub)
        $formPengabdian = collect();
        $grouped = [];

        foreach ($formPengabdianRaw as $item) {
            $kategori = $item->kategori ?? 'uncategorized';
            if (!isset($grouped[$kategori])) {
                $grouped[$kategori] = collect();
            }
            $grouped[$kategori]->push($item);
        }

        $seenCategories = [];
        foreach ($formPengabdianRaw as $item) {
            $kategori = $item->kategori ?? 'uncategorized';
            if (!in_array($kategori, $seenCategories)) {
                $seenCategories[] = $kategori;
                $formPengabdian->put($kategori, $grouped[$kategori]);
            }
        }

        $existingReview = LaporanKemajuanReview::with('items')
            ->where('laporan_kemajuan_id', $latestLaporan->id)
            ->where('reviewer_id', $reviewerId)
            ->first();

        // Track which sub-component is selected for each component
        $existingSelectedSub = [];
        if ($existingReview) {
            foreach ($existingReview->items as $item) {
                if ($item->form_penilaian_laporan_kemajuan_sub_id) {
                    $existingSelectedSub[$item->form_penilaian_laporan_kemajuan_id] = $item->form_penilaian_laporan_kemajuan_sub_id;
                }
            }
        }

        // Get ketua tim pelaksana
        $ketuaTim = $proposal->anggota->where('peran', 'Ketua')->first() 
            ?? $proposal->anggota->where('peran', 'ketua')->first();

        // Get jumlah anggota tim
        $jumlahAnggotaTim = $proposal->anggota->count();

        // Get dana disetujui
        $danaDisetujui = $proposal->biaya_disetujui ?? '-';

        // Get jurusan/prodi dari ketua
        $jurusanProdi = '-';
        if ($ketuaTim) {
            $jurusan = $ketuaTim->jurusan_nama ?? null;
            $prodi = $ketuaTim->program_studi_nama ?? null;
            if ($jurusan && $prodi) {
                $jurusanProdi = $jurusan . ' / ' . $prodi;
            } elseif ($jurusan) {
                $jurusanProdi = $jurusan;
            } elseif ($prodi) {
                $jurusanProdi = $prodi;
            }
        }

        return view('reviewer.ppm.pengabdian.laporan-kemajuan.create', compact(
            'proposal',
            'latestLaporan',
            'timeline',
            'currentDate',
            'formPengabdian',
            'existingReview',
            'existingSelectedSub',
            'ketuaTim',
            'jumlahAnggotaTim',
            'danaDisetujui',
            'jurusanProdi'
        ));
    }

    public function laporanKemajuanStore(Request $request, $id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();
        $reviewerId = Auth::id();

        $proposal = Pengabdian::with([
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
            return redirect()->route('pengabdian-rev.laporan-kemajuan.index')
                ->with('error', 'Tidak ada laporan kemajuan untuk proposal ini.');
        }

        // Semua reviewer dapat mengakses dan menyimpan review laporan kemajuan
        // Tidak perlu validasi assignment lagi

        $formPengabdianRaw = FormPenilaianLaporanKemajuan::where('jenis', 'pengabdian')
            ->with('subKomponen')
            ->where('is_active', true)
            ->orderBy('urutan', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $action = $request->input('action', 'draft');
        $targetStatus = $action === 'submit' ? 'selesai' : 'draft';

        $rules = [
            'sub_komponen' => 'array',
            'sub_komponen.*' => 'nullable|exists:form_penilaian_laporan_kemajuan_sub,id',
            'catatan_umum' => 'nullable|string',
        ];

        $validated = $request->validate($rules);
        $selectedSubKomponen = $validated['sub_komponen'] ?? [];

        // Validate that selected sub-components belong to their components
        // and if submitting, ensure all components with sub-components have one selected
        if ($action === 'submit') {
            foreach ($formPengabdianRaw as $komponen) {
                $subKomponenCount = $komponen->subKomponen->count();
                if ($subKomponenCount > 0) {
                    $componentId = $komponen->id;
                    if (!isset($selectedSubKomponen[$componentId]) || empty($selectedSubKomponen[$componentId])) {
                        return redirect()
                            ->route('pengabdian-rev.laporan-kemajuan.create', $proposal->id)
                            ->with('error', 'Silakan pilih sub komponen untuk semua komponen yang memiliki sub komponen.')
                            ->withInput();
                    }
                    
                    // Verify the selected sub belongs to this component
                    $selectedSubId = $selectedSubKomponen[$componentId];
                    $subKomponen = FormPenilaianLaporanKemajuanSub::find($selectedSubId);
                    if (!$subKomponen || $subKomponen->form_penilaian_id != $componentId) {
                        return redirect()
                            ->route('pengabdian-rev.laporan-kemajuan.create', $proposal->id)
                            ->with('error', 'Sub komponen yang dipilih tidak valid untuk komponen tersebut.')
                            ->withInput();
                    }
                }
            }
        } else {
            // For draft, just validate that selected subs belong to their components
            foreach ($selectedSubKomponen as $componentId => $subId) {
                if ($subId) {
                    $subKomponen = FormPenilaianLaporanKemajuanSub::find($subId);
                    if (!$subKomponen || $subKomponen->form_penilaian_id != $componentId) {
                        return redirect()
                            ->route('pengabdian-rev.laporan-kemajuan.create', $proposal->id)
                            ->with('error', 'Sub komponen yang dipilih tidak valid untuk komponen tersebut.')
                            ->withInput();
                    }
                }
            }
        }

        $review = LaporanKemajuanReview::updateOrCreate(
            [
                'laporan_kemajuan_id' => $latestLaporan->id,
                'reviewer_id' => $reviewerId,
            ],
            [
                'jenis' => 'pengabdian',
            ]
        );

        $review->status = $targetStatus;
        $review->catatan_umum = $validated['catatan_umum'] ?? null;
        $review->submitted_at = $targetStatus === 'selesai' ? now() : null;
        $review->save();

        $review->items()->delete();

        // Save selected sub-components with their configured values
        foreach ($selectedSubKomponen as $componentId => $subId) {
            if ($subId) {
                $subKomponen = FormPenilaianLaporanKemajuanSub::find($subId);
                if ($subKomponen && $subKomponen->form_penilaian_id == $componentId) {
                    $review->items()->create([
                        'form_penilaian_laporan_kemajuan_id' => $componentId,
                        'form_penilaian_laporan_kemajuan_sub_id' => $subId,
                        'nilai' => $subKomponen->nilai, // Use the configured value
                    ]);
                }
            }
        }

        $latestLaporan->status = $targetStatus === 'selesai' ? 'Selesai' : 'Draft';
        $latestLaporan->save();

        $message = $targetStatus === 'selesai'
            ? 'Penilaian laporan kemajuan berhasil disimpan dan ditandai selesai.'
            : 'Draft penilaian laporan kemajuan berhasil disimpan.';

        return redirect()
            ->route('pengabdian-rev.laporan-kemajuan.index')
            ->with('success', $message);
    }

    public function laporanKemajuanPdf($id)
    {
        $reviewerId = Auth::id();

        $proposal = Pengabdian::with([
                'laporanKemajuan' => function ($query) {
                    $query->orderByDesc('created_at');
                },
                'revisionParent.reviews',
                'reviews',
                'user',
                'anggota',
            ])
            ->where('id', $id)
            ->where('is_revised', true)
            ->whereHas('laporanKemajuan')
            ->firstOrFail();

        $latestLaporan = $proposal->laporanKemajuan->first();

        if (!$latestLaporan) {
            return redirect()->route('pengabdian-rev.laporan-kemajuan.index')
                ->with('error', 'Tidak ada laporan kemajuan untuk proposal ini.');
        }

        $existingReview = LaporanKemajuanReview::with('items.formPenilaianLaporanKemajuan', 'items.formPenilaianLaporanKemajuanSub')
            ->where('laporan_kemajuan_id', $latestLaporan->id)
            ->where('reviewer_id', $reviewerId)
            ->where('status', 'selesai')
            ->first();

        if (!$existingReview) {
            return redirect()->route('pengabdian-rev.laporan-kemajuan.index')
                ->with('error', 'Review laporan kemajuan belum selesai atau tidak ditemukan.');
        }

        $formPengabdianRaw = FormPenilaianLaporanKemajuan::where('jenis', 'pengabdian')
            ->with('subKomponen')
            ->where('is_active', true)
            ->orderBy('urutan', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        // Group by kategori
        $formPengabdian = collect();
        $grouped = [];

        foreach ($formPengabdianRaw as $item) {
            $kategori = $item->kategori ?? 'uncategorized';
            if (!isset($grouped[$kategori])) {
                $grouped[$kategori] = collect();
            }
            $grouped[$kategori]->push($item);
        }

        $seenCategories = [];
        foreach ($formPengabdianRaw as $item) {
            $kategori = $item->kategori ?? 'uncategorized';
            if (!in_array($kategori, $seenCategories)) {
                $seenCategories[] = $kategori;
                $formPengabdian->put($kategori, $grouped[$kategori]);
            }
        }

        $ketuaTim = $proposal->anggota->where('peran', 'Ketua')->first() 
            ?? $proposal->anggota->where('peran', 'ketua')->first();

        $jumlahAnggotaTim = $proposal->anggota->count();
        $danaDisetujui = $proposal->biaya_disetujui ?? '-';

        $jurusanProdi = '-';
        if ($ketuaTim) {
            $jurusan = $ketuaTim->jurusan_nama ?? null;
            $prodi = $ketuaTim->program_studi_nama ?? null;
            if ($jurusan && $prodi) {
                $jurusanProdi = $jurusan . ' / ' . $prodi;
            } elseif ($jurusan) {
                $jurusanProdi = $jurusan;
            } elseif ($prodi) {
                $jurusanProdi = $prodi;
            }
        }

        // Calculate total nilai
        $totalNilai = 0;
        foreach ($existingReview->items as $item) {
            if ($item->nilai) {
                $totalNilai += $item->nilai;
            }
        }

        $html = view('pdf.laporan-kemajuan-pengabdian', compact(
            'proposal',
            'latestLaporan',
            'existingReview',
            'formPengabdian',
            'ketuaTim',
            'jumlahAnggotaTim',
            'danaDisetujui',
            'jurusanProdi',
            'totalNilai'
        ))->render();

        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 15,
            'margin_bottom' => 15,
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Laporan_Kemajuan_Pengabdian_' . $proposal->id . '.pdf', 'I');
    }

    protected function getReviewWindow(?Timeline $timeline, Pengabdian $proposal): array
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
}
