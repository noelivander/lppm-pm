<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Berita;
use Auth;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $berita = Berita::orderBy('created_at','desc')->get();

        return view('admin.layanan.berita.index', compact('berita'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.layanan.berita.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new = new Berita;
        $new->user_id = Auth::user()->id;

        $judul = preg_replace('/\p{P}/', '', $request->input('judul'));
        $new->judul = $judul;
        $new->slug = time()."-".str_replace(" ","-",strtolower($judul));

        $text_isi = $request->input('isi');
        $text_isi = str_replace("<img alt", "<img class=\"img-fluid img-thumbnail w-100\" alt", $text_isi);
        $new->isi = $text_isi;

        $new->is_shown = 1;

        $file = $request->file('cover');

        if ($file) {
            $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension_file = $file->getClientOriginalExtension();
            $file_name_as = time().'-'.$file_name.'.'.$extension_file;

            $tahun = date("Y",time());

            $path = $file->storeAs(
                        'berita/'.$tahun, $file_name_as, ['disk' => 'public']
                    );
            
            $new->cover = 'berita/'.$tahun.'/'.$file_name_as;
        }

        $new->save();

        return redirect()->route('berita.edit', ['beritum'=>$new->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Berita $beritum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Berita $beritum)
    {
        $berita = $beritum;
        return view('admin.layanan.berita.edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Berita $beritum)
    {
        $time = explode("-", $beritum->slug)[0];

        $judul = preg_replace('/\p{P}/', '', $request->input('judul'));
        $beritum->judul = $judul;
        $beritum->slug = $time."-".str_replace(" ","-",strtolower($judul));

        $text_isi = $request->input('isi');
        $text_isi = str_replace("<img alt", "<img class=\"img-fluid img-thumbnail w-100\" alt", $text_isi);
        $beritum->isi = $text_isi;
        
        $beritum->created_at = $request->input('created_at');
        
        $beritum->is_shown = ($request->input('is_shown'))? 1 : 0;;

        $file = $request->file('cover');

        if ($file) {
            $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension_file = $file->getClientOriginalExtension();
            $file_name_as = $time.'-'.$file_name.'.'.$extension_file;

            $tahun = date("Y",time());

            $path = $file->storeAs(
                        'berita/'.$tahun, $file_name_as, ['disk' => 'public']
                    );
            
            $beritum->cover = 'berita/'.$tahun.'/'.$file_name_as;
        }

        $beritum->save();

        return redirect()->route('berita.edit', ['beritum'=>$beritum->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Berita $beritum)
    {
        $beritum->delete();
        return redirect()->route('berita.index');
    }
}
