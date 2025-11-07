<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Berita;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Berita::query()->where('is_shown', 1);

        // Search by keyword in title or content
        $q = trim((string) $request->get('q'));
        if ($q !== '') {
            $query->where(function($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhere('isi', 'like', "%{$q}%");
            });
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Pagination
        $perPage = (int) $request->get('per_page', 9);
        $perPage = $perPage > 0 && $perPage <= 24 ? $perPage : 9;
        $berita = $query->paginate($perPage)->withQueryString();

        return view('user.berita.index', compact('berita', 'sort', 'q', 'perPage'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $berita = Berita::where('slug',$slug)->firstOrFail();
        
        // Increment views
        $berita->increment('views');

        return view('user.berita.show', compact('berita'));
    }
}
