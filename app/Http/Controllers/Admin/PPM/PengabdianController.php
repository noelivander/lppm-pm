<?php

namespace App\Http\Controllers\Admin\PPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengabdian;
use App\Models\Review;
use App\Models\Anggota_pengabdian;
use App\Models\RabPengabdian;
use App\Models\Timeline;
use Illuminate\Support\Facades\Storage;

class PengabdianController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan proposal yang sudah direview lengkap (2 reviewer)
     */
    public function index(Request $request)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();
        
        // Query proposal yang sudah direview lengkap (minimal 2 reviewer)
        $baseQuery = Pengabdian::where('is_draft', false)
            ->whereRaw('(SELECT COUNT(*) FROM reviews WHERE reviews.pengabdian_id = pengabdian.id) >= 2')
            ->withCount('reviews');

        $filterSkemas = (clone $baseQuery)->select('skema')
            ->whereNotNull('skema')
            ->distinct()
            ->orderBy('skema')
            ->pluck('skema');

        $filterYears = (clone $baseQuery)->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $adminStatuses = [
            'pending' => 'Pending',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak'
        ];

        if ($search = $request->get('search')) {
            $baseQuery->where('judul', 'like', '%' . $search . '%');
        }

        if ($adminStatus = $request->get('admin_status')) {
            if ($adminStatus === 'pending') {
                $baseQuery->whereNull('admin_status');
            } else {
                $baseQuery->where('admin_status', $adminStatus);
            }
        }

        if ($skema = $request->get('skema')) {
            $baseQuery->where('skema', $skema);
        }

        if ($year = $request->get('year')) {
            $baseQuery->whereYear('created_at', $year);
        }

        $proposals = $baseQuery->orderByDesc('updated_at')
            ->paginate(10)
            ->withQueryString();

        $filters = $request->only(['search', 'admin_status', 'skema', 'year']);

        return view('admin.ppm.pengabdian.index', compact(
            'proposals',
            'filterSkemas',
            'filterYears',
            'adminStatuses',
            'filters',
            'timeline',
            'currentDate'
        ));
    }

    /**
     * Display the specified resource.
     * Menampilkan detail proposal beserta 2 review dan form acc/tolak
     */
    public function show($id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();
        
        $proposal = Pengabdian::with(['anggota', 'rab', 'user', 'reviews.reviewer'])->findOrFail($id);
        $proposalYear = $proposal->created_at ? $proposal->created_at->format('Y') : null;
        
        // Pastikan proposal sudah direview minimal 2 reviewer
        $reviews = $proposal->reviews;
        if ($reviews->count() < 2) {
            return redirect()->route('pengabdian-adm.index')
                ->with('error', 'Proposal ini belum direview lengkap oleh 2 reviewer.');
        }

        $anggotaList = $proposal->anggota ?? collect();
        $rabItems = $proposal->rab ?? collect();
        
        $ketuaTim = Anggota_pengabdian::where('pengabdian_id', $id)
            ->where('peran', 'ketua')
            ->first();
        
        $anggotaTim = Anggota_pengabdian::where('pengabdian_id', $id)
            ->where('peran', 'anggota')
            ->get();

        $fileUrl = Storage::url($proposal->dokumen_proposal);

        return view('admin.ppm.pengabdian.show', compact(
            'proposal',
            'reviews',
            'anggotaList',
            'rabItems',
            'ketuaTim',
            'anggotaTim',
            'fileUrl',
            'timeline',
            'currentDate',
            'proposalYear'
        ));
    }

    /**
     * Approve or reject proposal
     */
    public function approveReject(Request $request, $id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();
        
        $proposal = Pengabdian::findOrFail($id);
        $proposalYear = $proposal->created_at ? $proposal->created_at->format('Y') : null;
        
        // Validasi periode admin decision
        if (
            !$timeline ||
            !$timeline->admin_decision_start_date ||
            !$timeline->admin_decision_end_date ||
            !$proposalYear ||
            (string) $timeline->period !== (string) $proposalYear
        ) {
            return redirect()->back()
                ->with('error', 'Periode penyetujuan admin untuk proposal ini belum ditentukan atau sudah tidak aktif.');
        }
        
        if ($currentDate < $timeline->admin_decision_start_date || $currentDate > $timeline->admin_decision_end_date) {
            return redirect()->back()
                ->with('error', 'Anda tidak dapat melakukan keputusan di luar periode yang ditentukan.');
        }
        
        $request->validate([
            'admin_status' => 'required|in:approved,rejected',
            'admin_comment' => 'required|string|max:1000',
        ], [
            'admin_comment.required' => 'Komentar admin wajib diisi.',
        ]);

        // Pastikan proposal sudah direview lengkap
        $reviewCount = Review::where('pengabdian_id', $id)->count();
        if ($reviewCount < 2) {
            return redirect()->back()
                ->with('error', 'Proposal ini belum direview lengkap oleh 2 reviewer.');
        }

        $proposal->admin_status = $request->admin_status;
        $proposal->admin_comment = $request->admin_comment;
        
        // Update status proposal berdasarkan keputusan admin
        if ($request->admin_status === 'approved') {
            $proposal->status = 'Disetujui';
        } else {
            $proposal->status = 'Ditolak';
        }
        
        $proposal->save();

        $statusText = $request->admin_status === 'approved' ? 'disetujui' : 'ditolak';
        
        return redirect()->route('pengabdian-adm.index')
            ->with('success', "Proposal berhasil {$statusText}.");
    }

    /**
     * List proposal revisi pengabdian.
     */
    public function revisiIndex(Request $request)
    {
        $baseQuery = Pengabdian::with(['user'])
            ->where('is_draft', false)
            ->where('is_revised', true);

        $filterSkemas = (clone $baseQuery)->select('skema')
            ->whereNotNull('skema')
            ->distinct()
            ->orderBy('skema')
            ->pluck('skema');

        $filterYears = (clone $baseQuery)->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $statuses = ['Pending', 'Diproses', 'Selesai'];

        $filters = [
            'search' => $request->get('search'),
            'skema' => $request->get('skema'),
            'year' => $request->get('year'),
            'status' => $request->get('status'),
        ];

        if ($filters['search']) {
            $baseQuery->where('judul', 'like', '%' . $filters['search'] . '%');
        }

        if ($filters['skema']) {
            $baseQuery->where('skema', $filters['skema']);
        }

        if ($filters['year']) {
            $baseQuery->whereYear('created_at', $filters['year']);
        }

        if ($filters['status']) {
            $baseQuery->where('status', $filters['status']);
        }

        $proposals = $baseQuery->orderByDesc('updated_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.ppm.pengabdian.revisi.index', compact(
            'proposals',
            'filterSkemas',
            'filterYears',
            'statuses',
            'filters'
        ));
    }

    /**
     * Detail proposal revisi pengabdian.
     */
    public function revisiShow($id)
    {
        $proposal = Pengabdian::with([
                'user',
                'anggota',
                'rab',
                'revisionParent.user',
                'revisionParent.reviews.reviewer',
            ])
            ->where('is_revised', true)
            ->findOrFail($id);

        $originalProposal = $proposal->revisionParent;
        $initialReviews = $originalProposal?->reviews ?? collect();

        $revisionReviews = Review::with('reviewer')
            ->where('pengabdian_id', $proposal->id)
            ->whereNotNull('revision_comment')
            ->orderBy('updated_at', 'desc')
            ->get();

        $fileUrl = $proposal->dokumen_proposal ? Storage::url($proposal->dokumen_proposal) : null;

        return view('admin.ppm.pengabdian.revisi.show', compact(
            'proposal',
            'originalProposal',
            'revisionReviews',
            'initialReviews',
            'fileUrl'
        ));
    }

    /**
     * Get active timeline
     */
    protected function getActiveTimeline()
    {
        return Timeline::active()
            ->orderBy('period', 'desc')
            ->ordered()
            ->first();
    }
}
