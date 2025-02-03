<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KaprodiController extends Controller
{
    /**
     * Display the kaprodi dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('kaprodi.dashboard');
    }
}
