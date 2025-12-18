<?php

namespace App\Http\Controllers\Admin\PPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanAkhir;
use App\Models\Penelitian;
use App\Models\Pengabdian;

class LaporanAkhirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $jenis = $request->query('jenis', 'penelitian'); // Default to penelitian

        $query = LaporanAkhir::query();

        // Join relevant tables first to allow searching/filtering on their columns
        // This makes filtering more efficient than "whereHas" in some large datasets, but Eloquent's whereHas is fine here.
        // We stick to the existing structure but apply filters.

        // Filter Jenis first (Base Scope)
        if ($jenis === 'penelitian') {
            $query->whereNotNull('penelitian_id')->with('penelitian.user');
        } else {
            $query->whereNotNull('pengabdian_id')->with('pengabdian.user');
        }

        // Filter: Search (Judul or User Name)
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search, $jenis) {
                if ($jenis === 'penelitian') {
                    $q->whereHas('penelitian', function ($sq) use ($search) {
                        $sq->where('judul', 'like', '%' . $search . '%');
                    });
                } else {
                    $q->whereHas('pengabdian', function ($sq) use ($search) {
                        $sq->where('judul', 'like', '%' . $search . '%');
                    });
                }
                $q->orWhereHas('user', function ($sq) use ($search) {
                    $sq->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        // Filter: Skema
        if ($skema = $request->get('skema')) {
            if ($jenis === 'penelitian') {
                $query->whereHas('penelitian', function ($q) use ($skema) {
                    $q->where('skema', 'like', '%' . $skema . '%');
                });
            } else {
                $query->whereHas('pengabdian', function ($q) use ($skema) {
                    $q->where('skema', 'like', '%' . $skema . '%');
                });
            }
        }

        // Filter: Tahun
        if ($year = $request->get('year')) {
            $query->whereYear('created_at', $year);
        }

        $laporanAkhir = $query->latest()->paginate(10)->withQueryString();

        // Dropdown Data
        // Filter Years
        $filterYears = LaporanAkhir::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        // Filter Skemas
        $penelitianSkemas = Penelitian::distinct()->pluck('skema')->toArray();
        $pengabdianSkemas = Pengabdian::distinct()->pluck('skema')->toArray();
        $filterSkemas = array_unique(array_merge($penelitianSkemas, $pengabdianSkemas));
        sort($filterSkemas);

        return view('admin.ppm.laporan-akhir.index', compact('laporanAkhir', 'jenis', 'filterYears', 'filterSkemas'));
    }
    public function show($id)
    {
        $laporan = LaporanAkhir::with([
            'user.programStudi', // Corrected from prodi
            'penelitian',
            'pengabdian'
        ])->findOrFail($id);

        $jenis = $laporan->penelitian_id ? 'penelitian' : 'pengabdian';

        $laporan->load([
            'reviews' => function ($query) use ($jenis) {
                $query->where('jenis', $jenis);
            },
            'reviews.reviewer',
            'reviews.items.formPenilaian',
            'reviews.items.statusChoice',
            'reviews.items.bobotChoice',
            'reviews.items.subChoice',
        ]);

        $proposal = $laporan->penelitian ?? $laporan->pengabdian;

        // Check for reviews on other LaporanAkhir versions of the same proposal
        $otherReviewsCount = 0;
        $otherLaporanId = null;
        if ($proposal) {
            $allLaporans = $proposal->laporanAkhir()->where('id', '!=', $id)->withCount('reviews')->get();
            $otherReviewsCount = $allLaporans->sum('reviews_count');
            // If we found reviews elsewhere (and current has none), maybe suggest the first one that has reviews
            if ($laporan->reviews->isEmpty() && $otherReviewsCount > 0) {
                $firstWithReviews = $allLaporans->first(function ($l) {
                    return $l->reviews_count > 0;
                });
                if ($firstWithReviews) {
                    $otherLaporanId = $firstWithReviews->id;
                }
            }
        }

        return view('admin.ppm.laporan-akhir.show', compact('laporan', 'jenis', 'proposal', 'otherReviewsCount', 'otherLaporanId'));
    }
}
