<?php

namespace App\Http\Controllers\Admin\PPM\Pengaturan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PPM\BidangPenelitian;

class BidangPenelitianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bidangPenelitian = BidangPenelitian::orderBy('urutan', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.ppm.pengaturan.bidang-penelitian.index', compact('bidangPenelitian'));
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
            'nama' => 'required|string|max:255|unique:bidang_penelitian,nama',
            'kode' => 'required|string|max:50',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = [
            'nama' => $request->nama,
            'kode' => $request->kode,
            'urutan' => $request->urutan,
            'is_active' => $request->has('is_active') ? 1 : 0
        ];

        BidangPenelitian::create($data);

        return redirect()->route('bidang-penelitian.index')->with('success', 'Bidang penelitian berhasil ditambahkan!');
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
            $bidangPenelitian = BidangPenelitian::findOrFail($id);
            
            return response()->json([
                'bidangPenelitian' => $bidangPenelitian
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengambil data bidang penelitian',
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
                'nama' => 'required|string|max:255|unique:bidang_penelitian,nama,' . $id,
                'kode' => 'required|string|max:50',
                'urutan' => 'nullable|integer|min:0',
                'is_active' => 'boolean',
            ]);

            $bidangPenelitian = BidangPenelitian::findOrFail($id);
            
            $data = [
                'nama' => $request->nama,
                'kode' => $request->kode,
                'urutan' => $request->urutan,
                'is_active' => $request->has('is_active') ? 1 : 0
            ];

            $bidangPenelitian->update($data);

            return redirect()->route('bidang-penelitian.index')->with('success', 'Bidang penelitian berhasil diperbarui!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan validasi. Silakan periksa kembali data yang dimasukkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui bidang penelitian. Silakan coba lagi.');
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
            $bidangPenelitian = BidangPenelitian::findOrFail($id);
            
            // Check if bidang penelitian is being used
            if ($bidangPenelitian->penelitian()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Bidang penelitian tidak dapat dihapus karena masih digunakan pada penelitian.');
            }
            
            $bidangPenelitian->delete();

            return redirect()->route('bidang-penelitian.index')->with('success', 'Bidang penelitian berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus bidang penelitian. Silakan coba lagi.');
        }
    }
}
