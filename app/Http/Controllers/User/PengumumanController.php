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
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'latest');
        
        $query = Pengumuman::query();
        
        switch ($sort) {
            case 'popular':
                $query->orderBy('dilihat', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $pengumuman = $query->paginate(12);

        return view('user.pengumuman.index', compact('pengumuman', 'sort'));
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
