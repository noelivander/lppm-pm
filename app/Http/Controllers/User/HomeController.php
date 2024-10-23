<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Berita;

class HomeController extends Controller
{
    public function index()
    {
        $berita = Berita::orderBy('created_at','desc')->take(3)->get();

        return view('user.home', compact('berita'));
    }
}
