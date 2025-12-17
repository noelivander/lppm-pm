<?php
namespace App\Http\Controllers\Dosen\PPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penelitian;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota;
use App\Models\RabPenelitian;
use App\Models\Review;
use Mpdf\Mpdf;
use App\Models\Timeline;
use App\Models\PPM\Skema;
use App\Models\PPM\Luaran;
use App\Models\LaporanKemajuan;
use App\Models\Jurusan;
use App\Models\ProgramStudi;
use App\Models\PPM\BidangPenelitian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PenelitianController extends Controller
{

    public function index(Request $request)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        $baseQuery = Penelitian::where('user_id', Auth::id())
            ->where('is_draft', false)
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

        $statuses = ['Pending', 'Diproses', 'Disetujui', 'Ditolak'];

        if ($search = $request->get('search')) {
            $baseQuery->where('judul', 'like', '%' . $search . '%');
        }

        if ($status = $request->get('status')) {
            $baseQuery->where('status', $status);
        }

        if ($skema = $request->get('skema')) {
            $baseQuery->where('skema', $skema);
        }

        if ($year = $request->get('year')) {
            $baseQuery->whereYear('created_at', $year);
        }

        $penelitian = $baseQuery->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        // Cek apakah ada draft
        $draft = Penelitian::where('user_id', Auth::id())
            ->where('is_draft', true)
            ->first();

        // Data sudah tidak dienkripsi, tidak perlu dekripsi

        $filters = $request->only(['search', 'status', 'skema', 'year']);

        return view('dosen.ppm.penelitian.index', compact(
            'penelitian',
            'timeline',
            'currentDate',
            'draft',
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

        $baseQuery = Penelitian::with([
            'revisionChild' => function ($query) {
                $query->where('user_id', Auth::id());
            }
        ])
            ->where('user_id', Auth::id())
            ->where('is_draft', false)
            ->where('is_revised', false)
            ->where('status', 'Disetujui');

        $filterSkemas = (clone $baseQuery)->select('skema')
            ->whereNotNull('skema')
            ->distinct()
            ->orderBy('skema')
            ->pluck('skema');

        $filterYears = (clone $baseQuery)->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        // Status khusus tampilan revisi: Pending (belum/masih diproses) dan Selesai
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
                // Pending = belum ada revisi yang diupload
                $baseQuery->whereDoesntHave('revisionChild');
            } elseif ($filters['status'] === 'Selesai') {
                // Selesai = sudah ada revisi yang diupload
                $baseQuery->whereHas('revisionChild');
            }
        }

        $proposals = $baseQuery->orderByDesc('created_at')
            ->paginate(10)
            ->appends($request->query());

        return view('dosen.ppm.penelitian.revisi.index', [
            'proposals' => $proposals,
            'timeline' => $timeline,
            'currentDate' => $currentDate,
            'filterSkemas' => $filterSkemas,
            'filterYears' => $filterYears,
            'statuses' => $statuses,
            'filters' => $filters,
        ]);
    }

    public function laporanKemajuanIndex(Request $request)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        // Ambil proposal revisi yang sudah diupload oleh dosen (setelah upload revisi = sudah selesai)
        $baseQuery = Penelitian::with([
            'revisionParent',
            'laporanKemajuan' => function ($query) {
                $query->where('tahap', 1)->where('user_id', Auth::id());
            }
        ])
            ->where('user_id', Auth::id())
            ->where('is_draft', false)
            ->where('is_revised', true)
            ->whereNotNull('revised_from_id');

        // Filter skema dari parent proposal
        $filterSkemas = Penelitian::whereIn('id', function ($query) {
            $query->select('revised_from_id')
                ->from('penelitian')
                ->where('user_id', Auth::id())
                ->where('is_draft', false)
                ->where('is_revised', true)
                ->whereNotNull('revised_from_id');
        })
            ->whereNotNull('skema')
            ->distinct()
            ->orderBy('skema')
            ->pluck('skema');

        // Filter tahun dari parent proposal
        $filterYears = Penelitian::whereIn('id', function ($query) {
            $query->select('revised_from_id')
                ->from('penelitian')
                ->where('user_id', Auth::id())
                ->where('is_draft', false)
                ->where('is_revised', true)
                ->whereNotNull('revised_from_id');
        })
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

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
            $baseQuery->whereHas('revisionParent', function ($query) use ($filters) {
                $query->where('skema', $filters['skema']);
            });
        }

        if ($filters['year']) {
            $baseQuery->whereHas('revisionParent', function ($query) use ($filters) {
                $query->whereYear('created_at', $filters['year']);
            });
        }

        if ($filters['status']) {
            $normalizedStatus = strtolower($filters['status']);

            // Filter berdasarkan jumlah review selesai (Pending/Diproses/Selesai)
            if (in_array($normalizedStatus, ['pending', 'diproses', 'selesai'])) {
                $baseQuery->whereHas('laporanKemajuan', function ($query) use ($normalizedStatus) {
                    $query->where('tahap', 1)
                        ->where('user_id', Auth::id())
                        ->whereRaw("(SELECT COUNT(*) 
                                    FROM laporan_kemajuan_reviews r 
                                    WHERE r.laporan_kemajuan_id = laporan_kemajuan.id 
                                      AND LOWER(TRIM(r.status)) = 'selesai')" .
                            ($normalizedStatus === 'pending'
                                ? " = 0"
                                : ($normalizedStatus === 'diproses' ? " = 1" : " >= 2")));
                });
            }
        }

        $proposals = $baseQuery->orderByDesc('updated_at')
            ->paginate(10)
            ->appends($request->query());

        // Get review counts for each laporan kemajuan
        $reviewCounts = [];
        foreach ($proposals as $proposal) {
            $laporanKemajuan = $proposal->laporanKemajuan->first();
            if ($laporanKemajuan) {
                $reviewCounts[$laporanKemajuan->id] = \App\Models\LaporanKemajuanReview::where('laporan_kemajuan_id', $laporanKemajuan->id)
                    ->where('status', 'selesai')
                    ->count();
            }
        }

        return view('dosen.ppm.penelitian.laporan-kemajuan.index', [
            'proposals' => $proposals,
            'timeline' => $timeline,
            'currentDate' => $currentDate,
            'filterSkemas' => $filterSkemas,
            'filterYears' => $filterYears,
            'filters' => $filters,
            'reviewCounts' => $reviewCounts,
        ]);
    }

    public function createLaporanKemajuan($id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        // Ambil proposal revisi
        $proposal = Penelitian::with(['revisionParent'])
            ->where('user_id', Auth::id())
            ->where('is_draft', false)
            ->where('is_revised', true)
            ->whereNotNull('revised_from_id')
            ->findOrFail($id);

        // Ambil skema dari parent proposal atau dari proposal revisi
        $skemaNama = $proposal->revisionParent->skema ?? $proposal->skema;

        // Cari skema di database berdasarkan nama
        $skema = Skema::where('nama', $skemaNama)
            ->orWhere('kode', $skemaNama)
            ->where('jenis', 'penelitian')
            ->first();

        // Cek apakah sudah ada laporan kemajuan untuk proposal ini (tahap 1)
        $laporanKemajuan = LaporanKemajuan::where('penelitian_id', $proposal->id)
            ->where('tahap', 1)
            ->where('user_id', Auth::id())
            ->first();

        // Cek periode pengajuan laporan kemajuan
        $hasProgressWindow = $timeline && $timeline->progress_submission_start_date && $timeline->progress_submission_end_date;
        $isWithinProgressWindow = $hasProgressWindow && $currentDate->between($timeline->progress_submission_start_date, $timeline->progress_submission_end_date);

        return view('dosen.ppm.penelitian.laporan-kemajuan.create', [
            'proposal' => $proposal,
            'skema' => $skema,
            'timeline' => $timeline,
            'currentDate' => $currentDate,
            'isWithinProgressWindow' => $isWithinProgressWindow,
            'laporanKemajuan' => $laporanKemajuan,
            'isEdit' => $laporanKemajuan !== null,
        ]);
    }

    public function storeLaporanKemajuan(Request $request, $id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        // Validasi periode pengajuan laporan kemajuan
        $hasProgressWindow = $timeline && $timeline->progress_submission_start_date && $timeline->progress_submission_end_date;
        $isWithinProgressWindow = $hasProgressWindow && $currentDate->between($timeline->progress_submission_start_date, $timeline->progress_submission_end_date);

        if (!$isWithinProgressWindow) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Periode pengajuan laporan kemajuan belum dibuka atau sudah ditutup.');
        }

        // Ambil proposal revisi
        $proposal = Penelitian::with(['revisionParent'])
            ->where('user_id', Auth::id())
            ->where('is_draft', false)
            ->where('is_revised', true)
            ->whereNotNull('revised_from_id')
            ->findOrFail($id);

        // Cek apakah sudah ada laporan kemajuan untuk proposal ini (tahap 1)
        $existingLaporan = LaporanKemajuan::where('penelitian_id', $proposal->id)
            ->where('tahap', 1)
            ->where('user_id', Auth::id())
            ->first();

        // Validasi ukuran file sebelum validasi lainnya (hanya jika file diupload)
        if ($request->hasFile('laporan_kemajuan')) {
            $laporanKemajuanSize = $request->file('laporan_kemajuan')->getSize();
            if ($laporanKemajuanSize > 10240 * 1024) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Ukuran file laporan kemajuan terlalu besar. Maksimal 10MB.');
            }
        }

        if ($request->hasFile('laporan_keuangan_tahap_1')) {
            $laporanKeuanganSize = $request->file('laporan_keuangan_tahap_1')->getSize();
            if ($laporanKeuanganSize > 10240 * 1024) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Ukuran file laporan keuangan tahap 1 terlalu besar. Maksimal 10MB.');
            }
        }

        // Validasi file upload (required jika belum ada laporan, optional jika edit)
        $isEdit = $existingLaporan !== null;

        // Validasi: jika edit, file tidak wajib (bisa menggunakan file existing)
        // Jika create, file wajib
        $validationRules = [];
        if (!$isEdit || ($isEdit && !$existingLaporan->laporan_kemajuan)) {
            $validationRules['laporan_kemajuan'] = ['required', 'file', 'mimes:pdf', 'max:10240'];
        } else {
            $validationRules['laporan_kemajuan'] = ['nullable', 'file', 'mimes:pdf', 'max:10240'];
        }

        if (!$isEdit || ($isEdit && !$existingLaporan->laporan_keuangan_tahap_1)) {
            $validationRules['laporan_keuangan_tahap_1'] = ['required', 'file', 'mimes:pdf', 'max:10240'];
        } else {
            $validationRules['laporan_keuangan_tahap_1'] = ['nullable', 'file', 'mimes:pdf', 'max:10240'];
        }

        try {
            $request->validate($validationRules, [
                'laporan_kemajuan.required' => 'File laporan kemajuan wajib diupload.',
                'laporan_kemajuan.file' => 'Laporan kemajuan harus berupa file.',
                'laporan_kemajuan.mimes' => 'Laporan kemajuan harus berformat PDF (.pdf) saja.',
                'laporan_kemajuan.max' => 'Ukuran file laporan kemajuan maksimal 10MB. File yang Anda upload terlalu besar.',
                'laporan_keuangan_tahap_1.required' => 'File laporan keuangan tahap 1 wajib diupload.',
                'laporan_keuangan_tahap_1.file' => 'Laporan keuangan tahap 1 harus berupa file.',
                'laporan_keuangan_tahap_1.mimes' => 'Laporan keuangan tahap 1 harus berformat PDF (.pdf) saja.',
                'laporan_keuangan_tahap_1.max' => 'Ukuran file laporan keuangan tahap 1 maksimal 10MB. File yang Anda upload terlalu besar.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->validator)
                ->with('error', 'Terjadi kesalahan validasi. Silakan periksa kembali file yang diupload.');
        }

        DB::beginTransaction();

        try {
            // Upload file laporan kemajuan (jika ada file baru)
            $laporanKemajuanPath = null;
            if ($request->hasFile('laporan_kemajuan')) {
                $laporanKemajuanFile = $request->file('laporan_kemajuan');
                $laporanKemajuanFileName = time() . '_' . str_replace(' ', '_', $laporanKemajuanFile->getClientOriginalName());
                $laporanKemajuanPath = $laporanKemajuanFile->storeAs('laporan_kemajuan/penelitian', $laporanKemajuanFileName, 'public');
            } elseif ($isEdit && $existingLaporan) {
                // Jika edit dan tidak upload file baru, gunakan file yang sudah ada
                $laporanKemajuanPath = $existingLaporan->laporan_kemajuan;
            }

            // Upload file laporan keuangan tahap 1 (jika ada file baru)
            $laporanKeuanganPath = null;
            if ($request->hasFile('laporan_keuangan_tahap_1')) {
                $laporanKeuanganFile = $request->file('laporan_keuangan_tahap_1');
                $laporanKeuanganFileName = time() . '_' . str_replace(' ', '_', $laporanKeuanganFile->getClientOriginalName());
                $laporanKeuanganPath = $laporanKeuanganFile->storeAs('laporan_kemajuan/penelitian', $laporanKeuanganFileName, 'public');
            } elseif ($isEdit && $existingLaporan) {
                // Jika edit dan tidak upload file baru, gunakan file yang sudah ada
                $laporanKeuanganPath = $existingLaporan->laporan_keuangan_tahap_1;
            }

            // Validasi: file harus ada (baik dari upload baru atau existing)
            if (!$laporanKemajuanPath) {
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'File laporan kemajuan wajib diupload.');
            }

            if (!$laporanKeuanganPath) {
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'File laporan keuangan tahap 1 wajib diupload.');
            }

            if ($existingLaporan) {
                // Update laporan yang sudah ada
                // Hapus file lama hanya jika ada file baru yang diupload
                if ($request->hasFile('laporan_kemajuan') && $existingLaporan->laporan_kemajuan && Storage::disk('public')->exists($existingLaporan->laporan_kemajuan)) {
                    Storage::disk('public')->delete($existingLaporan->laporan_kemajuan);
                }
                if ($request->hasFile('laporan_keuangan_tahap_1') && $existingLaporan->laporan_keuangan_tahap_1 && Storage::disk('public')->exists($existingLaporan->laporan_keuangan_tahap_1)) {
                    Storage::disk('public')->delete($existingLaporan->laporan_keuangan_tahap_1);
                }

                $existingLaporan->update([
                    'laporan_kemajuan' => $laporanKemajuanPath,
                    'laporan_keuangan_tahap_1' => $laporanKeuanganPath,
                    'status' => 'Pending',
                ]);

                $laporanKemajuan = $existingLaporan;
            } else {
                // Buat laporan baru
                $laporanKemajuan = LaporanKemajuan::create([
                    'penelitian_id' => $proposal->id,
                    'pengabdian_id' => null,
                    'laporan_kemajuan' => $laporanKemajuanPath,
                    'laporan_keuangan_tahap_1' => $laporanKeuanganPath,
                    'tahap' => 1,
                    'status' => 'Pending',
                    'user_id' => Auth::id(),
                ]);
            }

            DB::commit();

            return redirect()
                ->route('penelitian-dos.laporan-kemajuan.index')
                ->with('success', 'Laporan kemajuan berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing laporan kemajuan: ' . $e->getMessage());

            // Hapus file yang sudah terupload jika ada error
            if (isset($laporanKemajuanPath) && Storage::disk('public')->exists($laporanKemajuanPath)) {
                Storage::disk('public')->delete($laporanKemajuanPath);
            }
            if (isset($laporanKeuanganPath) && Storage::disk('public')->exists($laporanKeuanganPath)) {
                Storage::disk('public')->delete($laporanKeuanganPath);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan laporan kemajuan. Silakan coba lagi.');
        }
    }

    public function viewLaporanKemajuanReviews($penelitian_id, $review_number)
    {
        $proposal = Penelitian::with([
            'laporanKemajuan' => function ($query) {
                $query->where('tahap', 1)->orderByDesc('created_at');
            },
            'revisionParent.bidangPenelitian',
            'bidangPenelitian',
            'anggota'
        ])
            ->where('user_id', Auth::id())
            ->where('is_revised', true)
            ->findOrFail($penelitian_id);

        $latestLaporan = $proposal->laporanKemajuan->first();

        if (!$latestLaporan) {
            return redirect()->route('penelitian-dos.laporan-kemajuan.index')
                ->with('error', 'Laporan kemajuan tidak ditemukan.');
        }

        $reviews = \App\Models\LaporanKemajuanReview::with('reviewer', 'items.formPenilaian', 'items.subFormPenilaian')
            ->where('laporan_kemajuan_id', $latestLaporan->id)
            ->where('status', 'selesai')
            ->get();

        if ($review_number == 1) {
            $review = $reviews->first();
        } elseif ($review_number == 2) {
            $review = $reviews->skip(1)->first();
        } else {
            return redirect()->route('penelitian-dos.laporan-kemajuan.index')
                ->with('error', 'Nomor review tidak valid.');
        }

        if (!$review) {
            return redirect()->route('penelitian-dos.laporan-kemajuan.index')
                ->with('error', 'Review tidak ditemukan.');
        }

        // Get form penilaian
        $formPenelitian = \App\Models\FormPenilaianLaporanKemajuan::where('jenis', 'penelitian')
            ->with('subKomponen')
            ->where('is_active', true)
            ->orderBy('urutan', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        // Get ketua tim info
        $ketuaTim = $proposal->anggota->where('peran', 'Ketua')->first()
            ?? $proposal->anggota->where('peran', 'ketua')->first();
        $ketuaPeneliti = $ketuaTim; // Alias for PDF template

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

        // Get bidang penelitian, skema, and lama penelitian
        // Try from current proposal first, then parent proposal
        $bidangPenelitian = $proposal->bidang_penelitian_nama
            ?? optional($proposal->bidangPenelitian)->nama
            ?? optional($proposal->revisionParent)->bidang_penelitian_nama
            ?? optional($proposal->revisionParent->bidangPenelitian)->nama
            ?? '-';

        $skema = $proposal->skema
            ?? optional($proposal->revisionParent)->skema
            ?? '-';

        $lamaPenelitian = $proposal->lama_penelitian
            ?? optional($proposal->revisionParent)->lama_penelitian
            ?? '-';

        $proposalYear = $proposal->created_at ? $proposal->created_at->format('Y') : ($proposal->revisionParent && $proposal->revisionParent->created_at ? $proposal->revisionParent->created_at->format('Y') : date('Y'));

        // Get reviewer name
        $reviewerName = optional($review->reviewer)->name ?? '-';

        $html = view('pdf.laporan-kemajuan-penelitian', [
            'proposal' => $proposal,
            'latestLaporan' => $latestLaporan,
            'existingReview' => $review,
            'formPenelitian' => $formPenelitian,
            'ketuaTim' => $ketuaTim,
            'ketuaPeneliti' => $ketuaPeneliti,
            'jurusanProdi' => $jurusanProdi,
            'bidangPenelitian' => $bidangPenelitian,
            'skema' => $skema,
            'lamaPenelitian' => $lamaPenelitian,
            'proposalYear' => $proposalYear,
            'reviewerName' => $reviewerName,
        ])->render();

        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'margin_left' => 25,
            'margin_right' => 25,
            'margin_top' => 20,
            'margin_bottom' => 20,
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output("Hasil_Review_Laporan_Kemajuan_{$proposal->judul}_Review{$review_number}.pdf", 'I');
    }

    public function revisiCreate($id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        $originalProposal = Penelitian::with(['anggota', 'rab', 'reviews.reviewer'])
            ->where('user_id', Auth::id())
            ->where('is_draft', false)
            ->where('is_revised', false)
            ->where('status', 'Disetujui')
            ->findOrFail($id);

        $revisionOpen = $timeline
            && $timeline->revision_start_date
            && $timeline->revision_end_date
            && $currentDate >= $timeline->revision_start_date
            && $currentDate <= $timeline->revision_end_date;

        $skemaPenelitian = Skema::where('jenis', 'penelitian')->where('is_shown', 1)->get();
        $luaranWajibPenelitian = Luaran::where('jenis', 'penelitian')->where('kategori', 'wajib')->where('is_shown', 1)->get();
        $luaranTambahanPenelitian = Luaran::where('jenis', 'penelitian')->where('kategori', 'tambahan')->where('is_shown', 1)->get();
        $bidangPenelitian = BidangPenelitian::where('is_active', true)->orderBy('urutan')->orderBy('nama')->get();
        $jurusanList = Jurusan::orderBy('nama')->get();
        $programStudiList = ProgramStudi::orderBy('nama')->get()->groupBy('jurusan_id');
        $jurusanOptions = $jurusanList->map(function ($j) {
            return ['id' => $j->id, 'nama' => $j->nama];
        })->values();
        $prodiByJurusan = $programStudiList->map(function ($list) {
            return $list->map(function ($p) {
                return ['id' => $p->id, 'nama' => $p->nama, 'jurusan_id' => $p->jurusan_id];
            })->values();
        });
        $kelompokRab = \App\Models\KelompokRab::where('is_active', true)->orderBy('nama')->get();
        $komponenRab = \App\Models\KomponenRab::with('satuan')->where('is_active', true)->orderBy('nama')->get();
        $satuanRab = \App\Models\SatuanRab::where('is_active', true)->orderBy('nama')->get();

        $existingRevision = Penelitian::with(['anggota', 'rab'])
            ->where('user_id', Auth::id())
            ->where('is_revised', true)
            ->where('revised_from_id', $originalProposal->id)
            ->first();

        $proposal = $existingRevision ?? $originalProposal;
        $reviews = $originalProposal->reviews;

        return view('dosen.ppm.penelitian.revisi.form', [
            'proposal' => $proposal,
            'originalProposal' => $originalProposal,
            'isEditingRevision' => (bool) $existingRevision,
            'timeline' => $timeline,
            'currentDate' => $currentDate,
            'skemaPenelitian' => $skemaPenelitian,
            'luaranWajibPenelitian' => $luaranWajibPenelitian,
            'luaranTambahanPenelitian' => $luaranTambahanPenelitian,
            'kelompokRab' => $kelompokRab,
            'komponenRab' => $komponenRab,
            'satuanRab' => $satuanRab,
            'bidangPenelitian' => $bidangPenelitian,
            'jurusanList' => $jurusanList,
            'programStudiList' => $programStudiList,
            'jurusanOptions' => $jurusanOptions,
            'prodiByJurusan' => $prodiByJurusan,
            'reviews' => $reviews,
            'revisionOpen' => $revisionOpen,
        ]);
    }

    public function revisiStore(Request $request, $id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        $proposal = Penelitian::where('user_id', Auth::id())
            ->where('is_draft', false)
            ->where('is_revised', false)
            ->where('status', 'Disetujui')
            ->findOrFail($id);

        $existingRevision = Penelitian::where('user_id', Auth::id())
            ->where('is_revised', true)
            ->where('revised_from_id', $proposal->id)
            ->first();

        if (
            !$timeline ||
            !$timeline->revision_start_date ||
            !$timeline->revision_end_date ||
            $currentDate < $timeline->revision_start_date ||
            $currentDate > $timeline->revision_end_date
        ) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Periode revisi belum dibuka atau sudah ditutup.');
        }

        $validationRules = [
            'judul' => 'required|string|max:255',
            'luaran_wajib' => 'required|string',
            'lama_penelitian' => 'required|string',
            'biaya_diusulkan' => 'required|string',
            'skema' => 'required|string',
            'luaran_tambahan' => 'nullable|string',
            'ringkasan_proposal' => 'required|string',
            'dokumen_proposal' => ($existingRevision ? 'nullable' : 'required') . '|mimes:pdf|max:10000',
            'sinta_index' => 'nullable|string',
            'anggota_nama' => 'required|array|min:1',
            'anggota_nama.*' => 'required|string',
            'anggota_peran' => 'required|array|min:1',
            'anggota_peran.*' => 'required|string|in:Ketua,Anggota',
            'anggota_nidn' => 'required|array|min:1',
            'anggota_nidn.*' => 'required|string',
            'anggota_jabatan' => 'required|array|min:1',
            'anggota_jabatan.*' => 'required|string|in:Dosen,Mahasiswa',
            'anggota_email' => 'required|array|min:1',
            'anggota_email.*' => 'required|email',
            'anggota_telepon' => 'required|array|min:1',
            'anggota_telepon.*' => 'required|string',
            'rab_kelompok' => 'required|array|min:1',
            'rab_kelompok.*' => 'required|string|in:Honorarium,Perjalanan,Operasional,Peralatan,Lainnya',
            'rab_komponen' => 'required|array|min:1',
            'rab_komponen.*' => 'required|string|in:SDM,Material,Jasa,Transportasi,Lainnya',
            'rab_item' => 'required|array|min:1',
            'rab_item.*' => 'required|string|max:255',
            'rab_satuan' => 'required|array|min:1',
            'rab_satuan.*' => 'required|string|max:50',
            'rab_volume' => 'required|array|min:1',
            'rab_volume.*' => 'required|integer|min:1',
            'rab_harga_satuan' => 'required|array|min:1',
            'rab_harga_satuan.*' => 'required|numeric|min:0',
            'rab_total' => 'required|array|min:1',
            'rab_total.*' => 'required|numeric|min:0',
            'rab_total_anggaran' => 'nullable|numeric|min:0',
        ];

        $validatedData = $request->validate($validationRules, [
            'rab_kelompok.required' => 'Minimal satu baris RAB harus diisi.',
            'rab_kelompok.*.required' => 'Kelompok RAB harus dipilih.',
            'rab_komponen.*.required' => 'Komponen RAB harus dipilih.',
            'rab_item.*.required' => 'Item RAB harus diisi.',
            'rab_volume.*.required' => 'Volume RAB harus diisi.',
            'rab_volume.*.integer' => 'Volume harus berupa angka.',
            'rab_volume.*.min' => 'Volume minimal 1.',
            'rab_harga_satuan.*.required' => 'Harga satuan RAB harus diisi.',
            'rab_harga_satuan.*.numeric' => 'Harga satuan harus berupa angka.',
            'rab_harga_satuan.*.min' => 'Harga satuan minimal 0.',
        ]);

        DB::beginTransaction();

        try {
            $dokumenProposalPath = $existingRevision ? $existingRevision->dokumen_proposal : null;

            if ($request->hasFile('dokumen_proposal')) {
                $dokumenProposalPath = $request->file('dokumen_proposal')->store('public/proposals');
                if ($existingRevision && $existingRevision->dokumen_proposal) {
                    Storage::delete($existingRevision->dokumen_proposal);
                }
            } elseif (!$dokumenProposalPath) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Dokumen proposal revisi wajib diunggah.');
            }

            if ($existingRevision) {
                $existingRevision->update([
                    'judul' => $request->judul,
                    'luaran_wajib' => $request->luaran_wajib,
                    'sinta_index' => $request->sinta_index,
                    'lama_penelitian' => $request->lama_penelitian,
                    'biaya_diusulkan' => !empty($request->biaya_diusulkan) ? $request->biaya_diusulkan : null,
                    'skema' => $request->skema,
                    'bidang_penelitian_nama' => $request->bidang_penelitian ?? null,
                    'luaran_tambahan' => $request->luaran_tambahan,
                    'ringkasan_proposal' => $request->ringkasan_proposal,
                    'dokumen_proposal' => $dokumenProposalPath,
                    'status' => 'Diproses',
                    'admin_status' => null,
                    'admin_comment' => null,
                ]);

                Anggota::where('penelitian_id', $existingRevision->id)->delete();
                RabPenelitian::where('penelitian_id', $existingRevision->id)->delete();
                $targetPenelitian = $existingRevision;
            } else {
                $targetPenelitian = Penelitian::create([
                    'judul' => $request->judul,
                    'luaran_wajib' => $request->luaran_wajib,
                    'sinta_index' => $request->sinta_index,
                    'lama_penelitian' => $request->lama_penelitian,
                    'biaya_diusulkan' => !empty($request->biaya_diusulkan) ? $request->biaya_diusulkan : null,
                    'skema' => $request->skema,
                    'bidang_penelitian_nama' => $request->bidang_penelitian ?? null,
                    'luaran_tambahan' => $request->luaran_tambahan,
                    'ringkasan_proposal' => $request->ringkasan_proposal,
                    'dokumen_proposal' => $dokumenProposalPath,
                    'is_draft' => false,
                    'is_revised' => true,
                    'revised_from_id' => $proposal->id,
                    'status' => 'Diproses',
                    'user_id' => Auth::id(),
                    'admin_status' => null,
                    'admin_comment' => null,
                ]);
            }

            foreach ($request->anggota_nama as $key => $nama) {
                if (empty($nama)) {
                    continue;
                }

                Anggota::create([
                    'penelitian_id' => $targetPenelitian->id,
                    'nama' => $nama,
                    'jabatan' => $request->anggota_jabatan[$key] ?? null,
                    'peran' => $request->anggota_peran[$key] ?? 'Anggota',
                    'nidn' => $request->anggota_nidn[$key] ?? null,
                    'email' => $request->anggota_email[$key] ?? null,
                    'telepon' => $request->anggota_telepon[$key] ?? null,
                    'jurusan_nama' => $request->anggota_jurusan[$key] ?? null,
                    'program_studi_nama' => $request->anggota_program_studi[$key] ?? null,
                ]);
            }

            foreach ($request->rab_kelompok as $key => $kelompok) {
                if (empty($kelompok)) {
                    continue;
                }

                $volume = (int) ($request->rab_volume[$key] ?? 0);
                $hargaSatuan = (float) ($request->rab_harga_satuan[$key] ?? 0);
                $total = (float) ($request->rab_total[$key] ?? 0);

                $calculatedTotal = $volume * $hargaSatuan;
                if (abs($calculatedTotal - $total) > 0.01) {
                    Log::warning('RAB total mismatch during revision', [
                        'key' => $key,
                        'calculated' => $calculatedTotal,
                        'submitted' => $total,
                        'penelitian_id' => $targetPenelitian->id,
                    ]);
                    $total = $calculatedTotal;
                }

                RabPenelitian::create([
                    'penelitian_id' => $targetPenelitian->id,
                    'kelompok' => $kelompok,
                    'komponen' => $request->rab_komponen[$key] ?? null,
                    'item' => $request->rab_item[$key] ?? null,
                    'satuan' => $request->rab_satuan[$key] ?? null,
                    'volume' => $volume > 0 ? $volume : null,
                    'harga_satuan' => $hargaSatuan > 0 ? $hargaSatuan : null,
                    'total' => $total > 0 ? $total : null,
                ]);
            }

            DB::commit();

            return redirect()->route('penelitian-dos.revisi.index')
                ->with('success', $existingRevision ? 'Perubahan revisi berhasil disimpan.' : 'Revisi proposal berhasil dikirim. Proposal akan diproses kembali.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing penelitian revision', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
                'original_id' => $proposal->id,
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan revisi. Silakan coba lagi.');
        }
    }

    public function create()
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        // Cek apakah ada draft
        $draft = Penelitian::where('user_id', Auth::id())
            ->where('is_draft', true)
            ->with(['anggota', 'rab'])
            ->first();

        $skemaPenelitian = Skema::where('jenis', 'penelitian')->where('is_shown', 1)->get();
        $luaranWajibPenelitian = Luaran::where('jenis', 'penelitian')->where('kategori', 'wajib')->where('is_shown', 1)->get();
        $luaranTambahanPenelitian = Luaran::where('jenis', 'penelitian')->where('kategori', 'tambahan')->where('is_shown', 1)->get();
        $bidangPenelitian = BidangPenelitian::where('is_active', true)->orderBy('urutan')->orderBy('nama')->get();
        $jurusanList = Jurusan::orderBy('nama')->get();
        $programStudiList = ProgramStudi::orderBy('nama')->get()->groupBy('jurusan_id');
        $jurusanOptions = $jurusanList->map(function ($j) {
            return ['id' => $j->id, 'nama' => $j->nama];
        })->values();
        $prodiByJurusan = $programStudiList->map(function ($list) {
            return $list->map(function ($p) {
                return ['id' => $p->id, 'nama' => $p->nama, 'jurusan_id' => $p->jurusan_id];
            })->values();
        });

        // Get RAB data from database
        $kelompokRab = \App\Models\KelompokRab::where('is_active', true)->orderBy('nama')->get();
        $komponenRab = \App\Models\KomponenRab::with('satuan')->where('is_active', true)->orderBy('nama')->get();
        $satuanRab = \App\Models\SatuanRab::where('is_active', true)->orderBy('nama')->get();

        return view('dosen.ppm.penelitian.create', compact(
            'timeline',
            'currentDate',
            'skemaPenelitian',
            'luaranWajibPenelitian',
            'luaranTambahanPenelitian',
            'kelompokRab',
            'komponenRab',
            'satuanRab',
            'draft',
            'bidangPenelitian',
            'jurusanList',
            'programStudiList',
            'jurusanOptions',
            'prodiByJurusan'
        ));
    }

    public function show($id)
    {
        $penelitian = Penelitian::with(['anggota', 'rab'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('dosen.ppm.penelitian.show', [
            'penelitian' => $penelitian,
            'timeline' => $this->getActiveTimeline(),
            'currentDate' => now(),
        ]);
    }

    public function viewReviews($penelitian_id, $review_number)
    {
        $penelitian = Penelitian::findOrFail($penelitian_id);

        $reviews = Review::where('penelitian_id', $penelitian_id)->get();

        if ($review_number == 1) {
            $review = $reviews->first();
        } elseif ($review_number == 2) {
            $review = $reviews->skip(1)->first();
        } else {
            return redirect()->route('penelitian-dos.index')
                ->with('error', 'Nomor review tidak valid.');
        }

        // Get existing review criteria scores
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
            // Fallback: use active forms if no review_kriteria exists (backward compatibility)
            $formKriteria = \App\Models\FormPenilaianReview::where('jenis', 'penelitian')
                ->where('is_active', true)
                ->orderBy('urutan')
                ->get();
        }

        $html = view('pdf.review_template', compact('penelitian', 'review', 'formKriteria', 'reviewKriteria'))->render();

        $mpdf = new \Mpdf\Mpdf(['format' => [215.9, 330.2]]);  // Format F4
        $mpdf->WriteHTML($html);
        $mpdf->Output("Hasil_Review_{$penelitian->judul}_Review{$review_number}.pdf", 'I');  // Output PDF
    }

    public function store(Request $request)
    {
        try {
            $currentDate = now();
            $timeline = $this->getActiveTimeline();

            $isDraft = $request->has('save_as_draft') && $request->save_as_draft == '1';

            // Check if existing draft has dokumen_proposal for submit (non-draft)
            $hasExistingDokumen = false;
            if (!$isDraft) {
                $checkDraft = Penelitian::where('user_id', Auth::id())
                    ->where('is_draft', true)
                    ->first();
                $hasExistingDokumen = $checkDraft && $checkDraft->dokumen_proposal;
            }

            // Untuk draft, validasi lebih ringan
            if (!$isDraft) {
                if (!$timeline) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Belum ada timeline aktif.');
                }

                if ($currentDate < $timeline->upload_start_date || $currentDate > $timeline->upload_end_date) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Anda tidak dapat mengunggah proposal di luar periode yang ditentukan.');
                }
            }

            // Validation rules - lebih ringan untuk draft
            $validationRules = [
                'judul' => 'required|string|max:255',
                'luaran_wajib' => 'required|string',
                'lama_penelitian' => 'required|string',
                'biaya_diusulkan' => 'required|string',
                'skema' => 'required|string',
                'bidang_penelitian' => 'required|string',
                'luaran_tambahan' => 'nullable|string',
                'ringkasan_proposal' => 'required|string',
                'dokumen_proposal' => ($isDraft || $hasExistingDokumen) ? 'nullable|mimes:pdf|max:10000' : 'required|mimes:pdf|max:10000',
                'sinta_index' => 'nullable|string',
                'anggota_nama' => 'required|array|min:1',
                'anggota_nama.*' => 'required|string',
                'anggota_peran' => 'required|array|min:1',
                'anggota_peran.*' => 'required|string|in:Ketua,Anggota',
                'anggota_nidn' => 'required|array|min:1',
                'anggota_nidn.*' => 'required|string',
                'anggota_jabatan' => 'required|array|min:1',
                'anggota_jabatan.*' => 'required|string|in:Dosen,Mahasiswa',
                'anggota_jurusan' => 'required|array|min:1',
                'anggota_jurusan.*' => 'required|string',
                'anggota_program_studi' => 'required|array|min:1',
                'anggota_program_studi.*' => 'required|string',
                'anggota_email' => 'required|array|min:1',
                'anggota_email.*' => 'required|email',
                'anggota_telepon' => 'required|array|min:1',
                'anggota_telepon.*' => 'required|string',
                // RAB validation
                'rab_kelompok' => 'required|array|min:1',
                'rab_kelompok.*' => 'required|string|in:Honorarium,Perjalanan,Operasional,Peralatan,Lainnya',
                'rab_komponen' => 'required|array|min:1',
                'rab_komponen.*' => 'required|string|in:SDM,Material,Jasa,Transportasi,Lainnya',
                'rab_item' => 'required|array|min:1',
                'rab_item.*' => 'required|string|max:255',
                'rab_satuan' => 'required|array|min:1',
                'rab_satuan.*' => 'required|string|max:50',
                'rab_volume' => 'required|array|min:1',
                'rab_volume.*' => 'required|integer|min:1',
                'rab_harga_satuan' => 'required|array|min:1',
                'rab_harga_satuan.*' => 'required|numeric|min:0',
                'rab_total' => 'required|array|min:1',
                'rab_total.*' => 'required|numeric|min:0',
                'rab_total_anggaran' => 'nullable|numeric|min:0',
            ];

            // Untuk draft, beberapa field tidak wajib
            if ($isDraft) {
                $validationRules['judul'] = 'nullable|string|max:255';
                $validationRules['luaran_wajib'] = 'nullable|string';
                $validationRules['lama_penelitian'] = 'nullable|string';
                $validationRules['biaya_diusulkan'] = 'nullable|string';
                $validationRules['skema'] = 'nullable|string';
                $validationRules['bidang_penelitian'] = 'nullable|string';
                $validationRules['ringkasan_proposal'] = 'nullable|string';
                // Untuk draft, izinkan tabel anggota dikosongkan atau sebagian terisi
                $validationRules['anggota_nama'] = 'nullable|array';
                $validationRules['anggota_nama.*'] = 'nullable|string';
                $validationRules['anggota_peran'] = 'nullable|array';
                $validationRules['anggota_peran.*'] = 'nullable|string';
                $validationRules['anggota_nidn'] = 'nullable|array';
                $validationRules['anggota_nidn.*'] = 'nullable|string';
                $validationRules['anggota_jabatan'] = 'nullable|array';
                $validationRules['anggota_jabatan.*'] = 'nullable|string';
                $validationRules['anggota_jurusan'] = 'nullable|array';
                $validationRules['anggota_jurusan.*'] = 'nullable|string';
                $validationRules['anggota_program_studi'] = 'nullable|array';
                $validationRules['anggota_program_studi.*'] = 'nullable|string';
                $validationRules['anggota_email'] = 'nullable|array';
                $validationRules['anggota_email.*'] = 'nullable|string';
                $validationRules['anggota_telepon'] = 'nullable|array';
                $validationRules['anggota_telepon.*'] = 'nullable|string';
                // Untuk draft, izinkan RAB kosong atau sebagian tanpa validasi angka/daftar
                $validationRules['rab_kelompok'] = 'nullable|array';
                $validationRules['rab_kelompok.*'] = 'nullable|string';
                $validationRules['rab_komponen'] = 'nullable|array';
                $validationRules['rab_komponen.*'] = 'nullable|string';
                $validationRules['rab_item'] = 'nullable|array';
                $validationRules['rab_item.*'] = 'nullable|string|max:255';
                $validationRules['rab_satuan'] = 'nullable|array';
                $validationRules['rab_satuan.*'] = 'nullable|string|max:50';
                $validationRules['rab_volume'] = 'nullable|array';
                $validationRules['rab_volume.*'] = 'nullable';
                $validationRules['rab_harga_satuan'] = 'nullable|array';
                $validationRules['rab_harga_satuan.*'] = 'nullable';
                $validationRules['rab_total'] = 'nullable|array';
                $validationRules['rab_total.*'] = 'nullable';
            }

            $validatedData = $request->validate($validationRules, [
                'rab_kelompok.required' => 'Minimal satu baris RAB harus diisi.',
                'rab_kelompok.*.required' => 'Kelompok RAB harus dipilih.',
                'rab_komponen.*.required' => 'Komponen RAB harus dipilih.',
                'rab_item.*.required' => 'Item RAB harus diisi.',
                'rab_volume.*.required' => 'Volume RAB harus diisi.',
                'rab_volume.*.integer' => 'Volume harus berupa angka.',
                'rab_volume.*.min' => 'Volume minimal 1.',
                'rab_harga_satuan.*.required' => 'Harga satuan RAB harus diisi.',
                'rab_harga_satuan.*.numeric' => 'Harga satuan harus berupa angka.',
                'rab_harga_satuan.*.min' => 'Harga satuan minimal 0.',
            ]);

            // Store file with error handling
            $dokumenProposal = null;
            if ($request->hasFile('dokumen_proposal')) {
                $dokumenProposal = $request->file('dokumen_proposal')->store('public/proposals');
                if (!$dokumenProposal) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Gagal mengunggah dokumen proposal. Silakan coba lagi.');
                }
            } elseif (!$isDraft) {
                // Check if existing draft has dokumen_proposal
                $existingDraft = Penelitian::where('user_id', Auth::id())
                    ->where('is_draft', true)
                    ->first();

                if (!$existingDraft || !$existingDraft->dokumen_proposal) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Dokumen proposal wajib diunggah.');
                }
            }

            // Use database transaction for atomic operations
            DB::beginTransaction();

            try {
                // Cek apakah ada draft yang akan diupdate
                $existingDraft = Penelitian::where('user_id', Auth::id())
                    ->where('is_draft', true)
                    ->first();

                $data = [
                    'judul' => $request->judul ?? null,
                    'luaran_wajib' => $request->luaran_wajib ?? null,
                    'sinta_index' => $request->sinta_index ?? null,
                    'lama_penelitian' => $request->lama_penelitian ?? null,
                    'biaya_diusulkan' => !empty($request->biaya_diusulkan) ? $request->biaya_diusulkan : null,
                    'skema' => $request->skema ?? null,
                    'bidang_penelitian_nama' => $request->bidang_penelitian ?? null,
                    'luaran_tambahan' => $request->luaran_tambahan ?? null,
                    'ringkasan_proposal' => $request->ringkasan_proposal ?? null,
                    'is_draft' => $isDraft,
                    'is_revised' => false,
                    'user_id' => Auth::id(),
                ];

                if ($dokumenProposal) {
                    $data['dokumen_proposal'] = $dokumenProposal;
                    // Hapus file lama jika ada
                    if ($existingDraft && $existingDraft->dokumen_proposal) {
                        Storage::delete($existingDraft->dokumen_proposal);
                    }
                } elseif ($existingDraft && $existingDraft->dokumen_proposal) {
                    // Keep existing file if no new file uploaded
                    $data['dokumen_proposal'] = $existingDraft->dokumen_proposal;
                } else {
                    // Allow null for draft
                    $data['dokumen_proposal'] = null;
                }

                if (!$isDraft) {
                    $data['status'] = 'Pending';
                }

                if ($existingDraft) {
                    // Update draft yang ada
                    $penelitian = $existingDraft;
                    $penelitian->update($data);

                    // Hapus anggota dan RAB lama
                    Anggota::where('penelitian_id', $penelitian->id)->delete();
                    RabPenelitian::where('penelitian_id', $penelitian->id)->delete();
                } else {
                    // Create baru
                    $penelitian = Penelitian::create($data);
                }

                if (!$penelitian) {
                    throw new \Exception('Gagal membuat penelitian.');
                }

                // Create anggota (aman untuk draft yang parsial)
                $anggotaNama = $request->anggota_nama ?? [];
                $anggotaPeran = $request->anggota_peran ?? [];
                $anggotaJabatan = $request->anggota_jabatan ?? [];
                $anggotaNidn = $request->anggota_nidn ?? [];
                $anggotaEmail = $request->anggota_email ?? [];
                $anggotaTelepon = $request->anggota_telepon ?? [];
                $anggotaJurusan = $request->anggota_jurusan ?? [];
                $anggotaProgramStudi = $request->anggota_program_studi ?? [];

                if (is_array($anggotaNama)) {
                    foreach ($anggotaNama as $key => $nama) {
                        $peranVal = $anggotaPeran[$key] ?? null;
                        $jabatanVal = $anggotaJabatan[$key] ?? null;
                        $nidnVal = $anggotaNidn[$key] ?? null;
                        $emailVal = $anggotaEmail[$key] ?? null;
                        $teleponVal = $anggotaTelepon[$key] ?? null;
                        $jurusanVal = $anggotaJurusan[$key] ?? null;
                        $prodiVal = $anggotaProgramStudi[$key] ?? null;

                        $rowEmpty = empty($nama) && empty($peranVal) && empty($jabatanVal) && empty($nidnVal) && empty($emailVal) && empty($teleponVal) && empty($jurusanVal) && empty($prodiVal);
                        if ($rowEmpty) {
                            // baris benar-benar kosong, skip
                            continue;
                        }

                        Anggota::create([
                            'penelitian_id' => $penelitian->id,
                            'nama' => $nama ?? '',
                            'jabatan' => $jabatanVal ?? '',
                            'peran' => $peranVal ?? '',
                            'nidn' => $nidnVal ?? '',
                            'email' => $emailVal ?? '',
                            'telepon' => $teleponVal ?? '',
                            'jurusan_nama' => $jurusanVal ?? '',
                            'program_studi_nama' => $prodiVal ?? '',
                        ]);
                    }
                }

                // Create RAB items (aman untuk draft yang parsial)
                $rabKelompok = $request->rab_kelompok ?? [];
                $rabKomponen = $request->rab_komponen ?? [];
                $rabItem = $request->rab_item ?? [];
                $rabSatuan = $request->rab_satuan ?? [];
                $rabVolume = $request->rab_volume ?? [];
                $rabHarga = $request->rab_harga_satuan ?? [];
                $rabTotal = $request->rab_total ?? [];

                if (is_array($rabKelompok)) {
                    foreach ($rabKelompok as $key => $kelompok) {
                        $komponenVal = $rabKomponen[$key] ?? null;
                        $itemVal = $rabItem[$key] ?? null;
                        $satuanVal = $rabSatuan[$key] ?? null;
                        $volume = (int) ($rabVolume[$key] ?? 0);
                        $hargaSatuan = (float) ($rabHarga[$key] ?? 0);
                        $total = (float) ($rabTotal[$key] ?? 0);

                        $allEmpty = empty($kelompok) && empty($komponenVal) && empty($itemVal) && empty($satuanVal) && $volume === 0 && $hargaSatuan === 0;
                        if ($allEmpty) {
                            // Baris benar-benar kosong, skip
                            continue;
                        }

                        // Untuk submit final: butuh data lengkap
                        if (!$isDraft) {
                            if (empty($kelompok) || empty($komponenVal) || empty($itemVal) || empty($satuanVal) || $volume <= 0) {
                                throw new \Exception('Data RAB tidak lengkap. Lengkapi kelompok, komponen, item, satuan, dan volume.');
                            }
                        }

                        // Validate and calculate total
                        $calculatedTotal = $volume * $hargaSatuan;
                        if (abs($calculatedTotal - $total) > 0.01) {
                            Log::warning('RAB total mismatch', [
                                'key' => $key,
                                'calculated' => $calculatedTotal,
                                'submitted' => $total
                            ]);
                            // Use calculated total for accuracy
                            $total = $calculatedTotal;
                        }

                        RabPenelitian::create([
                            'penelitian_id' => $penelitian->id,
                            'kelompok' => $kelompok ?: '',
                            'komponen' => !empty($komponenVal) ? $komponenVal : '',
                            'item' => !empty($itemVal) ? $itemVal : '',
                            'satuan' => !empty($satuanVal) ? $satuanVal : '',
                            'volume' => $volume > 0 ? $volume : 0,
                            'harga_satuan' => $hargaSatuan > 0 ? $hargaSatuan : 0,
                            'total' => $total > 0 ? $total : 0,
                        ]);
                    }
                } elseif (!$isDraft) {
                    throw new \Exception('Data RAB tidak ditemukan. Minimal satu baris RAB harus diisi.');
                }

                DB::commit();

                if ($isDraft) {
                    return redirect()->route('penelitian-dos.index')
                        ->with('success', 'Draft berhasil disimpan.');
                } else {
                    return redirect()->route('penelitian-dos.index')
                        ->with('success', 'Proposal penelitian berhasil diajukan.');
                }

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error creating penelitian: ' . $e->getMessage(), [
                    'user_id' => Auth::id(),
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                // Clean up uploaded file on error
                if (isset($dokumenProposal) && Storage::exists($dokumenProposal)) {
                    Storage::delete($dokumenProposal);
                }

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Unexpected error in PenelitianController@store: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan tidak terduga. Silakan coba lagi atau hubungi administrator.');
        }
    }

    public function downloadDokumenProposal($id)
    {
        $penelitian = Penelitian::findOrFail($id);
        $filePath = $penelitian->dokumen_proposal;

        if (!Storage::exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        $defaultName = $penelitian->judul ? Str::slug($penelitian->judul, '-') : 'proposal';

        return Storage::download($filePath, $defaultName . '.pdf');
    }


    protected function getActiveTimeline()
    {
        return Timeline::active()
            ->orderBy('period', 'desc')
            ->ordered()
            ->first();
    }

    // --- Laporan Akhir Methods ---

    public function laporanAkhirIndex(Request $request)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        // Base Query: Proposals that have an Approved Laporan Kemajuan
        $baseQuery = Penelitian::with([
            'revisionParent',
            'laporanAkhir.reviews' => function ($q) {
                $q->where('jenis', 'penelitian');
            },
            'laporanKemajuan'
        ])
            ->where('user_id', Auth::id())
            ->whereHas('laporanKemajuan', function ($q) {
                // Must have approved progress report to proceed to final report
                $q->whereIn('status', ['Disetujui', 'Selesai']);
            });

        // Filters (Similar to Kemajuan)
        $filterSkemas = (clone $baseQuery)->pluck('skema')->unique(); // Simplified pluck
        $filterYears = (clone $baseQuery)->selectRaw('YEAR(created_at) as year')->distinct()->pluck('year');

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
            $normalizedStatus = strtolower($filters['status']);

            if (in_array($normalizedStatus, ['pending', 'diproses', 'selesai'])) {
                $baseQuery->whereHas('laporanAkhir', function ($q) use ($normalizedStatus) {
                    $q->whereRaw("(SELECT COUNT(*) 
                                   FROM laporan_akhir_reviews r 
                                   WHERE r.laporan_akhir_id = laporan_akhir.id 
                                     AND r.jenis = 'penelitian'
                                     AND LOWER(TRIM(r.status)) = 'selesai')" .
                        ($normalizedStatus === 'pending'
                            ? " = 0"
                            : ($normalizedStatus === 'diproses' ? " = 1" : " >= 2")));
                });
            }
        }

        $proposals = $baseQuery->orderByDesc('created_at')->paginate(10)->appends($request->query());

        // Review Counts
        $reviewCounts = [];
        foreach ($proposals as $proposal) {
            $laporanAkhir = $proposal->laporanAkhir; // HasOne or First? Model says hasMany reviews
            // Wait, Penelitian hasOne LaporanAkhir? No, LaporanAkhir belongsTo Penelitian.
            // If I defined relation in Penelitian model... I haven't. I need to check Penelitian model.
            // Assuming HasOne or HasMany. Default HasOne makes sense.
            // Actually I'll use direct query for safety as I haven't touched Penelitian model yet.
            $laporanAkhir = \App\Models\LaporanAkhir::where('penelitian_id', $proposal->id)->first();

            if ($laporanAkhir) {
                $reviewCounts[$laporanAkhir->id] = \App\Models\LaporanAkhirReview::where('laporan_akhir_id', $laporanAkhir->id)
                    ->where('jenis', 'penelitian')
                    ->where('status', 'selesai')
                    ->count();
            }
        }

        return view('dosen.ppm.penelitian.laporan-akhir.index', compact('proposals', 'timeline', 'currentDate', 'filterSkemas', 'filterYears', 'filters', 'reviewCounts'));
    }

    public function createLaporanAkhir($id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();
        $proposal = Penelitian::findOrFail($id); // Should add ownership check

        // Ownership check
        if ($proposal->user_id != Auth::id()) {
            abort(403);
        }

        $skemaNama = $proposal->skema;
        $skema = Skema::where('nama', $skemaNama)->first();

        // Check existing
        $laporanAkhir = \App\Models\LaporanAkhir::where('penelitian_id', $proposal->id)->first();

        // Window check (Using final_submission dates)
        $hasWindow = $timeline && $timeline->final_submission_start_date && $timeline->final_submission_end_date;
        $isWithinWindow = $hasWindow && $currentDate->between($timeline->final_submission_start_date, $timeline->final_submission_end_date);

        return view('dosen.ppm.penelitian.laporan-akhir.create', compact('proposal', 'skema', 'timeline', 'currentDate', 'isWithinWindow', 'laporanAkhir'));
    }

    public function storeLaporanAkhir(Request $request, $id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        // Window check
        $hasWindow = $timeline && $timeline->final_submission_start_date && $timeline->final_submission_end_date;
        $isWithinWindow = $hasWindow && $currentDate->between($timeline->final_submission_start_date, $timeline->final_submission_end_date);

        if (!$isWithinWindow) {
            return back()->with('error', 'Periode pengajuan laporan akhir ditutup.');
        }

        $proposal = Penelitian::findOrFail($id);
        if ($proposal->user_id != Auth::id()) {
            abort(403);
        }

        $existing = \App\Models\LaporanAkhir::where('penelitian_id', $id)->first();
        $isEdit = $existing !== null;

        $request->validate([
            'laporan_akhir' => $isEdit && $existing->laporan_akhir ? 'nullable|file|mimes:pdf|max:10240' : 'required|file|mimes:pdf|max:10240',
            'laporan_keuangan_tahap_2' => $isEdit && $existing->laporan_keuangan_tahap_2 ? 'nullable|file|mimes:pdf|max:10240' : 'required|file|mimes:pdf|max:10240',
        ]);

        DB::beginTransaction();
        try {
            // Upload logic
            $pathLaporan = $existing ? $existing->laporan_akhir : null;
            if ($request->hasFile('laporan_akhir')) {
                if ($pathLaporan && Storage::disk('public')->exists($pathLaporan)) {
                    Storage::disk('public')->delete($pathLaporan);
                }
                $pathLaporan = $request->file('laporan_akhir')->store('laporan_akhir/penelitian', 'public');
            }

            $pathKeuangan = $existing ? $existing->laporan_keuangan_tahap_2 : null;
            if ($request->hasFile('laporan_keuangan_tahap_2')) {
                if ($pathKeuangan && Storage::disk('public')->exists($pathKeuangan)) {
                    Storage::disk('public')->delete($pathKeuangan);
                }
                $pathKeuangan = $request->file('laporan_keuangan_tahap_2')->store('laporan_akhir/penelitian', 'public');
            }

            if ($existing) {
                $existing->update([
                    'laporan_akhir' => $pathLaporan,
                    'laporan_keuangan_tahap_2' => $pathKeuangan,
                    'status' => 'Pending'
                ]);
            } else {
                \App\Models\LaporanAkhir::create([
                    'penelitian_id' => $id,
                    'user_id' => Auth::id(),
                    'laporan_akhir' => $pathLaporan,
                    'laporan_keuangan_tahap_2' => $pathKeuangan,
                    'status' => 'Pending'
                ]);
            }

            DB::commit();
            return redirect()->route('penelitian-dos.laporan-akhir.index')->with('success', 'Laporan Akhir berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function viewLaporanAkhirReviews($penelitian_id, $review_number)
    {
        $proposal = Penelitian::with('anggota', 'bidangPenelitian')->findOrFail($penelitian_id);
        if ($proposal->user_id != Auth::id())
            abort(403);

        $laporanAkhir = \App\Models\LaporanAkhir::where('penelitian_id', $penelitian_id)->first();
        if (!$laporanAkhir)
            return back()->with('error', 'Laporan Akhir belum ada');

        $reviews = \App\Models\LaporanAkhirReview::where('laporan_akhir_id', $laporanAkhir->id)
            ->where('jenis', 'penelitian')
            ->where('status', 'selesai')
            ->get();

        if ($review_number == 1) {
            $existingReview = $reviews->first();
        } elseif ($review_number == 2) {
            $existingReview = $reviews->skip(1)->first();
        } else {
            return back()->with('error', 'Nomor review tidak valid');
        }

        if (!$existingReview) {
            return back()->with('error', 'Review belum tersedia');
        }

        // Fetch Form Data
        $formPenelitian = \App\Models\FormPenilaianLaporanAkhir::where('jenis', 'penelitian')
            ->with(['subKomponen'])
            ->where('is_active', true)
            ->orderBy('urutan')
            ->get();

        // Eager load items for the review
        $existingReview->load([
            'items.formPenilaian',
            'items.statusChoice',
            'items.bobotChoice',
        ]);

        // Calculate Total Score
        $totalNilai = $existingReview->items->sum('nilai');

        // Prepare additional data for PDF
        $ketuaTim = $proposal->anggota->where('peran', 'Ketua')->first();
        $ketuaPeneliti = $ketuaTim; // Alias
        $reviewerName = $existingReview->reviewer->name ?? '-';

        $skema = $proposal->skema ?? '-';
        $lamaPenelitian = $proposal->lama_penelitian ? $proposal->lama_penelitian . ' Tahun' : '-';
        $bidangPenelitian = $proposal->bidang_penelitian_nama ?? ($proposal->bidangPenelitian->nama ?? '-');

        // Jurusan/Prodi logic
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

        $html = view('pdf.laporan-akhir-penelitian', compact(
            'proposal',
            'existingReview',
            'formPenelitian',
            'totalNilai',
            'ketuaPeneliti',
            'jurusanProdi',
            'reviewerName',
            'skema',
            'lamaPenelitian',
            'bidangPenelitian'
        ))->render();

        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'margin_left' => 25,
            'margin_right' => 25,
            'margin_top' => 20,
            'margin_bottom' => 20,
        ]);

        $mpdf->WriteHTML($html);
        $mpdf->Output("Hasil_Review_Laporan_Akhir_{$proposal->judul}_Review{$review_number}.pdf", 'I');
    }
}
