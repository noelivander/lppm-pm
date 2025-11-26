<?php

namespace App\Http\Controllers\Admin\Pengaturan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\RelatedLink;

class RelatedLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $related_link = RelatedLink::orderBy('created_at', 'desc')->get();

        return view('admin.pengaturan.tautan.index', compact('related_link'));
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
        $request->validate([
            'nama' => 'required|string|max:255',
            'url' => 'required|url|max:255',
        ]);

        RelatedLink::create($request->all());
        return redirect()->route('related_link.index')->with('success', 'Tautan berhasil ditambahkan.');
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
    public function edit(RelatedLink $related_link)
    {
        return view('admin.pengaturan.tautan.edit', compact('related_link'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RelatedLink $related_link)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'url' => 'required|url|max:255',
        ]);

        $related_link->update($request->all());
        return redirect()->route('related_link.index')->with('success', 'Tautan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RelatedLink $related_link)
    {
        $related_link->delete();
        return redirect()->route('related_link.index')->with('success', 'Tautan berhasil dihapus.');
    }
}
