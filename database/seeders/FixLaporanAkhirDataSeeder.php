<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\FormPenilaianLaporanAkhir;
use App\Models\FormPenilaianLaporanAkhirSub;

class FixLaporanAkhirDataSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->command->info('Truncating Laporan Akhir Reviews (Cleaning bad data)...');
        DB::table('laporan_akhir_review_items')->truncate();
        DB::table('laporan_akhir_reviews')->truncate();

        $this->command->info('Resetting Form Penilaian Laporan Akhir...');
        FormPenilaianLaporanAkhirSub::truncate();
        FormPenilaianLaporanAkhir::truncate();

        $urutan = 1;

        // 1. Ketercapaian Luaran Wajib
        $f1 = FormPenilaianLaporanAkhir::create([
            'jenis' => 'penelitian',
            'komponen_penilaian' => 'Ketercapaian Luaran Wajib',
            'kategori' => 'Laporan Akhir',
            'urutan' => $urutan++,
            'is_active' => true
        ]);
        // Status
        FormPenilaianLaporanAkhirSub::create(['form_penilaian_laporan_akhir_id' => $f1->id, 'tipe' => 'status', 'keterangan' => 'Terpublikasi/Granted (100)', 'skor' => 100, 'urutan' => 1]);
        FormPenilaianLaporanAkhirSub::create(['form_penilaian_laporan_akhir_id' => $f1->id, 'tipe' => 'status', 'keterangan' => 'Accepted (75)', 'skor' => 75, 'urutan' => 2]);
        FormPenilaianLaporanAkhirSub::create(['form_penilaian_laporan_akhir_id' => $f1->id, 'tipe' => 'status', 'keterangan' => 'Submitted (50)', 'skor' => 50, 'urutan' => 3]);
        FormPenilaianLaporanAkhirSub::create(['form_penilaian_laporan_akhir_id' => $f1->id, 'tipe' => 'status', 'keterangan' => 'Draft (25)', 'skor' => 25, 'urutan' => 4]);
        // Items
        FormPenilaianLaporanAkhirSub::create(['form_penilaian_laporan_akhir_id' => $f1->id, 'tipe' => 'item', 'keterangan' => 'Kualitas Artikel/Luaran', 'skor' => 0, 'urutan' => 1]);
        FormPenilaianLaporanAkhirSub::create(['form_penilaian_laporan_akhir_id' => $f1->id, 'tipe' => 'item', 'keterangan' => 'Reputasi Jurnal/Media', 'skor' => 0, 'urutan' => 2]);

        // 2. Kualitas Dokumen Laporan
        $f2 = FormPenilaianLaporanAkhir::create([
            'jenis' => 'penelitian',
            'komponen_penilaian' => 'Kualitas Dokumen Laporan Akhir',
            'kategori' => 'Laporan Akhir',
            'urutan' => $urutan++,
            'is_active' => true
        ]);
        FormPenilaianLaporanAkhirSub::create(['form_penilaian_laporan_akhir_id' => $f2->id, 'tipe' => 'status', 'keterangan' => 'Sangat Baik (100)', 'skor' => 100, 'urutan' => 1]);
        FormPenilaianLaporanAkhirSub::create(['form_penilaian_laporan_akhir_id' => $f2->id, 'tipe' => 'status', 'keterangan' => 'Baik (80)', 'skor' => 80, 'urutan' => 2]);
        FormPenilaianLaporanAkhirSub::create(['form_penilaian_laporan_akhir_id' => $f2->id, 'tipe' => 'status', 'keterangan' => 'Cukup (60)', 'skor' => 60, 'urutan' => 3]);
        // Items
        FormPenilaianLaporanAkhirSub::create(['form_penilaian_laporan_akhir_id' => $f2->id, 'tipe' => 'item', 'keterangan' => 'Sistematika Penulisan', 'skor' => 0, 'urutan' => 1]);
        FormPenilaianLaporanAkhirSub::create(['form_penilaian_laporan_akhir_id' => $f2->id, 'tipe' => 'item', 'keterangan' => 'Ketajaman Analisis', 'skor' => 0, 'urutan' => 2]);
        FormPenilaianLaporanAkhirSub::create(['form_penilaian_laporan_akhir_id' => $f2->id, 'tipe' => 'item', 'keterangan' => 'Simpulan dan Saran', 'skor' => 0, 'urutan' => 3]);

        // 3. Kesesuaian Pelaksanaan
        $f3 = FormPenilaianLaporanAkhir::create([
            'jenis' => 'penelitian',
            'komponen_penilaian' => 'Kesesuaian Pelaksanaan',
            'kategori' => 'Laporan Akhir',
            'urutan' => $urutan++,
            'is_active' => true
        ]);
        FormPenilaianLaporanAkhirSub::create(['form_penilaian_laporan_akhir_id' => $f3->id, 'tipe' => 'status', 'keterangan' => 'Sesuai (100)', 'skor' => 100, 'urutan' => 1]);
        FormPenilaianLaporanAkhirSub::create(['form_penilaian_laporan_akhir_id' => $f3->id, 'tipe' => 'status', 'keterangan' => 'Kurang Sesuai (50)', 'skor' => 50, 'urutan' => 2]);
        FormPenilaianLaporanAkhirSub::create(['form_penilaian_laporan_akhir_id' => $f3->id, 'tipe' => 'item', 'keterangan' => 'Kesesuaian Metode', 'skor' => 0, 'urutan' => 1]);
        FormPenilaianLaporanAkhirSub::create(['form_penilaian_laporan_akhir_id' => $f3->id, 'tipe' => 'item', 'keterangan' => 'Kesesuaian Jadwal', 'skor' => 0, 'urutan' => 2]);

        // Repeat slightly for Pengabdian
        $urutan = 1;
        $f4 = FormPenilaianLaporanAkhir::create([
            'jenis' => 'pengabdian',
            'komponen_penilaian' => 'Ketercapaian Luaran',
            'kategori' => 'Laporan Akhir',
            'urutan' => $urutan++,
            'is_active' => true
        ]);
        FormPenilaianLaporanAkhirSub::create(['form_penilaian_laporan_akhir_id' => $f4->id, 'tipe' => 'status', 'keterangan' => 'Tercapai (100)', 'skor' => 100, 'urutan' => 1]);
        FormPenilaianLaporanAkhirSub::create(['form_penilaian_laporan_akhir_id' => $f4->id, 'tipe' => 'status', 'keterangan' => 'Sebagian (50)', 'skor' => 50, 'urutan' => 2]);
        FormPenilaianLaporanAkhirSub::create(['form_penilaian_laporan_akhir_id' => $f4->id, 'tipe' => 'item', 'keterangan' => 'Dokumentasi Kegiatan', 'skor' => 0, 'urutan' => 1]);
        FormPenilaianLaporanAkhirSub::create(['form_penilaian_laporan_akhir_id' => $f4->id, 'tipe' => 'item', 'keterangan' => 'Partisipasi Mitra', 'skor' => 0, 'urutan' => 2]);


        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->command->info('FixLaporanAkhirDataSeeder completed successfully.');
    }
}
