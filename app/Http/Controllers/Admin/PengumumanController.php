<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pengumuman;
use Auth;

class PengumumanController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengumuman = Pengumuman::orderBy('created_at','desc')->get();

        return view('admin.layanan.pengumuman.index', compact('pengumuman'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.layanan.pengumuman.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new = new Pengumuman;
        $new->user_id = Auth::user()->id;
        
        $judul = preg_replace('/\p{P}/', '', $request->input('judul'));
        $new->judul = $judul;
        $new->slug = time()."-".str_replace(" ","-",strtolower($judul));

        $text_isi = $request->input('isi');
        $text_isi = str_replace("<img alt", "<img class=\"img-fluid img-thumbnail w-100\" alt", $text_isi);
        $new->isi = $text_isi;
        $new->tag = $request->input('tag');
        $new->is_shown = 1;

        $file = $request->file('dokumen');

        if ($file) {
            $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension_file = $file->getClientOriginalExtension();
            $file_name_as = time().'-'.$file_name.'.'.$extension_file;

            $tahun = date("Y",time());

            $path = $file->storeAs(
                        'pengumuman/'.$tahun, $file_name_as, ['disk' => 'public']
                    );
            
            $new->dokumen = 'pengumuman/'.$tahun.'/'.$file_name_as;
        }

        $cover = $request->file('cover');

        if ($cover) {
            $cover_name = pathinfo($cover->getClientOriginalName(), PATHINFO_FILENAME);
            $extension_cover = $cover->getClientOriginalExtension();
            $cover_name_as = time().'-'.$cover_name.'.'.$extension_cover;

            $tahun = date("Y",time());

            $path = $cover->storeAs(
                        'pengumuman/'.$tahun.'/sampul',$cover_name_as, ['disk' => 'public']
                    );
            
            $new->cover = 'pengumuman/'.$tahun.'/sampul/'.$cover_name_as;
        }

        $new->save();

        return redirect()->route('pengumuman.edit', ['pengumuman'=>$new->id]);
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
    public function edit(Pengumuman $pengumuman)
    {
        $exp = explode("/",$pengumuman->dokumen);
        $file_dokumen = end($exp);
        return view('admin.layanan.pengumuman.edit', compact('pengumuman', 'file_dokumen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        $time = explode("-", $pengumuman->slug)[0];
        $judul = preg_replace('/\p{P}/', '', $request->input('judul'));

        $pengumuman->judul = $judul;
        $pengumuman->slug = $time."-".str_replace(" ","-",strtolower($judul));

        $text_isi = $request->input('isi');
        $text_isi = str_replace("<img alt", "<img class=\"img-fluid img-thumbnail w-100\" alt", $text_isi);
        $pengumuman->isi = $text_isi;
        $pengumuman->tag = $request->input('tag');
        $pengumuman->is_shown = ($request->input('is_shown'))? 1 : 0;;

        $file = $request->file('dokumen');

        if ($file) {
            $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension_file = $file->getClientOriginalExtension();
            $file_name_as = $time.'-'.$file_name.'.'.$extension_file;

            $tahun = date("Y",time());

            $path = $file->storeAs(
                        'pengumuman/'.$tahun, $file_name_as, ['disk' => 'public']
                    );
            
            $pengumuman->dokumen = 'pengumuman/'.$tahun.'/'.$file_name_as;
        }

        $cover = $request->file('cover');

        if ($cover) {
            $cover_name = pathinfo($cover->getClientOriginalName(), PATHINFO_FILENAME);
            $extension_cover = $cover->getClientOriginalExtension();
            $cover_name_as = time().'-'.$cover_name.'.'.$extension_cover;

            $tahun = date("Y",time());

            $path = $cover->storeAs(
                        'pengumuman/'.$tahun.'/sampul',$cover_name_as, ['disk' => 'public']
                    );
            
            $pengumuman->cover = 'pengumuman/'.$tahun.'/sampul/'.$cover_name_as;
        }

        $pengumuman->save();

        return redirect()->route('pengumuman.edit', ['pengumuman'=>$pengumuman->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return redirect()->route('pengumuman.index');
    }
}
