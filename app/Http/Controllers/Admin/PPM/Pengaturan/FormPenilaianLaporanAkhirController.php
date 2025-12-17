<?php

namespace App\Http\Controllers\Admin\PPM\Pengaturan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FormPenilaianLaporanAkhir;
use App\Models\FormPenilaianLaporanAkhirSub;

class FormPenilaianLaporanAkhirController extends Controller
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
        // Fetch form with sub components, grouped by type if needed or just handled in view
        // Fetch form with sub components, grouped by type if needed or just handled in view
        $formPenelitian = FormPenilaianLaporanAkhir::where('jenis', 'penelitian')
            ->with([
                'subKomponen' => function ($q) {
                    $q->orderBy('urutan');
                }
            ])
            ->orderBy('urutan')
            ->get();

        // Group pengabdian by kategori, then by komponen
        // Get all data ordered by urutan (global order) - including inactive
        $formPengabdianRaw = FormPenilaianLaporanAkhir::where('jenis', 'pengabdian')
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
        $kategoriList = FormPenilaianLaporanAkhir::where('jenis', 'pengabdian')
            ->whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori')
            ->sort()
            ->values();

        return view('admin.ppm.pengaturan.form-penilaian-laporan-akhir.index', compact('formPenelitian', 'formPengabdian', 'kategoriList'));
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
            'sub_komponen' => 'nullable|array',
            'sub_komponen.*.sub_komponen' => 'required_with:sub_komponen|string',
            'sub_komponen.*.nilai' => 'required_with:sub_komponen|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Get max urutan for ordering
            $maxUrutan = FormPenilaianLaporanAkhir::where('jenis', $request->jenis)->max('urutan') ?? 0;

            $form = FormPenilaianLaporanAkhir::create([
                'jenis' => $request->jenis,
                'kategori' => $request->kategori,
                'komponen_penilaian' => $request->komponen_penilaian,
                'urutan' => $request->urutan ?? ($maxUrutan + 1),
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            // If sub_komponen provided, create them (for both penelitian and pengabdian)
            if ($request->has('sub_komponen')) {
                foreach ($request->sub_komponen as $index => $sub) {
                    FormPenilaianLaporanAkhirSub::create([
                        'form_penilaian_laporan_akhir_id' => $form->id, // Fixed FK name
                        'keterangan' => $sub['sub_komponen'],
                        'skor' => $sub['nilai'],
                        'urutan' => $index + 1,
                    ]);
                }

            }

            // If penelitian with complex structure (kriteria & items)
            if ($request->jenis === 'penelitian') {
                // Save Kriteria (Status)
                if ($request->has('kriteria')) {
                    foreach ($request->kriteria as $index => $krit) {
                        FormPenilaianLaporanAkhirSub::create([
                            'form_penilaian_laporan_akhir_id' => $form->id,
                            'keterangan' => $krit['deskripsi'], // e.g. "Telah tercapai (skor=80)"
                            'skor' => $krit['bobot'], // e.g. 80
                            'tipe' => 'status',
                            'urutan' => $index + 1,
                        ]);
                    }
                }

                // Save Items
                if ($request->has('item_penilaian')) {
                    foreach ($request->item_penilaian as $index => $item) {
                        FormPenilaianLaporanAkhirSub::create([
                            'form_penilaian_laporan_akhir_id' => $form->id,
                            'keterangan' => $item, // e.g. "Kualitas dokumen luaran"
                            'skor' => 0, // Not used for items
                            'tipe' => 'item',
                            'urutan' => $index + 1,
                        ]);
                    }
                }
            }

            DB::commit();
            $redirect = redirect()->route('form-penilaian-laporan-akhir.index')
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
            $form = FormPenilaianLaporanAkhir::with('subKomponen')->findOrFail($id);

            // Format sub_komponen untuk response
            $subKomponen = $form->subKomponen->map(function ($sub) {
                return [
                    'sub_komponen' => $sub->keterangan,
                    'nilai' => (float) $sub->skor,
                ];
            })->toArray();

            // Separate into kriteria and items for frontend if needed
            $kriteria = $form->subKomponen->where('tipe', 'status')->map(function ($sub) {
                return [
                    'deskripsi' => $sub->keterangan,
                    'bobot' => (float) $sub->skor
                ];
            })->values()->toArray();

            $itemPenilaian = $form->subKomponen->where('tipe', 'item')->pluck('keterangan')->toArray();

            return response()->json([
                'form' => [
                    'id' => $form->id,
                    'jenis' => $form->jenis,
                    'kategori' => $form->kategori,
                    'komponen_penilaian' => $form->komponen_penilaian,
                    'urutan' => $form->urutan,
                    'is_active' => $form->is_active ? 1 : 0,
                    'sub_komponen' => $subKomponen,
                    'kriteria' => $kriteria,
                    'item_penilaian' => $itemPenilaian,
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in FormPenilaianLaporanAkhirController@edit: ' . $e->getMessage());
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
            $form = FormPenilaianLaporanAkhir::findOrFail($id);
            $used = $form->hasBeenUsed();

            return response()->json([
                'used' => $used,
                'message' => $used
                    ? 'Komponen penilaian ini sudah pernah digunakan dalam laporan akhir.'
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
            'sub_komponen' => 'nullable|array',
            'sub_komponen.*.sub_komponen' => 'required_with:sub_komponen|string',
            'sub_komponen.*.nilai' => 'required_with:sub_komponen|numeric|min:0',
            // New validation for Penelitian complex structure
            'kriteria' => 'nullable|array',
            'kriteria.*.deskripsi' => 'required_with:kriteria|string',
            'kriteria.*.bobot' => 'required_with:kriteria|numeric|min:0',
            'item_penilaian' => 'nullable|array',
            'item_penilaian.*' => 'required_with:item_penilaian|string',
        ]);

        DB::beginTransaction();
        try {
            $form = FormPenilaianLaporanAkhir::findOrFail($id);

            $form->update([
                'kategori' => $request->kategori,
                'komponen_penilaian' => $request->komponen_penilaian,
                'urutan' => $request->urutan ?? $form->urutan,
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            // If sub_komponen provided, update sub komponen (for both types)
            if ($request->has('sub_komponen')) {
                // Delete existing sub komponen
                $form->subKomponen()->delete();

                // Create new sub komponen
                foreach ($request->sub_komponen as $index => $sub) {
                    FormPenilaianLaporanAkhirSub::create([
                        'form_penilaian_laporan_akhir_id' => $form->id, // Fixed FK
                        'keterangan' => $sub['sub_komponen'],
                        'skor' => $sub['nilai'],
                        'urutan' => $index + 1,
                    ]);
                }

            }

            // Update complex structure for penelitian
            if ($form->jenis === 'penelitian' && ($request->has('kriteria') || $request->has('item_penilaian'))) {
                // Delete existing subs if replacing
                // We must be careful not to delete subs if we just processed them above (though logic suggests mutually exclusive types)
                // Since this block is for penelitian, and the above block is effectively for pengabdian (which uses sub_komponen),
                // it is safer to delete existing subs here if we are indeed updating penelitian structure.
                // However, we must ensure we don't double delete if 'sub_komponen' was somehow passed.
                // Given the form logic, 'sub_komponen' is usually null for penelitian.

                // FORCE DELETE any existing subs for this form to fully replace with new structure
                $form->subKomponen()->delete();

                if ($request->has('kriteria')) {
                    foreach ($request->kriteria as $index => $krit) {
                        FormPenilaianLaporanAkhirSub::create([
                            'form_penilaian_laporan_akhir_id' => $form->id,
                            'keterangan' => $krit['deskripsi'],
                            'skor' => $krit['bobot'],
                            'tipe' => 'status',
                            'urutan' => $index + 1,
                        ]);
                    }
                }

                if ($request->has('item_penilaian')) {
                    foreach ($request->item_penilaian as $index => $item) {
                        FormPenilaianLaporanAkhirSub::create([
                            'form_penilaian_laporan_akhir_id' => $form->id,
                            'keterangan' => $item,
                            'skor' => 0,
                            'tipe' => 'item',
                            'urutan' => $index + 1,
                        ]);
                    }
                }
            }

            DB::commit();
            $redirect = redirect()->route('form-penilaian-laporan-akhir.index')
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
            $form = FormPenilaianLaporanAkhir::findOrFail($id);
            $jenis = $form->jenis; // Store jenis before deletion

            // Check if form has been used (for data integrity)
            // Instead of hard delete, we'll just deactivate it
            // This ensures historical data remains accessible
            if ($form->hasBeenUsed()) {
                // If form has been used, just deactivate it instead of deleting
                $form->update(['is_active' => false]);

                $redirect = redirect()->route('form-penilaian-laporan-akhir.index')
                    ->with('warning', 'Komponen penilaian dinonaktifkan karena sudah pernah digunakan. Data historis tetap aman.');
            } else {
                // If form hasn't been used, safe to delete
                $form->delete(); // Sub komponen akan terhapus otomatis karena cascade

                $redirect = redirect()->route('form-penilaian-laporan-akhir.index')
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
