<?php
namespace App\Http\Controllers\Dosen\PPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penelitian;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota;
use App\Models\Review;
use Mpdf\Mpdf;

class PenelitianController extends Controller
{
    public function index()
    {
        $penelitian = Penelitian::where('user_id', Auth::id())->get();
        return view('dosen.ppm.penelitian.index', compact('penelitian'));
    }
    public function viewReviews($penelitian_id, $review_number)
    {
        // Cari penelitian berdasarkan ID
        $penelitian = Penelitian::findOrFail($penelitian_id);

        // Ambil review berdasarkan penelitian_id
        $reviews = Review::where('penelitian_id', $penelitian_id)->get();

        // Tentukan review yang akan ditampilkan berdasarkan nomor yang dipilih
        if ($review_number == 1) {
            $review = $reviews->first(); // Review pertama
        } elseif ($review_number == 2) {
            $review = $reviews->skip(1)->first(); // Review kedua
        } else {
            return redirect()->route('penelitian-dos.index')
                            ->with('error', 'Nomor review tidak valid.');
        }

        // Generate PDF berdasarkan review yang dipilih
        $html = view('pdf.review_template', compact('penelitian', 'review'))->render();
        
        $mpdf = new \Mpdf\Mpdf(['format' => [215.9, 330.2]]);  // Format F4
        $mpdf->WriteHTML($html);
        $mpdf->Output("Hasil_Review_{$penelitian->judul}_Review{$review_number}.pdf", 'I');  // Output PDF
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'luaran_wajib' => 'required',
            'lama_penelitian' => 'required',
            'biaya_diusulkan' => 'required',
            'skema' => 'required',
            'luaran_tambahan' => 'nullable',
            'ringkasan_proposal' => 'required',
            'dokumen_proposal' => 'required|mimes:pdf|max:10000',
            'sinta_index' => 'required',
            'anggota_nama' => 'required|array',
            'anggota_nama.*' => 'required|string',
            'anggota_peran' => 'required|array',
            'anggota_peran.*' => 'required|string',
            'anggota_nidn' => 'required|array',
            'anggota_nidn.*' => 'required|string',
            'anggota_jabatan' => 'required|array',
            'anggota_jabatan.*' => 'required|string',
            'anggota_email' => 'required|array',
            'anggota_email.*' => 'required|email',
            'anggota_telepon' => 'required|array',
            'anggota_telepon.*' => 'required|string',
        ]);
        

    $dokumenProposal = $request->file('dokumen_proposal')->store('public/proposals');

    $penelitian = penelitian::create([
        'judul' => $request->judul,
        'luaran_wajib' => $request->luaran_wajib,
        'sinta_index' => $request->sinta_index,
        'lama_penelitian' => $request->lama_penelitian,
        'biaya_diusulkan' => $request->biaya_diusulkan,
        'skema' => $request->skema,
        'luaran_tambahan' => $request->luaran_tambahan,
        'ringkasan_proposal' => $request->ringkasan_proposal,
        'dokumen_proposal' => $dokumenProposal,
        'status' => 'Pending',
        'user_id' => Auth::id(),
    ]);
    

    foreach ($request->anggota_nama as $key => $nama) {
        Anggota::create([
            'penelitian_id' => $penelitian->id,
            'nama' => $nama,
            'jabatan' => $request->anggota_jabatan[$key],
            'peran' => $request->anggota_peran[$key],
            'nidn' => $request->anggota_nidn[$key],
            'email' => $request->anggota_email[$key],
            'telepon' => $request->anggota_telepon[$key],
        ]);
    }

    return redirect()->route('penelitian-dos.index')->with('success', 'Proposal submitted successfully.');
}

}
