<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FormPenilaianReview;

class FormPenilaianReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed untuk Penelitian
        $penelitianKriteria = [
            [
                'jenis' => 'penelitian',
                'kriteria_penilaian' => 'Penguasaan materi dan keterkaitan antara usulan penelitian dengan Topik Penelitian ITH',
                'bobot' => 20,
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'jenis' => 'penelitian',
                'kriteria_penilaian' => 'Kesesuaian latar belakang, permasalahan, dan tujuan serta kemutakhiran pustaka',
                'bobot' => 20,
                'urutan' => 2,
                'is_active' => true,
            ],
            [
                'jenis' => 'penelitian',
                'kriteria_penilaian' => "Metode Penelitian:\n• Makna Ilmiah\n• Orisinalitas\n• Pola pendekatan dan kesesuaian mode",
                'bobot' => 20,
                'urutan' => 3,
                'is_active' => true,
            ],
            [
                'jenis' => 'penelitian',
                'kriteria_penilaian' => 'Memiliki peta jalan (roadmap) penelitian',
                'bobot' => 10,
                'urutan' => 4,
                'is_active' => true,
            ],
            [
                'jenis' => 'penelitian',
                'kriteria_penilaian' => "Potensi tercapainya luaran:\n• Publikasi Jurnal Nasional\n• Produk/Proses teknologi\n• Publikasi, HKI, buku ajar, teknologi tepat guna, model/kebijakan, rekayasa sosial, dan lain-lain\n• Pengkajian, pengembangan, dan penerapan IPTEKS-SOSBUD",
                'bobot' => 30,
                'urutan' => 5,
                'is_active' => true,
            ],
        ];

        // Seed untuk Pengabdian (sama dengan penelitian untuk default)
        $pengabdianKriteria = [
            [
                'jenis' => 'pengabdian',
                'kriteria_penilaian' => 'Penguasaan materi dan keterkaitan antara usulan penelitian dengan Topik Penelitian ITH',
                'bobot' => 20,
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'jenis' => 'pengabdian',
                'kriteria_penilaian' => 'Kesesuaian latar belakang, permasalahan, dan tujuan serta kemutakhiran pustaka',
                'bobot' => 20,
                'urutan' => 2,
                'is_active' => true,
            ],
            [
                'jenis' => 'pengabdian',
                'kriteria_penilaian' => "Metode Penelitian:\n• Makna Ilmiah\n• Orisinalitas\n• Pola pendekatan dan kesesuaian mode",
                'bobot' => 20,
                'urutan' => 3,
                'is_active' => true,
            ],
            [
                'jenis' => 'pengabdian',
                'kriteria_penilaian' => 'Memiliki peta jalan (roadmap) penelitian',
                'bobot' => 10,
                'urutan' => 4,
                'is_active' => true,
            ],
            [
                'jenis' => 'pengabdian',
                'kriteria_penilaian' => "Potensi tercapainya luaran:\n• Publikasi Jurnal Nasional\n• Produk/Proses teknologi\n• Publikasi, HKI, buku ajar, teknologi tepat guna, model/kebijakan, rekayasa sosial, dan lain-lain\n• Pengkajian, pengembangan, dan penerapan IPTEKS-SOSBUD",
                'bobot' => 30,
                'urutan' => 5,
                'is_active' => true,
            ],
        ];

        // Insert data
        foreach ($penelitianKriteria as $kriteria) {
            FormPenilaianReview::create($kriteria);
        }

        foreach ($pengabdianKriteria as $kriteria) {
            FormPenilaianReview::create($kriteria);
        }

        $this->command->info('Form Penilaian Review seeded successfully!');
    }
}
