<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use File;

class KelembagaanController extends Controller
{
    public function tentang()
    {
        $text_about = File::get(storage_path('content/text/tentang_lppm.txt'));
        
        return view('kelembagaan.tentang', compact('text_about'));
    }

    public function struktur_organisasi()
    {
        $text_stucture = File::get(storage_path('content/text/struktur_organisasi.txt'));
        
        return view('kelembagaan.struktur_organisasi', compact('text_stucture'));
    }

    public function visi_misi()
    {
        $text_visi_misi = File::get(storage_path('content/text/visi_misi.txt'));
        
        return view('kelembagaan.visi_misi', compact('text_visi_misi'));
    }
}
