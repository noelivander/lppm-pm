<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DosenController extends Controller
{
    /**
     * Display the dosen dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('dosen.dashboard');
    }
}
