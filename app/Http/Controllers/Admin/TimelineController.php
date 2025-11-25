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
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'upload_start_date' => 'required|date',
            'upload_end_date' => 'required|date|after_or_equal:upload_start_date',
            'review_start_date' => 'required|date|after_or_equal:upload_end_date',
            'review_end_date' => 'required|date|after_or_equal:review_start_date',
            'revision_start_date' => 'nullable|date|after_or_equal:review_end_date',
            'revision_end_date' => 'nullable|date|after_or_equal:revision_start_date',
            'progress_submission_start_date' => 'nullable|date|after_or_equal:revision_end_date',
            'progress_submission_end_date' => 'nullable|date|after_or_equal:progress_submission_start_date',
            'progress_review_start_date' => 'nullable|date|after_or_equal:progress_submission_end_date',
            'progress_review_end_date' => 'nullable|date|after_or_equal:progress_review_start_date',
            'final_submission_start_date' => 'nullable|date|after_or_equal:progress_review_end_date',
            'final_submission_end_date' => 'nullable|date|after_or_equal:final_submission_start_date',
            'final_review_start_date' => 'nullable|date|after_or_equal:final_submission_end_date',
            'final_review_end_date' => 'nullable|date|after_or_equal:final_review_start_date',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer',
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
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'upload_start_date' => 'required|date',
            'upload_end_date' => 'required|date|after:upload_start_date',
            'review_start_date' => 'required|date|after:upload_end_date',
            'review_end_date' => 'required|date|after:review_start_date',
            'revision_start_date' => 'nullable|date|after:review_end_date',
            'revision_end_date' => 'nullable|date|after:revision_start_date',
            'progress_submission_start_date' => 'nullable|date|after:revision_end_date',
            'progress_submission_end_date' => 'nullable|date|after:progress_submission_start_date',
            'progress_review_start_date' => 'nullable|date|after:progress_submission_end_date',
            'progress_review_end_date' => 'nullable|date|after:progress_review_start_date',
            'final_submission_start_date' => 'nullable|date|after:progress_review_end_date',
            'final_submission_end_date' => 'nullable|date|after:final_submission_start_date',
            'final_review_start_date' => 'nullable|date|after:final_submission_end_date',
            'final_review_end_date' => 'nullable|date|after:final_review_start_date',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer',
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