<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengumuman;

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

        return view('user.pengumuman.index', compact('pengumuman'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $pengumuman = Pengumuman::where('slug',$slug)->first();

        return view('user.pengumuman.show', compact('pengumuman'));
    }
}
