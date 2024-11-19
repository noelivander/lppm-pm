<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penelitian;
use App\Models\Pengabdian;

class DosenController extends Controller
{
    /**
     * Display the dosen dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $userId = Auth::id(); // ID user yang sedang login
        $jumlahPenelitian = Penelitian::where('user_id', $userId)->count();
        $jumlahPengabdian = Pengabdian::where('user_id', $userId)->count();
    
        return view('dosen.dashboard', compact('jumlahPenelitian', 'jumlahPengabdian'));
    }
}
