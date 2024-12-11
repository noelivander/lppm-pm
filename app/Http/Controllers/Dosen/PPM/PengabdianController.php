<?php
namespace App\Http\Controllers\Dosen\PPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengabdian;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota_pengabdian;
use App\Models\Review;
use Mpdf\Mpdf;

class PengabdianController extends Controller
{
    public function index()
    {
        $pengabdian = Pengabdian::where('user_id', Auth::id())->get();
        return view('dosen.ppm.pengabdian.index', compact('pengabdian'));
    }

    public function viewReviews($pengabdian_id, $review_number)
    {
        // Cari pengabdian berdasarkan ID
        $pengabdian = Pengabdian::findOrFail($pengabdian_id);

        // Ambil review berdasarkan pengabdian_id
        $reviews = Review::where('pengabdian_id', $pengabdian_id)->get();

        // Tentukan review yang akan ditampilkan berdasarkan nomor yang dipilih
        if ($review_number == 1) {
            $review = $reviews->first(); // Review pertama
        } elseif ($review_number == 2) {
            $review = $reviews->skip(1)->first(); // Review kedua
        } else {
            return redirect()->route('pengabdian-dos.index')
                            ->with('error', 'Nomor review tidak valid.');
        }

        // Generate PDF berdasarkan review yang dipilih
        $html = view('pdf.review_template', compact('pengabdian', 'review'))->render();
        
        $mpdf = new \Mpdf\Mpdf(['format' => [215.9, 330.2]]);  // Format F4
        $mpdf->WriteHTML($html);
        $mpdf->Output("Hasil_Review_{$pengabdian->judul}_Review{$review_number}.pdf", 'I');  // Output PDF
    }

    public function store(Request $request)
{
    $request->validate([
        'judul' => 'required',
        'luaran_wajib' => 'required',
        'sinta_index' => 'required',
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

    $pengabdian = Pengabdian::create([
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
        Anggota_pengabdian::create([
            'pengabdian_id' => $pengabdian->id,
            'nama' => $nama,
            'peran' => $request->anggota_peran[$key],
            'jabatan' => $request->anggota_jabatan[$key],
            'nidn' => $request->anggota_nidn[$key],
            'email' => $request->anggota_email[$key],
            'telepon' => $request->anggota_telepon[$key],
        ]);
    }

    return redirect()->route('pengabdian-dos.index')->with('success', 'Proposal submitted successfully.');
}

}
