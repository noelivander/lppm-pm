<?php

namespace App\Http\Controllers\Admin\Kelembagaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TentangController extends Controller
{
    private $jsonPath;
    private $txtPath;

    public function __construct()
    {
        $this->jsonPath = storage_path('content/data/tentang_lppm.json');
        $this->txtPath = storage_path('content/text/tentang_lppm.txt');
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
                'hero_title' => 'Tentang<br><span style="background: linear-gradient(135deg, #a78bfa 0%, #ec4899 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">LPPM-PM ITH</span>',
                'hero_description' => 'Mengenal lebih dekat <strong>Lembaga Penelitian, Pengabdian Masyarakat, dan Penjaminan Mutu</strong> Institut Teknologi Bacharuddin Jusuf Habibie',
                'hero_badge' => 'Tentang Kami',
                'founded_year' => '2023',
                'main_content' => $mainContent,
                'stats' => [
                    ['icon' => 'fas fa-flask', 'value' => 'Penelitian', 'color' => '#a78bfa'],
                    ['icon' => 'fas fa-hands-helping', 'value' => 'Pengabdian', 'color' => '#60a5fa'],
                    ['icon' => 'fas fa-award', 'value' => 'Penjaminan Mutu', 'color' => '#34d399'],
                ],
                'features' => [
                    ['title' => 'Riset Berkualitas', 'desc' => 'Penelitian inovatif dan berdampak', 'icon' => 'fas fa-check'],
                    ['title' => 'Pengabdian Nyata', 'desc' => 'Kontribusi untuk masyarakat', 'icon' => 'fas fa-check'],
                    ['title' => 'Standar Mutu Tinggi', 'desc' => 'Penjaminan kualitas pendidikan', 'icon' => 'fas fa-check'],
                ]
            ];
            
            // Save default data to create the file
            File::put($this->jsonPath, json_encode($data, JSON_PRETTY_PRINT));
        }
        
        return view('admin.kelembagaan.tentang.index', compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token']);
        
        // Handle Main Content Image Paths (keep existing logic)
        if (isset($data['main_content'])) {
            $data['main_content'] = str_replace("<img alt", "<img class=\"img-fluid img-thumbnail w-100\" alt", $data['main_content']);
        }

        // Structure the data (ensure arrays are preserved)
        // Note: The form will send arrays for stats and features
        
        File::put($this->jsonPath, json_encode($data, JSON_PRETTY_PRINT));

        // Also update the txt file for backward compatibility if needed (optional, but good for safety)
        if (isset($data['main_content'])) {
            File::put($this->txtPath, $data['main_content']);
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }
}
