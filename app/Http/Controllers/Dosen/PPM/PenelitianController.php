<?php
namespace App\Http\Controllers\Dosen\PPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penelitian;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota;
use App\Models\Review;
use Mpdf\Mpdf;
use App\Helpers\EncryptionHelper;
use App\Models\Timeline;

class PenelitianController extends Controller
{

    public function index()
    {
        $currentDate = now();
        $timeline = Timeline::first();
        $penelitian = Penelitian::where('user_id', Auth::id())->get();

        foreach ($penelitian as $item) {
            $item->judul = EncryptionHelper::decrypt($item->judul);
            $item->luaran_wajib = EncryptionHelper::decrypt($item->luaran_wajib);
            $item->sinta_index = EncryptionHelper::decrypt($item->sinta_index);
            $item->lama_penelitian = EncryptionHelper::decrypt($item->lama_penelitian);
            $item->biaya_diusulkan = EncryptionHelper::decrypt($item->biaya_diusulkan);
            $item->skema = EncryptionHelper::decrypt($item->skema);
            $item->luaran_tambahan = EncryptionHelper::decrypt($item->luaran_tambahan);
            $item->ringkasan_proposal = EncryptionHelper::decrypt($item->ringkasan_proposal);
        }

        return view('dosen.ppm.penelitian.index', compact('penelitian','timeline','currentDate'));
    }

    public function viewReviews($penelitian_id, $review_number)
    {
        $penelitian = Penelitian::findOrFail($penelitian_id);

        $reviews = Review::where('penelitian_id', $penelitian_id)->get();

        if ($review_number == 1) {
            $review = $reviews->first();
        } elseif ($review_number == 2) {
            $review = $reviews->skip(1)->first(); 
        } else {
            return redirect()->route('penelitian-dos.index')
                            ->with('error', 'Nomor review tidak valid.');
        }

        $html = view('pdf.review_template', compact('penelitian', 'review'))->render();
        
        $mpdf = new \Mpdf\Mpdf(['format' => [215.9, 330.2]]);  // Format F4
        $mpdf->WriteHTML($html);
        $mpdf->Output("Hasil_Review_{$penelitian->judul}_Review{$review_number}.pdf", 'I');  // Output PDF
    }

    public function store(Request $request)
    {
        $currentDate = now();
        $timeline = Timeline::first(); // Assuming there's only one timeline record
    
        if ($currentDate < $timeline->upload_start_date || $currentDate > $timeline->upload_end_date) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengunggah proposal di luar periode yang ditentukan.');
        }

        $request->validate([
            'judul' => 'required',
            'luaran_wajib' => 'required',
            'lama_penelitian' => 'required',
            'biaya_diusulkan' => 'required',
            'skema' => 'required',
            'luaran_tambahan' => 'nullable',
            'ringkasan_proposal' => 'required',
            'dokumen_proposal' => 'required|mimes:pdf|max:10000',
            'sinta_index' => 'nullable',
            'anggota_nama' => 'required|array',
            'anggota_nama.*' => 'required',
            'anggota_peran' => 'required|array',
            'anggota_peran.*' => 'required',
            'anggota_nidn' => 'required|array',
            'anggota_nidn.*' => 'required',
            'anggota_jabatan' => 'required|array',
            'anggota_jabatan.*' => 'required',
            'anggota_email' => 'required|array',
            'anggota_email.*' => 'required|email',
            'anggota_telepon' => 'required|array',
            'anggota_telepon.*' => 'required',
        ]);

        $dokumenProposal = $request->file('dokumen_proposal')->store('public/proposals');

        $encryptedDokumenProposal = EncryptionHelper::encryptFile($dokumenProposal);

        $penelitian = Penelitian::create([
            'judul' => EncryptionHelper::encrypt($request->judul),
            'luaran_wajib' => EncryptionHelper::encrypt($request->luaran_wajib),
            'sinta_index' => EncryptionHelper::encrypt($request->sinta_index),
            'lama_penelitian' => EncryptionHelper::encrypt($request->lama_penelitian),
            'biaya_diusulkan' => EncryptionHelper::encrypt($request->biaya_diusulkan),
            'skema' => EncryptionHelper::encrypt($request->skema),
            'luaran_tambahan' => EncryptionHelper::encrypt($request->luaran_tambahan),
            'ringkasan_proposal' => EncryptionHelper::encrypt($request->ringkasan_proposal),
            'dokumen_proposal' => $encryptedDokumenProposal,
            'status' => 'Pending',
            'user_id' => Auth::id(),
        ]);

        foreach ($request->anggota_nama as $key => $nama) {
            Anggota::create([
                'penelitian_id' => $penelitian->id,
                'nama' => EncryptionHelper::encrypt($nama),
                'jabatan' => EncryptionHelper::encrypt($request->anggota_jabatan[$key]),
                'peran' => $request->anggota_peran[$key],
                'nidn' => EncryptionHelper::encrypt($request->anggota_nidn[$key]),
                'email' => EncryptionHelper::encrypt($request->anggota_email[$key]),
                'telepon' => EncryptionHelper::encrypt($request->anggota_telepon[$key]),
            ]);
        }

        return redirect()->route('penelitian-dos.index')->with('success', 'Proposal submitted successfully.');
    }

    public function downloadDokumenProposal($id)
    {
        $penelitian = Penelitian::findOrFail($id);
        $encryptedFilePath = $penelitian->dokumen_proposal;

        $decryptedContent = EncryptionHelper::decryptFile($encryptedFilePath);

        return response($decryptedContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="proposal.pdf"');
    }


}
