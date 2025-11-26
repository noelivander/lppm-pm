<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\LandingPageContent;

class HomeController extends Controller
{
    public function index()
    {
        $berita = Berita::latest()->take(3)->get();
        $landingPage = LandingPageContent::all()->pluck('value', 'key');

        return view('user.home', compact('berita', 'landingPage'));
    }
}
