<?php

namespace App\Http\Controllers\Admin\PPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanAkhir;
use App\Models\Penelitian;
use App\Models\Pengabdian;
use Mpdf\Mpdf;

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
                // Log the query to see what's happening
                \Illuminate\Support\Facades\Log::info('Loading Reviews for Laporan ID: ' . $query->getParent()->id);
                \Illuminate\Support\Facades\Log::info('Query SQL: ' . $query->toSql());
                \Illuminate\Support\Facades\Log::info('Query Bindings: ' . json_encode($query->getBindings()));
                // $query->where('jenis', $jenis); // Disable filter to ensure visibility
            },
            'reviews.reviewer',
            'reviews.items.formPenilaian',
            'reviews.items.statusChoice',
            'reviews.items.bobotChoice',
            'reviews.items.subChoice',
        ]);

        \Illuminate\Support\Facades\Log::info('Laporan Loaded ID: ' . $laporan->id);
        \Illuminate\Support\Facades\Log::info('Reviews Count: ' . $laporan->reviews->count());

        // AUTO-FIX: If we loaded a Laporan with 0 reviews, but we know reviews exist for this proposal,
        // try to find the Laporan ID that ACTUALLY has the reviews.
        if ($laporan->reviews->isEmpty()) {
            \Illuminate\Support\Facades\Log::info('Current Laporan has 0 reviews. Attempting Auto-Fix...');
            $proposal = $laporan->penelitian ?? $laporan->pengabdian;

            if ($proposal) {
                \Illuminate\Support\Facades\Log::info('Proposal Found: ' . $proposal->id . ' (Type: ' . ($laporan->penelitian ? 'Penelitian' : 'Pengabdian') . ')');

                $otherLaporanWithReviews = $proposal->laporanAkhir()
                    ->where('id', '!=', $laporan->id)
                    ->whereHas('reviews')
                    ->with([
                        // Re-load everything for the "Correct" Laporan
                        'user.programStudi',
                        'penelitian',
                        'pengabdian',
                        'reviews' => function ($q) {
                            // No Type Filter here to see EVERYTHING
                        },
                        'reviews.reviewer',
                        'reviews.items.formPenilaian',
                        'reviews.items.statusChoice',
                        'reviews.items.bobotChoice',
                        'reviews.items.subChoice',
                    ])
                    ->first();

                if ($otherLaporanWithReviews) {
                    \Illuminate\Support\Facades\Log::info('SUCCESS: Found Better Laporan ID: ' . $otherLaporanWithReviews->id . ' with ' . $otherLaporanWithReviews->reviews->count() . ' reviews.');
                    $laporan = $otherLaporanWithReviews; // Swap the object
                    $jenis = $laporan->penelitian_id ? 'penelitian' : 'pengabdian'; // Re-determine jenis
                } else {
                    \Illuminate\Support\Facades\Log::info('FAILURE: No other Laporan found with reviews.');
                    // Debug: List all other Laporan IDs
                    $allIds = $proposal->laporanAkhir()->pluck('id');
                    \Illuminate\Support\Facades\Log::info('All Laporan IDs for this proposal: ' . json_encode($allIds));
                }
            } else {
                \Illuminate\Support\Facades\Log::info('FAILURE: Proposal Relationship is NULL.');
            }
        }

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

        // Fetch Form Structure for Penelitian (to match PDF logic)
        $formPenelitian = \App\Models\FormPenilaianLaporanAkhir::where('jenis', 'penelitian')
            ->where('is_active', true)
            ->with([
                'subKomponen' => function ($q) {
                    $q->orderBy('urutan', 'asc');
                }
            ])
            ->orderBy('urutan', 'asc')
            ->get();

        return view('admin.ppm.laporan-akhir.show', compact('laporan', 'jenis', 'proposal', 'otherReviewsCount', 'otherLaporanId', 'formPenelitian'));
    }

    public function downloadPdf($id, $reviewId)
    {
        $laporan = LaporanAkhir::with(['penelitian.anggota', 'pengabdian.anggota', 'penelitian.revisionParent', 'pengabdian.revisionParent'])->findOrFail($id);
        $review = \App\Models\LaporanAkhirReview::with(['reviewer', 'items'])->findOrFail($reviewId);

        if ($review->laporan_akhir_id != $laporan->id) {
            abort(404, 'Review tidak sesuai dengan laporan akhir');
        }

        $jenis = $review->jenis;
        $proposal = $jenis === 'penelitian' ? $laporan->penelitian : $laporan->pengabdian;

        if (!$proposal) {
            abort(404, 'Proposal tidak ditemukan');
        }

        $latestLaporan = $laporan;
        $existingReview = $review;
        $reviewerName = optional($review->reviewer)->name ?? 'Reviewer';

        // Prepare Common Variables
        $currentDate = now();

        if ($jenis === 'penelitian') {
            // --- PENELITIAN LOGIC ---
            $formPenelitian = \App\Models\FormPenilaianLaporanAkhir::where('jenis', 'penelitian')
                ->where('is_active', true)
                ->orderBy('urutan', 'asc')
                ->orderBy('id', 'asc')
                ->get();

            $ketuaTim = $proposal->anggota->where('peran', 'Ketua')->first()
                ?? $proposal->anggota->whereIn('peran', ['Ketua', 'ketua'])->first();
            $ketuaPeneliti = $ketuaTim; // Alias

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

            // Fallback logical chain for metadata
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

            $html = view('pdf.laporan-akhir-penelitian', [
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

            $mpdf = new Mpdf([
                'format' => 'A4',
                'margin_left' => 25,
                'margin_right' => 25,
                'margin_top' => 20,
                'margin_bottom' => 20,
            ]);
            $mpdf->WriteHTML($html);
            $filename = "Hasil_Review_Laporan_Akhir_Penelitian_" . ($proposal->judul ? \Illuminate\Support\Str::slug($proposal->judul) : 'download') . ".pdf";
            $mpdf->Output($filename, 'I');

        } else {
            // --- PENGABDIAN LOGIC ---
            $formPengabdianRaw = \App\Models\FormPenilaianLaporanAkhir::where('jenis', 'pengabdian')
                ->where('is_active', true)
                ->with('subKomponen')
                ->orderBy('urutan')
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
                ?? $proposal->anggota->whereIn('peran', ['Ketua', 'ketua'])->first();

            $jumlahAnggotaTim = $proposal->anggota->count();
            $danaDisetujui = $proposal->biaya_disetujui > 0 ? $proposal->biaya_disetujui : (optional($proposal->revisionParent)->biaya_disetujui ?? 0);

            $skema = optional($proposal->revisionParent)->skema ?? $proposal->skema ?? '-';

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

            $lamaPenelitian = $proposal->lama_kegiatan ?? '-';

            // Calculate total nilai
            $totalNilai = 0;
            // Ensure items are loaded
            if ($review->relationLoaded('items')) {
                foreach ($review->items as $item) {
                    $totalNilai += $item->nilai;
                }
            } else {
                $totalNilai = $review->items()->sum('nilai');
            }


            $html = view('pdf.laporan-akhir-pengabdian', compact(
                'proposal',
                'latestLaporan',
                'existingReview',
                'formPengabdian',
                'ketuaTim',
                'jumlahAnggotaTim',
                'danaDisetujui',
                'skema',
                'jurusanProdi',
                'lamaPenelitian',
                'reviewerName',
                'totalNilai'
            ))->render();

            $mpdf = new Mpdf([
                'format' => 'A4',
                'margin_left' => 25,
                'margin_right' => 25,
                'margin_top' => 20,
                'margin_bottom' => 20,
            ]);
            $mpdf->WriteHTML($html);
            $filename = "Hasil_Review_Laporan_Akhir_Pengabdian_" . ($proposal->judul ? \Illuminate\Support\Str::slug($proposal->judul) : 'download') . ".pdf";
            $mpdf->Output($filename, 'I');
        }
    }
}
