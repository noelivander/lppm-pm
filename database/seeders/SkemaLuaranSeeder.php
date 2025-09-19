<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PPM\JenisSkema;
use App\Models\PPM\Skema;
use App\Models\PPM\Luaran;

class SkemaLuaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Jenis Skema
        $jenisSkema = [
            ['kode' => 'PD', 'nama' => 'Penelitian Dasar', 'is_shown' => 1],
            ['kode' => 'PL', 'nama' => 'Penelitian Lanjutan', 'is_shown' => 1],
            ['kode' => 'PM', 'nama' => 'Pengabdian Masyarakat', 'is_shown' => 1],
            ['kode' => 'PDM', 'nama' => 'Pendampingan', 'is_shown' => 1],
        ];

        foreach ($jenisSkema as $jenis) {
            JenisSkema::create($jenis);
        }

        // Create Skema
        $skema = [
            // Skema Penelitian
            [
                'kode' => 'PD-001',
                'nama' => 'Penelitian Dasar',
                'perihal' => 'Penelitian untuk pengembangan ilmu pengetahuan dasar',
                'jenis' => 'penelitian',
                'jenis_skema_id' => 1,
                'is_research' => 1,
                'is_shown' => 1
            ],
            [
                'kode' => 'PL-001',
                'nama' => 'Penelitian Lanjutan',
                'perihal' => 'Penelitian untuk pengembangan teknologi dan inovasi',
                'jenis' => 'penelitian',
                'jenis_skema_id' => 2,
                'is_research' => 1,
                'is_shown' => 1
            ],
            [
                'kode' => 'PL-002',
                'nama' => 'Penelitian Terapan',
                'perihal' => 'Penelitian untuk aplikasi teknologi',
                'jenis' => 'penelitian',
                'jenis_skema_id' => 2,
                'is_research' => 1,
                'is_shown' => 1
            ],
            // Skema Pengabdian
            [
                'kode' => 'PM-001',
                'nama' => 'Pengabdian Masyarakat',
                'perihal' => 'Program pengabdian kepada masyarakat',
                'jenis' => 'pengabdian',
                'jenis_skema_id' => 3,
                'is_research' => 0,
                'is_shown' => 1
            ],
            [
                'kode' => 'PDM-001',
                'nama' => 'Pendampingan',
                'perihal' => 'Program pendampingan masyarakat',
                'jenis' => 'pengabdian',
                'jenis_skema_id' => 4,
                'is_research' => 0,
                'is_shown' => 1
            ],
        ];

        foreach ($skema as $item) {
            Skema::create($item);
        }

        // Create Luaran
        $luaran = [
            // Luaran Wajib Penelitian
            [
                'kode' => 'LW-P-001',
                'nama' => 'Jurnal Nasional Terindeks Sinta',
                'perihal' => 'Publikasi jurnal nasional yang terindeks Sinta',
                'jenis' => 'penelitian',
                'kategori' => 'wajib',
                'is_shown' => 1
            ],
            [
                'kode' => 'LW-P-002',
                'nama' => 'Jurnal Internasional Terindeks',
                'perihal' => 'Publikasi jurnal internasional yang terindeks Scopus/WoS',
                'jenis' => 'penelitian',
                'kategori' => 'wajib',
                'is_shown' => 1
            ],
            [
                'kode' => 'LW-P-003',
                'nama' => 'Jurnal Internasional',
                'perihal' => 'Publikasi jurnal internasional',
                'jenis' => 'penelitian',
                'kategori' => 'wajib',
                'is_shown' => 1
            ],
            [
                'kode' => 'LW-P-004',
                'nama' => 'Prosiding Konferensi Nasional',
                'perihal' => 'Publikasi dalam prosiding konferensi nasional',
                'jenis' => 'penelitian',
                'kategori' => 'wajib',
                'is_shown' => 1
            ],
            [
                'kode' => 'LW-P-005',
                'nama' => 'Produk/Model/Prototype',
                'perihal' => 'Hasil penelitian berupa produk, model, atau prototype',
                'jenis' => 'penelitian',
                'kategori' => 'wajib',
                'is_shown' => 1
            ],
            // Luaran Tambahan Penelitian
            [
                'kode' => 'LT-P-001',
                'nama' => 'Bahan Ajar',
                'perihal' => 'Bahan ajar hasil penelitian',
                'jenis' => 'penelitian',
                'kategori' => 'tambahan',
                'is_shown' => 1
            ],
            [
                'kode' => 'LT-P-002',
                'nama' => 'Buku Monografi',
                'perihal' => 'Buku monografi hasil penelitian',
                'jenis' => 'penelitian',
                'kategori' => 'tambahan',
                'is_shown' => 1
            ],
            [
                'kode' => 'LT-P-003',
                'nama' => 'HAKI',
                'perihal' => 'Hak Kekayaan Intelektual',
                'jenis' => 'penelitian',
                'kategori' => 'tambahan',
                'is_shown' => 1
            ],
            [
                'kode' => 'LT-P-004',
                'nama' => 'Teknologi Tepat Guna',
                'perihal' => 'Teknologi tepat guna hasil penelitian',
                'jenis' => 'penelitian',
                'kategori' => 'tambahan',
                'is_shown' => 1
            ],
            // Luaran Wajib Pengabdian
            [
                'kode' => 'LW-PG-001',
                'nama' => 'Jurnal Nasional Terindeks Sinta',
                'perihal' => 'Publikasi jurnal nasional yang terindeks Sinta',
                'jenis' => 'pengabdian',
                'kategori' => 'wajib',
                'is_shown' => 1
            ],
            [
                'kode' => 'LW-PG-002',
                'nama' => 'Jurnal Internasional Terindeks',
                'perihal' => 'Publikasi jurnal internasional yang terindeks Scopus/WoS',
                'jenis' => 'pengabdian',
                'kategori' => 'wajib',
                'is_shown' => 1
            ],
            [
                'kode' => 'LW-PG-003',
                'nama' => 'Jurnal Internasional',
                'perihal' => 'Publikasi jurnal internasional',
                'jenis' => 'pengabdian',
                'kategori' => 'wajib',
                'is_shown' => 1
            ],
            [
                'kode' => 'LW-PG-004',
                'nama' => 'Prosiding Konferensi Nasional',
                'perihal' => 'Publikasi dalam prosiding konferensi nasional',
                'jenis' => 'pengabdian',
                'kategori' => 'wajib',
                'is_shown' => 1
            ],
            [
                'kode' => 'LW-PG-005',
                'nama' => 'Produk/Model/Prototype',
                'perihal' => 'Hasil pengabdian berupa produk, model, atau prototype',
                'jenis' => 'pengabdian',
                'kategori' => 'wajib',
                'is_shown' => 1
            ],
            // Luaran Tambahan Pengabdian
            [
                'kode' => 'LT-PG-001',
                'nama' => 'Bahan Ajar',
                'perihal' => 'Bahan ajar hasil pengabdian',
                'jenis' => 'pengabdian',
                'kategori' => 'tambahan',
                'is_shown' => 1
            ],
            [
                'kode' => 'LT-PG-002',
                'nama' => 'Buku Monografi',
                'perihal' => 'Buku monografi hasil pengabdian',
                'jenis' => 'pengabdian',
                'kategori' => 'tambahan',
                'is_shown' => 1
            ],
            [
                'kode' => 'LT-PG-003',
                'nama' => 'HAKI',
                'perihal' => 'Hak Kekayaan Intelektual',
                'jenis' => 'pengabdian',
                'kategori' => 'tambahan',
                'is_shown' => 1
            ],
        ];

        foreach ($luaran as $item) {
            Luaran::create($item);
        }
    }
}