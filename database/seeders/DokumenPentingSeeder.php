<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\DokumenPenting;

class DokumenPentingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DokumenPenting::create([
            'slug'=>'pengecekan-similarity-artikel-ilmiah-menggunakan-turnitin',
            'judul'=>'Pengecekan Similarity Artikel Ilmiah Menggunakan Turnitin',
            'cover'=>'dokumen_penting/sampul/01-pengecekan-similarity.png',
            'file'=>'dokumen_penting/1664095367-1664095367-pedoman-pengecekan-plagiarisme-turnitin.pdf',
            'urutan'=>1,
            'is_lock'=> 0
        ]);

        DokumenPenting::create([
            'slug'=>'roadmap-penelitian-ith-2023',
            'judul'=>'Roadmap Penelitian ITH 2023',
            'cover'=>'dokumen_penting/sampul/02-roadmap-penelitian.png',
            'urutan'=>1,
            'is_lock'=> 1
        ]);

        DokumenPenting::create([
            'slug'=>'pedoman-penelitian-dan-pengabdian-kedapa-masyarakat-ith-2023',
            'judul'=>'Pedoman Penelitian dan Pengabdian kedapa Masyarakat ITH 2023',
            'cover'=>'dokumen_penting/sampul/03-pedoman-ppm.png',
            'urutan'=>1,
            'is_lock'=> 1
        ]);
    }
}
