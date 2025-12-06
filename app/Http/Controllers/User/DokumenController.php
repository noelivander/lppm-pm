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
        if ($request->has('q') && $request->q != '') {
            $query->where('judul', 'like', '%' . $request->q . '%');
        }

        // Filter by Type (Extension) - Optional, if we want server side
        // Note: The view currently does client-side type filtering. 
        // We can keep it client-side for the current page, or move it server-side.
        // For now, let's focus on Category Pagination.

        // Filter by Category (Label)
        $category = $request->get('category', 'all');
        if ($category !== 'all') {
            $labelMap = [
                'umum' => 0,
                'ppm' => 1,
                'pm' => 2,
                'lain' => 3
            ];
            
            if (isset($labelMap[$category])) {
                $query->where('label', $labelMap[$category]);
            }
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

        // Pagination
        $perPage = 9;
        $documents = $query->paginate($perPage)->withQueryString();

        // Counts for Tabs
        // We need to run separate queries or a grouped query to get counts for all categories
        // regardless of the current filter.
        $counts = DokumenPenting::where('is_shown', 1)
            ->selectRaw('label, count(*) as total')
            ->groupBy('label')
            ->pluck('total', 'label')
            ->toArray();

        // Map counts to category names
        $categoryCounts = [
            'umum' => $counts[0] ?? 0,
            'ppm' => $counts[1] ?? 0,
            'pm' => $counts[2] ?? 0,
            'lain' => $counts[3] ?? 0,
            'all' => array_sum($counts)
        ];

        return view('user.dokumen.index', compact('documents', 'categoryCounts'));
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
