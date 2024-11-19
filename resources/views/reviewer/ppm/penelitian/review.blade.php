<x-reviewer-layout>
    <x-slot name="header">
        {{ __('Review Penelitian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row mt-3">
            <div class="col-md-12">
                <h3>Review Proposal Penelitian: {{ $proposal->judul }}</h3>
                <iframe src="{{ Storage::url($proposal->dokumen_proposal) }}" style="width:100%; height:700px;"></iframe>
                
                <!-- resources/views/review_form.blade.php -->
                <form action="{{ route('penelitian.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="penelitian_id" value="{{ $proposal->id }}">
                    <input type="hidden" name="reviewer_id" value="{{ auth()->user()->id }}">

                    <h3>Formulir Penilaian Pembahasan Proposal Penelitian Tahun 2024</h3>

                    <input type="hidden" id="judul_kegiatan" name="judul_kegiatan" value="{{ $proposal->judul }}">

                    <label for="ketua_tim">Ketua Tim Pelaksana:</label>
                    <input type="text" id="ketua_tim" name="ketua_tim" value="{{ old('ketua_tim', $ketuaTimName) }}" required><br>

                    <label for="nidn">NIDN:</label>
                    <input type="text" id="nidn" name="nidn" value="{{ old('nidn', $nidn) }}" required><br>                    

                    <label for="jabatan">Jabatan:</label>
                    <input type="text" id="jabatan" name="jabatan" required><br>

                    <label for="scopus">H-Index (Scopus):</label>
                    <input type="text" id="scopus" name="scopus" required><br>

                    <label for="anggota">Anggota Peneliti:</label>
                    <input type="text" id="anggota" name="anggota" required><br>

                    <label for="biaya_usulan">Biaya Usulan:</label>
                    <input type="number" id="biaya_usulan" name="biaya_usulan" required><br>

                    <label for="disarankan">Direkomendasikan:</label>
                    <input type="text" id="disarankan" name="disarankan"><br>

                    <h4>Kriteria Penilaian</h4>
                    <table>
                        <tr>
                            <th>No.</th>
                            <th>Kriteria Penilaian</th>
                            <th>Bobot (%)</th>
                            <th>Skor</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Penguasaan materi terhadap analisis situasi (Kondisi mitra saat ini, persoalan umum yang dihadapi mitra)</td>
                            <td>20</td>
                            <td><input type="number" name="skor_1" min="1" max="7" required></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Permasalahan prioritas mitra dan Solusi yang ditawarkan (kecocokan permasalahan, Solusi dan kompetensi tim)</td>
                            <td>15</td>
                            <td><input type="number" name="skor_2" min="1" max="7" required></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Target luaran (jenis luaran dan spesifikasinya sesuai kegiatan yang diusulkan)</td>
                            <td>15</td>
                            <td><input type="number" name="skor_3" min="1" max="7" required></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Ketepatan metode pendekatan untuk mengatasi permasalahan, rencana kegiatan, kontribusi partisipasi mitra</td>
                            <td>20</td>
                            <td><input type="number" name="skor_4" min="1" max="7" required></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Kelayakan jurusan (Kualifikasi Tim Pelaksana, Relevansi Skill Tim, Sinergisme Tim, Pengalaman Kemasyarakatan, Organisasi, Jadwal Kegiatan, Kelengkapan Lampiran)</td>
                            <td>10</td>
                            <td><input type="number" name="skor_5" min="1" max="7" required></td>
                        </tr>
                    </table>

                    <label for="komentar">Komentar Penilai:</label>
                    <textarea id="komentar" name="komentar"></textarea><br>

                    <button type="submit">Submit Review</button>
                </form>

            </div>
        </div>
    </div>
</x-reviewer-layout>
