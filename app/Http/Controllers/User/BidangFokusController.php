<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use File;

use App\Models\PPM\FokusBidang;

class BidangFokusController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $bidang_fokus = FokusBidang::where('slug',$slug)->first();
        $deskripsi = File::get('storage/'.$bidang_fokus->deskripsi_file);

        return view('user.bidang_fokus.show', compact('bidang_fokus','deskripsi'));
    }
}
