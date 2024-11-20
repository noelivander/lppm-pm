<?php
namespace App\Http\Controllers\Dosen\PPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penelitian;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota;

class PenelitianController extends Controller
{
    public function index()
    {
        $penelitian = Penelitian::where('user_id', Auth::id())->get();
        return view('dosen.ppm.penelitian.index', compact('penelitian'));
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
