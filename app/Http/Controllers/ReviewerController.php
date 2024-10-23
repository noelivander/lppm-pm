<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewerController extends Controller
{
    /**
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('reviewer.dashboard');
    }
}
