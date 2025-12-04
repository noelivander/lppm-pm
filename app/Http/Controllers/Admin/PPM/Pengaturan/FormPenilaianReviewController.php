<?php

namespace App\Http\Controllers\Admin\PPM\Pengaturan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FormPenilaianReview;

class FormPenilaianReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formPenelitian = FormPenilaianReview::where('jenis', 'penelitian')
            ->orderBy('urutan')
            ->get();
        
        $formPengabdian = FormPenilaianReview::where('jenis', 'pengabdian')
            ->orderBy('urutan')
            ->get();

        return view('admin.ppm.pengaturan.form-penilaian-review.index', compact('formPenelitian', 'formPengabdian'));
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
            'kriteria_penilaian' => 'required|string',
            'bobot' => 'required|numeric|min:0|max:100',
            'urutan' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Get max urutan for ordering
            $maxUrutan = FormPenilaianReview::where('jenis', $request->jenis)->max('urutan') ?? 0;
            
            $form = FormPenilaianReview::create([
                'jenis' => $request->jenis,
                'kriteria_penilaian' => $request->kriteria_penilaian,
                'bobot' => $request->bobot,
                'urutan' => $request->urutan ?? ($maxUrutan + 1),
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            DB::commit();
            $redirect = redirect()->route('form-penilaian-review.index')
                ->with('success', 'Kriteria penilaian berhasil ditambahkan!');
            
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
            $form = FormPenilaianReview::findOrFail($id);
            
            return response()->json([
                'form' => [
                    'id' => $form->id,
                    'jenis' => $form->jenis,
                    'kriteria_penilaian' => $form->kriteria_penilaian,
                    'bobot' => (float) $form->bobot,
                    'urutan' => $form->urutan,
                    'is_active' => $form->is_active ? 1 : 0,
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in FormPenilaianReviewController@edit: ' . $e->getMessage());
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
            $form = FormPenilaianReview::findOrFail($id);
            $used = $form->hasBeenUsed();
            
            return response()->json([
                'used' => $used,
                'message' => $used 
                    ? 'Kriteria penilaian ini sudah pernah digunakan dalam penilaian review.' 
                    : 'Kriteria penilaian ini belum pernah digunakan dan dapat dihapus.',
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
            'kriteria_penilaian' => 'required|string',
            'bobot' => 'required|numeric|min:0|max:100',
            'urutan' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            $form = FormPenilaianReview::findOrFail($id);
            
            $form->update([
                'kriteria_penilaian' => $request->kriteria_penilaian,
                'bobot' => $request->bobot,
                'urutan' => $request->urutan ?? $form->urutan,
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            DB::commit();
            $redirect = redirect()->route('form-penilaian-review.index')
                ->with('success', 'Kriteria penilaian berhasil diupdate!');
            
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
            $form = FormPenilaianReview::findOrFail($id);
            $jenis = $form->jenis; // Store jenis before deletion
            
            // Check if form has been used (for data integrity)
            // Instead of hard delete, we'll just deactivate it
            // This ensures historical data remains accessible
            if ($form->hasBeenUsed()) {
                // If form has been used, just deactivate it instead of deleting
                $form->update(['is_active' => false]);
                
                $redirect = redirect()->route('form-penilaian-review.index')
                    ->with('warning', 'Kriteria penilaian dinonaktifkan karena sudah pernah digunakan. Data historis tetap aman.');
            } else {
                // If form hasn't been used, safe to delete
                $form->delete();
                
                $redirect = redirect()->route('form-penilaian-review.index')
                    ->with('success', 'Kriteria penilaian berhasil dihapus!');
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
