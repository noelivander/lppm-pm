<?php

namespace App\Http\Controllers\Admin\Kelembagaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use File;

class StrukturorgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $text_stucture = File::get(storage_path('content/text/struktur_organisasi.txt'));

        return view('admin.kelembagaan.struktur_organisasi.index', compact('text_stucture'));
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
        $text_stucture = $request->struktur_org;
        $text_stucture = str_replace("<img alt", "<img class=\"img-fluid img-thumbnail w-100\" alt", $text_stucture);

        File::replace(storage_path('content/text/struktur_organisasi.txt'), $text_stucture);

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
