<?php

namespace App\Http\Controllers\Admin\Kelembagaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use File;

class StrukturorgController extends Controller
{
    private $jsonPath;
    private $txtPath;

    public function __construct()
    {
        $this->jsonPath = storage_path('content/data/struktur_organisasi.json');
        $this->txtPath = storage_path('content/text/struktur_organisasi.txt');
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
                'hero_title' => 'Struktur Organisasi',
                'hero_description' => 'Susunan hierarki dan alur koordinasi yang sinergis untuk mendukung visi dan misi lembaga dalam pengembangan riset dan pengabdian.',
                'hero_badge' => 'Tata Kelola & Kepemimpinan',
                'chart_image' => '', // Path to uploaded image
                'main_content' => $mainContent,
                'info_cards' => [
                    ['title' => 'Kepemimpinan', 'desc' => 'Struktur kepemimpinan yang solid dan berpengalaman', 'icon' => 'fas fa-user-tie'],
                    ['title' => 'Tim Profesional', 'desc' => 'SDM yang berkompeten dan berdedikasi tinggi', 'icon' => 'fas fa-users'],
                    ['title' => 'Koordinasi', 'desc' => 'Sistem kerja yang terorganisir dengan baik', 'icon' => 'fas fa-tasks'],
                    ['title' => 'Pengembangan', 'desc' => 'Peningkatan kualitas berkelanjutan', 'icon' => 'fas fa-chart-line'],
                ]
            ];
            
            // Save default data to create the file
            File::put($this->jsonPath, json_encode($data, JSON_PRETTY_PRINT));
        }
        
        return view('admin.kelembagaan.struktur_organisasi.index', compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token', 'chart_image_file']);
        
        // Handle Image Upload
        if ($request->hasFile('chart_image_file')) {
            $file = $request->file('chart_image_file');
            $filename = 'org_chart_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Ensure directory exists
            $path = public_path('img/kelembagaan');
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }
            
            $file->move($path, $filename);
            $data['chart_image'] = 'img/kelembagaan/' . $filename;
        } else {
            // Keep existing image if no new file uploaded
            $existingData = [];
            if (File::exists($this->jsonPath)) {
                $existingData = json_decode(File::get($this->jsonPath), true);
            }
            $data['chart_image'] = $existingData['chart_image'] ?? '';
        }

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
