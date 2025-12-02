<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use File;

class KelembagaanController extends Controller
{
    public function tentang()
    {
        $jsonPath = storage_path('content/data/tentang_lppm.json');
        $data = [];

        if (File::exists($jsonPath)) {
            $data = json_decode(File::get($jsonPath), true);
        } else {
            // Fallback if JSON doesn't exist yet (e.g. before first admin save)
            $txtPath = storage_path('content/text/tentang_lppm.txt');
            $mainContent = File::exists($txtPath) ? File::get($txtPath) : '';
            
            $data = [
                'hero_title' => 'Tentang<br><span style="background: linear-gradient(135deg, #a78bfa 0%, #ec4899 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">LPPM-PM ITH</span>',
                'hero_description' => 'Mengenal lebih dekat <strong>Lembaga Penelitian, Pengabdian Masyarakat, dan Penjaminan Mutu</strong> Institut Teknologi Bacharuddin Jusuf Habibie',
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
        }
        
        return view('kelembagaan.tentang', compact('data'));
    }

    public function struktur_organisasi()
    {
        $jsonPath = storage_path('content/data/struktur_organisasi.json');
        $data = [];

        if (File::exists($jsonPath)) {
            $data = json_decode(File::get($jsonPath), true);
        } else {
            // Fallback if JSON doesn't exist yet
            $txtPath = storage_path('content/text/struktur_organisasi.txt');
            $mainContent = File::exists($txtPath) ? File::get($txtPath) : '';
            
            $data = [
                'hero_title' => 'Struktur Organisasi',
                'hero_description' => 'Susunan hierarki dan alur koordinasi yang sinergis untuk mendukung visi dan misi lembaga dalam pengembangan riset dan pengabdian.',
                'hero_badge' => 'Tata Kelola & Kepemimpinan',
                'chart_image' => '',
                'main_content' => $mainContent,
                'info_cards' => [
                    ['title' => 'Kepemimpinan', 'desc' => 'Struktur kepemimpinan yang solid dan berpengalaman', 'icon' => 'fas fa-user-tie'],
                    ['title' => 'Tim Profesional', 'desc' => 'SDM yang berkompeten dan berdedikasi tinggi', 'icon' => 'fas fa-users'],
                    ['title' => 'Koordinasi', 'desc' => 'Sistem kerja yang terorganisir dengan baik', 'icon' => 'fas fa-tasks'],
                    ['title' => 'Pengembangan', 'desc' => 'Peningkatan kualitas berkelanjutan', 'icon' => 'fas fa-chart-line'],
                ]
            ];
        }

        return view('kelembagaan.struktur_organisasi', compact('data'));
    }

    public function visi_misi()
    {
        $jsonPath = storage_path('content/data/visi_misi_lppm.json');
        $data = [];

        if (File::exists($jsonPath)) {
            $data = json_decode(File::get($jsonPath), true);
        } else {
            // Fallback if JSON doesn't exist yet
            $txtPath = storage_path('content/text/visi_misi.txt');
            $mainContent = File::exists($txtPath) ? File::get($txtPath) : '';
            
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
        }
        
        return view('kelembagaan.visi_misi', compact('data'));
    }
}
