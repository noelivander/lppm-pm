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
        // 1. High-level KPIs (Consistent Filters: No Drafts, No Revisions)
        $totalUsers = User::count();
        $totalPenelitian = Penelitian::where('is_draft', false)->where('is_revised', false)->count();
        $totalPengabdian = Pengabdian::where('is_draft', false)->where('is_revised', false)->count();
        $totalProdi = class_exists(ProgramStudi::class) ? ProgramStudi::count() : 0;

        // NEW: Total Funding (Sum of 'biaya_disetujui')
        $fundingPenelitian = Penelitian::where('is_draft', false)->where('is_revised', false)->sum('biaya_disetujui');
        $fundingPengabdian = Pengabdian::where('is_draft', false)->where('is_revised', false)->sum('biaya_disetujui');
        $totalFunding = $fundingPenelitian + $fundingPengabdian;

        // 2. Monthly Series (Clean Data)
        $year = now()->year;
        $months = collect(range(1, 12))->map(fn($m) => Carbon::create($year, $m, 1)->format('M'));

        $penelitianMonthly = collect(range(1, 12))->map(function ($m) use ($year) {
            return Penelitian::whereYear('created_at', $year)
                ->whereMonth('created_at', $m)
                ->where('is_draft', false)
                ->where('is_revised', false)
                ->count();
        });

        $pengabdianMonthly = collect(range(1, 12))->map(function ($m) use ($year) {
            return Pengabdian::whereYear('created_at', $year)
                ->whereMonth('created_at', $m)
                ->where('is_draft', false)
                ->where('is_revised', false)
                ->count();
        });

        // 3. Status Breakdown (Clean Data)
        $penelitianStatus = Penelitian::where('is_draft', false)
            ->where('is_revised', false)
            ->selectRaw('LOWER(COALESCE(status, "unknown")) as status, COUNT(*) as total')
            ->groupBy('status')
            ->orderByDesc('total')
            ->pluck('total', 'status');

        $pengabdianStatus = Pengabdian::where('is_draft', false)
            ->where('is_revised', false)
            ->selectRaw('LOWER(COALESCE(status, "unknown")) as status, COUNT(*) as total')
            ->groupBy('status')
            ->orderByDesc('total')
            ->pluck('total', 'status');

        // NEW: Pending Reviewer Assignments (Bottleneck Indicator)
        // Proposals that are ready for review ('buka_review' or 'submitted') but have NO reviewers assigned
        $pendingPenelitian = Penelitian::where('is_draft', false)
            ->where('is_revised', false)
            ->whereIn('status', ['submitted', 'buka_review'])
            ->doesntHave('assignedReviewers')
            ->count();

        $pendingPengabdian = Pengabdian::where('is_draft', false)
            ->where('is_revised', false)
            ->whereIn('status', ['submitted', 'buka_review'])
            ->doesntHave('assignedReviewers')
            ->count();

        $pendingAssignments = $pendingPenelitian + $pendingPengabdian;

        // 4. Skema Breakdown (Clean Data & Decrypt Labels)
        $allSkemaCounts = Penelitian::where('is_draft', false)
            ->where('is_revised', false)
            ->pluck('skema')
            ->filter(fn($v) => $v !== '' && $v !== null)
            ->map(function ($skema) {
                // Try decryption if it looks encrypted (optional, assuming simplistic check or try/catch)
                try {
                    return \Illuminate\Support\Facades\Crypt::decryptString($skema);
                } catch (\Exception $e) {
                    return $skema;
                }
            })
            ->countBy()
            ->sortDesc();

        $topSkema = $allSkemaCounts->take(3);
        $othersCount = $allSkemaCounts->sum() - $topSkema->sum();
        if ($othersCount > 0) {
            $topSkema = $topSkema->put('Lainnya', $othersCount);
        }

        // 5. Recent Submissions (Unified List)
        $limit = 5;
        $latestPenelitian = Penelitian::where('is_draft', false)
            ->where('is_revised', false)
            ->select('id', 'judul', 'status', 'created_at', \Illuminate\Support\Facades\DB::raw("'Penelitian' as type"))
            ->latest('created_at')->take($limit)->get();

        $latestPengabdian = Pengabdian::where('is_draft', false)
            ->where('is_revised', false)
            ->select('id', 'judul', 'status', 'created_at', \Illuminate\Support\Facades\DB::raw("'Pengabdian' as type"))
            ->latest('created_at')->take($limit)->get();

        $latestSubmissions = $latestPenelitian->concat($latestPengabdian)
            ->sortByDesc('created_at')
            ->take($limit);

        return view('admin.dashboard', [
            'kpis' => [
                'totalProdi' => $totalProdi,
                'totalUsers' => $totalUsers,
                'totalPenelitian' => $totalPenelitian,
                'totalPengabdian' => $totalPengabdian,
                'totalFunding' => $totalFunding,
                'fundingPenelitian' => $fundingPenelitian, // Add breakdown
                'fundingPengabdian' => $fundingPengabdian, // Add breakdown
                'pendingAssignments' => $pendingAssignments, // New Metric
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
            'latestSubmissions' => $latestSubmissions,
        ]);
    }
}
