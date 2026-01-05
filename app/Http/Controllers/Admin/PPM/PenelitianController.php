<?php

namespace App\Http\Controllers\Admin\PPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penelitian;
use App\Models\Review;
use App\Models\Anggota;
use App\Models\RabPenelitian;
use App\Models\Timeline;
use Illuminate\Support\Facades\Storage;
use App\Models\User; // Added User model

class PenelitianController extends Controller
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
        // REMOVED: Allow admin to see all proposals to assign reviewers
        // Added: Exclude revisions
        $baseQuery = Penelitian::where('is_draft', false)
            ->where('is_revised', false)
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

        return view('admin.ppm.penelitian.index', compact(
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

        $proposal = Penelitian::with(['anggota', 'rab', 'user', 'reviews.reviewer', 'reviews.reviewKriteria.formPenilaianReview'])->findOrFail($id);
        $proposalYear = $proposal->created_at ? $proposal->created_at->format('Y') : null;

        // Pastikan proposal sudah direview minimal 2 reviewer
        $reviews = $proposal->reviews;
        // REMOVED BLOCKING CHECK: Allow admin to view proposal even if reviews < 2 to assign reviewers
        // if ($reviews->count() < 2) {
        //     return redirect()->route('penelitian-adm.index')
        //         ->with('error', 'Proposal ini belum direview lengkap oleh 2 reviewer.');
        // }
        // Instead, just pass a flag or count to view
        $reviewCount = $reviews->count();

        // Load Assigned Reviewers
        $proposal->load('assignedReviewers');
        $assignedReviewers = $proposal->assignedReviewers;

        // Get Available Reviewers (Users with role 'reviewer')
        // Assuming 'role' column exists and stores string 'reviewer' or similar. 
        // Based on previous files, User model has 'role'.
        $availableReviewers = User::where('role', 'reviewer')
            ->whereDoesntHave('assignedPenelitians', function ($q) use ($id) {
                $q->where('penelitian_id', $id);
            })
            ->orderBy('name')
            ->get();

        $anggotaList = $proposal->anggota ?? collect();
        $rabItems = $proposal->rab ?? collect();

        $ketuaTim = Anggota::where('penelitian_id', $id)
            ->where('peran', 'ketua')
            ->first();

        $anggotaTim = Anggota::where('penelitian_id', $id)
            ->where('peran', 'anggota')
            ->get();

        $fileUrl = Storage::url($proposal->dokumen_proposal);

        return view('admin.ppm.penelitian.show', compact(
            'proposal',
            'reviews',
            'anggotaList',
            'rabItems',
            'ketuaTim',
            'anggotaTim',
            'fileUrl',
            'timeline',
            'currentDate',
            'proposalYear',
            'assignedReviewers',
            'availableReviewers',
            'reviewCount'
        ));
    }

    /**
     * Approve or reject proposal
     */
    public function approveReject(Request $request, $id)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        $proposal = Penelitian::findOrFail($id);
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
            'biaya_disetujui' => 'required|numeric|min:0',
        ], [
            'admin_comment.required' => 'Komentar admin wajib diisi.',
            'biaya_disetujui.required' => 'Biaya yang disetujui wajib dipilih atau diisi.',
            'biaya_disetujui.numeric' => 'Biaya harus berupa angka.',
            'biaya_disetujui.min' => 'Biaya tidak boleh negatif.',
        ]);

        // Pastikan proposal sudah direview lengkap
        $reviewCount = Review::where('penelitian_id', $id)->count();
        if ($reviewCount < 2) {
            return redirect()->back()
                ->with('error', 'Proposal ini belum direview lengkap oleh 2 reviewer.');
        }

        // Hitung biaya berdasarkan pilihan
        $biayaDisetujui = 0;
        if ($request->has('biaya_source')) {
            if ($request->biaya_source === 'custom') {
                // Ambil dari input custom
                $biayaDisetujui = $request->biaya_custom ? (float) preg_replace('/[^0-9]/', '', $request->biaya_custom) : 0;
            } else {
                // Ambil dari biaya_disetujui yang sudah dihitung di frontend
                $biayaDisetujui = (float) $request->biaya_disetujui;
            }
        } else {
            // Fallback: ambil langsung dari biaya_disetujui
            $biayaDisetujui = (float) $request->biaya_disetujui;
        }

        $proposal->admin_status = $request->admin_status;
        $proposal->admin_comment = $request->admin_comment;
        $proposal->biaya_disetujui = $biayaDisetujui;

        // Update status proposal berdasarkan keputusan admin
        if ($request->admin_status === 'approved') {
            $proposal->status = 'Disetujui';
        } else {
            $proposal->status = 'Ditolak';
        }

        $proposal->save();

        $statusText = $request->admin_status === 'approved' ? 'disetujui' : 'ditolak';

        return redirect()->route('penelitian-adm.index')
            ->with('success', "Proposal berhasil {$statusText}.");
    }

    /**
     * List proposal revisi (hasil revisi dosen) beserta status review revisinya.
     */
    public function revisiIndex(Request $request)
    {
        $baseQuery = Penelitian::with(['user'])
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

        $proposals = $baseQuery->orderByDesc('updated_at')->paginate(10);
        /** @var \Illuminate\Pagination\LengthAwarePaginator $proposals */
        $proposals->withQueryString();

        return view('admin.ppm.penelitian.revisi.index', compact(
            'proposals',
            'filterSkemas',
            'filterYears',
            'statuses',
            'filters'
        ));
    }

    /**
     * Detail proposal revisi beserta komentar reviewer.
     */
    public function revisiShow($id)
    {
        $proposal = Penelitian::with([
            'user',
            'anggota',
            'rab',
            'revisionParent.user',
            'revisionParent.reviews.reviewer',
            'revisionParent.reviews.reviewKriteria.formPenilaianReview',
        ])
            ->where('is_revised', true)
            ->findOrFail($id);

        $originalProposal = $proposal->revisionParent;
        $initialReviews = $originalProposal?->reviews ?? collect();

        $revisionReviews = Review::with('reviewer')
            ->where('penelitian_id', $proposal->id)
            ->whereNotNull('revision_comment')
            ->orderBy('updated_at', 'desc')
            ->get();

        $fileUrl = $proposal->dokumen_proposal ? Storage::url($proposal->dokumen_proposal) : null;

        return view('admin.ppm.penelitian.revisi.show', compact(
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

    /**
     * Assign a reviewer to the proposal
     */
    public function assignReviewer(Request $request, $id)
    {
        $request->validate([
            'reviewer_id' => 'required|exists:users,id',
        ]);

        $proposal = Penelitian::findOrFail($id);
        $reviewer = User::with('assignedPenelitians')->findOrFail($request->reviewer_id);

        if ($reviewer->role !== 'reviewer') {
            return redirect()->back()->with('error', 'User yang dipilih bukan reviewer.');
        }

        // Check availability/limit if necessary (e.g. max 2 reviewers)
        // For now, allow multiple, but typically 2.
        if ($proposal->assignedReviewers()->count() >= 2) {
            // Optional: Block if strict 2. But maybe we want a backup reviewer?
            // Let's just warn or allow. Based on requirement "Pilih Reviewer", usually implies managing the team.
            // Let's allow >2 for flexibility, or warn.
        }

        try {
            $proposal->assignedReviewers()->attach($reviewer->id);
            return redirect()->back()->with('success', 'Reviewer berhasil ditugaskan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menugaskan reviewer: ' . $e->getMessage());
        }
    }

    /**
     * Remove an assigned reviewer
     */
    public function removeReviewer($id, $reviewerId)
    {
        $proposal = Penelitian::findOrFail($id);

        // Remove assignment
        $proposal->assignedReviewers()->detach($reviewerId);

        return redirect()->back()->with('success', 'Reviewer berhasil dihapus dari penugasan.');
    }
}
