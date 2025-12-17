<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormPenilaianLaporanKemajuan;
use App\Models\FormPenilaianLaporanKemajuanSub;
use Illuminate\Support\Facades\DB;

class FormPenilaianLaporanKemajuanPenelitianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing penelitian data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Only delete entries for 'penelitian' to avoid clearing pengabdian data
        $existingForms = FormPenilaianLaporanKemajuan::where('jenis', 'penelitian')->get();
        foreach ($existingForms as $form) {
            FormPenilaianLaporanKemajuanSub::where('form_penilaian_id', $form->id)->delete();
            $form->delete();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $urutan = 1;
        $kategori = 'Monev Penelitian';

        // 1. Kemajuan ketercapaian luaran wajib yang dijanjikan
        $form1 = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'penelitian',
            'kategori' => $kategori,
            'komponen_penilaian' => 'Kemajuan ketercapaian luaran wajib yang dijanjikan',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form1->id, 'sub_komponen' => 'Belum ada progress/bukti', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form1->id, 'sub_komponen' => 'Draft/Status Submitted', 'nilai' => 10, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form1->id, 'sub_komponen' => 'Accepted/Published/Granted', 'nilai' => 25, 'urutan' => 3]);

        // 2. Kesesuaian penelitian dengan usulan
        $form2 = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'penelitian',
            'kategori' => $kategori,
            'komponen_penilaian' => 'Kesesuaian penelitian dengan usulan',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form2->id, 'sub_komponen' => 'Tidak sesuai', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form2->id, 'sub_komponen' => 'Kurang sesuai (banyak perubahan)', 'nilai' => 10, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form2->id, 'sub_komponen' => 'Sesuai dengan usulan', 'nilai' => 25, 'urutan' => 3]);

        // 3. Potensi keberlanjutan hasil Penelitian
        $form3 = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'penelitian',
            'kategori' => $kategori,
            'komponen_penilaian' => 'Potensi keberlanjutan hasil Penelitian',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form3->id, 'sub_komponen' => 'Tidak berpotensi lanjut', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form3->id, 'sub_komponen' => 'Berpotensi lanjut dengan catatan', 'nilai' => 10, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form3->id, 'sub_komponen' => 'Sangat berpotensi untuk dilanjutkan (komersialisasi/hilirisasi)', 'nilai' => 25, 'urutan' => 3]);

        // 4. Level TKT saat ini (monev)
        $form4 = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'penelitian',
            'kategori' => $kategori,
            'komponen_penilaian' => 'Level TKT saat ini (monev)',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form4->id, 'sub_komponen' => 'TKT 1 - 2', 'nilai' => 5, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form4->id, 'sub_komponen' => 'TKT 3 - 4', 'nilai' => 10, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form4->id, 'sub_komponen' => 'TKT 5 - 6', 'nilai' => 15, 'urutan' => 3]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form4->id, 'sub_komponen' => 'TKT > 6', 'nilai' => 25, 'urutan' => 4]);

        // 5. Persentase serapan anggaran belanja
        $form5 = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'penelitian',
            'kategori' => $kategori,
            'komponen_penilaian' => 'Persentase serapan anggaran belanja',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5->id, 'sub_komponen' => 'Rendah', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5->id, 'sub_komponen' => 'Menengah', 'nilai' => 10, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5->id, 'sub_komponen' => 'Tinggi', 'nilai' => 15, 'urutan' => 3]);

        $this->command->info('Form Penilaian Laporan Kemajuan Penelitian berhasil di-seed!');
    }
}
