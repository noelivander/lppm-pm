<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Schema;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Pengumuman::query()->where('is_shown', 1);

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
        $pengumuman = $query->paginate($perPage)->withQueryString();

        return view('user.pengumuman.index', compact('pengumuman', 'sort', 'q', 'perPage'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $pengumuman = Pengumuman::where('slug',$slug)->firstOrFail();
        
        // Increment views (only if column exists)
        if (Schema::hasColumn('announcements', 'views')) {
            $pengumuman->increment('views');
        }

        return view('user.pengumuman.show', compact('pengumuman'));
    }
}
