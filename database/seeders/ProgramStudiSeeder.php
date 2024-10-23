<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ProgramStudi;
use App\Models\Jurusan;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Jurusan::create(['kode' => 'tpi', 'nama' => 'Teknologi Produksi dan Industri', 'tahun' => '2022', 'urutan' => 1]);
        Jurusan::create(['kode' => 'sci', 'nama' => 'Sains', 'tahun' => '2022', 'urutan' => 2]);


        ProgramStudi::create(['jurusan_id' => 2,'kode' => 'mtk', 'nama' => 'Matematika', 'tahun' => '2022', 'urutan' => 1]);
        ProgramStudi::create(['jurusan_id' => 1,'kode' => 'ik', 'nama' => 'Ilmu Komputer', 'tahun' => '2022', 'urutan' => 2]);
        ProgramStudi::create(['jurusan_id' => 2,'kode' => 'si', 'nama' => 'Sistem Informasi', 'tahun' => '2022', 'urutan' => 3]);

    }
}
