<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Agenda;
use Storage;
use Auth;
use File;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agenda = Agenda::orderBy('jadwal','asc')->get();

        return view('admin.layanan.agenda.index', compact('agenda'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.layanan.agenda.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new = new Agenda;
        $new->user_id = Auth::user()->id;

        $judul = preg_replace('/\p{P}/', '', $request->input('judul'));
        $slug = time()."-".str_replace(" ","-",strtolower($judul));

        $new->judul = $judul;
        $new->slug = $slug;

        $new->lokasi = $request->input('lokasi');
        $new->jadwal = $request->input('jadwal');
        $new->jadwal_akhir = $request->input('jadwal_akhir');
        $new->tautan = $request->input('tautan');
        $new->tag = $request->input('tag');

        $text_deskripsi = $request->input('deskripsi');

        if($text_deskripsi) {
            $text_deskripsi = str_replace("<img alt", "<img class=\"img-fluid img-thumbnail w-100\" alt", $text_deskripsi);

            Storage::disk('public')->put('agenda/text/'.$slug.'.txt', $text_deskripsi);

            $new->deskripsi = 'agenda/text/'.$slug.'.txt';
        }

        $new->is_shown = 1;

        $cover = $request->file('cover');

        if ($cover) {
            $cover_name = pathinfo($cover->getClientOriginalName(), PATHINFO_FILENAME);
            $extension_cover = $cover->getClientOriginalExtension();
            $cover_name_as = time().'-'.$cover_name.'.'.$extension_cover;

            $tahun = date("Y",time());

            $path = $cover->storeAs(
                        'agenda/'.$tahun.'/',$cover_name_as, ['disk' => 'public']
                    );
            
            $new->cover = 'agenda/'.$tahun.'/'.$cover_name_as;
        }

        $new->save();

        return redirect()->route('agenda.edit', ['agenda'=>$new->id]);
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
    public function edit(Agenda $agenda)
    {
        $deskripsi = File::get('storage/'.$agenda->deskripsi);
        return view('admin.layanan.agenda.edit', compact('agenda','deskripsi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agenda $agenda)
    {
        $time = explode("-", $agenda->slug)[0];
        $judul = preg_replace('/\p{P}/', '', $request->input('judul'));
        $slug = $time ."-".str_replace(" ","-",strtolower($judul));
        $agenda->judul = $judul;
        $agenda->slug = $slug;

        $agenda->lokasi = $request->input('lokasi');
        $agenda->jadwal = $request->input('jadwal');
        $agenda->jadwal_akhir = $request->input('jadwal_akhir');
        $agenda->tautan = $request->input('tautan');
        $agenda->tag = $request->input('tag');
        $agenda->is_shown = ($request->input('is_shown'))? 1 : 0;

        $text_deskripsi = $request->input('deskripsi');
        if($text_deskripsi) {
            $text_deskripsi = str_replace("<img alt", "<img class=\"img-fluid img-thumbnail w-100\" alt", $text_deskripsi);

            Storage::disk('public')->put('agenda/text/'.$slug.'.txt', $text_deskripsi);

            $agenda->deskripsi = 'agenda/text/'.$slug.'.txt';
        }


        $cover = $request->file('cover');

        if ($cover) {
            $cover_name = pathinfo($cover->getClientOriginalName(), PATHINFO_FILENAME);
            $extension_cover = $cover->getClientOriginalExtension();
            $cover_name_as = time().'-'.$cover_name.'.'.$extension_cover;

            $tahun = date("Y",time());

            $path = $cover->storeAs(
                        'agenda/'.$tahun.'/',$cover_name_as, ['disk' => 'public']
                    );
            
            $agenda->cover = 'agenda/'.$tahun.'/'.$cover_name_as;
        }

        $agenda->save();

        return redirect()->route('agenda.edit', ['agenda'=>$agenda->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agenda $agenda)
    {
        $agenda->delete();

        return redirect()->route('agenda.index');
    }
}
