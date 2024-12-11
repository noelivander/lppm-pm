<?php
namespace App\Http\Controllers\Reviewer\PPM;

use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengabdian;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota_pengabdian;
use App\Models\Review;
use Illuminate\Support\Facades\Log;

class PengabdianController extends Controller
{
    // Fungsi index untuk menampilkan semua proposal
    public function index()
    {
        $proposals = Pengabdian::all(); // Mengambil semua proposal
        $reviews = Review::where('reviewer_id', auth()->id())->pluck('pengabdian_id')->toArray();
        $existingReviews = Review::all(); // Mengambil semua review
    
        return view('reviewer.ppm.pengabdian.index', compact('proposals', 'reviews', 'existingReviews'));
    }
    

    public function review($id)
    {
        $proposal = Pengabdian::findOrFail($id);
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
        $anggotaNames = $anggotaTim->pluck('nama')->join(', ');
        $biayaUsulan = $proposal->biaya_diusulkan;
        $sintaIndex = $proposal->sinta_index;
    
        if ($review) {
            return view('reviewer.ppm.pengabdian.edit_review', compact('proposal', 'review', 'ketuaTimName', 'nidn', 'anggotaNames', 'jabatan', 'biayaUsulan', 'sintaIndex'));
        } else {
            return view('reviewer.ppm.pengabdian.review', compact('proposal', 'ketuaTimName', 'nidn', 'anggotaNames', 'jabatan', 'biayaUsulan', 'sintaIndex'));
        }
    }
    

    public function view_pdf($pengabdian_id)
    {
        // Cari review berdasarkan pengabdian_id dan reviewer_id
        $review = Review::where('pengabdian_id', $pengabdian_id)
                        ->where('reviewer_id', auth()->id()) // Pastikan reviewer yang login yang sesuai
                        ->first();
    
        if (!$review) {
            // Jika tidak ada review yang sesuai, tampilkan error atau redirect
            return redirect()->route('pengabdian-rev.index')->with('error', 'Review tidak ditemukan atau Anda tidak memiliki akses.');
        }
    
        // Load template view dan kirimkan data ke view
        $html = view('pdf.review_pengabdian', compact('review'))->render();
    
        // Buat PDF dengan mPDF
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
        $review = new Review();
    
        // Menambahkan data yang diterima dari formulir
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
    
        // Simpan skor kriteria penilaian
        $review->skor_1 = $request->skor_1;
        $review->skor_2 = $request->skor_2;
        $review->skor_3 = $request->skor_3;
        $review->skor_4 = $request->skor_4;
        $review->skor_5 = $request->skor_5;
    
        $review->komentar = $request->komentar;
        $review->save();
    
        // Redirect ke halaman index dengan parameter review_id
        return redirect()->route('pengabdian-rev.index')->with('status', 'Review berhasil disubmit!');
    }

    // Fungsi updateStatus untuk memperbarui status proposal
    public function updateStatus(Request $request, $id)
    {
        // Mencari proposal berdasarkan id
        $proposal = Pengabdian::find($id);

        // Mengupdate status proposal
        $proposal->status = $request->status;
        $proposal->save();

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }
    public function updateReview(Request $request, $id)
    {
        // Validasi inputan form
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

        // Ambil review yang akan diupdate
        $review = Review::findOrFail($id);

        // Update data review dengan data yang divalidasi
        $review->update($validatedData);

        // Redirect ke halaman yang sesuai setelah berhasil update
        return redirect()->route('pengabdian-rev.index')->with('success', 'Review berhasil diperbarui.');
    }

    public function editReview($id)
    {
        $proposal = Pengabdian::findOrFail($id);
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
        $anggotaNames = $anggotaTim->pluck('nama')->join(', ');
        $biayaUsulan = $proposal->biaya_diusulkan;
        $sintaIndex = $proposal->sinta_index;

        if ($review) {
            return view('reviewer.ppm.pengabdian.edit_review', compact('proposal', 'review', 'ketuaTimName', 'nidn', 'anggotaNames', 'jabatan', 'biayaUsulan', 'sintaIndex'));
        } else {
            return redirect()->back()->with('error', 'Review not found.');
        }
    }

}
