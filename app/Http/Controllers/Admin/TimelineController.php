<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timeline;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function create()
    {
        return view('admin.timeline.create'); // Create a view for setting the timeline
    }

    public function store(Request $request)
    {
        $request->validate([
            'period' => 'required|digits:4',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            // Upload Proposal
            'upload_start_date' => 'required|date',
            'upload_end_date' => 'required|date|after_or_equal:upload_start_date',
            // Review Proposal
            'review_start_date' => 'required|date|after_or_equal:upload_end_date',
            'review_end_date' => 'required|date|after_or_equal:review_start_date',
            // Admin Decision
            'admin_decision_start_date' => 'required|date|after_or_equal:review_end_date',
            'admin_decision_end_date' => 'required|date|after_or_equal:admin_decision_start_date',
            // Revision Proposal (single period)
            'revision_start_date' => 'required|date|after_or_equal:admin_decision_end_date',
            'revision_end_date' => 'required|date|after_or_equal:revision_start_date',
            // Progress report now dimulai setelah akhir revisi
            'progress_submission_start_date' => 'required|date|after_or_equal:revision_end_date',
            'progress_submission_end_date' => 'required|date|after_or_equal:progress_submission_start_date',
            'progress_review_start_date' => 'required|date|after_or_equal:progress_submission_end_date',
            'progress_review_end_date' => 'required|date|after_or_equal:progress_review_start_date',
            'final_submission_start_date' => 'required|date|after_or_equal:progress_review_end_date',
            'final_submission_end_date' => 'required|date|after_or_equal:final_submission_start_date',
            'final_review_start_date' => 'required|date|after_or_equal:final_submission_end_date',
            'final_review_end_date' => 'required|date|after_or_equal:final_review_start_date',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ], [
            'upload_end_date.after_or_equal' => 'Tanggal akhir Upload harus sama atau setelah tanggal mulai Upload.',
            'review_start_date.after_or_equal' => 'Tanggal mulai Review harus sama atau setelah tanggal akhir Upload.',
            'review_end_date.after_or_equal' => 'Tanggal akhir Review harus sama atau setelah tanggal mulai Review.',
            'admin_decision_start_date.after_or_equal' => 'Tanggal mulai Keputusan Admin harus sama atau setelah tanggal akhir Review.',
            'admin_decision_end_date.after_or_equal' => 'Tanggal akhir Keputusan Admin harus sama atau setelah tanggal mulai Keputusan Admin.',
            'revision_start_date.after_or_equal' => 'Tanggal mulai Revisi harus sama atau setelah tanggal akhir Keputusan Admin.',
            'revision_end_date.after_or_equal' => 'Tanggal akhir Revisi harus sama atau setelah tanggal mulai Revisi.',
            'progress_submission_start_date.after_or_equal' => 'Tanggal mulai Pengajuan Laporan Kemajuan harus sama atau setelah tanggal akhir Revisi.',
            'progress_submission_end_date.after_or_equal' => 'Tanggal akhir Pengajuan Laporan Kemajuan harus sama atau setelah tanggal mulai Pengajuan.',
            'progress_review_start_date.after_or_equal' => 'Tanggal mulai Peninjauan Laporan Kemajuan harus sama atau setelah tanggal akhir Pengajuan.',
            'progress_review_end_date.after_or_equal' => 'Tanggal akhir Peninjauan Laporan Kemajuan harus sama atau setelah tanggal mulai Peninjauan.',
            'final_submission_start_date.after_or_equal' => 'Tanggal mulai Pengajuan Laporan Akhir harus sama atau setelah tanggal akhir Peninjauan Laporan Kemajuan.',
            'final_submission_end_date.after_or_equal' => 'Tanggal akhir Pengajuan Laporan Akhir harus sama atau setelah tanggal mulai Pengajuan.',
            'final_review_start_date.after_or_equal' => 'Tanggal mulai Peninjauan Laporan Akhir harus sama atau setelah tanggal akhir Pengajuan.',
            'final_review_end_date.after_or_equal' => 'Tanggal akhir Peninjauan Laporan Akhir harus sama atau setelah tanggal mulai Peninjauan.',
        ]);

        Timeline::create($request->all());

        return redirect()->route('timeline.index')->with('success', 'Timeline berhasil dibuat.');
    }

    public function index()
    {
        $timelines = Timeline::orderBy('period', 'desc')
            ->orderBy('order', 'asc')
            ->orderBy('upload_start_date', 'asc')
            ->get();
        
        return view('admin.timeline.index', compact('timelines'));
    }
    public function edit($id)
    {
        $timeline = Timeline::findOrFail($id);
        return view('admin.timeline.edit', compact('timeline'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'period' => 'required|digits:4',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            // Upload Proposal
            'upload_start_date' => 'required|date',
            'upload_end_date' => 'required|date|after_or_equal:upload_start_date',
            // Review Proposal
            'review_start_date' => 'required|date|after_or_equal:upload_end_date',
            'review_end_date' => 'required|date|after_or_equal:review_start_date',
            // Admin Decision
            'admin_decision_start_date' => 'required|date|after_or_equal:review_end_date',
            'admin_decision_end_date' => 'required|date|after_or_equal:admin_decision_start_date',
            // Revision Proposal (single period)
            'revision_start_date' => 'required|date|after_or_equal:admin_decision_end_date',
            'revision_end_date' => 'required|date|after_or_equal:revision_start_date',
            // Progress report now dimulai setelah akhir revisi
            'progress_submission_start_date' => 'required|date|after_or_equal:revision_end_date',
            'progress_submission_end_date' => 'required|date|after_or_equal:progress_submission_start_date',
            'progress_review_start_date' => 'required|date|after_or_equal:progress_submission_end_date',
            'progress_review_end_date' => 'required|date|after_or_equal:progress_review_start_date',
            'final_submission_start_date' => 'required|date|after_or_equal:progress_review_end_date',
            'final_submission_end_date' => 'required|date|after_or_equal:final_submission_start_date',
            'final_review_start_date' => 'required|date|after_or_equal:final_submission_end_date',
            'final_review_end_date' => 'required|date|after_or_equal:final_review_start_date',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ], [
            'upload_end_date.after_or_equal' => 'Tanggal akhir Upload harus sama atau setelah tanggal mulai Upload.',
            'review_start_date.after_or_equal' => 'Tanggal mulai Review harus sama atau setelah tanggal akhir Upload.',
            'review_end_date.after_or_equal' => 'Tanggal akhir Review harus sama atau setelah tanggal mulai Review.',
            'admin_decision_start_date.after_or_equal' => 'Tanggal mulai Keputusan Admin harus sama atau setelah tanggal akhir Review.',
            'admin_decision_end_date.after_or_equal' => 'Tanggal akhir Keputusan Admin harus sama atau setelah tanggal mulai Keputusan Admin.',
            'revision_start_date.after_or_equal' => 'Tanggal mulai Revisi harus sama atau setelah tanggal akhir Keputusan Admin.',
            'revision_end_date.after_or_equal' => 'Tanggal akhir Revisi harus sama atau setelah tanggal mulai Revisi.',
            'progress_submission_start_date.after_or_equal' => 'Tanggal mulai Pengajuan Laporan Kemajuan harus sama atau setelah tanggal akhir Revisi.',
            'progress_submission_end_date.after_or_equal' => 'Tanggal akhir Pengajuan Laporan Kemajuan harus sama atau setelah tanggal mulai Pengajuan.',
            'progress_review_start_date.after_or_equal' => 'Tanggal mulai Peninjauan Laporan Kemajuan harus sama atau setelah tanggal akhir Pengajuan.',
            'progress_review_end_date.after_or_equal' => 'Tanggal akhir Peninjauan Laporan Kemajuan harus sama atau setelah tanggal mulai Peninjauan.',
            'final_submission_start_date.after_or_equal' => 'Tanggal mulai Pengajuan Laporan Akhir harus sama atau setelah tanggal akhir Peninjauan Laporan Kemajuan.',
            'final_submission_end_date.after_or_equal' => 'Tanggal akhir Pengajuan Laporan Akhir harus sama atau setelah tanggal mulai Pengajuan.',
            'final_review_start_date.after_or_equal' => 'Tanggal mulai Peninjauan Laporan Akhir harus sama atau setelah tanggal akhir Pengajuan.',
            'final_review_end_date.after_or_equal' => 'Tanggal akhir Peninjauan Laporan Akhir harus sama atau setelah tanggal mulai Peninjauan.',
        ]);

        $timeline = Timeline::findOrFail($id);
        $timeline->update($request->all());

        return redirect()->route('timeline.index')->with('success', 'Timeline berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $timeline = Timeline::findOrFail($id);
        $timeline->delete();

        return redirect()->route('timeline.index')->with('success', 'Timeline deleted successfully.');
    }
}