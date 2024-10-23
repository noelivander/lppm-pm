<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DokumenPenting;

class DokumenPentingController extends Controller
{
    protected $label_dokumen = ['LPPM-PM', 'Penelitian dan PkM', 'Penjaminan Mutu', 'Lainnya'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $label_dokumen = $this->label_dokumen;
        $dokumen_penting = DokumenPenting::orderBy('urutan','asc')->orderBy('label','asc')->get();

        foreach ($dokumen_penting as $key => $value) {
            if($value->label) {
                $value->label = $label_dokumen[$value->label];
            }
        }

        return view('admin.layanan.dokumen_penting.index', compact('dokumen_penting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $label_dokumen = $this->label_dokumen;

        return view('admin.layanan.dokumen_penting.create', compact('label_dokumen'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new = new DokumenPenting;

        $judul = preg_replace('/\p{P}/', '', $request->input('judul'));
        $new->judul = $judul;
        $new->label = $request->input('label');
        $new->urutan = $request->input('urutan');

        $slug = time()."-".str_replace(" ","-", strtolower($judul));
        $new->slug = $slug;
        $new->is_shown = 0;

        $file = $request->file('file');

        if ($file) {
            $extension_file = $file->getClientOriginalExtension();
            $file_name_as = $slug.'.'.$extension_file;

            $path = $file->storeAs(
                        'dokumen_penting/', $file_name_as, ['disk' => 'public']
                    );
            
            $new->file = 'dokumen_penting/'.$file_name_as;
        }


        $cover = $request->file('cover');

        if ($cover) {
            $cover_name = pathinfo($cover->getClientOriginalName(), PATHINFO_FILENAME);
            $extension_cover = $cover->getClientOriginalExtension();
            $cover_name_as = time().'-'.$cover_name.'.'.$extension_cover;

            $tahun = date("Y",time());

            $path = $cover->storeAs(
                        'dokumen_penting/sampul',$cover_name_as, ['disk' => 'public']
                    );
            
            $new->cover = 'dokumen_penting/sampul/'.$cover_name_as;
        }

        $new->save();

        return redirect()->route('dokumen_penting.edit', ['dokumen_penting'=>$new->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(DokumenPenting $dokumen_penting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(DokumenPenting $dokumen_penting)
    {
        $label_dokumen = $this->label_dokumen;

        $exp = explode("/",$dokumen_penting->file);
        $file_dokumen = end($exp);

        return view('admin.layanan.dokumen_penting.edit', compact('dokumen_penting','file_dokumen','label_dokumen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DokumenPenting $dokumen_penting)
    {

        $judul = preg_replace('/\p{P}/', '', $request->input('judul'));
        $dokumen_penting->judul = $judul;
        $dokumen_penting->label = $request->input('label');
        $dokumen_penting->urutan = $request->input('urutan');
        $dokumen_penting->is_shown = ($request->input('is_shown'))? 1 : 0;;
        $dokumen_penting->is_lock = (!$request->input('is_lock'))? 1 : 0;

        $time = explode("-",$dokumen_penting->slug)[0];
        $slug = $time."-".str_replace(" ","-", strtolower($judul));
        $dokumen_penting->slug = $slug;

        $file = $request->file('file');

        if ($file) {
            $extension_file = $file->getClientOriginalExtension();
            $file_name_as = time().'-'.$slug.'.'.$extension_file;

            $path = $file->storeAs(
                        'dokumen_penting/', $file_name_as, ['disk' => 'public']
                    );
            
            $dokumen_penting->file = 'dokumen_penting/'.$file_name_as;
        }


        $cover = $request->file('cover');

        if ($cover) {
            $cover_name = pathinfo($cover->getClientOriginalName(), PATHINFO_FILENAME);
            $extension_cover = $cover->getClientOriginalExtension();
            $cover_name_as = time().'-'.$cover_name.'.'.$extension_cover;

            $tahun = date("Y",time());

            $path = $cover->storeAs(
                        'dokumen_penting/sampul/',$cover_name_as, ['disk' => 'public']
                    );
            
            $dokumen_penting->cover = 'dokumen_penting/sampul/'.$cover_name_as;
        }
        $dokumen_penting->save();

        return redirect()->route('dokumen_penting.edit', ['dokumen_penting'=>$dokumen_penting->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DokumenPenting $dokumen_penting)
    {
        $dokumen_penting->delete();
        
        return redirect()->route('dokumen_penting.index');
    }
}
