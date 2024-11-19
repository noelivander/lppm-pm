<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penelitian;
use App\Models\Pengabdian;

class ReviewerController extends Controller
{
    /**
     * Display the reviewer dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $jumlahPenelitian = Penelitian::count();
        $jumlahPengabdian = Pengabdian::count();

        return view('reviewer.dashboard', compact('jumlahPenelitian', 'jumlahPengabdian'));
    }
}
