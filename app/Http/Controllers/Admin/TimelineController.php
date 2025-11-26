<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timeline;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    /**
     * Display a listing of timelines grouped by period
     */
    public function index(Request $request)
    {
        $selectedPeriod = $request->get('period');
        $periods = Timeline::getAllPeriods();
        
        // If no period selected, use the latest period
        if (!$selectedPeriod && $periods->isNotEmpty()) {
            $selectedPeriod = $periods->first();
        }
        
        $timelines = Timeline::when($selectedPeriod, function($query) use ($selectedPeriod) {
                return $query->byPeriod($selectedPeriod);
            })
            ->ordered()
            ->get();
        
        return view('admin.timeline.index', compact('timelines', 'periods', 'selectedPeriod'));
    }

    /**
     * Show the form for creating a new timeline
     */
    public function create(Request $request)
    {
        $period = $request->get('period');
        $periods = Timeline::getAllPeriods();
        
        return view('admin.timeline.create', compact('period', 'periods'));
    }

    /**
     * Store a newly created timeline
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'period' => 'required|digits:4',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            // Upload Proposal
            'upload_start_date' => 'required|date',
            'upload_end_date' => 'required|date|after_or_equal:upload_start_date',
            // Review Proposal
            'review_start_date' => 'required|date|after_or_equal:upload_end_date',
            'review_end_date' => 'required|date|after_or_equal:review_start_date',
            // Revisi Proposal
            'revisi_proposal_start_date' => 'nullable|date|after_or_equal:review_end_date',
            'revisi_proposal_end_date' => 'nullable|date|after_or_equal:revisi_proposal_start_date',
            // Laporan Kemajuan
            'laporan_kemajuan_start_date' => 'nullable|date',
            'laporan_kemajuan_end_date' => 'nullable|date|after_or_equal:laporan_kemajuan_start_date',
            'laporan_kemajuan_review_start_date' => 'nullable|date|after_or_equal:laporan_kemajuan_end_date',
            'laporan_kemajuan_review_end_date' => 'nullable|date|after_or_equal:laporan_kemajuan_review_start_date',
            // Laporan Akhir
            'laporan_akhir_start_date' => 'nullable|date',
            'laporan_akhir_end_date' => 'nullable|date|after_or_equal:laporan_akhir_start_date',
            'laporan_akhir_review_start_date' => 'nullable|date|after_or_equal:laporan_akhir_end_date',
            'laporan_akhir_review_end_date' => 'nullable|date|after_or_equal:laporan_akhir_review_start_date',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        // Set default values
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        Timeline::create($validated);

        return redirect()
            ->route('admin.timeline.index', ['period' => $validated['period']])
            ->with('success', 'Timeline berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified timeline
     */
    public function edit($id)
    {
        $timeline = Timeline::findOrFail($id);
        $periods = Timeline::getAllPeriods();
        
        return view('admin.timeline.edit', compact('timeline', 'periods'));
    }

    /**
     * Update the specified timeline
     */
    public function update(Request $request, $id)
    {
        $timeline = Timeline::findOrFail($id);
        
        $validated = $request->validate([
            'period' => 'required|digits:4',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            // Upload Proposal
            'upload_start_date' => 'required|date',
            'upload_end_date' => 'required|date|after_or_equal:upload_start_date',
            // Review Proposal
            'review_start_date' => 'required|date|after_or_equal:upload_end_date',
            'review_end_date' => 'required|date|after_or_equal:review_start_date',
            // Revisi Proposal
            'revisi_proposal_start_date' => 'nullable|date|after_or_equal:review_end_date',
            'revisi_proposal_end_date' => 'nullable|date|after_or_equal:revisi_proposal_start_date',
            // Laporan Kemajuan
            'laporan_kemajuan_start_date' => 'nullable|date',
            'laporan_kemajuan_end_date' => 'nullable|date|after_or_equal:laporan_kemajuan_start_date',
            'laporan_kemajuan_review_start_date' => 'nullable|date|after_or_equal:laporan_kemajuan_end_date',
            'laporan_kemajuan_review_end_date' => 'nullable|date|after_or_equal:laporan_kemajuan_review_start_date',
            // Laporan Akhir
            'laporan_akhir_start_date' => 'nullable|date',
            'laporan_akhir_end_date' => 'nullable|date|after_or_equal:laporan_akhir_start_date',
            'laporan_akhir_review_start_date' => 'nullable|date|after_or_equal:laporan_akhir_end_date',
            'laporan_akhir_review_end_date' => 'nullable|date|after_or_equal:laporan_akhir_review_start_date',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        // Set default values
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? $timeline->order;

        $timeline->update($validated);

        return redirect()
            ->route('admin.timeline.index', ['period' => $validated['period']])
            ->with('success', 'Timeline berhasil diperbarui!');
    }

    /**
     * Remove the specified timeline
     */
    public function destroy($id)
    {
        $timeline = Timeline::findOrFail($id);
        $period = $timeline->period;
        $timeline->delete();

        return redirect()
            ->route('admin.timeline.index', ['period' => $period])
            ->with('success', 'Timeline berhasil dihapus!');
    }

    /**
     * Toggle timeline active status
     */
    public function toggleActive($id)
    {
        $timeline = Timeline::findOrFail($id);
        $timeline->is_active = !$timeline->is_active;
        $timeline->save();

        return response()->json([
            'success' => true,
            'is_active' => $timeline->is_active,
            'message' => 'Status timeline berhasil diubah!'
        ]);
    }
}