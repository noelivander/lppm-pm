<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuditorController extends Controller
{
    /**
     * Display the auditor dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('auditor.dashboard');
    }
}
