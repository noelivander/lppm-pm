<?php

namespace App\Http\Controllers\Admin\PPM;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use Auth;
use File;

use App\Models\PPM\FokusBidang;

class FokusBidangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fokus_bidang = FokusBidang::all();

        return view('admin.ppm.fokus_bidang.index', compact('fokus_bidang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.ppm.fokus_bidang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $new = new FokusBidang;

        $nama = preg_replace('/\p{P}/', '', $request->input('nama'));
        $new->nama = $nama;
        $new->perihal = $request->input('perihal');
        $new->singkatan = $request->input('singkatan');

        $slug = time()."-".str_replace(" ","-", strtolower($nama));
        $new->slug = $slug;

        $cover = $request->file('cover');

        if ($cover) {
            $extension_file = $cover->getClientOriginalExtension();
            $file_name_as = $slug.'.'.$extension_file;

            $folder = 'fokus_bidang/cover/';

            $path = $cover->storeAs(
                        $folder, $file_name_as, ['disk' => 'public']
                    );
            
            $new->cover = $folder.$file_name_as;
        }

        $text_stucture = $request->deskripsi;
        $text_stucture = str_replace("<img alt", "<img class=\"img-fluid img-thumbnail w-100\" alt", $text_stucture);

        Storage::disk('public')->put('fokus_bidang/text/'.$slug.'.txt', $text_stucture);

        $new->deskripsi_file = 'fokus_bidang/text/'.$slug.'.txt';

        $new->save();

        return redirect()->route('fokus-bidang.edit', ['fokus_bidang'=>$new->id]);
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
    public function edit(FokusBidang $fokus_bidang)
    {
        $deskripsi = File::get('storage/'.$fokus_bidang->deskripsi_file);

        return view('admin.ppm.fokus_bidang.edit', compact('fokus_bidang', 'deskripsi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FokusBidang $fokus_bidang)
    {
        $time = explode("-", $fokus_bidang->slug)[0];

        $nama = preg_replace('/\p{P}/', '', $request->input('nama'));
        $fokus_bidang->nama = $nama;
        $fokus_bidang->perihal = $request->input('perihal');
        $fokus_bidang->singkatan = $request->input('singkatan');

        $slug = $time."-".str_replace(" ","-", strtolower($nama));
        $fokus_bidang->slug = $slug;

        $cover = $request->file('cover');

        if ($cover) {
            $extension_file = $cover->getClientOriginalExtension();
            $file_name_as = $slug.'.'.$extension_file;

            $folder = 'fokus_bidang/cover/';

            $path = $cover->storeAs(
                        $folder, $file_name_as, ['disk' => 'public']
                    );
            
            $fokus_bidang->cover = $folder.$file_name_as;
        }

        $text_stucture = $request->deskripsi;
        $text_stucture = str_replace("<img alt", "<img class=\"img-fluid img-thumbnail w-100\" alt", $text_stucture);

        Storage::disk('public')->put('fokus_bidang/text/'.$slug.'.txt', $text_stucture);

        $fokus_bidang->deskripsi_file = 'fokus_bidang/text/'.$slug.'.txt';

        $fokus_bidang->save();

        return redirect()->route('fokus-bidang.edit', ['fokus_bidang'=>$fokus_bidang->id]);
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
