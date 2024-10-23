<?php
namespace App\Http\Controllers\Reviewer\PPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penelitian;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota;
use App\Models\Review;

class PenelitianController extends Controller
{
    // Fungsi index untuk menampilkan semua proposal
    public function index()
    {
        $proposals = Penelitian::all(); // Mengambil semua proposal
        $reviews = Review::where('reviewer_id', auth()->id())->pluck('penelitian_id')->toArray();
        $existingReviews = Review::all(); // Mengambil semua review
    
        return view('reviewer.ppm.penelitian.index', compact('proposals', 'reviews', 'existingReviews'));
    }
    

    public function review($id)
    {
        $proposal = Penelitian::findOrFail($id);
        $review = Review::where('penelitian_id', $id)->where('reviewer_id', Auth::id())->first();  // Cek apakah review sudah ada

        if ($review) {
            // Jika review sudah ada, arahkan ke form edit review
            return view('reviewer.ppm.penelitian.edit_review', compact('proposal', 'review'));
        } else {
            // Jika review belum ada, tampilkan form submit review
            return view('reviewer.ppm.penelitian.review', compact('proposal'));
    }
    }
    public function submitReview(Request $request, $id)
    {
        $proposal = Penelitian::findOrFail($id);

        $request->validate([
            'reviewer_name' => 'required',
            'background' => 'required',
            'research_objective' => 'required',
            'methodology' => 'required',
            'results' => 'required',
            'strengths' => 'required',
            'weaknesses' => 'required',
            'discussion' => 'required',
        ]);

        Review::create([
            'penelitian_id' => $proposal->id,
            'reviewer_id' => Auth::id(),
            'reviewer_name' => $request->reviewer_name,
            'background' => $request->background,
            'research_objective' => $request->research_objective,
            'methodology' => $request->methodology,
            'results' => $request->results,
            'strengths' => $request->strengths,
            'weaknesses' => $request->weaknesses,
            'discussion' => $request->discussion,
        ]);

        return redirect()->route('penelitian-rev.index')->with('success', 'Review berhasil disimpan.');
    }
    // Fungsi store untuk menyimpan proposal baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required',
            'luaran_wajib' => 'required',
            'lama_penelitian' => 'required',
            'biaya_diusulkan' => 'required',
            'skema' => 'required',
            'luaran_tambahan' => 'nullable',
            'ringkasan_proposal' => 'required',
            'dokumen_proposal' => 'required|mimes:pdf|max:10000',
            'anggota_nama' => 'required|array',
            'anggota_nama.*' => 'required|string',
            'anggota_peran' => 'required|array',
            'anggota_peran.*' => 'required|string',
            'anggota_email' => 'required|array',
            'anggota_email.*' => 'required|email',
            'anggota_telepon' => 'required|array',
            'anggota_telepon.*' => 'required|string',
        ]);
    
        // Menyimpan dokumen proposal
        $dokumenProposal = $request->file('dokumen_proposal')->store('public/proposals');
    
        // Membuat instance penelitian baru dan menyimpan data proposal
        $penelitian = Penelitian::create([
            'judul' => $request->judul,
            'luaran_wajib' => $request->luaran_wajib,
            'lama_penelitian' => $request->lama_penelitian,
            'biaya_diusulkan' => $request->biaya_diusulkan,
            'skema' => $request->skema,
            'luaran_tambahan' => $request->luaran_tambahan,
            'ringkasan_proposal' => $request->ringkasan_proposal,
            'dokumen_proposal' => $dokumenProposal,
            'status' => 'Pending',
            'user_id' => Auth::id(),
        ]);
    
        // Menyimpan data anggota penelitian
        foreach ($request->anggota_nama as $key => $nama) {
            Anggota::create([
                'penelitian_id' => $penelitian->id,
                'nama' => $nama,
                'peran' => $request->anggota_peran[$key],
                'email' => $request->anggota_email[$key],
                'telepon' => $request->anggota_telepon[$key],
            ]);
        }
    
        // Redirect ke halaman proposal reviewer dengan pesan sukses
        return redirect()->route('penelitian-rev.index')->with('success', 'Proposal submitted successfully.');
    }

    // Fungsi updateStatus untuk memperbarui status proposal
    public function updateStatus(Request $request, $id)
    {
        // Mencari proposal berdasarkan id
        $proposal = Penelitian::find($id);

        // Mengupdate status proposal
        $proposal->status = $request->status;
        $proposal->save();

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }
    public function updateReview(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        // Lakukan validasi input di sini jika perlu

        // Update review dengan data dari request
        $review->update([
            'background' => $request->background,
            'research_objective' => $request->research_objective,
            'methodology' => $request->methodology,
            'results' => $request->results,
            'strengths' => $request->strengths,
            'weaknesses' => $request->weaknesses,
            'discussion' => $request->discussion,
        ]);

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('penelitian-rev.index')->with('success', 'Review berhasil diperbarui.');
    }

    public function editReview($id)
    {
        $proposal = Penelitian::findOrFail($id);
        $review = Review::where('penelitian_id', $id)->where('reviewer_id', Auth::id())->first();

        if ($review) {
            return view('reviewer.ppm.penelitian.edit_review', compact('proposal', 'review'));
        } else {
            return redirect()->back()->with('error', 'Review not found.');
        }
    }

}
