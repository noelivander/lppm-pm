<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Berita;
use App\Models\Penelitian;
use App\Models\Pengabdian;
use App\Models\Pegawai;
use App\Models\ProgramStudi;

class HomeController extends Controller
{
    public function index()
    {
        $berita = Berita::orderBy('created_at','desc')->take(3)->get();

        // Real counts pulled from database for the landing page
        $totalPenelitian = Penelitian::count();
        $totalPengabdian = Pengabdian::count();
        $totalDosen = Pegawai::count();
        $totalProdi = class_exists(ProgramStudi::class) ? ProgramStudi::count() : 0;
        $totalBerita = Berita::count();

        return view('user.home', compact('berita', 'totalPenelitian', 'totalPengabdian', 'totalDosen', 'totalProdi', 'totalBerita'));
    }
}
