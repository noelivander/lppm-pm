<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandingPageController extends Controller
{
    public function index()
    {
        $contents = LandingPageContent::all()->groupBy('section');
        return view('admin.landing-page.index', compact('contents'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            // Handle file uploads
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $path = $file->store('landing-page', 'public');
                $value = Storage::url($path);
            }

            // Find the content by ID (keys are formatted as content_{id})
            if (strpos($key, 'content_') === 0) {
                $id = str_replace('content_', '', $key);
                $content = LandingPageContent::find($id);
                if ($content) {
                    $content->update(['value' => $value]);
                }
            }
        }

        return redirect()->back()->with('success', 'Landing Page updated successfully.');
    }
}
