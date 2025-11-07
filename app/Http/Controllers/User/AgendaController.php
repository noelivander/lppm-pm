<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Models\Agenda;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            $query = Agenda::query()->where('is_shown', 1);

            // Search by keyword in title or description
            $q = trim((string) $request->get('q'));
            if ($q !== '') {
                $query->where(function($sub) use ($q) {
                    $sub->where('judul', 'like', "%{$q}%")
                        ->orWhere('deskripsi_singkat', 'like', "%{$q}%")
                        ->orWhere('lokasi', 'like', "%{$q}%");
                });
            }

            // Filtering by month
            if ($request->filled('month')) {
                $query->whereMonth('jadwal', $request->month);
            }

            // Filtering by category/tag
            if ($request->filled('category')) {
                $query->where('tag', $request->category);
            }

            // Sorting
            $sort = $request->get('sort', 'upcoming');
            switch ($sort) {
                case 'oldest':
                    $query->orderBy('jadwal', 'asc');
                    break;
                case 'latest':
                    $query->orderBy('jadwal', 'desc');
                    break;
                case 'upcoming':
                default:
                    $query->orderBy('jadwal', 'asc');
                    break;
            }

            // Pagination
            $perPage = (int) $request->get('per_page', 9);
            $perPage = $perPage > 0 && $perPage <= 24 ? $perPage : 9;
            $agenda = $query->paginate($perPage)->withQueryString();

            // Cache the results of these queries since they don't change often
            $availableMonths = cache()->remember('available_months', now()->addDay(), function () {
                return Agenda::selectRaw('DISTINCT MONTH(jadwal) as month, YEAR(jadwal) as year')
                    ->orderBy('year', 'desc')
                    ->orderBy('month', 'desc')
                    ->get()
                    ->map(function($item) {
                        return [
                            'value' => $item->month,
                            'label' => Carbon::create()->month($item->month)->format('F Y')
                        ];
                    });
            });

            $availableCategories = cache()->remember('available_categories', now()->addDay(), function () {
                return Agenda::whereNotNull('tag')
                    ->distinct()
                    ->pluck('tag')
                    ->filter()
                    ->values();
            });

            return view('user.agenda.index', compact('agenda', 'availableMonths', 'availableCategories', 'sort', 'q', 'perPage'));
            
        } catch (\Exception $e) {
            Log::error('Error in AgendaController@index: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat halaman agenda. Silakan coba lagi nanti.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        try {
            $agenda = Agenda::where('slug', $slug)->firstOrFail();
            
            $deskripsi = '';
            if ($agenda->deskripsi) {
                $filePath = storage_path('app/public/' . ltrim($agenda->deskripsi, '/'));
                if (File::exists($filePath)) {
                    $deskripsi = File::get($filePath);
                }
            }

            $jadwal = Carbon::parse($agenda->jadwal)->translatedFormat('d F Y');

            if ($agenda->jadwal_akhir) {
                $jadwal = Carbon::parse($agenda->jadwal)->translatedFormat('d M Y') . ' - ' . 
                         Carbon::parse($agenda->jadwal_akhir)->translatedFormat('d M Y');
            }

            return view('user.agenda.show', compact('agenda', 'deskripsi', 'jadwal'));
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Agenda not found: ' . $slug);
            abort(404, 'Agenda tidak ditemukan');
        } catch (\Exception $e) {
            Log::error('Error in AgendaController@show: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat detail agenda. Silakan coba lagi nanti.');
        }
    }
}
