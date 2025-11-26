<?php

namespace App\Http\Controllers\Admin\PPM\Pengaturan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KelompokRab;
use App\Models\KomponenRab;
use App\Models\SatuanRab;

class RabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelompokRab = KelompokRab::orderBy('nama')->get();
        $komponenRab = KomponenRab::with('satuan')->orderBy('nama')->get();
        $satuanRab = SatuanRab::orderBy('nama')->get();

        return view('admin.ppm.pengaturan.rab.index', compact('kelompokRab', 'komponenRab', 'satuanRab'));
    }

    /**
     * Store a newly created Kelompok RAB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeKelompok(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kelompok_rab,nama',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        KelompokRab::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('rab.index')->with('success', 'Kelompok RAB berhasil ditambahkan!');
    }

    /**
     * Store a newly created Komponen RAB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeKomponen(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:komponen_rab,nama',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        KomponenRab::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('rab.index')->with('success', 'Komponen RAB berhasil ditambahkan!');
    }

    /**
     * Store a newly created Satuan RAB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSatuan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:satuan_rab,nama',
            'singkatan' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        SatuanRab::create([
            'nama' => $request->nama,
            'singkatan' => $request->singkatan,
            'deskripsi' => $request->deskripsi,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('rab.index')->with('success', 'Satuan RAB berhasil ditambahkan!');
    }

    /**
     * Get data for editing Kelompok RAB (AJAX).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editKelompok($id)
    {
        try {
            $kelompok = KelompokRab::findOrFail($id);
            return response()->json($kelompok);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengambil data kelompok RAB',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get data for editing Komponen RAB (AJAX).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editKomponen($id)
    {
        try {
            $komponen = KomponenRab::findOrFail($id);
            return response()->json($komponen);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengambil data komponen RAB',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get data for editing Satuan RAB (AJAX).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editSatuan($id)
    {
        try {
            $satuan = SatuanRab::findOrFail($id);
            return response()->json($satuan);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengambil data satuan RAB',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified Kelompok RAB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateKelompok(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255|unique:kelompok_rab,nama,' . $id,
                'deskripsi' => 'nullable|string',
                'is_active' => 'boolean',
            ]);

            $kelompok = KelompokRab::findOrFail($id);
            $kelompok->update([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'is_active' => $request->has('is_active') ? 1 : 0,
            ]);

            return redirect()->route('rab.index')->with('success', 'Kelompok RAB berhasil diperbarui!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan validasi. Silakan periksa kembali data yang dimasukkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui kelompok RAB. Silakan coba lagi.');
        }
    }

    /**
     * Update the specified Komponen RAB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateKomponen(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255|unique:komponen_rab,nama,' . $id,
                'deskripsi' => 'nullable|string',
                'is_active' => 'boolean',
            ]);

            $komponen = KomponenRab::findOrFail($id);
            $komponen->update([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'is_active' => $request->has('is_active') ? 1 : 0,
            ]);

            return redirect()->route('rab.index')->with('success', 'Komponen RAB berhasil diperbarui!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan validasi. Silakan periksa kembali data yang dimasukkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui komponen RAB. Silakan coba lagi.');
        }
    }

    /**
     * Update the specified Satuan RAB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSatuan(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255|unique:satuan_rab,nama,' . $id,
                'singkatan' => 'nullable|string|max:50',
                'deskripsi' => 'nullable|string',
                'is_active' => 'boolean',
            ]);

            $satuan = SatuanRab::findOrFail($id);
            $satuan->update([
                'nama' => $request->nama,
                'singkatan' => $request->singkatan,
                'deskripsi' => $request->deskripsi,
                'is_active' => $request->has('is_active') ? 1 : 0,
            ]);

            return redirect()->route('rab.index')->with('success', 'Satuan RAB berhasil diperbarui!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan validasi. Silakan periksa kembali data yang dimasukkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui satuan RAB. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified Kelompok RAB.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyKelompok($id)
    {
        try {
            $kelompok = KelompokRab::findOrFail($id);
            $kelompok->delete();

            return redirect()->route('rab.index')->with('success', 'Kelompok RAB berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus kelompok RAB. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified Komponen RAB.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyKomponen($id)
    {
        try {
            $komponen = KomponenRab::findOrFail($id);
            $komponen->delete();

            return redirect()->route('rab.index')->with('success', 'Komponen RAB berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus komponen RAB. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified Satuan RAB.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroySatuan($id)
    {
        try {
            $satuan = SatuanRab::findOrFail($id);
            $satuan->delete();

            return redirect()->route('rab.index')->with('success', 'Satuan RAB berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus satuan RAB. Silakan coba lagi.');
        }
    }

    /**
     * Assign satuan to komponen (attach/detach)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $komponenId
     * @return \Illuminate\Http\Response
     */
    public function assignSatuanToKomponen(Request $request, $komponenId)
    {
        try {
            $request->validate([
                'satuan_ids' => 'required|array',
                'satuan_ids.*' => 'exists:satuan_rab,id',
            ]);

            $komponen = KomponenRab::findOrFail($komponenId);
            $komponen->satuan()->sync($request->satuan_ids);

            return response()->json([
                'success' => true,
                'message' => 'Satuan berhasil diassign ke komponen'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get satuan for a komponen
     *
     * @param  int  $komponenId
     * @return \Illuminate\Http\Response
     */
    public function getSatuanForKomponen($komponenId)
    {
        try {
            $komponen = KomponenRab::findOrFail($komponenId);
            
            // Get assigned satuan
            $assignedSatuan = $komponen->satuan()->where('is_active', true)->get();
            
            // Get all active satuan
            $allSatuan = SatuanRab::where('is_active', true)->orderBy('nama')->get();
            
            return response()->json([
                'assigned' => $assignedSatuan,
                'all' => $allSatuan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
