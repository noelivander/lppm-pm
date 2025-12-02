<?php

namespace App\Http\Controllers\Admin\Kelembagaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use File;

class VisimisiController extends Controller
{
    private $jsonPath;
    private $txtPath;

    public function __construct()
    {
        $this->jsonPath = storage_path('content/data/visi_misi_lppm.json');
        $this->txtPath = storage_path('content/text/visi_misi.txt');
    }

    public function index()
    {
        // Ensure directory exists
        if (!File::exists(dirname($this->jsonPath))) {
            File::makeDirectory(dirname($this->jsonPath), 0755, true);
        }

        $data = [];

        if (File::exists($this->jsonPath)) {
            $data = json_decode(File::get($this->jsonPath), true);
        } else {
            // Migration: Fallback to txt if json doesn't exist
            $mainContent = '';
            if (File::exists($this->txtPath)) {
                $mainContent = File::get($this->txtPath);
            }

            // Default Data
            $data = [
                'hero_title' => 'Visi & Misi',
                'hero_description' => 'Arah dan tujuan LPPM-PM ITH dalam pengembangan ilmu pengetahuan, teknologi, dan penjaminan mutu pendidikan tinggi',
                'hero_badge' => 'Arah & Tujuan',
                'hero_cards' => [
                    ['title' => 'Inovasi', 'subtitle' => 'Kreativitas dalam penelitian', 'icon' => 'fas fa-lightbulb'],
                    ['title' => 'Kolaborasi', 'subtitle' => 'Kerjasama strategis', 'icon' => 'fas fa-users'],
                    ['title' => 'Kualitas', 'subtitle' => 'Standar tinggi', 'icon' => 'fas fa-star'],
                ],
                'main_content' => $mainContent,
                'value_cards' => [
                    ['title' => 'Inovasi', 'desc' => 'Mendorong inovasi dan kreativitas dalam penelitian dan pengabdian masyarakat', 'icon' => 'fas fa-lightbulb'],
                    ['title' => 'Kolaborasi', 'desc' => 'Membangun kerjasama strategis dengan berbagai pihak untuk kemajuan bersama', 'icon' => 'fas fa-users'],
                    ['title' => 'Kualitas', 'desc' => 'Menjaga standar kualitas tinggi dalam setiap kegiatan dan program', 'icon' => 'fas fa-star'],
                    ['title' => 'Integritas', 'desc' => 'Menjalankan tugas dengan penuh tanggung jawab dan kejujuran', 'icon' => 'fas fa-heart'],
                ]
            ];
            
            // Save default data to create the file
            File::put($this->jsonPath, json_encode($data, JSON_PRETTY_PRINT));
        }
        
        return view('admin.kelembagaan.visi_misi.index', compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token']);
        
        // Handle Main Content Image Paths
        if (isset($data['main_content'])) {
            $data['main_content'] = str_replace("<img alt", "<img class=\"img-fluid img-thumbnail w-100\" alt", $data['main_content']);
        }
        
        File::put($this->jsonPath, json_encode($data, JSON_PRETTY_PRINT));

        // Also update the txt file for backward compatibility
        if (isset($data['main_content'])) {
            File::put($this->txtPath, $data['main_content']);
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }
}
