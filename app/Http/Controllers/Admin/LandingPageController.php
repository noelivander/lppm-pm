<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\LandingPageContent;
use Illuminate\Support\Facades\Storage;

class LandingPageController extends Controller
{
    public function index()
    {
        $contents = LandingPageContent::all()->pluck('value', 'key');
        return view('admin.landing-page.index', compact('contents'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            $section = explode('_', $key)[0]; // Infer section from key prefix (e.g. hero_title -> hero)
            
            if ($request->hasFile($key)) {
                $path = $request->file($key)->store('landing-page', 'public');
                LandingPageContent::updateOrCreate(
                    ['key' => $key],
                    ['value' => $path, 'section' => $section]
                );
            } else {
                LandingPageContent::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value, 'section' => $section]
                );
            }
        }

        return redirect()->back()->with('success', 'Landing Page updated successfully!');
    }
}
