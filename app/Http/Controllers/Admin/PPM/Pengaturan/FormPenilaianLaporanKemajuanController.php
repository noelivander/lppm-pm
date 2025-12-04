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
        // Get all forms (both active and inactive) for admin management
        // Admin needs to see all forms including deactivated ones
        $formPenelitian = FormPenilaianLaporanKemajuan::where('jenis', 'penelitian')
            ->orderBy('urutan')
            ->get();
        
        // Group pengabdian by kategori, then by komponen
        // Get all data ordered by urutan (global order) - including inactive
        $formPengabdianRaw = FormPenilaianLaporanKemajuan::where('jenis', 'pengabdian')
            ->with('subKomponen')
            ->orderBy('urutan', 'asc')
            ->orderBy('id', 'asc')
            ->get();
        
        // Group by kategori while maintaining the order
        // Use a custom collection to preserve order
        $formPengabdian = collect();
        $grouped = [];
        
        foreach ($formPengabdianRaw as $item) {
            $kategori = $item->kategori ?? 'uncategorized';
            if (!isset($grouped[$kategori])) {
                $grouped[$kategori] = collect();
            }
            $grouped[$kategori]->push($item);
        }
        
        // Rebuild collection maintaining order of first appearance
        $seenCategories = [];
        foreach ($formPengabdianRaw as $item) {
            $kategori = $item->kategori ?? 'uncategorized';
            if (!in_array($kategori, $seenCategories)) {
                $seenCategories[] = $kategori;
                $formPengabdian->put($kategori, $grouped[$kategori]);
            }
        }
        
        // Get unique categories for dropdown
        $kategoriList = FormPenilaianLaporanKemajuan::where('jenis', 'pengabdian')
            ->whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori')
            ->sort()
            ->values();

        return view('admin.ppm.pengaturan.form-penilaian-laporan-kemajuan.index', compact('formPenelitian', 'formPengabdian', 'kategoriList'));
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
            $redirect = redirect()->route('form-penilaian-laporan-kemajuan.index')
                ->with('success', 'Komponen penilaian berhasil ditambahkan!');
            
            // Redirect to appropriate tab based on jenis
            if ($request->jenis === 'pengabdian') {
                $redirect = $redirect->withFragment('pengabdian');
            } else {
                $redirect = $redirect->withFragment('penelitian');
            }
            
            return $redirect;
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
     * Check if form has been used
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkUsage($id)
    {
        try {
            $form = FormPenilaianLaporanKemajuan::findOrFail($id);
            $used = $form->hasBeenUsed();
            
            return response()->json([
                'used' => $used,
                'message' => $used 
                    ? 'Komponen penilaian ini sudah pernah digunakan dalam laporan kemajuan.' 
                    : 'Komponen penilaian ini belum pernah digunakan dan dapat dihapus.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat memeriksa penggunaan',
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
            $redirect = redirect()->route('form-penilaian-laporan-kemajuan.index')
                ->with('success', 'Komponen penilaian berhasil diupdate!');
            
            // Redirect to appropriate tab based on jenis
            if ($form->jenis === 'pengabdian') {
                $redirect = $redirect->withFragment('pengabdian');
            } else {
                $redirect = $redirect->withFragment('penelitian');
            }
            
            return $redirect;
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
            $jenis = $form->jenis; // Store jenis before deletion
            
            // Check if form has been used (for data integrity)
            // Instead of hard delete, we'll just deactivate it
            // This ensures historical data remains accessible
            if ($form->hasBeenUsed()) {
                // If form has been used, just deactivate it instead of deleting
                $form->update(['is_active' => false]);
                
                $redirect = redirect()->route('form-penilaian-laporan-kemajuan.index')
                    ->with('warning', 'Komponen penilaian dinonaktifkan karena sudah pernah digunakan. Data historis tetap aman.');
            } else {
                // If form hasn't been used, safe to delete
                $form->delete(); // Sub komponen akan terhapus otomatis karena cascade
                
                $redirect = redirect()->route('form-penilaian-laporan-kemajuan.index')
                    ->with('success', 'Komponen penilaian berhasil dihapus!');
            }
            
            // Redirect to appropriate tab based on jenis
            if ($jenis === 'pengabdian') {
                $redirect = $redirect->withFragment('pengabdian');
            } else {
                $redirect = $redirect->withFragment('penelitian');
            }
            
            return $redirect;
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
