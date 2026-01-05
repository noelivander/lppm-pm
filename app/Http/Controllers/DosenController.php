<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penelitian;
use App\Models\Pengabdian;

class DosenController extends Controller
{
    /**
     * Display the dosen dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $userId = Auth::id();

        // 1. Basic Counts
        // Count only non-draft and non-revision (snapshot) proposals to match Index view
        $jumlahPenelitian = Penelitian::where('user_id', $userId)
            ->where('is_draft', false)
            ->where('is_revised', false)
            ->count();
        $jumlahPengabdian = Pengabdian::where('user_id', $userId)
            ->where('is_draft', false)
            ->where('is_revised', false)
            ->count();

        // 2. Action Items: Perlu Revisi
        // Logic: Status 'Disetujui' OR 'Revisi' but no revision child created yet
        $penelitianPerluRevisi = Penelitian::where('user_id', $userId)
            ->where('is_draft', false)
            ->where('is_revised', false)
            ->whereIn('status', ['Disetujui', 'Revisi'])
            ->doesntHave('revisionChild')
            ->count();

        $pengabdianPerluRevisi = Pengabdian::where('user_id', $userId)
            ->where('is_draft', false)
            ->where('is_revised', false)
            ->whereIn('status', ['Disetujui', 'Revisi'])
            ->doesntHave('revisionChild')
            ->count();

        $usulanPerluRevisi = $penelitianPerluRevisi + $pengabdianPerluRevisi;

        // 3. Action Items: Laporan Pending (Monev)
        // Logic: Revised proposals (active project) that don't have Laporan Kemajuan
        $penelitianLaporanPending = Penelitian::where('user_id', $userId)
            ->where('is_revised', true) // Active project
            ->whereDoesntHave('laporanKemajuan')
            ->count();

        $pengabdianLaporanPending = Pengabdian::where('user_id', $userId)
            ->where('is_revised', true) // Active project
            ->whereDoesntHave('laporanKemajuan')
            ->count();

        $laporanPending = $penelitianLaporanPending + $pengabdianLaporanPending;

        // 4. Funding History (Riwayat Pendanaan)
        // Group by year of creation of the *Original* proposal (which holds the year info usually)
        // But the approved cost is usually on the proposal itself (or parent). 
        // Let's assume 'biaya_disetujui' is on the proposal record that is 'Disetujui'.
        // We'll use the 'biaya_disetujui' from the proposals that are funded.
        // It's safer to query proposals that have 'biaya_disetujui > 0'.

        $penelitianFunding = Penelitian::where('user_id', $userId)
            ->where('biaya_disetujui', '>', 0)
            ->selectRaw('YEAR(created_at) as year, SUM(biaya_disetujui) as total')
            ->groupBy('year')
            ->pluck('total', 'year')
            ->toArray();

        $pengabdianFunding = Pengabdian::where('user_id', $userId)
            ->where('biaya_disetujui', '>', 0)
            ->selectRaw('YEAR(created_at) as year, SUM(biaya_disetujui) as total')
            ->groupBy('year')
            ->pluck('total', 'year')
            ->toArray();

        // Merge Funding Data
        $years = array_unique(array_merge(array_keys($penelitianFunding), array_keys($pengabdianFunding)));
        sort($years);
        $fundingHistory = [
            'years' => [],
            'data' => [],
            'total' => 0
        ];
        foreach ($years as $year) {
            $amount = ($penelitianFunding[$year] ?? 0) + ($pengabdianFunding[$year] ?? 0);
            $fundingHistory['years'][] = $year;
            $fundingHistory['data'][] = $amount;
            $fundingHistory['total'] += $amount;
        }

        // 5. Active Timeline
        $timelineActive = \App\Models\Timeline::where('is_active', true)->first();
        $currentStage = $timelineActive ? $timelineActive->getCurrentStage() : '-';
        $currentStageColor = $timelineActive ? $timelineActive->getStatusColor() : 'secondary';

        return view('dosen.dashboard', compact(
            'jumlahPenelitian',
            'jumlahPengabdian',
            'usulanPerluRevisi',
            'laporanPending',
            'fundingHistory',
            'timelineActive',
            'currentStage',
            'currentStageColor'
        ));
    }

    public function riwayatPendanaan()
    {
        $userId = Auth::id();

        // Fetch funded Penelitian
        $penelitian = Penelitian::where('user_id', $userId)
            ->where('biaya_disetujui', '>', 0)
            ->select('id', 'judul', 'biaya_disetujui', 'created_at', \Illuminate\Support\Facades\DB::raw("'Penelitian' as type"))
            ->get();

        // Fetch funded Pengabdian
        $pengabdian = Pengabdian::where('user_id', $userId)
            ->where('biaya_disetujui', '>', 0)
            ->select('id', 'judul', 'biaya_disetujui', 'created_at', \Illuminate\Support\Facades\DB::raw("'Pengabdian' as type"))
            ->get();

        // Merge and sort by year desc
        $fundedProposals = $penelitian->concat($pengabdian)->sortByDesc('created_at');

        return view('dosen.riwayat_pendanaan', compact('fundedProposals'));
    }
}
