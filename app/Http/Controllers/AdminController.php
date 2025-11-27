<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Penelitian;
use App\Models\Pengabdian;
use App\Models\ProgramStudi;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // High-level KPIs
        $totalUsers = User::count();
        $totalPenelitian = Penelitian::count();
        $totalPengabdian = Pengabdian::count();
        $totalProdi = class_exists(ProgramStudi::class) ? ProgramStudi::count() : 0;

        // Monthly series for current year
        $year = now()->year;
        $months = collect(range(1, 12))->map(fn($m) => Carbon::create($year, $m, 1)->format('M'));

        $penelitianMonthly = collect(range(1, 12))->map(function ($m) use ($year) {
            return Penelitian::whereYear('created_at', $year)->whereMonth('created_at', $m)->count();
        });

        $pengabdianMonthly = collect(range(1, 12))->map(function ($m) use ($year) {
            return Pengabdian::whereYear('created_at', $year)->whereMonth('created_at', $m)->count();
        });

        // Pie breakdown for skema (top 3 + others)
        $allSkemaCounts = Penelitian::pluck('skema')
            ->filter(fn($v) => $v !== '' && $v !== null)
            ->countBy()
            ->sortDesc();

        $topSkema = $allSkemaCounts->take(3);
        $othersCount = $allSkemaCounts->sum() - $topSkema->sum();
        if ($othersCount > 0) {
            $topSkema = $topSkema->put('Lainnya', $othersCount);
        }

        // Status breakdowns
        $penelitianStatus = Penelitian::selectRaw('LOWER(COALESCE(status, "unknown")) as status, COUNT(*) as total')
            ->groupBy('status')
            ->orderByDesc('total')
            ->pluck('total', 'status');

        $pengabdianStatus = Pengabdian::selectRaw('LOWER(COALESCE(status, "unknown")) as status, COUNT(*) as total')
            ->groupBy('status')
            ->orderByDesc('total')
            ->pluck('total', 'status');

        // Recent submissions
        $latestPenelitian = Penelitian::latest('created_at')->take(5)->get(['id', 'judul', 'status', 'created_at']);
        $latestPengabdian = Pengabdian::latest('created_at')->take(5)->get(['id', 'judul', 'status', 'created_at']);

        return view('admin.dashboard', [
            'kpis' => [
                'totalProdi' => $totalProdi,
                'totalUsers' => $totalUsers,
                'totalPenelitian' => $totalPenelitian,
                'totalPengabdian' => $totalPengabdian,
            ],
            'months' => $months,
            'series' => [
                'penelitian' => $penelitianMonthly,
                'pengabdian' => $pengabdianMonthly,
            ],
            'skema' => [
                'labels' => $topSkema->keys()->values(),
                'data' => $topSkema->values(),
            ],
            'status' => [
                'penelitian' => [
                    'labels' => $penelitianStatus->keys()->values(),
                    'data' => $penelitianStatus->values(),
                ],
                'pengabdian' => [
                    'labels' => $pengabdianStatus->keys()->values(),
                    'data' => $pengabdianStatus->values(),
                ],
            ],
            'latest' => [
                'penelitian' => $latestPenelitian,
                'pengabdian' => $latestPengabdian,
            ],
        ]);
    }
}
