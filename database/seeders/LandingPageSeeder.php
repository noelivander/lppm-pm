<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LandingPageContent;

class LandingPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contents = [
            // Hero Section
            ['section' => 'hero', 'key' => 'badge_text', 'value' => 'Lembaga Penelitian & Pengabdian Masyarakat', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'title_prefix', 'value' => 'Inovasi untuk', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'title_suffix', 'value' => 'Negeri & Bangsa', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'hero_image', 'value' => '', 'type' => 'image'],
            ['section' => 'hero', 'key' => 'hero_image_2', 'value' => '', 'type' => 'image'],
            ['section' => 'hero', 'key' => 'hero_image_3', 'value' => '', 'type' => 'image'],
            ['section' => 'hero', 'key' => 'hero_description', 'value' => 'Mengembangkan potensi akademik melalui penelitian bermutu dan pengabdian yang berdampak nyata bagi masyarakat luas.', 'type' => 'textarea'],
            ['section' => 'hero', 'key' => 'button_text', 'value' => 'Jelajahi Layanan', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'button_url', 'value' => '#layanan', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'secondary_button_text', 'value' => 'Pelajari Lebih Lanjut', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'secondary_button_url', 'value' => '#tentang', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'stat_1_value', 'value' => '150', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'stat_1_label', 'value' => 'Penelitian', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'stat_2_value', 'value' => '85', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'stat_2_label', 'value' => 'Pengabdian', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'stat_3_value', 'value' => '50', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'stat_3_label', 'value' => 'Dosen Aktif', 'type' => 'text'],

            // Features Section (Ekosistem)
            ['section' => 'features', 'key' => 'features_subtitle', 'value' => 'Keunggulan Kami', 'type' => 'text'],
            ['section' => 'features', 'key' => 'features_title', 'value' => 'Ekosistem Riset Modern', 'type' => 'text'],
            ['section' => 'features', 'key' => 'features_description', 'value' => 'Kami menyediakan infrastruktur dan dukungan komprehensif untuk memajukan kualitas penelitian.', 'type' => 'textarea'],

            // Feature 1
            ['section' => 'features', 'key' => 'feature_1_title', 'value' => 'Sistem Terintegrasi', 'type' => 'text'],
            ['section' => 'features', 'key' => 'feature_1_desc', 'value' => 'Platform digital satu pintu untuk pengelolaan proposal, laporan, dan publikasi yang efisien.', 'type' => 'textarea'],

            // Feature 2
            ['section' => 'features', 'key' => 'feature_2_title', 'value' => 'Pendanaan Kompetitif', 'type' => 'text'],
            ['section' => 'features', 'key' => 'feature_2_desc', 'value' => 'Akses ke berbagai skema hibah internal dan eksternal untuk mendukung inovasi.', 'type' => 'textarea'],

            // Feature 3
            ['section' => 'features', 'key' => 'feature_3_title', 'value' => 'Jejaring Luas', 'type' => 'text'],
            ['section' => 'features', 'key' => 'feature_3_desc', 'value' => 'Terhubung dengan berbagai institusi riset dan industri baik nasional maupun internasional.', 'type' => 'textarea'],

            // About Section
            ['section' => 'about', 'key' => 'about_subtitle', 'value' => 'Tentang Kami', 'type' => 'text'],
            ['section' => 'about', 'key' => 'about_title', 'value' => 'Mewujudkan Visi Melalui Riset Unggulan', 'type' => 'text'],
            ['section' => 'about', 'key' => 'about_description', 'value' => 'LPPM-PM ITH hadir sebagai garda terdepan dalam pengembangan ilmu pengetahuan dan teknologi yang relevan dengan kebutuhan zaman.', 'type' => 'textarea'],
            ['section' => 'about', 'key' => 'about_image', 'value' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1470&q=80', 'type' => 'image'],
            ['section' => 'about', 'key' => 'about_point_1', 'value' => 'Manajemen Riset Terintegrasi', 'type' => 'text'],
            ['section' => 'about', 'key' => 'about_point_2', 'value' => 'Kolaborasi Multi-Disiplin', 'type' => 'text'],
            ['section' => 'about', 'key' => 'about_point_3', 'value' => 'Hilirisasi Hasil Inovasi', 'type' => 'text'],

            // Services Section
            ['section' => 'services', 'key' => 'services_title', 'value' => 'Layanan Akademik', 'type' => 'text'],
            ['section' => 'services', 'key' => 'services_subtitle', 'value' => 'Akses berbagai layanan pendukung kegiatan akademik Anda', 'type' => 'text'],

            // Service 1
            ['section' => 'services', 'key' => 'service_1_title', 'value' => 'Agenda Kegiatan', 'type' => 'text'],
            ['section' => 'services', 'key' => 'service_1_desc', 'value' => 'Jadwal lengkap seminar, workshop, dan kegiatan ilmiah lainnya.', 'type' => 'textarea'],

            // Service 2
            ['section' => 'services', 'key' => 'service_2_title', 'value' => 'Pengumuman', 'type' => 'text'],
            ['section' => 'services', 'key' => 'service_2_desc', 'value' => 'Informasi terbaru seputar hibah, beasiswa, dan kebijakan.', 'type' => 'textarea'],

            // Service 3
            ['section' => 'services', 'key' => 'service_3_title', 'value' => 'Dokumen', 'type' => 'text'],
            ['section' => 'services', 'key' => 'service_3_desc', 'value' => 'Unduh panduan, template, dan dokumen resmi lainnya.', 'type' => 'textarea'],
        ];

        foreach ($contents as $content) {
            LandingPageContent::updateOrCreate(
                ['section' => $content['section'], 'key' => $content['key']],
                $content
            );
        }
    }
}
