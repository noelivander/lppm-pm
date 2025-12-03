<?php

namespace App\Http\Controllers\Admin\PPM\Pengaturan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\PPM\Skema;
use App\Models\PPM\JenisSkema;

class SkemaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skema = Skema::with('jenis_skema')->orderBy('created_at', 'desc')->get();

        return view('admin.ppm.pengaturan.skema.index', compact('skema'));
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
            'jenis_skema_id' => 'required|exists:ppm_jenis_skema,id',
            'is_research' => 'boolean',
            'is_shown' => 'boolean',
            'template_laporan_kemajuan' => 'nullable|file|mimes:doc,docx,pdf|max:10240',
            'template_laporan_keuangan_tahap_1' => 'nullable|file|mimes:doc,docx,pdf|max:10240'
        ]);

        $data = [
            'kode' => $request->kode,
            'nama' => $request->nama,
            'perihal' => $request->perihal,
            'jenis' => $request->jenis,
            'jenis_skema_id' => $request->jenis_skema_id,
            'is_research' => $request->has('is_research') ? 1 : 0,
            'is_shown' => $request->has('is_shown') ? 1 : 0
        ];

        // Handle template laporan kemajuan upload
        if ($request->hasFile('template_laporan_kemajuan')) {
            $file = $request->file('template_laporan_kemajuan');
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $path = $file->storeAs('templates/skema', $fileName, 'public');
            $data['template_laporan_kemajuan'] = $path;
        }

        // Handle template laporan keuangan tahap 1 upload
        if ($request->hasFile('template_laporan_keuangan_tahap_1')) {
            $file = $request->file('template_laporan_keuangan_tahap_1');
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $path = $file->storeAs('templates/skema', $fileName, 'public');
            $data['template_laporan_keuangan_tahap_1'] = $path;
        }

        Skema::create($data);

        return redirect()->route('skema.index')->with('success', 'Skema berhasil ditambahkan!');
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
            $skema = Skema::with('jenis_skema')->findOrFail($id);
            $jenisSkema = JenisSkema::where('is_shown', 1)->get();
            
            return response()->json([
                'skema' => $skema,
                'jenisSkema' => $jenisSkema
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengambil data skema',
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
                'jenis_skema_id' => 'required|exists:ppm_jenis_skema,id',
                'is_research' => 'boolean',
                'is_shown' => 'boolean',
                'template_laporan_kemajuan' => 'nullable|file|mimes:doc,docx,pdf|max:10240',
                'template_laporan_keuangan_tahap_1' => 'nullable|file|mimes:doc,docx,pdf|max:10240'
            ]);

            $skema = Skema::findOrFail($id);
            
            $data = [
                'kode' => $request->kode,
                'nama' => $request->nama,
                'perihal' => $request->perihal,
                'jenis' => $request->jenis,
                'jenis_skema_id' => $request->jenis_skema_id,
                'is_research' => $request->has('is_research') ? 1 : 0,
                'is_shown' => $request->has('is_shown') ? 1 : 0
            ];

            // Handle template laporan kemajuan upload
            if ($request->hasFile('template_laporan_kemajuan')) {
                // Delete old file if exists
                if ($skema->template_laporan_kemajuan && Storage::disk('public')->exists($skema->template_laporan_kemajuan)) {
                    Storage::disk('public')->delete($skema->template_laporan_kemajuan);
                }
                
                $file = $request->file('template_laporan_kemajuan');
                $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $path = $file->storeAs('templates/skema', $fileName, 'public');
                $data['template_laporan_kemajuan'] = $path;
            }

            // Handle template laporan keuangan tahap 1 upload
            if ($request->hasFile('template_laporan_keuangan_tahap_1')) {
                // Delete old file if exists
                if ($skema->template_laporan_keuangan_tahap_1 && Storage::disk('public')->exists($skema->template_laporan_keuangan_tahap_1)) {
                    Storage::disk('public')->delete($skema->template_laporan_keuangan_tahap_1);
                }
                
                $file = $request->file('template_laporan_keuangan_tahap_1');
                $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $path = $file->storeAs('templates/skema', $fileName, 'public');
                $data['template_laporan_keuangan_tahap_1'] = $path;
            }

            $skema->update($data);

            return redirect()->route('skema.index')->with('success', 'Skema berhasil diperbarui!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan validasi. Silakan periksa kembali data yang dimasukkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui skema. Silakan coba lagi.');
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
            $skema = Skema::findOrFail($id);
            $skema->delete();

            return redirect()->route('skema.index')->with('success', 'Skema berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus skema. Silakan coba lagi.');
        }
    }
}
