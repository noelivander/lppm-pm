<?php

namespace App\Http\Controllers\Admin\Pengaturan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Jurusan;
use App\Models\ProgramStudi;

class ProgramStudiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jurusan = Jurusan::all();
        $program_studi = ProgramStudi::with('jurusan')->get();

        return view('admin.pengaturan.program_studi.index', compact('program_studi', 'jurusan'));
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
        $request->validate([
            'kode' => 'required|string|max:255',
            'jurusan' => 'required|exists:jurusan,id',
            'nama' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        $new = new ProgramStudi;
        $new->kode = $request->input('kode');
        $new->jurusan_id = $request->input('jurusan');
        $new->nama = $request->input('nama');
        $new->tahun = $request->input('tahun');
        $new->save();

        return redirect()->route('program_studi.index')->with('success', 'Program Studi berhasil ditambahkan.');
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
    public function edit(ProgramStudi $program_studi)
    {
        $jurusan = Jurusan::all();
        return view('admin.pengaturan.program_studi.edit', compact('program_studi', 'jurusan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProgramStudi $program_studi)
    {
        $request->validate([
            'kode' => 'required|string|max:255',
            'jurusan' => 'required|exists:jurusan,id',
            'nama' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        $program_studi->kode = $request->input('kode');
        $program_studi->jurusan_id = $request->input('jurusan');
        $program_studi->nama = $request->input('nama');
        $program_studi->tahun = $request->input('tahun');
        $program_studi->save();

        return redirect()->route('program_studi.index')->with('success', 'Program Studi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgramStudi $program_studi)
    {
        // Check if program studi has pegawai
        if ($program_studi->pegawai()->count() > 0) {
            return redirect()->back()->with('error', 'Program Studi tidak dapat dihapus karena masih memiliki pegawai terkait.');
        }

        $program_studi->delete();

        return redirect()->route('program_studi.index')->with('success', 'Program Studi berhasil dihapus.');
    }
}
