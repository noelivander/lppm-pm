<x-kaprodi-layout>
    <x-slot name="title">
        {{ __('Audit Mutu Internal') }}
    </x-slot>
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-8">
                <x-kaprodi.heading name="Audit Mutu Internal"></x-kaprodi.heading>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h4>Visi, Misi, Tujuan, dan Strategi Program Studi</h4>
                        @csrf
                        <table class="table table-hover table-responsive mb-4">
                            <thead class="thead-light bg-primary text-white">
                                <tr>
                                    <th>No.</th>
                                    <th>Indikator</th>
                                    <th style="width: 45%;">Pernyataan</th>
                                    <th style="width: 17%;">Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td style="text-align: left;">Program-program program studi mendukung terwujudnya visi keilmuan program studi.</td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_1" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_1" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td style="text-align: left;">Keterlibatan pemangku kepentingan internal dan eksternal Program Studi dalam penyusunan VMTS</td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_2" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_2" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td style="text-align: left;">Visi, misi tujuan dan sasaran prodi disajikan secara jelas dan lengkap, dapat diakses oleh publik setiap saat, dan dimutakhirkan setiap tahun</td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_3" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_3" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td style="text-align: left;">Target kinerja tridharma sesuai dengan strategi pencapaian VMTS.</td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </form>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h4>Tata Kelola, Tata Pamong, dan Kerjasama</h4>
                        @csrf
                        <table class="table table-hover table-responsive mb-4">
                            <thead class="thead-light bg-primary text-white">
                                <tr>
                                    <th>No.</th>
                                    <th>Indikator</th>
                                    <th style="width: 45%;">Pernyataan</th>
                                    <th style="width: 17%;">Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td style="text-align: left;">Sistem tata pamong yang digunakan bersifat kredibel, transparan, akuntabel, bertanggung jawab, dan adil.</td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_1" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_1" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td style="text-align: left;">Tersedianya dokumen pengelolaan fungsional institusi dan PS.</td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_2" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_2" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td style="text-align: left;">ITH melalui Wakil Rektor bertugas dalam tugas dan fungsi mengkoordinasikan kerjasama antara ITH dengan berbagai pihak, baik dalam negeri maupun luar negeri.</td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_3" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_3" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td style="text-align: left;">Tersedianya mekanisme penyelenggaraan pendidikan di ITH.</td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </form>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h4>Mahasiswa</h4>
                        @csrf
                        <table class="table table-hover table-responsive mb-4">
                            <thead class="thead-light bg-primary text-white">
                                <tr>
                                    <th>No.</th>
                                    <th>Indikator</th>
                                    <th style="width: 45%;">Pernyataan</th>
                                    <th style="width: 17%;">Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td style="text-align: left;">Keketatan seleksi meningkat yang ditunjukkan oleh rasio jumlah pendaftar dan jumlah yang diterima > 50%</td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_1" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_1" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td style="text-align: left;">Jumlah peserta yang dinyatakan lulus dan mendaftar ulang 100%</td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_2" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_2" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td style="text-align: left;">Jenis layanan mencakup bidang minat dan bakat, layanan beasiswa, dan layanan kesehatan, dan bimbingan kewirausahaan</td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_3" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_3" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td style="text-align: left;">Terjadi peningkatan jumlah pendaftar rata-rata >30% selama 2 tahun terakhir.</td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td style="text-align: left;">Persentase kelulusan mahasiswa tepat waktu, masa studi dijadwalkan 7-8 semester.</td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </form>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h4>Sumber Daya Manusia</h4>
                        @csrf
                        <table class="table table-hover table-responsive mb-4">
                            <thead class="thead-light bg-primary text-white">
                                <tr>
                                    <th>No.</th>
                                    <th>Indikator</th>
                                    <th style="width: 45%;">Pernyataan</th>
                                    <th style="width: 17%;">Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td style="text-align: left;">Rasio jumlah mahasiswa terhadap jumlah dosen tetap program studi sesuai dengan kriteria yang ditetapkan.</td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_1" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_1" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td style="text-align: left;">Semua Dosen pada PS sarjana dan minimal lulusan magister/magister terapan.</td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_2" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_2" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td style="text-align: left;">Jumlah Dosen Tetap yang ditugaskan sebagai pengampu MK kompetensi inti prodi minimal 5 orang</td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_3" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_3" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td style="text-align: left;">Persentase dosen tetap memiliki kartu anggota kompetensi/profesi
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td style="text-align: left;">Jumlah dosen yang mengikuti pelatihan kompetensi
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td style="text-align: left;">Sebanyak 50% tenaga kependidikan dan laboran minimal lulusan diploma 3
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td style="text-align: left;">Jumlah tendik cukup untuk memberikan layanan prodi, pelaksanaan administrasi akademik, mendukung fungsi unit pengelola, dan pengembangan prodi.
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </form>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h4>Keuangan, Sarana, dan Prasarana</h4>
                        @csrf
                        <table class="table table-hover table-responsive mb-4">
                            <thead class="thead-light bg-primary text-white">
                                <tr>
                                    <th>No.</th>
                                    <th>Indikator</th>
                                    <th style="width: 45%;">Pernyataan</th>
                                    <th style="width: 17%;">Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td style="text-align: left;">Tingkat biaya Pendidikan per mahasiswa (DOP) dihitung dari jumlah mahasiswa aktif dan besaran biaya operasional pembelajaran setiap tahun >500.000 per tahun jenjang sarjana
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_1" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_1" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td style="text-align: left;">Tingkat biaya penelitian per dosen (DPD), dihitung dengan menghimpun data jumlah dosen PS, jumlah kegiatan dan dana penelitian yang diperoleh setiap tahun. 3.5 juta per dosen per tahun</td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_2" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_2" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td style="text-align: left;">Tingkat biaya PkM per dosen (DPD), dihitung dengan menghimpun data jumlah dosen PS, jumlah kegiatan dan dana PKM yang diperoleh setiap tahun. >500.000 juta per dosen per tahun</td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_3" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_3" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td style="text-align: left;">SOP Pengembangan dan Pengelolaan Sarpras.</td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </form>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h4>Pendidikan</h4>
                        @csrf
                        <table class="table table-hover table-responsive mb-4">
                            <thead class="thead-light bg-primary text-white">
                                <tr>
                                    <th>No.</th>
                                    <th>Indikator</th>
                                    <th style="width: 45%;">Pernyataan</th>
                                    <th style="width: 17%;">Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td style="text-align: left;">Terlaksananya proses pembelajaran yang sesuai pada struktur kurikulum berbasis KKNI/OBE/SKKNI sesuai dengan Profil Lulusan, CPL, CPMK, RPS, Struktur MK dan Asesmen Pembelajaran sesuai dengan pedoman kurikulum.
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_1" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_1" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td style="text-align: left;">Tersedianya monitoring perkuliahan untuk memantau kesesuaian proses dengan rencana pembelajaran.
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_2" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_2" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td style="text-align: left;">Terdapat mekanisme topik penelitian dan PkM yang terintegrasi dalam proses Pembelajaran.
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_3" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_3" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td style="text-align: left;">Capaian Pembelajaran mengacu pada hasil kesepakatan dengan asosiasi penyelenggara program studi sejenis dan organisasi profesi
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td style="text-align: left;">Tersedianya fasilitas untuk interaksi antara dosen, mahasiswa, dan sumber belajar.
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td style="text-align: left;">Keterlaksanaan peninjauan/revisi kurikulum
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td style="text-align: left;">Terlaksananya kegiatan ilmiah pertahun
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h4>Penelitian
                    </h4>
                        @csrf
                        <table class="table table-hover table-responsive mb-4">
                            <thead class="thead-light bg-primary text-white">
                                <tr>
                                    <th>No.</th>
                                    <th>Indikator</th>
                                    <th style="width: 45%;">Pernyataan</th>
                                    <th style="width: 17%;">Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td style="text-align: left;">Tersedia lembaga/ unit pengelola penelitian
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_1" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_1" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td style="text-align: left;">Tersedia Rencana Strategis Penelitian.
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_2" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_2" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td style="text-align: left;">Tersedia Peta Jalan penelitian.
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_3" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_3" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td style="text-align: left;">Tema penelitian dosen dan mahasiswa tersedia pada Renstra dan Peta Jalan penelitian
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td style="text-align: left;">Jumlah Penelitian yang melibatkan mahasiswa dengan target 1 
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td style="text-align: left;">Tersedia Standar Penelitian 
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td style="text-align: left;">Tersedianya dokumen yang lengkap untuk setiap kegiatan penelitian
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td style="text-align: left;">Tersedianya mekanisme pelaksanaan penelitian
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td style="text-align: left;">Penelitian Dosen selaras dengan peta jalan penelitian
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h4>Pengabdian Kepada Masyarakat
                    </h4>
                        @csrf
                        <table class="table table-hover table-responsive mb-4">
                            <thead class="thead-light bg-primary text-white">
                                <tr>
                                    <th>No.</th>
                                    <th>Indikator</th>
                                    <th style="width: 45%;">Pernyataan</th>
                                    <th style="width: 17%;">Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td style="text-align: left;">Tersedia lembaga/ unit pengelola PkM
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_1" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_1" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td style="text-align: left;">Tersedia Rencana Strategis PkM
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_2" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_2" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td style="text-align: left;">Jumlah PkM yang dilaksanakan lebih dari 2
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_3" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_3" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td style="text-align: left;">LPPM-PM memastikan pengelolaan PkM dilengkapi dengan standar penelitian.
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td style="text-align: left;">Kesesuaian PkM dengan Peta Jalan 
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td style="text-align: left;">Tersedia mekanisme pelaksanaan PkM
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h4>Luaran dan Capaian Tri Dharma
                    </h4>
                        @csrf
                        <table class="table table-hover table-responsive mb-4">
                            <thead class="thead-light bg-primary text-white">
                                <tr>
                                    <th>No.</th>
                                    <th>Indikator</th>
                                    <th style="width: 45%;">Pernyataan</th>
                                    <th style="width: 17%;">Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td style="text-align: left;">Kompetensi lulusan atau Capaian Pembelajaran Lulusan (CPL) diukur dengan metode yang jelas dan dilaporkan secara periodik.
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_1" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_1" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td style="text-align: left;">Persentase mahasiswa ikut lomba Tingkat nasional dan internasional (Renstra ITH 2020-2024)
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_2" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_2" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td style="text-align: left;">Jumlah publikasi yang melibatkan mahasiswa dengan tema infokom
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_3" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_3" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td style="text-align: left;">Jumlah artikel karya ilmiah DTPR bidang infokom yang disitasi
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td style="text-align: left;">Jumlah publikasi penelitian dengan tema infokom
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td style="text-align: left;">Jumlah penelitian bidang Infokom yang mendapat pengakuan HKI (Paten, Paten Sederhana, Hak Cipta, Desain Produk Industri)
                                    </td>
                                    <td class="bobot">
                                        <textarea name="pernyataan_4" class="form-control" rows="3" required></textarea>
                                    </td>
                                    <td>
                                        <input type="file" name="bukti_4" class="form-control" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</x-kaprodi-layout>
