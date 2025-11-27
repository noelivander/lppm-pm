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

class PengabdianController extends Controller
{
    public function index()
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();
        // Hanya tampilkan proposal yang sudah disubmit (bukan draft) dan urutkan terbaru
        $proposals = Pengabdian::where('is_draft', false)
            ->orderByDesc('updated_at')
            ->get();
        $reviews = Review::where('reviewer_id', auth()->id())->pluck('pengabdian_id')->toArray();
        $existingReviews = Review::all();

        // Data sudah tidak dienkripsi, tidak perlu dekripsi
    
        return view('reviewer.ppm.pengabdian.index', compact('proposals', 'reviews', 'existingReviews','timeline','currentDate'));
    }
    

    public function review($id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();
        if (!$timeline || $currentDate < $timeline->review_start_date || $currentDate > $timeline->review_end_date) {
            return redirect()->back()->with('error', 'Anda tidak dapat melakukan review di luar periode yang ditentukan.');
        }
        $proposal = Pengabdian::with(['anggota', 'rab'])->findOrFail($id);
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
    
        if ($review) {
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
                'rabItems'
            ));
        } else {
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
                'rabItems'
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
    
        $html = view('pdf.review_pengabdian', compact('review'))->render();
    
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
            return redirect()->route('pengabdian-rev.index')->with('error', 'Periode review telah berakhir atau belum dimulai.');
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
    
        $review->skor_1 = $request->skor_1;
        $review->skor_2 = $request->skor_2;
        $review->skor_3 = $request->skor_3;
        $review->skor_4 = $request->skor_4;
        $review->skor_5 = $request->skor_5;
    
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
        if (!$timeline || $currentDate < $timeline->review_start_date || $currentDate > $timeline->review_end_date) {
            return redirect()->route('pengabdian-rev.index')->with('error', 'Periode review telah berakhir atau belum dimulai.');
        }
        $validatedData = $request->validate([
            'judul_kegiatan' => 'required|string|max:255',
            'ketua_tim' => 'required|string|max:255',
            'nidn' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'scopus' => 'nullable|string|max:255',
            'anggota' => 'nullable|string|max:255',
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

        $pengabdian = Pengabdian::findOrFail($request->pengabdian_id);
        $totalReviews = Review::where('pengabdian_id', $pengabdian->id)->count();

        if ($totalReviews == 1) {
            $pengabdian->status = 'Diproses';
        } elseif ($totalReviews >= 2) {
            $pengabdian->status = 'Selesai';
        }
        $pengabdian->save();

        return redirect()->route('pengabdian-rev.index')->with('success', 'Review berhasil diperbarui.');
    }

    public function editReview($id)
    {
        $timeline = $this->getActiveTimeline();
        $currentDate = now();
        if (!$timeline || $currentDate < $timeline->review_start_date || $currentDate > $timeline->review_end_date) {
            return redirect()->route('pengabdian-rev.index')->with('error', 'Periode review telah berakhir atau belum dimulai.');
        }
        $proposal = Pengabdian::with(['anggota', 'rab'])->findOrFail($id);
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

        if ($review) {
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
