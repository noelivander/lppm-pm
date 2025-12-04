<?php
namespace App\Http\Controllers\Dosen\PPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengabdian;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota_pengabdian;
use App\Models\RabPengabdian;
use App\Models\Review;
use Mpdf\Mpdf;
use App\Models\Timeline;
use App\Models\PPM\Skema;
use App\Models\PPM\Luaran;
use App\Models\LaporanKemajuan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengabdianController extends Controller
{
    public function index(Request $request)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        $baseQuery = Pengabdian::where('user_id', Auth::id())
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

        $pengabdian = $baseQuery->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        // Cek apakah ada draft
        $draft = Pengabdian::where('user_id', Auth::id())
            ->where('is_draft', true)
            ->first();

        // Data sudah tidak dienkripsi, tidak perlu dekripsi

        $filters = $request->only(['search', 'status', 'skema', 'year']);

        return view('dosen.ppm.pengabdian.index', compact(
            'pengabdian',
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

        $baseQuery = Pengabdian::with(['revisionChild' => function ($query) {
                $query->where('user_id', Auth::id());
            }])
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
                $baseQuery->whereDoesntHave('revisionChild');
            } else {
                $baseQuery->whereHas('revisionChild', function ($query) use ($filters) {
                    $query->where('status', $filters['status']);
                });
            }
        }

        $proposals = $baseQuery->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('dosen.ppm.pengabdian.revisi.index', [
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
        $baseQuery = Pengabdian::with(['revisionParent', 'laporanKemajuan' => function($query) {
                $query->where('tahap', 1)->where('user_id', Auth::id());
            }])
            ->where('user_id', Auth::id())
            ->where('is_draft', false)
            ->where('is_revised', true)
            ->whereNotNull('revised_from_id');

        // Filter skema dari parent proposal
        $filterSkemas = Pengabdian::whereIn('id', function($query) {
                $query->select('revised_from_id')
                    ->from('pengabdian')
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
        $filterYears = Pengabdian::whereIn('id', function($query) {
                $query->select('revised_from_id')
                    ->from('pengabdian')
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
            $baseQuery->whereHas('revisionParent', function($query) use ($filters) {
                $query->where('skema', $filters['skema']);
            });
        }

        if ($filters['year']) {
            $baseQuery->whereHas('revisionParent', function($query) use ($filters) {
                $query->whereYear('created_at', $filters['year']);
            });
        }

        if ($filters['status']) {
            if ($filters['status'] === 'belum_ada') {
                // Filter proposal yang belum ada laporan kemajuan
                $baseQuery->whereDoesntHave('laporanKemajuan', function($query) {
                    $query->where('tahap', 1)->where('user_id', Auth::id());
                });
            } elseif ($filters['status'] === 'Selesai') {
                // Filter proposal yang memiliki laporan kemajuan dengan status Selesai (Diproses, Disetujui, Ditolak, atau Selesai)
                $baseQuery->whereHas('laporanKemajuan', function($query) {
                    $query->where('tahap', 1)
                          ->where('user_id', Auth::id())
                          ->whereIn('status', ['Diproses', 'Disetujui', 'Ditolak', 'Selesai']);
                });
            } else {
                // Filter proposal yang memiliki laporan kemajuan dengan status tertentu
                $baseQuery->whereHas('laporanKemajuan', function($query) use ($filters) {
                    $query->where('tahap', 1)
                          ->where('user_id', Auth::id())
                          ->where('status', $filters['status']);
                });
            }
        }

        $proposals = $baseQuery->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('dosen.ppm.pengabdian.laporan-kemajuan.index', [
            'proposals' => $proposals,
            'timeline' => $timeline,
            'currentDate' => $currentDate,
            'filterSkemas' => $filterSkemas,
            'filterYears' => $filterYears,
            'filters' => $filters,
        ]);
    }

    public function createLaporanKemajuan($id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        // Ambil proposal revisi
        $proposal = Pengabdian::with(['revisionParent'])
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
            ->where('jenis', 'pengabdian')
            ->first();

        // Cek apakah sudah ada laporan kemajuan untuk proposal ini (tahap 1)
        $laporanKemajuan = LaporanKemajuan::where('pengabdian_id', $proposal->id)
            ->where('tahap', 1)
            ->where('user_id', Auth::id())
            ->first();

        // Cek periode pengajuan laporan kemajuan
        $hasProgressWindow = $timeline && $timeline->progress_submission_start_date && $timeline->progress_submission_end_date;
        $isWithinProgressWindow = $hasProgressWindow && $currentDate->between($timeline->progress_submission_start_date, $timeline->progress_submission_end_date);

        return view('dosen.ppm.pengabdian.laporan-kemajuan.create', [
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
        $proposal = Pengabdian::with(['revisionParent'])
            ->where('user_id', Auth::id())
            ->where('is_draft', false)
            ->where('is_revised', true)
            ->whereNotNull('revised_from_id')
            ->findOrFail($id);

        // Cek apakah sudah ada laporan kemajuan untuk proposal ini (tahap 1)
        $existingLaporan = LaporanKemajuan::where('pengabdian_id', $proposal->id)
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
                $laporanKemajuanPath = $laporanKemajuanFile->storeAs('laporan_kemajuan/pengabdian', $laporanKemajuanFileName, 'public');
            } elseif ($isEdit && $existingLaporan) {
                // Jika edit dan tidak upload file baru, gunakan file yang sudah ada
                $laporanKemajuanPath = $existingLaporan->laporan_kemajuan;
            }

            // Upload file laporan keuangan tahap 1 (jika ada file baru)
            $laporanKeuanganPath = null;
            if ($request->hasFile('laporan_keuangan_tahap_1')) {
                $laporanKeuanganFile = $request->file('laporan_keuangan_tahap_1');
                $laporanKeuanganFileName = time() . '_' . str_replace(' ', '_', $laporanKeuanganFile->getClientOriginalName());
                $laporanKeuanganPath = $laporanKeuanganFile->storeAs('laporan_kemajuan/pengabdian', $laporanKeuanganFileName, 'public');
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
                    'penelitian_id' => null,
                    'pengabdian_id' => $proposal->id,
                    'laporan_kemajuan' => $laporanKemajuanPath,
                    'laporan_keuangan_tahap_1' => $laporanKeuanganPath,
                    'tahap' => 1,
                    'status' => 'Pending',
                    'user_id' => Auth::id(),
                ]);
            }

            DB::commit();

            return redirect()
                ->route('pengabdian-dos.laporan-kemajuan.index')
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

    public function revisiCreate($id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        $originalProposal = Pengabdian::with(['anggota', 'rab', 'reviews.reviewer'])
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

        $skemaPengabdian = Skema::where('jenis', 'pengabdian')->where('is_shown', 1)->get();
        $luaranWajibPengabdian = Luaran::where('jenis', 'pengabdian')->where('kategori', 'wajib')->where('is_shown', 1)->get();
        $luaranTambahanPengabdian = Luaran::where('jenis', 'pengabdian')->where('kategori', 'tambahan')->where('is_shown', 1)->get();
        $kelompokRab = \App\Models\KelompokRab::where('is_active', true)->orderBy('nama')->get();
        $komponenRab = \App\Models\KomponenRab::with('satuan')->where('is_active', true)->orderBy('nama')->get();
        $satuanRab = \App\Models\SatuanRab::where('is_active', true)->orderBy('nama')->get();

        $existingRevision = Pengabdian::with(['anggota', 'rab'])
            ->where('user_id', Auth::id())
            ->where('is_revised', true)
            ->where('revised_from_id', $originalProposal->id)
            ->first();

        $proposal = $existingRevision ?? $originalProposal;
        $reviews = $originalProposal->reviews;

        return view('dosen.ppm.pengabdian.revisi.form', [
            'proposal' => $proposal,
            'originalProposal' => $originalProposal,
            'isEditingRevision' => (bool) $existingRevision,
            'timeline' => $timeline,
            'currentDate' => $currentDate,
            'skemaPengabdian' => $skemaPengabdian,
            'luaranWajibPengabdian' => $luaranWajibPengabdian,
            'luaranTambahanPengabdian' => $luaranTambahanPengabdian,
            'kelompokRab' => $kelompokRab,
            'komponenRab' => $komponenRab,
            'satuanRab' => $satuanRab,
            'reviews' => $reviews,
            'revisionOpen' => $revisionOpen,
        ]);
    }

    public function revisiStore(Request $request, $id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        $proposal = Pengabdian::where('user_id', Auth::id())
            ->where('is_draft', false)
            ->where('is_revised', false)
            ->where('status', 'Disetujui')
            ->findOrFail($id);

        $existingRevision = Pengabdian::where('user_id', Auth::id())
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
            'sinta_index' => 'nullable|string',
            'lama_penelitian' => 'required|string',
            'biaya_diusulkan' => 'required|string',
            'skema' => 'required|string',
            'luaran_tambahan' => 'nullable|string',
            'ringkasan_proposal' => 'required|string',
            'dokumen_proposal' => ($existingRevision ? 'nullable' : 'required') . '|mimes:pdf|max:10000',
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
                    'luaran_tambahan' => $request->luaran_tambahan,
                    'ringkasan_proposal' => $request->ringkasan_proposal,
                    'dokumen_proposal' => $dokumenProposalPath,
                    'status' => 'Diproses',
                    'admin_status' => null,
                    'admin_comment' => null,
                ]);

                Anggota_pengabdian::where('pengabdian_id', $existingRevision->id)->delete();
                RabPengabdian::where('pengabdian_id', $existingRevision->id)->delete();
                $targetPengabdian = $existingRevision;
            } else {
                $targetPengabdian = Pengabdian::create([
                    'judul' => $request->judul,
                    'luaran_wajib' => $request->luaran_wajib,
                    'sinta_index' => $request->sinta_index,
                    'lama_penelitian' => $request->lama_penelitian,
                    'biaya_diusulkan' => !empty($request->biaya_diusulkan) ? $request->biaya_diusulkan : null,
                    'skema' => $request->skema,
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

                Anggota_pengabdian::create([
                    'pengabdian_id' => $targetPengabdian->id,
                    'nama' => $nama,
                    'jabatan' => $request->anggota_jabatan[$key] ?? null,
                    'peran' => $request->anggota_peran[$key] ?? 'Anggota',
                    'nidn' => $request->anggota_nidn[$key] ?? null,
                    'email' => $request->anggota_email[$key] ?? null,
                    'telepon' => $request->anggota_telepon[$key] ?? null,
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
                    Log::warning('RAB total mismatch during pengabdian revision', [
                        'key' => $key,
                        'calculated' => $calculatedTotal,
                        'submitted' => $total,
                        'pengabdian_id' => $pengabdianBaru->id,
                    ]);
                    $total = $calculatedTotal;
                }

                RabPengabdian::create([
                    'pengabdian_id' => $targetPengabdian->id,
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

            return redirect()->route('pengabdian-dos.revisi.index')
                ->with('success', $existingRevision ? 'Perubahan revisi berhasil disimpan.' : 'Revisi proposal pengabdian berhasil dikirim.');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error storing pengabdian revision', [
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
        $draft = Pengabdian::where('user_id', Auth::id())
            ->where('is_draft', true)
            ->with(['anggota', 'rab'])
            ->first();

        $skemaPengabdian = Skema::where('jenis', 'pengabdian')->where('is_shown', 1)->get();
        $luaranWajibPengabdian = Luaran::where('jenis', 'pengabdian')->where('kategori', 'wajib')->where('is_shown', 1)->get();
        $luaranTambahanPengabdian = Luaran::where('jenis', 'pengabdian')->where('kategori', 'tambahan')->where('is_shown', 1)->get();

        // Get RAB data from database
        $kelompokRab = \App\Models\KelompokRab::where('is_active', true)->orderBy('nama')->get();
        $komponenRab = \App\Models\KomponenRab::with('satuan')->where('is_active', true)->orderBy('nama')->get();
        $satuanRab = \App\Models\SatuanRab::where('is_active', true)->orderBy('nama')->get();

        return view('dosen.ppm.pengabdian.create', compact(
            'timeline',
            'currentDate',
            'skemaPengabdian',
            'luaranWajibPengabdian',
            'luaranTambahanPengabdian',
            'kelompokRab',
            'komponenRab',
            'satuanRab',
            'draft'
        ));
    }

    public function viewReviews($pengabdian_id, $review_number)
    {
        $pengabdian = Pengabdian::findOrFail($pengabdian_id);

        $reviews = Review::where('pengabdian_id', $pengabdian_id)->get();

        if ($review_number == 1) {
            $review = $reviews->first();
        } elseif ($review_number == 2) {
            $review = $reviews->skip(1)->first(); 
        } else {
            return redirect()->route('pengabdian-dos.index')
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
        
        $html = view('pdf.review_pengabdian', compact('pengabdian', 'review', 'formKriteria', 'reviewKriteria'))->render();
        
        $mpdf = new \Mpdf\Mpdf(['format' => [215.9, 330.2]]);  // Format F4
        $mpdf->WriteHTML($html);
        $mpdf->Output("Hasil_Review_{$pengabdian->judul}_Review{$review_number}.pdf", 'I');  // Output PDF
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
                $checkDraft = Pengabdian::where('user_id', Auth::id())
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
                'sinta_index' => 'nullable|string',
                'lama_penelitian' => 'required|string',
                'biaya_diusulkan' => 'required|string',
                'skema' => 'required|string',
                'luaran_tambahan' => 'nullable|string',
                'ringkasan_proposal' => 'required|string',
                'dokumen_proposal' => ($isDraft || $hasExistingDokumen) ? 'nullable|mimes:pdf|max:10000' : 'required|mimes:pdf|max:10000',
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
                $validationRules['ringkasan_proposal'] = 'nullable|string';
                $validationRules['anggota_nama'] = 'nullable|array';
                $validationRules['anggota_nama.*'] = 'nullable|string';
                $validationRules['anggota_peran'] = 'nullable|array';
                $validationRules['anggota_peran.*'] = 'nullable|string|in:Ketua,Anggota';
                $validationRules['anggota_nidn'] = 'nullable|array';
                $validationRules['anggota_nidn.*'] = 'nullable|string';
                $validationRules['anggota_jabatan'] = 'nullable|array';
                $validationRules['anggota_jabatan.*'] = 'nullable|string|in:Dosen,Mahasiswa';
                $validationRules['anggota_email'] = 'nullable|array';
                $validationRules['anggota_email.*'] = 'nullable|email';
                $validationRules['anggota_telepon'] = 'nullable|array';
                $validationRules['anggota_telepon.*'] = 'nullable|string';
                $validationRules['rab_kelompok'] = 'nullable|array';
                $validationRules['rab_kelompok.*'] = 'nullable|string|in:Honorarium,Perjalanan,Operasional,Peralatan,Lainnya';
                $validationRules['rab_komponen'] = 'nullable|array';
                $validationRules['rab_komponen.*'] = 'nullable|string|in:SDM,Material,Jasa,Transportasi,Lainnya';
                $validationRules['rab_item'] = 'nullable|array';
                $validationRules['rab_item.*'] = 'nullable|string|max:255';
                $validationRules['rab_satuan'] = 'nullable|array';
                $validationRules['rab_satuan.*'] = 'nullable|string|max:50';
                $validationRules['rab_volume'] = 'nullable|array';
                $validationRules['rab_volume.*'] = 'nullable|integer';
                $validationRules['rab_harga_satuan'] = 'nullable|array';
                $validationRules['rab_harga_satuan.*'] = 'nullable|numeric|min:0';
                $validationRules['rab_total'] = 'nullable|array';
                $validationRules['rab_total.*'] = 'nullable|numeric|min:0';
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
                $existingDraft = Pengabdian::where('user_id', Auth::id())
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
                $existingDraft = Pengabdian::where('user_id', Auth::id())
                    ->where('is_draft', true)
                    ->first();
                
                $data = [
                    'judul' => $request->judul ?? null,
                    'luaran_wajib' => $request->luaran_wajib ?? null,
                    'sinta_index' => $request->sinta_index ?? null,
                    'lama_penelitian' => $request->lama_penelitian ?? null,
                    'biaya_diusulkan' => !empty($request->biaya_diusulkan) ? $request->biaya_diusulkan : null,
                    'skema' => $request->skema ?? null,
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
                    $pengabdian = $existingDraft;
                    $pengabdian->update($data);
                    
                    // Hapus anggota dan RAB lama
                    Anggota_pengabdian::where('pengabdian_id', $pengabdian->id)->delete();
                    RabPengabdian::where('pengabdian_id', $pengabdian->id)->delete();
                } else {
                    // Create baru
                    $pengabdian = Pengabdian::create($data);
                }

                if (!$pengabdian) {
                    throw new \Exception('Gagal membuat pengabdian.');
                }

                // Create anggota
                if (isset($request->anggota_nama) && is_array($request->anggota_nama)) {
                    foreach ($request->anggota_nama as $key => $nama) {
                        if (empty($nama)) {
                            continue;
                        }

                        Anggota_pengabdian::create([
                            'pengabdian_id' => $pengabdian->id,
                            'nama' => $nama,
                            'jabatan' => !empty($request->anggota_jabatan[$key]) ? $request->anggota_jabatan[$key] : null,
                            'peran' => !empty($request->anggota_peran[$key]) ? $request->anggota_peran[$key] : 'Anggota',
                            'nidn' => !empty($request->anggota_nidn[$key]) ? $request->anggota_nidn[$key] : null,
                            'email' => !empty($request->anggota_email[$key]) ? $request->anggota_email[$key] : null,
                            'telepon' => !empty($request->anggota_telepon[$key]) ? $request->anggota_telepon[$key] : null,
                        ]);
                    }
                }

                // Create RAB items
                if (isset($request->rab_kelompok) && is_array($request->rab_kelompok)) {
                    foreach ($request->rab_kelompok as $key => $kelompok) {
                        if (empty($kelompok)) {
                            continue;
                        }

                        $volume = (int) ($request->rab_volume[$key] ?? 0);
                        $hargaSatuan = (float) ($request->rab_harga_satuan[$key] ?? 0);
                        $total = (float) ($request->rab_total[$key] ?? 0);

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

                        RabPengabdian::create([
                            'pengabdian_id' => $pengabdian->id,
                            'kelompok' => $kelompok,
                            'komponen' => !empty($request->rab_komponen[$key]) ? $request->rab_komponen[$key] : null,
                            'item' => !empty($request->rab_item[$key]) ? $request->rab_item[$key] : null,
                            'satuan' => !empty($request->rab_satuan[$key]) ? $request->rab_satuan[$key] : null,
                            'volume' => $volume > 0 ? $volume : null,
                            'harga_satuan' => $hargaSatuan > 0 ? $hargaSatuan : null,
                            'total' => $total > 0 ? $total : null,
                        ]);
                    }
                } elseif (!$isDraft) {
                    throw new \Exception('Data RAB tidak ditemukan. Minimal satu baris RAB harus diisi.');
                }

                DB::commit();

                if ($isDraft) {
                    return redirect()->route('pengabdian-dos.index')
                        ->with('success', 'Draft berhasil disimpan.');
                } else {
                    return redirect()->route('pengabdian-dos.index')
                        ->with('success', 'Proposal pengabdian berhasil diajukan.');
                }

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error creating pengabdian: ' . $e->getMessage(), [
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
            Log::error('Unexpected error in PengabdianController@store: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan tidak terduga. Silakan coba lagi atau hubungi administrator.');
        }
    }

    protected function getActiveTimeline()
    {
        return Timeline::active()
            ->orderBy('period', 'desc')
            ->ordered()
            ->first();
    }

    public function downloadDokumenProposal($id)
    {
        $pengabdian = Pengabdian::findOrFail($id);
        $filePath = $pengabdian->dokumen_proposal;

        if (!$filePath || !Storage::exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        $defaultName = $pengabdian->judul ? Str::slug($pengabdian->judul, '-') : 'proposal';

        return Storage::download($filePath, $defaultName . '.pdf');
    }
}
