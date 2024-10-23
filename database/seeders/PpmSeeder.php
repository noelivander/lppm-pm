<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\PPM\JenisSkema;
use App\Models\PPM\Luaran;
use App\Models\PPM\Skema;

class PpmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        JenisSkema::create(['kode'=>'internal','nama'=>'Internal ITH']);
        JenisSkema::create(['kode'=>'kemendikbud-ristek','nama'=>'Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi']);
        JenisSkema::create(['kode'=>'lain','nama'=>'Lainnya']);

        Luaran::create(['kode'=>'hasil_penelitian','nama'=>'Hasil Penelitian','perihal'=>'']);
        Luaran::create(['kode'=>'hasil_pengabdian','nama'=>'Hasil Pengabdian','perihal'=>'']);
        Luaran::create(['kode'=>'buku_ajar','nama'=>'Buku Ajar','perihal'=>'']);
        Luaran::create(['kode'=>'publikasi_ilmiah','nama'=>'Publikasi Ilmiah','perihal'=>'']);

        # Internal
        Skema::create(['kode'=>'pki','nama'=>'Penelitian Kolaborasi Indonesia', 'is_research'=>1,'jenis_skema_id'=>1]);
        Skema::create(['kode'=>'pdin','nama'=>'Penelitian Dasar ITH', 'is_research'=>1,'jenis_skema_id'=>1]);
        Skema::create(['kode'=>'ptin','nama'=>'Penelitian Terapan ITH', 'is_research'=>1,'jenis_skema_id'=>1]);
        Skema::create(['kode'=>'pipin','nama'=>'Penelitian Inovasi Pengembangan ITH', 'is_research'=>1,'jenis_skema_id'=>1]);
        Skema::create(['kode'=>'pdpain','nama'=>'Penelitian Dosen Penasehat Akademik', 'is_research'=>1,'jenis_skema_id'=>1]);
        Skema::create(['kode'=>'pdpin','nama'=>'Penelitian Dosen Pemula ITH', 'is_research'=>1,'jenis_skema_id'=>1]);
        Skema::create(['kode'=>'pkin','nama'=>'Program Kemitraan ITH', 'is_research'=>0,'jenis_skema_id'=>1]);
        Skema::create(['kode'=>'ppupiki','nama'=>'Program Pengembangan Usaha Intelektual Kampus ITH', 'is_research'=>0,'jenis_skema_id'=>1]);
        Skema::create(['kode'=>'kkn-ppm','nama'=>'KuliahKerja Nyata Pembelajaran Pemberdayaan Masyarakat', 'is_research'=>0,'jenis_skema_id'=>1]);

        # Kemendikbut-ristek
        Skema::create(['kode'=>'pd','nama'=>'Penelitian Dasar', 'is_research'=>1, 'jenis_skema_id'=>2]);
        Skema::create(['kode'=>'pdupt','nama'=>'Penelitian Dasar Unggulan Perguruan Tinggi', 'is_research'=>1, 'jenis_skema_id'=>2]);
        Skema::create(['kode'=>'pt','nama'=>'Penelitian Terapan', 'is_research'=>1, 'jenis_skema_id'=>2]);
        Skema::create(['kode'=>'ptupt','nama'=>'Penelitian Terapan Unggulan Perguruan Tinggi', 'is_research'=>1, 'jenis_skema_id'=>2]);
        Skema::create(['kode'=>'pp','nama'=>'Penelitian Pengembangan', 'is_research'=>1, 'jenis_skema_id'=>2]);
        Skema::create(['kode'=>'ppupt','nama'=>'Penelitian Pengembangan Unggulan Perguruan Tinggi', 'is_research'=>1, 'jenis_skema_id'=>2]);
        Skema::create(['kode'=>'ppd','nama'=>'Penelitian Pasca Doktor', 'is_research'=>1, 'jenis_skema_id'=>2]);
        Skema::create(['kode'=>'ptm','nama'=>'Penelitian Tesis Magister', 'is_research'=>1, 'jenis_skema_id'=>2]);
        Skema::create(['kode'=>'pdd','nama'=>'Penelitian Disertasi Doktor', 'is_research'=>1, 'jenis_skema_id'=>2]);
        Skema::create(['kode'=>'pmdsu','nama'=>'Pendidikan Magister menuju Doktor untuk Sarjana Unggul', 'is_research'=>1, 'jenis_skema_id'=>2]);
        Skema::create(['kode'=>'krupt','nama'=>'Konsorsium Riset Unggulan Perguruan Tinggi', 'is_research'=>1, 'jenis_skema_id'=>2]);
        Skema::create(['kode'=>'wcr','nama'=>'World Class Research', 'is_research'=>1, 'jenis_skema_id'=>2]);
        Skema::create(['kode'=>'prn','nama'=>'Prioritas Riset Nasional', 'is_research'=>0, 'jenis_skema_id'=>2]);
        Skema::create(['kode'=>'kd','nama'=>'Kemitraan Dasar', 'is_research'=>0, 'jenis_skema_id'=>2]);
        Skema::create(['kode'=>'pkm','nama'=>'Program Kreativitas Mahasiswa', 'is_research'=>0, 'jenis_skema_id'=>2]);
        Skema::create(['kode'=>'ppuik','nama'=>'Program Pengembangan Usaha Intelektual Kampus', 'is_research'=>0, 'jenis_skema_id'=>2]);
    }
}