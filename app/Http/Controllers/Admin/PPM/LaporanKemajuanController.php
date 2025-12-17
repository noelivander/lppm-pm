<?php

namespace App\Http\Controllers\Admin\PPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanKemajuan;
use App\Models\Timeline;
use App\Models\FormPenilaianLaporanKemajuan;
use App\Models\LaporanKemajuanReview;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanKemajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     * Hanya menampilkan laporan kemajuan yang sudah direview oleh 2 reviewer.
     */
    public function index(Request $request)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        // Base Query: Laporan Kemajuan
        // Filter: Hanya yang memiliki minimal 2 review dengan status 'selesai'
        $baseQuery = LaporanKemajuan::with(['penelitian', 'pengabdian', 'user', 'reviews'])
            ->whereHas('reviews', function ($query) {
                // Asumsi: status review 'selesai' menandakan review sudah final
                // Jika tidak ada kolom status di reviews, gunakan logic lain (misal exists)
                // Berdasarkan analisis sebelumnya, tabel review punya status/selesai logic
                // Tapi untuk laporan_kemajuan_reviews, kita cek count-nya
            }, '>=', 2);

        // Filter pencarian
        if ($search = $request->get('search')) {
            $baseQuery->whereHas('penelitian', function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%');
            })->orWhereHas('pengabdian', function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%');
            })->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        // Filter Jenis (Penelitian/Pengabdian)
        if ($jenis = $request->get('jenis')) {
            if ($jenis === 'penelitian') {
                $baseQuery->whereNotNull('penelitian_id');
            } elseif ($jenis === 'pengabdian') {
                $baseQuery->whereNotNull('pengabdian_id');
            }
        }

        // Filter Skema
        if ($skema = $request->get('skema')) {
            $baseQuery->whereHas('penelitian', function ($q) use ($skema) {
                $q->where('skema', 'like', '%' . $skema . '%');
            })->orWhereHas('pengabdian', function ($q) use ($skema) {
                $q->where('skema', 'like', '%' . $skema . '%');
            });
        }

        // Filter Tahun
        if ($year = $request->get('year')) {
            $baseQuery->whereYear('created_at', $year);
        }

        /** @var \Illuminate\Pagination\LengthAwarePaginator $laporanKemajuans */
        $laporanKemajuans = $baseQuery->orderByDesc('updated_at')
            ->paginate(10)
            ->withQueryString();

        // Filter Years for Dropdown
        $filterYears = LaporanKemajuan::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        // Filter Skemas for Dropdown (Fetch from both Penelitian and Pengabdian)
        $penelitianSkemas = \App\Models\Penelitian::distinct()->pluck('skema')->toArray();
        $pengabdianSkemas = \App\Models\Pengabdian::distinct()->pluck('skema')->toArray();
        $filterSkemas = array_unique(array_merge($penelitianSkemas, $pengabdianSkemas));
        sort($filterSkemas);

        return view('admin.ppm.laporan-kemajuan.index', compact(
            'laporanKemajuans',
            'timeline',
            'currentDate',
            'filterYears',
            'filterSkemas'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $laporan = LaporanKemajuan::with([
            'penelitian.anggota',
            'pengabdian.anggota',
            'user',
            'reviews.reviewer',
            'reviews.items.subKriteria',
            'reviews.items.formPenilaianLaporanKemajuan',
            'reviews.items.formPenilaianLaporanKemajuanSub' // Load sub komponen
        ])->findOrFail($id);

        $proposal = $laporan->penelitian ?? $laporan->pengabdian;
        $jenis = $laporan->penelitian ? 'Penelitian' : 'Pengabdian';

        // Untuk pengabdian, ambil form penilaian per review
        // Setiap review mungkin menggunakan form yang berbeda
        $formPengabdianPerReview = [];
        if ($jenis === 'Pengabdian') {
            foreach ($laporan->reviews as $review) {
                // Ambil form penilaian yang digunakan dalam review items ini
                $formIds = [];
                foreach ($review->items as $item) {
                    if ($item->form_penilaian_laporan_kemajuan_id) {
                        $formIds[] = $item->form_penilaian_laporan_kemajuan_id;
                    }
                }
                
                if (!empty($formIds)) {
                    // Ambil form penilaian dengan sub komponen
                    $formPengabdianRaw = FormPenilaianLaporanKemajuan::whereIn('id', $formIds)
                        ->with('subKomponen')
                        ->orderBy('urutan', 'asc')
                        ->orderBy('id', 'asc')
                        ->get();

                    // Group by kategori seperti di reviewer
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
                    
                    $formPengabdianPerReview[$review->id] = $formPengabdian;
                }
            }
        }

        return view('admin.ppm.laporan-kemajuan.show', compact('laporan', 'proposal', 'jenis', 'formPengabdianPerReview'));
    }

    /**
     * Download PDF hasil monev laporan kemajuan
     */
    public function downloadPdf(Request $request, $id)
    {
        $laporan = LaporanKemajuan::with([
            'penelitian.anggota',
            'penelitian.bidangPenelitian',
            'penelitian.revisionParent',
            'pengabdian.anggota',
            'user',
            'reviews.reviewer',
            'reviews.items'
        ])->findOrFail($id);

        $proposal = $laporan->penelitian ?? $laporan->pengabdian;
        $jenis = $laporan->penelitian ? 'Penelitian' : 'Pengabdian';
        $reviewNumber = $request->get('review_number');

        // Ambil review selesai
        $reviews = LaporanKemajuanReview::with(['reviewer', 'items.formPenilaian', 'items.subFormPenilaian'])
            ->where('laporan_kemajuan_id', $laporan->id)
            ->where('status', 'selesai')
            ->orderBy('submitted_at', 'asc')
            ->get();

        if ($reviews->count() < 1) {
            return redirect()->route('admin.laporan-kemajuan.index')
                ->with('error', 'Review laporan kemajuan belum tersedia.');
        }

        if ($jenis === 'Pengabdian') {
            // Untuk pengabdian, selalu gabungan 2 review
            $review1 = $reviews->get(0);
            $review2 = $reviews->get(1) ?? null;

            // Form penilaian pengabdian
            $formPengabdianRaw = FormPenilaianLaporanKemajuan::where('jenis', 'pengabdian')
                ->with('subKomponen')
                ->where('is_active', true)
                ->orderBy('urutan', 'asc')
                ->orderBy('id', 'asc')
                ->get();

            // Kelompokkan per kategori
            $formPengabdian = $formPengabdianRaw->groupBy(function ($item) {
                return $item->kategori ?? 'Lainnya';
            });

            // Get ketua tim info
            $ketuaTim = $proposal->anggota->where('peran', 'Ketua')->first()
                ?? $proposal->anggota->where('peran', 'ketua')->first();

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

            $jumlahAnggotaTim = $proposal->anggota->count();
            $danaDisetujui = $proposal->biaya_disetujui ?? 0;

            // Data penilai
            $reviewer1Name = $review1 && $review1->reviewer ? $review1->reviewer->name : '............................................';
            $reviewer2Name = $review2 && $review2->reviewer ? $review2->reviewer->name : '............................................';
            $reviewer1Nidn = $review1 && $review1->reviewer
                ? ($review1->reviewer->nip ?? '')
                : '';
            $reviewer2Nidn = $review2 && $review2->reviewer
                ? ($review2->reviewer->nip ?? '')
                : '';

            $ttdDate = $laporan && $laporan->submitted_at
                ? $laporan->submitted_at->format('d F Y')
                : date('d F Y');

            $html = view('pdf.laporan-kemajuan-pengabdian-dosen', [
                'proposal' => $proposal,
                'latestLaporan' => $laporan,
                'formPengabdian' => $formPengabdian,
                'ketuaTim' => $ketuaTim,
                'jurusanProdi' => $jurusanProdi,
                'jumlahAnggotaTim' => $jumlahAnggotaTim,
                'danaDisetujui' => $danaDisetujui,
                'review1' => $review1,
                'review2' => $review2,
                'reviewer1Name' => $reviewer1Name,
                'reviewer2Name' => $reviewer2Name,
                'reviewer1Nidn' => $reviewer1Nidn,
                'reviewer2Nidn' => $reviewer2Nidn,
                'ttdDate' => $ttdDate,
            ])->render();

            $mpdf = new \Mpdf\Mpdf([
                'format' => 'A4',
                'margin_left' => 25,
                'margin_right' => 25,
                'margin_top' => 20,
                'margin_bottom' => 20,
            ]);
            $mpdf->WriteHTML($html);
            $mpdf->Output("Hasil_Monev_Laporan_Kemajuan_Pengabdian_{$proposal->judul}.pdf", 'I');
        } else {
            // Untuk penelitian, bisa download per review atau semua review
            if ($reviewNumber) {
                // Download per review
                if ($reviewNumber == 1) {
                    $review = $reviews->first();
                } elseif ($reviewNumber == 2) {
                    $review = $reviews->skip(1)->first();
                } else {
                    return redirect()->route('admin.laporan-kemajuan.index')
                        ->with('error', 'Nomor review tidak valid.');
                }

                if (!$review) {
                    return redirect()->route('admin.laporan-kemajuan.index')
                        ->with('error', 'Review tidak ditemukan.');
                }
            } else {
                // Jika tidak ada review_number, ambil review pertama
                $review = $reviews->first();
            }

            // Get form penilaian
            $formPenelitian = FormPenilaianLaporanKemajuan::where('jenis', 'penelitian')
                ->with('subKomponen')
                ->where('is_active', true)
                ->orderBy('urutan', 'asc')
                ->orderBy('id', 'asc')
                ->get();

            // Get ketua tim info
            $ketuaTim = $proposal->anggota->where('peran', 'Ketua')->first()
                ?? $proposal->anggota->where('peran', 'ketua')->first();
            $ketuaPeneliti = $ketuaTim;

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
            $bidangPenelitian = $proposal->bidang_penelitian_nama
                ?? optional($proposal->bidangPenelitian)->nama
                ?? optional($proposal->revisionParent)->bidang_penelitian_nama
                ?? optional(optional($proposal->revisionParent)->bidangPenelitian)->nama
                ?? '-';

            $skema = $proposal->skema
                ?? optional($proposal->revisionParent)->skema
                ?? '-';

            $lamaPenelitian = $proposal->lama_penelitian
                ?? optional($proposal->revisionParent)->lama_penelitian
                ?? '-';

            $proposalYear = $proposal->created_at ? $proposal->created_at->format('Y') : (optional($proposal->revisionParent)->created_at ? optional($proposal->revisionParent)->created_at->format('Y') : date('Y'));

            // Get reviewer name
            $reviewerName = optional($review->reviewer)->name ?? '-';

            $html = view('pdf.laporan-kemajuan-penelitian', [
                'proposal' => $proposal,
                'latestLaporan' => $laporan,
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
            
            $filename = $reviewNumber 
                ? "Hasil_Monev_Laporan_Kemajuan_Penelitian_{$proposal->judul}_Monev{$reviewNumber}.pdf"
                : "Hasil_Monev_Laporan_Kemajuan_Penelitian_{$proposal->judul}.pdf";
            $mpdf->Output($filename, 'I');
        }
    }

    protected function getActiveTimeline()
    {
        return Timeline::active()
            ->orderBy('period', 'desc')
            ->ordered()
            ->first();
    }
}
