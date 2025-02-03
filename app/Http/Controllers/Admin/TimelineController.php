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
            'upload_start_date' => 'required|date',
            'upload_end_date' => 'required|date|after_or_equal:upload_start_date',
            'review_start_date' => 'required|date|after_or_equal:upload_end_date',
            'review_end_date' => 'required|date|after_or_equal:review_start_date',
        ]);

        Timeline::create($request->all());

        return redirect()->route('admin.timeline.index')->with('success', 'Timeline created successfully.');
    }

    public function index()
    {
        $timelines = Timeline::all();
        return view('admin.timeline.index', compact('timelines')); // List all timelines
    }
    public function edit($id)
    {
        $timeline = Timeline::findOrFail($id);
        return view('admin.timeline.edit', compact('timeline'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'upload_start_date' => 'required|date',
            'upload_end_date' => 'required|date|after:upload_start_date',
            'review_start_date' => 'required|date|after:upload_end_date',
            'review_end_date' => 'required|date|after:review_start_date',
        ]);

        $timeline = Timeline::findOrFail($id);
        $timeline->update($request->all());

        return redirect()->route('admin.timeline.index')->with('success', 'Timeline updated successfully.');
    }

    public function destroy($id)
    {
        $timeline = Timeline::findOrFail($id);
        $timeline->delete();

        return redirect()->route('admin.timeline.index')->with('success', 'Timeline deleted successfully.');
    }
}