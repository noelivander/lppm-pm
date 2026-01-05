<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penelitian;
use App\Models\Pengabdian;

class ReviewerController extends Controller
{
    /**
     * Display the reviewer dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $userId = \Illuminate\Support\Facades\Auth::id();

        // 1. Basic Counts (Total Proposals in System - existing logic)
        $jumlahPenelitian = Penelitian::count();
        $jumlahPengabdian = Pengabdian::count();

        // 2. My Workload (Pending Reviews)
        // Get IDs of proposals I have already reviewed
        $reviewedPenelitianIds = \App\Models\Review::where('reviewer_id', $userId)
            ->whereNotNull('penelitian_id')
            ->pluck('penelitian_id')
            ->toArray();

        $reviewedPengabdianIds = \App\Models\Review::where('reviewer_id', $userId)
            ->whereNotNull('pengabdian_id')
            ->pluck('pengabdian_id')
            ->toArray();

        // Count Assigned but NOT Reviewed
        $pendingPenelitian = Penelitian::where('is_draft', false)
            ->whereHas('assignedReviewers', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereNotIn('id', $reviewedPenelitianIds)
            ->count();

        $pendingPengabdian = Pengabdian::where('is_draft', false)
            ->whereHas('assignedReviewers', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereNotIn('id', $reviewedPengabdianIds)
            ->count();

        $pendingReviewCount = $pendingPenelitian + $pendingPengabdian;

        // Count Assigned AND Reviewed (to match the Assignments page logic)
        $completedPenelitian = Penelitian::whereHas('assignedReviewers', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
            ->whereIn('id', $reviewedPenelitianIds)
            ->count();

        $completedPengabdian = Pengabdian::whereHas('assignedReviewers', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
            ->whereIn('id', $reviewedPengabdianIds)
            ->count();

        $completedReviewCount = $completedPenelitian + $completedPengabdian;

        // 3. Recent Assignments (Priority List)
        // Fetch pending assignments details
        $limit = 5;
        $recentPenelitian = Penelitian::where('is_draft', false)
            ->whereHas('assignedReviewers', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereNotIn('id', $reviewedPenelitianIds)
            ->select('id', 'judul', 'created_at', \Illuminate\Support\Facades\DB::raw("'Penelitian' as type"))
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();

        $recentPengabdian = Pengabdian::where('is_draft', false)
            ->whereHas('assignedReviewers', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereNotIn('id', $reviewedPengabdianIds)
            ->select('id', 'judul', 'created_at', \Illuminate\Support\Facades\DB::raw("'Pengabdian' as type"))
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();

        // Merge and sort
        $recentAssignments = $recentPenelitian->concat($recentPengabdian)
            ->sortByDesc('created_at')
            ->take($limit);

        // 4. Score Distribution
        // Calculate score based on ReviewKriteria (dynamic) or fallback to columns (static)
        $myReviews = \App\Models\Review::with('reviewKriteria')->where('reviewer_id', $userId)->get();
        $scoreDistribution = [
            '< 400' => 0,
            '400 - 500' => 0,
            '> 500' => 0
        ];

        foreach ($myReviews as $review) {
            $totalScore = 0;

            if ($review->reviewKriteria->count() > 0) {
                // Dynamic form: sum of 'nilai' (skor * bobot)
                $totalScore = $review->reviewKriteria->sum('nilai');
            } else {
                // Legacy/Static form: sum of skor_1 to skor_5
                $totalScore = ($review->skor_1 ?? 0) +
                    ($review->skor_2 ?? 0) +
                    ($review->skor_3 ?? 0) +
                    ($review->skor_4 ?? 0) +
                    ($review->skor_5 ?? 0);
            }

            if ($totalScore < 400) {
                $scoreDistribution['< 400']++;
            } elseif ($totalScore <= 500) {
                $scoreDistribution['400 - 500']++;
            } else {
                $scoreDistribution['> 500']++;
            }
        }

        // 5. Monthly Reviews for Chart
        $monthlyReviews = $this->getMonthlyReviews($userId);

        return view('reviewer.dashboard', compact(
            'jumlahPenelitian',
            'jumlahPengabdian',
            'pendingReviewCount',
            'completedReviewCount',
            'recentAssignments',
            'scoreDistribution',
            'monthlyReviews'
        ));
    }

    public function assignments(Request $request)
    {
        $userId = \Illuminate\Support\Facades\Auth::id();
        $status = $request->get('status', 'pending'); // pending, completed

        // Get Completed IDs
        $reviewedPenelitianIds = \App\Models\Review::where('reviewer_id', $userId)
            ->whereNotNull('penelitian_id')
            ->pluck('penelitian_id')
            ->toArray();

        $reviewedPengabdianIds = \App\Models\Review::where('reviewer_id', $userId)
            ->whereNotNull('pengabdian_id')
            ->pluck('pengabdian_id')
            ->toArray();

        // Query Penelitian
        $penelitianQuery = Penelitian::where('is_draft', false)
            ->whereHas('assignedReviewers', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->select('id', 'judul', 'created_at', \Illuminate\Support\Facades\DB::raw("'Penelitian' as type"));

        // Query Pengabdian
        $pengabdianQuery = Pengabdian::where('is_draft', false)
            ->whereHas('assignedReviewers', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->select('id', 'judul', 'created_at', \Illuminate\Support\Facades\DB::raw("'Pengabdian' as type"));

        // Filter Logic
        if ($status == 'pending') {
            $penelitianQuery->whereNotIn('id', $reviewedPenelitianIds);
            $pengabdianQuery->whereNotIn('id', $reviewedPengabdianIds);
        } elseif ($status == 'completed') {
            $penelitianQuery->whereIn('id', $reviewedPenelitianIds);
            $pengabdianQuery->whereIn('id', $reviewedPengabdianIds);
        }

        $allAssignments = $penelitianQuery->get()->concat($pengabdianQuery->get())->sortByDesc('created_at');

        return view('reviewer.assignments', compact('allAssignments', 'status'));
    }

    private function getMonthlyReviews($userId)
    {
        // Calculate reviews per month for current year
        $reviews = \App\Models\Review::where('reviewer_id', $userId)
            ->whereYear('created_at', date('Y'))
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $reviews[$i] ?? 0;
        }

        return $data;
    }
}
