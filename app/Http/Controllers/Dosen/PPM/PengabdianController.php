<?php
namespace App\Http\Controllers\Dosen\PPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengabdian;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota_pengabdian;

class PengabdianController extends Controller
{
    public function index()
    {
        $pengabdian = Pengabdian::where('user_id', Auth::id())->get();
        return view('dosen.ppm.pengabdian.index', compact('pengabdian'));
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
        'anggota_nama' => 'required|array',
        'anggota_nama.*' => 'required|string',
        'anggota_peran' => 'required|array',
        'anggota_peran.*' => 'required|string',
        'anggota_email' => 'required|array',
        'anggota_email.*' => 'required|email',
        'anggota_telepon' => 'required|array',
        'anggota_telepon.*' => 'required|string',
    ]);

    $dokumenProposal = $request->file('dokumen_proposal')->store('public/proposals');

    $pengabdian = Pengabdian::create([
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

    foreach ($request->anggota_nama as $key => $nama) {
        Anggota_pengabdian::create([
            'pengabdian_id' => $pengabdian->id,
            'nama' => $nama,
            'peran' => $request->anggota_peran[$key],
            'email' => $request->anggota_email[$key],
            'telepon' => $request->anggota_telepon[$key],
        ]);
    }

    return redirect()->route('pengabdian-dos.index')->with('success', 'Proposal submitted successfully.');
}

}
