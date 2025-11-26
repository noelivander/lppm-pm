<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\Jurusan;
use App\Models\ProgramStudi;
use App\Models\PangkatGolonganRuang;
use Auth;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawai = Pegawai::with(['program_studi.jurusan', 'jabatan', 'pangkat_golongan_ruang'])->orderBy('created_at','desc')->get();

        return view('admin.pengaturan.pegawai.index', compact('pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pegawai $pegawai)
    {
        $program_studi = ProgramStudi::with('jurusan')->get();
        $jabatan = Jabatan::all();
        $pangkat_golongan_ruang = PangkatGolonganRuang::all();
        
        return view('admin.pengaturan.pegawai.edit', compact('pegawai', 'program_studi', 'jabatan', 'pangkat_golongan_ruang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:pegawai,email,' . $pegawai->id,
            'nip' => 'required|string|max:255|unique:pegawai,nip,' . $pegawai->id,
            'program_studi_id' => 'nullable|exists:program_studi,id',
            'jabatan_id' => 'nullable|exists:jabatan,id',
            'pangkat_golongan_ruang_id' => 'nullable|exists:pangkat_golongan_ruang,id',
        ]);

        $pegawai->nama = $request->input('nama');
        $pegawai->email = $request->input('email');
        $pegawai->nip = $request->input('nip');
        $pegawai->program_studi_id = $request->input('program_studi_id');
        $pegawai->jabatan_id = $request->input('jabatan_id');
        $pegawai->pangkat_golongan_ruang_id = $request->input('pangkat_golongan_ruang_id');
        
        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old foto if exists
            if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
                Storage::disk('public')->delete($pegawai->foto);
            }
            
            $foto = $request->file('foto');
            $fotoPath = $foto->store('pegawai/foto', 'public');
            $pegawai->foto = $fotoPath;
        }
        
        $pegawai->save();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pegawai $pegawai)
    {
        // Delete foto if exists
        if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
            Storage::disk('public')->delete($pegawai->foto);
        }

        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus.');
    }
}
