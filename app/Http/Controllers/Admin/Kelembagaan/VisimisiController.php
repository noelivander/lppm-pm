<?php

namespace App\Http\Controllers\Admin\Kelembagaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use File;

class VisimisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $text_visi_misi = File::get(storage_path('content/text/visi_misi.txt'));

        return view('admin.kelembagaan.visi_misi.index', compact('text_visi_misi'));
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
        $text_visi_misi = $request->visi_misi_org;
        $text_visi_misi = str_replace("<img alt", "<img class=\"img-fluid img-thumbnail w-100\" alt", $text_visi_misi);

        File::replace(storage_path('content/text/visi_misi.txt'), $text_visi_misi);

        return redirect()->back();

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
