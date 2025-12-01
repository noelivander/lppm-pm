<?php

namespace App\Http\Controllers\Admin\PPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penelitian;
use App\Models\Review;
use App\Models\Anggota;
use App\Models\RabPenelitian;
use Illuminate\Support\Facades\Storage;

class PenelitianController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan proposal yang sudah direview lengkap (2 reviewer)
     */
    public function index(Request $request)
    {
        // Query proposal yang sudah direview lengkap (minimal 2 reviewer)
        $baseQuery = Penelitian::where('is_draft', false)
            ->whereRaw('(SELECT COUNT(*) FROM reviews WHERE reviews.penelitian_id = penelitian.id) >= 2')
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
            'filters'
        ));
    }

    /**
     * Display the specified resource.
     * Menampilkan detail proposal beserta 2 review dan form acc/tolak
     */
    public function show($id)
    {
        $proposal = Penelitian::with(['anggota', 'rab', 'user', 'reviews.reviewer'])->findOrFail($id);
        
        // Pastikan proposal sudah direview minimal 2 reviewer
        $reviews = $proposal->reviews;
        if ($reviews->count() < 2) {
            return redirect()->route('penelitian-adm.index')
                ->with('error', 'Proposal ini belum direview lengkap oleh 2 reviewer.');
        }

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
            'fileUrl'
        ));
    }

    /**
     * Approve or reject proposal
     */
    public function approveReject(Request $request, $id)
    {
        $request->validate([
            'admin_status' => 'required|in:approved,rejected',
            'admin_comment' => 'required|string|max:1000',
        ], [
            'admin_comment.required' => 'Komentar admin wajib diisi.',
        ]);

        $proposal = Penelitian::findOrFail($id);
        
        // Pastikan proposal sudah direview lengkap
        $reviewCount = Review::where('penelitian_id', $id)->count();
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
        
        return redirect()->route('penelitian-adm.index')
            ->with('success', "Proposal berhasil {$statusText}.");
    }
}
