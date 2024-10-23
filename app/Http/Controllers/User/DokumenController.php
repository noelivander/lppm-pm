<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DokumenPenting;

class DokumenController extends Controller
{
    public function index()
    {
        $dokumen_umum = DokumenPenting::where('label',0)->where('is_shown',1)->orderBy('urutan','asc')->get();
        $dokumen_ppm = DokumenPenting::where('label',1)->where('is_shown',1)->orderBy('urutan','asc')->get();
        $dokumen_pm = DokumenPenting::where('label',2)->where('is_shown',1)->orderBy('urutan','asc')->get();
        $dokumen_lain = DokumenPenting::where('label',3)->where('is_shown',1)->orderBy('urutan','asc')->get();

        return view('user.dokumen.index', compact('dokumen_umum','dokumen_ppm','dokumen_pm','dokumen_lain'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $dokumen = DokumenPenting::where('slug',$slug)->first();

        return view('user.dokumen.show', compact('dokumen'));
    }
}
