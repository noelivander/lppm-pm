<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DokumenPenting;

class DokumenController extends Controller
{
    public function index(Request $request)
    {
        $query = DokumenPenting::where('is_shown', 1);

        // Search
        if ($request->has('q')) {
            $query->where('judul', 'like', '%' . $request->q . '%');
        }

        // Sort
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'name-asc':
                    $query->orderBy('judul', 'asc');
                    break;
                case 'name-desc':
                    $query->orderBy('judul', 'desc');
                    break;
                default:
                    $query->orderBy('urutan', 'asc');
                    break;
            }
        } else {
            $query->orderBy('urutan', 'asc');
        }

        $documents = $query->get();

        $dokumen_umum = $documents->where('label', 0);
        $dokumen_ppm = $documents->where('label', 1);
        $dokumen_pm = $documents->where('label', 2);
        $dokumen_lain = $documents->where('label', 3);

        return view('user.dokumen.index', compact('dokumen_umum', 'dokumen_ppm', 'dokumen_pm', 'dokumen_lain'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $dokumen = DokumenPenting::where('slug', $slug)->first();

        return view('user.dokumen.show', compact('dokumen'));
    }
}
