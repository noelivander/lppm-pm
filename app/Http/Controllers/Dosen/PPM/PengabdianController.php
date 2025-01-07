<?php
namespace App\Http\Controllers\Dosen\PPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengabdian;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota_pengabdian;
use App\Models\Review;
use Mpdf\Mpdf;
use App\Helpers\EncryptionHelper;

class PengabdianController extends Controller
{
    public function index()
    {
        $pengabdian = Pengabdian::where('user_id', Auth::id())->get();

        foreach ($pengabdian as $item) {
            $item->judul = EncryptionHelper::decrypt($item->judul);
            $item->luaran_wajib = EncryptionHelper::decrypt($item->luaran_wajib);
            $item->sinta_index = EncryptionHelper::decrypt($item->sinta_index);
            $item->lama_penelitian = EncryptionHelper::decrypt($item->lama_penelitian);
            $item->biaya_diusulkan = EncryptionHelper::decrypt($item->biaya_diusulkan);
            $item->skema = EncryptionHelper::decrypt($item->skema);
            $item->luaran_tambahan = EncryptionHelper::decrypt($item->luaran_tambahan);
            $item->ringkasan_proposal = EncryptionHelper::decrypt($item->ringkasan_proposal);
        }

        return view('dosen.ppm.pengabdian.index', compact('pengabdian'));
    }

    public function viewReviews($pengabdian_id, $review_number)
    {
        $pengabdian = Pengabdian::findOrFail($pengabdian_id);

        $reviews = Review::where('pengabdian_id', $pengabdian_id)->get();

        if ($review_number == 1) {
            $review = $reviews->first();
        } elseif ($review_number == 2) {
            $review = $reviews->skip(1)->first(); 
        } else {
            return redirect()->route('pengabdian-dos.index')
                            ->with('error', 'Nomor review tidak valid.');
        }

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
            'sinta_index' => 'nullable',
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
            'judul' => EncryptionHelper::encrypt($request->judul),
            'luaran_wajib' => EncryptionHelper::encrypt($request->luaran_wajib),
            'sinta_index' => EncryptionHelper::encrypt($request->sinta_index),
            'lama_penelitian' => EncryptionHelper::encrypt($request->lama_penelitian),
            'biaya_diusulkan' => EncryptionHelper::encrypt($request->biaya_diusulkan),
            'skema' => EncryptionHelper::encrypt($request->skema),
            'luaran_tambahan' => EncryptionHelper::encrypt($request->luaran_tambahan),
            'ringkasan_proposal' => EncryptionHelper::encrypt($request->ringkasan_proposal),
            'dokumen_proposal' => $dokumenProposal,
            'status' => 'Pending',
            'user_id' => Auth::id(),
        ]);

        foreach ($request->anggota_nama as $key => $nama) {
            Anggota_pengabdian::create([
                'pengabdian_id' => $pengabdian->id,
                'nama' => EncryptionHelper::encrypt($nama),
                'jabatan' => EncryptionHelper::encrypt($request->anggota_jabatan[$key]),
                'peran' => $request->anggota_peran[$key],
                'nidn' => EncryptionHelper::encrypt($request->anggota_nidn[$key]),
                'email' => EncryptionHelper::encrypt($request->anggota_email[$key]),
                'telepon' => EncryptionHelper::encrypt($request->anggota_telepon[$key]),
            ]);
        }

        return redirect()->route('pengabdian-dos.index')->with('success', 'Proposal submitted successfully.');
    }

}
