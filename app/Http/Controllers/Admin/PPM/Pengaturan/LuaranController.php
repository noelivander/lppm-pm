<?php

namespace App\Http\Controllers\Admin\PPM\Pengaturan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PPM\Luaran;

class LuaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $luaran = Luaran::orderBy('created_at', 'desc')->get();

        return view('admin.ppm.pengaturan.luaran.index', compact('luaran'));
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
            'kode' => 'nullable|string|max:10',
            'nama' => 'required|string|max:255',
            'perihal' => 'nullable|string|max:255',
            'jenis' => 'required|in:penelitian,pengabdian',
            'kategori' => 'required|in:wajib,tambahan',
            'is_shown' => 'boolean'
        ]);

        Luaran::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'perihal' => $request->perihal,
            'jenis' => $request->jenis,
            'kategori' => $request->kategori,
            'is_shown' => $request->has('is_shown') ? 1 : 0
        ]);

        return redirect()->route('luaran.index')->with('success', 'Luaran berhasil ditambahkan!');
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
    public function edit($id)
    {
        try {
            $luaran = Luaran::findOrFail($id);
            
            return response()->json($luaran);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengambil data luaran',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'kode' => 'nullable|string|max:10',
                'nama' => 'required|string|max:255',
                'perihal' => 'nullable|string|max:255',
                'jenis' => 'required|in:penelitian,pengabdian',
                'kategori' => 'required|in:wajib,tambahan',
                'is_shown' => 'boolean'
            ]);

            $luaran = Luaran::findOrFail($id);
            $luaran->update([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'perihal' => $request->perihal,
                'jenis' => $request->jenis,
                'kategori' => $request->kategori,
                'is_shown' => $request->has('is_shown') ? 1 : 0
            ]);

            return redirect()->route('luaran.index')->with('success', 'Luaran berhasil diperbarui!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan validasi. Silakan periksa kembali data yang dimasukkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui luaran. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $luaran = Luaran::findOrFail($id);
            $luaran->delete();

            return redirect()->route('luaran.index')->with('success', 'Luaran berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus luaran. Silakan coba lagi.');
        }
    }
}
