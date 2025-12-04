<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormPenilaianLaporanKemajuan;
use App\Models\FormPenilaianLaporanKemajuanSub;
use Illuminate\Support\Facades\DB;

class FormPenilaianLaporanKemajuanPengabdianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing pengabdian data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        FormPenilaianLaporanKemajuan::where('jenis', 'pengabdian')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $urutan = 1;

        // 1. Kehadiran dan Pelaksanaan
        $kategori1 = 'Kehadiran dan Pelaksanaan';
        
        // A. Kemampuan presentasi dan penguasaan materi
        $form1A = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori1,
            'komponen_penilaian' => 'A. Kemampuan presentasi dan penguasaan materi',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form1A->id, 'sub_komponen' => 'Presentasi kurang sistematis dan penyampaian materi kurang komunikatif', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form1A->id, 'sub_komponen' => 'Presentasi sistematis dan penyampaian materi komunikatif', 'nilai' => 10, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form1A->id, 'sub_komponen' => 'Presentasi sistematis dan penyampaian materi komunikatif', 'nilai' => 20, 'urutan' => 3]);

        // B. Kehadiran Pelaksana
        $form1B = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori1,
            'komponen_penilaian' => 'B. Kehadiran Pelaksana',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form1B->id, 'sub_komponen' => 'Tim pelaksana, mahasiswa dan mitra tidak hadir lengkap', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form1B->id, 'sub_komponen' => 'Tim pelaksana, mahasiswa dan mitra hadir lengkap namun terdapat ketidakhadiran yang tidak dapat dikonfirmasi', 'nilai' => 10, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form1B->id, 'sub_komponen' => 'Tim pelaksana, mahasiswa dan mitra hadir lengkap dan dapat dikonfirmasi seluruhnya', 'nilai' => 20, 'urutan' => 3]);

        // C. Kesiapan dan kelengkapan Pelaksana
        $form1C = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori1,
            'komponen_penilaian' => 'C. Kesiapan dan kelengkapan Pelaksana',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form1C->id, 'sub_komponen' => 'Tim pelaksana tidak menyiapkan dokumen', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form1C->id, 'sub_komponen' => 'Tim pelaksana telah menyiapkan dokumen', 'nilai' => 10, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form1C->id, 'sub_komponen' => 'Tim pelaksana telah menyiapkan dokumen', 'nilai' => 20, 'urutan' => 3]);

        // D. Kesiapan Mitra
        $form1D = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori1,
            'komponen_penilaian' => 'D. Kesiapan Mitra',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form1D->id, 'sub_komponen' => 'Mitra tidak siap', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form1D->id, 'sub_komponen' => 'Mitra siap', 'nilai' => 10, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form1D->id, 'sub_komponen' => 'Mitra sangat siap', 'nilai' => 20, 'urutan' => 3]);

        // E. Kesuaian substansi materi dengan materi proposal
        $form1E = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori1,
            'komponen_penilaian' => 'E. Kesuaian substansi materi dengan materi proposal',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form1E->id, 'sub_komponen' => 'Substansi tidak sesuai', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form1E->id, 'sub_komponen' => 'Substansi cukup sesuai', 'nilai' => 10, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form1E->id, 'sub_komponen' => 'Substansi sesuai', 'nilai' => 20, 'urutan' => 3]);

        // 2. Artikel publikasi/berita pada media massa (cetak/elektronik)
        $kategori2 = 'Artikel publikasi/berita pada media massa (cetak/elektronik)';
        
        $form2A = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori2,
            'komponen_penilaian' => 'A. Artikel publikasi berita pada media massa (cetak/elektronik)',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form2A->id, 'sub_komponen' => 'Tidak ada draft artikel', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form2A->id, 'sub_komponen' => 'Ada draft/artikel media massa setelah ketentuan dan menyebutkan nama DRTPM, institusi dan sumber dana', 'nilai' => 10, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form2A->id, 'sub_komponen' => 'Sudah terbit di media cetak elektronik nasional, menyebutkan nama DRTPM, institusi dan sumber dana', 'nilai' => 100, 'urutan' => 3]);

        // 3. Publikasi pada Jurnal nasional terakreditasi SINTA 3-6
        $kategori3 = 'Publikasi pada Jurnal nasional terakreditasi SINTA 3-6';
        
        $form3A = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori3,
            'komponen_penilaian' => 'A. Publikasi pada Jurnal nasional terakreditasi SINTA 3-6',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form3A->id, 'sub_komponen' => 'Tidak ada draft', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form3A->id, 'sub_komponen' => 'Ada draft/artikel sesuai ketentuan', 'nilai' => 10, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form3A->id, 'sub_komponen' => 'Ada bukti diterima dan direview', 'nilai' => 70, 'urutan' => 3]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form3A->id, 'sub_komponen' => 'Terpublikasi nasional terindeks SINTA', 'nilai' => 100, 'urutan' => 4]);

        // 4. Rekognisi SKS minimal 4 SKS
        $kategori4 = 'Rekognisi SKS minimal 4 SKS';
        
        // A. Rekognisi mahasiswa ke 1
        $form4A = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori4,
            'komponen_penilaian' => 'A. Rekognisi mahasiswa ke 1',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form4A->id, 'sub_komponen' => 'Tidak ada rekognisi SKS', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form4A->id, 'sub_komponen' => 'Ada Rekognisi SKS namun judulnya masih kurang dari ketentuan', 'nilai' => 5, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form4A->id, 'sub_komponen' => 'Ada Rekognisi SKS sesuai dengan ketentuan dan melampirkan buku dan nama mahasiswa yang tertera sesuai dengan nama yang tertera pada proposal', 'nilai' => 25, 'urutan' => 3]);

        // B. Rekognisi mahasiswa ke 2
        $form4B = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori4,
            'komponen_penilaian' => 'B. Rekognisi mahasiswa ke 2',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form4B->id, 'sub_komponen' => 'Tidak ada rekognisi SKS', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form4B->id, 'sub_komponen' => 'Ada Rekognisi SKS namun judulnya masih kurang dari ketentuan', 'nilai' => 5, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form4B->id, 'sub_komponen' => 'Ada Rekognisi SKS sesuai dengan ketentuan dan melampirkan buku dan nama mahasiswa yang tertera sesuai dengan nama yang tertera pada proposal', 'nilai' => 25, 'urutan' => 3]);

        // 5. Karya Audio Visual (Video)
        $kategori5 = 'Karya Audio Visual (Video)';
        
        // A. Channel / Penayangan
        $form5A = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori5,
            'komponen_penilaian' => 'A. Channel / Penayangan',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5A->id, 'sub_komponen' => 'Tidak ada Video', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5A->id, 'sub_komponen' => 'Video sudah diunggah di Youtube lembaga maupun Perguruan Tinggi Pelaksana namun tidak diunggah di laman lembaga', 'nilai' => 15, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5A->id, 'sub_komponen' => 'Video sudah diunggah di Youtube lembaga/Perguruan Tinggi Pelaksana maupun laman lembaga dan telah memiliki subscriber lebih dari 1K', 'nilai' => 20, 'urutan' => 3]);

        // B. Kualitas Video
        $form5B = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori5,
            'komponen_penilaian' => 'B. Kualitas Video',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5B->id, 'sub_komponen' => 'Tidak ada video', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5B->id, 'sub_komponen' => 'Video sudah diunggah di Youtube lembaga maupun Perguruan Tinggi Pelaksana dengan resolusi 1080p', 'nilai' => 15, 'urutan' => 2]);

        // C. Bentuk Video
        $form5C = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori5,
            'komponen_penilaian' => 'C. Bentuk Video',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5C->id, 'sub_komponen' => 'Tidak ada video', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5C->id, 'sub_komponen' => 'Video sudah diunggah di Youtube lembaga maupun Perguruan Tinggi Pelaksana dan merupakan video produk', 'nilai' => 10, 'urutan' => 2]);

        // D. Voice Over dan Running Text/Subtitle
        $form5D = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori5,
            'komponen_penilaian' => 'D. Voice Over dan Running Text/Subtitle',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5D->id, 'sub_komponen' => 'Tidak ada video', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5D->id, 'sub_komponen' => 'Video sudah diunggah di Youtube lembaga maupun Perguruan Tinggi Pelaksana namun tidak terdapat voice over, subtitle, dan running text', 'nilai' => 1, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5D->id, 'sub_komponen' => 'Video sudah diunggah di Youtube lembaga maupun Perguruan Tinggi Pelaksana dan terdapat voice over, subtitle, dan running text', 'nilai' => 15, 'urutan' => 3]);

        // E. Penyebutan Program dan Sumber Dana
        $form5E = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori5,
            'komponen_penilaian' => 'E. Penyebutan Program dan Sumber Dana',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5E->id, 'sub_komponen' => 'Tidak ada video', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5E->id, 'sub_komponen' => 'Video sudah diunggah di Youtube lembaga maupun Perguruan Tinggi Pelaksana namun tidak menyebutkan nama program dan sumber dana', 'nilai' => 1, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5E->id, 'sub_komponen' => 'Video sudah diunggah di Youtube lembaga maupun Perguruan Tinggi Pelaksana dan telah menyebutkan nama program serta sumber dana', 'nilai' => 10, 'urutan' => 3]);

        // F. Cerita dan Penggambaran
        $form5F = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori5,
            'komponen_penilaian' => 'F. Cerita dan Penggambaran',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5F->id, 'sub_komponen' => 'Tidak ada video', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5F->id, 'sub_komponen' => 'Video sudah diunggah di Youtube lembaga maupun Perguruan Tinggi Pelaksana namun tidak menggambarkan gambaran hasil pelaksanaan pengabdian serta hasil pengabdian', 'nilai' => 1, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5F->id, 'sub_komponen' => 'Video sudah diunggah di Youtube lembaga maupun Perguruan Tinggi Pelaksana dan telah menggambarkan gambaran hasil pelaksanaan pengabdian serta hasil pengabdian', 'nilai' => 10, 'urutan' => 3]);

        // G. Daya Tarik, Suasana, dan Stabilisasi
        $form5G = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori5,
            'komponen_penilaian' => 'G. Daya Tarik, Suasana, dan Stabilisasi',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5G->id, 'sub_komponen' => 'Tidak ada video', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5G->id, 'sub_komponen' => 'Video sudah diunggah di Youtube lembaga maupun Perguruan Tinggi Pelaksana namun tidak menarik', 'nilai' => 1, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5G->id, 'sub_komponen' => 'Video sudah diunggah di Youtube lembaga maupun Perguruan Tinggi Pelaksana dan video menarik dan bagus', 'nilai' => 10, 'urutan' => 3]);

        // H. Jumlah viewers video
        $form5H = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori5,
            'komponen_penilaian' => 'H. Jumlah viewers video',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5H->id, 'sub_komponen' => 'Tidak ada viewers', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5H->id, 'sub_komponen' => 'Jumlah viewers < 25', 'nilai' => 5, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5H->id, 'sub_komponen' => 'Jumlah viewers 25 - 50', 'nilai' => 7, 'urutan' => 3]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5H->id, 'sub_komponen' => 'Jumlah viewers 50 - 100', 'nilai' => 10, 'urutan' => 4]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form5H->id, 'sub_komponen' => 'Jumlah viewers > 100', 'nilai' => 15, 'urutan' => 5]);

        // 6. Karya Visual (Poster)
        $kategori6 = 'Karya Visual (Poster)';
        
        // A. Format Poster
        $form6A = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori6,
            'komponen_penilaian' => 'A. Format Poster',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form6A->id, 'sub_komponen' => 'Tidak ada poster', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form6A->id, 'sub_komponen' => 'Ada poster, ukuran poster tidak sesuai ketentuan, dan tidak menyebutkan sumber pendanaan dan logo Komdiktek', 'nilai' => 0, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form6A->id, 'sub_komponen' => 'Ukuran poster sesuai ketentuan dan telah menyebutkan sumber pendanaan dan logo Komdiktek', 'nilai' => 70, 'urutan' => 3]);

        // B. Isi/Substansi Poster
        $form6B = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori6,
            'komponen_penilaian' => 'B. Isi/Substansi Poster',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form6B->id, 'sub_komponen' => 'Tidak ada poster', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form6B->id, 'sub_komponen' => 'Poster tidak menggambarkan gambaran pelaksanaan pengabdian serta hasil pengabdian', 'nilai' => 5, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form6B->id, 'sub_komponen' => 'Poster telah menggambarkan gambaran pelaksanaan pengabdian serta hasil pengabdian', 'nilai' => 30, 'urutan' => 3]);

        // C. Daya Tarik, Warna dan Layout
        $form6C = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori6,
            'komponen_penilaian' => 'C. Daya Tarik, Warna dan Layout',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form6C->id, 'sub_komponen' => 'Tidak ada poster', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form6C->id, 'sub_komponen' => 'Ada poster namun tidak menarik, warna monoton, dan layout tidak beraturan', 'nilai' => 5, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form6C->id, 'sub_komponen' => 'Ada poster namun menarik dan bagus', 'nilai' => 30, 'urutan' => 3]);

        // 7. Penggunaan Anggaran 70%
        $kategori7 = 'Penggunaan Anggaran 70%';
        
        // A. Dokumen Laporan Penggunaan Anggaran
        $form7A = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori7,
            'komponen_penilaian' => 'A. Dokumen Laporan Penggunaan Anggaran',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form7A->id, 'sub_komponen' => 'Dokumen laporan penggunaan anggaran tidak ada/belum diunggah', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form7A->id, 'sub_komponen' => 'Dokumen laporan penggunaan anggaran sudah diunggah dengan disertai kuitansi dan bukti dukung namun beberapa kuitansi dan bukti dukung tidak sesuai dengan ketentuan', 'nilai' => 4, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form7A->id, 'sub_komponen' => 'Dokumen laporan penggunaan anggaran sudah diunggah dengan disertai kuitansi dan bukti dukung dan sudah sesuai dengan ketentuan', 'nilai' => 12, 'urutan' => 3]);

        // B. Penggunaan Anggaran 70% dengan SDM
        $form7B = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori7,
            'komponen_penilaian' => 'B. Penggunaan Anggaran 70% dengan SDM',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form7B->id, 'sub_komponen' => 'Penggunaan anggaran tidak sesuai dengan ketentuan pada SDM 2024', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form7B->id, 'sub_komponen' => 'Penggunaan beberapa komponen anggaran tidak sesuai dengan ketentuan dalam SDM 2024', 'nilai' => 5, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form7B->id, 'sub_komponen' => 'Penggunaan komponen anggaran sesuai dengan ketentuan dalam SDM 2024', 'nilai' => 30, 'urutan' => 3]);

        // C. Penggunaan Anggaran 70% dengan Fasilitas dan Komponennya
        $form7C = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori7,
            'komponen_penilaian' => 'C. Penggunaan Anggaran 70% dengan Fasilitas dan Komponennya',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form7C->id, 'sub_komponen' => 'Penggunaan anggaran tidak sesuai dengan ketentuan dalam fasilitas dan komponennya', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form7C->id, 'sub_komponen' => 'Penggunaan beberapa komponen anggaran tidak sesuai dengan ketentuan dalam fasilitas dan komponennya', 'nilai' => 5, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form7C->id, 'sub_komponen' => 'Penggunaan komponen anggaran sesuai dengan ketentuan dalam fasilitas dan komponennya', 'nilai' => 10, 'urutan' => 3]);

        // 8. Pemberdayaan dan Keberlanjutan
        $kategori8 = 'Pemberdayaan dan Keberlanjutan';
        
        // A. Peningkatan level keberdayaan
        $form8A = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori8,
            'komponen_penilaian' => 'A. Peningkatan level keberdayaan (aspek produksi, aspek manajemen, aspek pemasaran, aspek sosial, aspek kemasyarakatan)',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form8A->id, 'sub_komponen' => 'Tidak ada peningkatan level keberdayaan', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form8A->id, 'sub_komponen' => 'Ada peningkatan level keberdayaan dari yang belum teridentifikasi atau yang ada dan baru teridentifikasi setelah program pada aspek yang dipilih', 'nilai' => 10, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form8A->id, 'sub_komponen' => 'Ada peningkatan level keberdayaan mitra yang teridentifikasi secara jelas dan hasil pengembangannya', 'nilai' => 100, 'urutan' => 3]);

        // B. Persen peningkatan level keberdayaan mitra
        $form8B = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori8,
            'komponen_penilaian' => 'B. Persen peningkatan level keberdayaan mitra',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form8B->id, 'sub_komponen' => 'Tidak ada peningkatan level keberdayaan mitra', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form8B->id, 'sub_komponen' => 'Tidak menunjukkan peningkatan < 20%', 'nilai' => 10, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form8B->id, 'sub_komponen' => 'Cukup menunjukkan peningkatan 21 - 50%', 'nilai' => 25, 'urutan' => 3]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form8B->id, 'sub_komponen' => 'Menunjukkan peningkatan 51 - 70%', 'nilai' => 40, 'urutan' => 4]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form8B->id, 'sub_komponen' => 'Sangat menunjukkan peningkatan > 70%', 'nilai' => 70, 'urutan' => 5]);

        // C. Penerapan teknologi dan inovasi
        $form8C = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori8,
            'komponen_penilaian' => 'C. Penerapan teknologi dan inovasi',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form8C->id, 'sub_komponen' => 'Tidak ada teknologi dan inovasi yang diterapkan kepada mitra sasaran', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form8C->id, 'sub_komponen' => 'Ada teknologi dan inovasi yang diterapkan namun tidak sesuai dengan kebutuhan mitra sasaran', 'nilai' => 5, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form8C->id, 'sub_komponen' => 'Teknologi dan inovasi yang diterapkan sesuai dengan kebutuhan mitra, namun belum dapat dioptimalkan oleh mitra sasaran', 'nilai' => 15, 'urutan' => 3]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form8C->id, 'sub_komponen' => 'Teknologi dan inovasi yang diterapkan sesuai dengan kebutuhan mitra, dan sudah dapat dioptimalkan oleh mitra sasaran', 'nilai' => 55, 'urutan' => 4]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form8C->id, 'sub_komponen' => 'Teknologi dan inovasi yang diterapkan sesuai dengan kebutuhan mitra, dan sudah dapat dioptimalkan oleh mitra sasaran dan memberikan peningkatan keberdayaan', 'nilai' => 90, 'urutan' => 5]);

        // D. Kehadiran anggota tim pelaksana dan mahasiswa ke lokasi mitra sasaran
        $form8D = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori8,
            'komponen_penilaian' => 'D. Kehadiran anggota tim pelaksana dan mahasiswa ke lokasi mitra sasaran',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form8D->id, 'sub_komponen' => 'Tidak pernah hadir ke lokasi kegiatan', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form8D->id, 'sub_komponen' => 'Tim pelaksana hadir < 1 kali kedatangan ke lokasi mitra', 'nilai' => 20, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form8D->id, 'sub_komponen' => 'Tim pelaksana hadir > 1 kali kedatangan ke lokasi mitra', 'nilai' => 28, 'urutan' => 3]);

        // E. Partisipasi dan peran seluruh anggota tim pelaksana dan mahasiswa
        $form8E = FormPenilaianLaporanKemajuan::create([
            'jenis' => 'pengabdian',
            'kategori' => $kategori8,
            'komponen_penilaian' => 'E. Partisipasi dan peran seluruh anggota tim pelaksana dan mahasiswa',
            'urutan' => $urutan++,
            'is_active' => true,
        ]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form8E->id, 'sub_komponen' => 'Tidak semua tim pelaksana memiliki peran dalam pembentukan/distribusi pembagian tugas dan peran tidak jelas', 'nilai' => 0, 'urutan' => 1]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form8E->id, 'sub_komponen' => 'Pembagian peran tim pelaksana dalam pembentukan/distribusi tugas sesuai ketentuan', 'nilai' => 20, 'urutan' => 2]);
        FormPenilaianLaporanKemajuanSub::create(['form_penilaian_id' => $form8E->id, 'sub_komponen' => 'Seluruh tim pelaksana dan mahasiswa memiliki peran dalam melakukan pemberdayaan', 'nilai' => 30, 'urutan' => 3]);

        $this->command->info('Form Penilaian Laporan Kemajuan Pengabdian berhasil di-seed!');
    }
}

