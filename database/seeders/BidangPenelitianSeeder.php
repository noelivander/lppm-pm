<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PPM\BidangPenelitian;

class BidangPenelitianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bidangPenelitian = [
            [
                'nama' => 'Ilmu Komputer dan Teknologi Informasi',
                'kode' => 'IK-TI',
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'nama' => 'Teknik Elektro dan Elektronika',
                'kode' => 'TE',
                'urutan' => 2,
                'is_active' => true,
            ],
            [
                'nama' => 'Teknik Mesin dan Manufaktur',
                'kode' => 'TM',
                'urutan' => 3,
                'is_active' => true,
            ],
            [
                'nama' => 'Teknik Sipil dan Konstruksi',
                'kode' => 'TS',
                'urutan' => 4,
                'is_active' => true,
            ],
            [
                'nama' => 'Manajemen dan Bisnis',
                'kode' => 'MB',
                'urutan' => 5,
                'is_active' => true,
            ],
            [
                'nama' => 'Akuntansi dan Keuangan',
                'kode' => 'AK',
                'urutan' => 6,
                'is_active' => true,
            ],
            [
                'nama' => 'Pendidikan',
                'kode' => 'PD',
                'urutan' => 7,
                'is_active' => true,
            ],
            [
                'nama' => 'Kesehatan dan Kedokteran',
                'kode' => 'KK',
                'urutan' => 8,
                'is_active' => true,
            ],
            [
                'nama' => 'Ilmu Sosial dan Humaniora',
                'kode' => 'ISH',
                'urutan' => 9,
                'is_active' => true,
            ],
            [
                'nama' => 'Pertanian dan Perikanan',
                'kode' => 'PP',
                'urutan' => 10,
                'is_active' => true,
            ],
        ];

        foreach ($bidangPenelitian as $bidang) {
            BidangPenelitian::create($bidang);
        }
    }
}
