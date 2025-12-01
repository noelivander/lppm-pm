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


class PenelitianController extends Controller
{
    public function index(Request $request)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        $baseQuery = Penelitian::where('is_draft', false);

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
        $reviews = Review::where('reviewer_id', auth()->id())->pluck('penelitian_id')->toArray();

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
            $reviews = Review::where('reviewer_id', auth()->id())->pluck('penelitian_id')->toArray();
        }
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

    public function review($id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();
        if (!$timeline || $currentDate < $timeline->review_start_date || $currentDate > $timeline->review_end_date) {
            return redirect()->back()->with('error', 'Anda tidak dapat melakukan review di luar periode yang ditentukan.');
        }

        $proposal = Penelitian::with(['anggota', 'rab'])->findOrFail($id);
        
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
        
        $anggotaNames = $anggotaTim->map(function($anggota) {
            return $anggota->nama;
        })->join(', ');
        
        $judul = $proposal->judul;
        $biayaUsulan = $proposal->biaya_diusulkan; 
        $sintaIndex = $proposal->sinta_index;

        // Buat URL publik untuk file proposal
        $fileUrl = Storage::url($proposal->dokumen_proposal);

        if ($review) {
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
                'rabItems'
            ));
        } else {
            return view('reviewer.ppm.penelitian.review', compact(
                'proposal',
                'ketuaTimName',
                'nidn',
                'fileUrl',
                'anggotaNames',
                'jabatan',
                'judul',
                'biayaUsulan',
                'sintaIndex',
                'anggotaList',
                'rabItems'
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
    
        $html = view('pdf.review_template', compact('review'))->render();
    
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
        if (!$timeline || $currentDate < $timeline->review_start_date || $currentDate > $timeline->review_end_date) {
            return redirect()->route('penelitian-rev.index')->with('error', 'Periode review telah berakhir atau belum dimulai.');
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

        $review->skor_1 = $request->skor_1;
        $review->skor_2 = $request->skor_2;
        $review->skor_3 = $request->skor_3;
        $review->skor_4 = $request->skor_4;
        $review->skor_5 = $request->skor_5;

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
        if (!$timeline || $currentDate < $timeline->review_start_date || $currentDate > $timeline->review_end_date) {
            return redirect()->route('penelitian-rev.index')->with('error', 'Periode review telah berakhir atau belum dimulai.');
        }
        $validatedData = $request->validate([
            'judul_kegiatan' => 'required|string|max:255',
            'ketua_tim' => 'required|string|max:255',
            'nidn' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'scopus' => 'nullable|string|max:255',
            'anggota' => 'required|string|max:255',
            'biaya_usulan' => 'required|numeric',
            'disarankan' => 'nullable|string|max:255',
            'skor_1' => 'required|integer|min:1|max:7',
            'skor_2' => 'required|integer|min:1|max:7',
            'skor_3' => 'required|integer|min:1|max:7',
            'skor_4' => 'required|integer|min:1|max:7',
            'skor_5' => 'required|integer|min:1|max:7',
            'komentar' => 'nullable|string',
        ]);

        $review = Review::findOrFail($id);

        $review->update($validatedData);

        $penelitian = Penelitian::findOrFail($review->penelitian_id);
        // Status tetap Diproses jika sudah ada review, tidak perlu diubah lagi

        return redirect()->route('penelitian-rev.index')->with('success', 'Review berhasil diperbarui.');
    }

    public function editReview($id)
    {
        $timeline = $this->getActiveTimeline();
        $currentDate = now();
        if (!$timeline || $currentDate < $timeline->review_start_date || $currentDate > $timeline->review_end_date) {
            return redirect()->route('penelitian-rev.index')->with('error', 'Periode review telah berakhir atau belum dimulai.');
        }
        $proposal = Penelitian::with(['anggota', 'rab'])->findOrFail($id);
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
        
        $anggotaNames = $anggotaTim->map(function($anggota) {
            return $anggota->nama;
        })->join(', ');

        $judul = $proposal->judul;
        $biayaUsulan = $proposal->biaya_diusulkan; 
        $sintaIndex = $proposal->sinta_index;

        // Buat URL publik untuk file proposal
        $fileUrl = Storage::url($proposal->dokumen_proposal);

        if ($review) {
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
                'rabItems'
            ));
        } else {
            return redirect()->back()->with('error', 'Review not found.');
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
