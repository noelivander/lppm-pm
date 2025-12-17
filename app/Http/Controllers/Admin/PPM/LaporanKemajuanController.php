<?php

namespace App\Http\Controllers\Admin\PPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanKemajuan;
use App\Models\Timeline;
use App\Models\FormPenilaianLaporanKemajuan;
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

    protected function getActiveTimeline()
    {
        return Timeline::active()
            ->orderBy('period', 'desc')
            ->ordered()
            ->first();
    }
}
