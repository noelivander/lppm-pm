<?php

namespace App\Http\Controllers\Admin\PPM\Pengaturan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FormPenilaianLaporanKemajuan;
use App\Models\FormPenilaianLaporanKemajuanSub;

class FormPenilaianLaporanKemajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formPenelitian = FormPenilaianLaporanKemajuan::where('jenis', 'penelitian')
            ->orderBy('urutan')
            ->get();
        
        $formPengabdian = FormPenilaianLaporanKemajuan::where('jenis', 'pengabdian')
            ->with('subKomponen')
            ->orderBy('urutan')
            ->get();

        return view('admin.ppm.pengaturan.form-penilaian-laporan-kemajuan.index', compact('formPenelitian', 'formPengabdian'));
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
            'jenis' => 'required|in:penelitian,pengabdian',
            'kategori' => 'required_if:jenis,pengabdian|nullable|string',
            'komponen_penilaian' => 'required|string',
            'urutan' => 'nullable|integer|min:0',
            'sub_komponen' => 'required_if:jenis,pengabdian|array',
            'sub_komponen.*.sub_komponen' => 'required_with:sub_komponen|string',
            'sub_komponen.*.nilai' => 'required_with:sub_komponen|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Get max urutan for ordering
            $maxUrutan = FormPenilaianLaporanKemajuan::where('jenis', $request->jenis)->max('urutan') ?? 0;
            
            $form = FormPenilaianLaporanKemajuan::create([
                'jenis' => $request->jenis,
                'kategori' => $request->kategori,
                'komponen_penilaian' => $request->komponen_penilaian,
                'urutan' => $request->urutan ?? ($maxUrutan + 1),
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            // If pengabdian, create sub komponen
            if ($request->jenis === 'pengabdian' && $request->has('sub_komponen')) {
                foreach ($request->sub_komponen as $index => $sub) {
                    FormPenilaianLaporanKemajuanSub::create([
                        'form_penilaian_id' => $form->id,
                        'sub_komponen' => $sub['sub_komponen'],
                        'nilai' => $sub['nilai'],
                        'urutan' => $index + 1,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('form-penilaian-laporan-kemajuan.index')
                ->with('success', 'Komponen penilaian berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
            $form = FormPenilaianLaporanKemajuan::with('subKomponen')->findOrFail($id);
            
            // Format sub_komponen untuk response
            $subKomponen = $form->subKomponen->map(function($sub) {
                return [
                    'sub_komponen' => $sub->sub_komponen,
                    'nilai' => (float) $sub->nilai,
                ];
            })->toArray();
            
            return response()->json([
                'form' => [
                    'id' => $form->id,
                    'jenis' => $form->jenis,
                    'kategori' => $form->kategori,
                    'komponen_penilaian' => $form->komponen_penilaian,
                    'urutan' => $form->urutan,
                    'is_active' => $form->is_active ? 1 : 0,
                    'sub_komponen' => $subKomponen,
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in FormPenilaianLaporanKemajuanController@edit: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengambil data',
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
        $request->validate([
            'kategori' => 'required_if:jenis,pengabdian|nullable|string',
            'komponen_penilaian' => 'required|string',
            'urutan' => 'nullable|integer|min:0',
            'sub_komponen' => 'required_if:jenis,pengabdian|array',
            'sub_komponen.*.sub_komponen' => 'required_with:sub_komponen|string',
            'sub_komponen.*.nilai' => 'required_with:sub_komponen|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $form = FormPenilaianLaporanKemajuan::findOrFail($id);
            
            $form->update([
                'kategori' => $request->kategori,
                'komponen_penilaian' => $request->komponen_penilaian,
                'urutan' => $request->urutan ?? $form->urutan,
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            // If pengabdian, update sub komponen
            if ($form->jenis === 'pengabdian' && $request->has('sub_komponen')) {
                // Delete existing sub komponen
                $form->subKomponen()->delete();
                
                // Create new sub komponen
                foreach ($request->sub_komponen as $index => $sub) {
                    FormPenilaianLaporanKemajuanSub::create([
                        'form_penilaian_id' => $form->id,
                        'sub_komponen' => $sub['sub_komponen'],
                        'nilai' => $sub['nilai'],
                        'urutan' => $index + 1,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('form-penilaian-laporan-kemajuan.index')
                ->with('success', 'Komponen penilaian berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
            $form = FormPenilaianLaporanKemajuan::findOrFail($id);
            $form->delete(); // Sub komponen akan terhapus otomatis karena cascade

            return redirect()->route('form-penilaian-laporan-kemajuan.index')
                ->with('success', 'Komponen penilaian berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
