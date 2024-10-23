<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use File;
use Carbon\Carbon;

use App\Models\Agenda;

class AgendaController extends Controller
{
    public function index()
    {
        $agenda = Agenda::orderBy('jadwal','asc')->get();

        return view('user.agenda.index', compact('agenda'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $agenda = Agenda::where('slug',$slug)->first();
        
        $deskripsi = File::get('storage/'.$agenda->deskripsi);
        // $deskripsi = File::get('storage/'.$agenda->deskripsi);

        $jadwal = Carbon::createFromFormat('Y-m-d H:i:s', $agenda->jadwal)->format('d F Y');

        if($agenda->jadwal_akhir){
            $jadwal = Carbon::createFromFormat('Y-m-d H:i:s', $agenda->jadwal)->format('d M Y').' - '.Carbon::createFromFormat('Y-m-d H:i:s', $agenda->jadwal_akhir)->format('d M Y');
        }

        return view('user.agenda.show', compact('agenda','deskripsi','jadwal'));
    }
}
