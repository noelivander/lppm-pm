<!DOCTYPE html>
<html>
    <head>
        <style>
            body {
                font-family: 'Times New Roman', Times, serif;
                font-size: 0.8rem;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 0px;
            }

            /* Tabel tanpa garis */
            .no-border-table td {
                border: none;
                padding: 2.5px;
            }

            /* Tabel dengan garis */
            .bordered-table, .bordered-table th, .bordered-table td {
                border: 1px solid black;
            }

            .bordered-table th, .bordered-table td {
                padding: 6px;
                text-align: left;
            }

            .bordered-table th {
                background-color: #f2f2f2;
                font-weight: bold;
                text-align: center;
            }

            .label {
                width: 30%; /* Lebar kolom label */
                font-weight: bold;
                vertical-align: top;
            }

            .value {
                width: 60%; /* Lebar kolom nilai */
            }
            hr {
                color: #000000;
                height: 3px;
                width: 100%; /* 80% of the page width */
                margin: 10px auto; /* Center the line with some space above and below */
            }
        </style>
    </head>
    <body>
        <div class="header" style="margin-bottom:-1rem;">
            <h2>FORMULIR PENILAIAN PEMBAHASAN PROPOSAL PENGABDIAN DOSEN PEMULA TAHUN 2024 <hr></h2>
        </div>

        <!-- Tabel informasi (tanpa garis) -->
        <table class="no-border-table">
            <tr>
                <td style="vertical-align: top;">Judul Penelitian :</td>
                <td class="value" style="text-align: justify;">{{ $review->judul_kegiatan }}</td>
            </tr>
            <tr>
                <td>Bidang Unggulan PT :</td>
                <td class="value">{{ $review->bidang_unggulan }}</td>
            </tr>
            <tr>
                <td>Topik Unggulan Fakultas / Program Studi :</td>
                <td class="value">{{ $review->topik_unggulan }}</td>
            </tr>
            <tr>
                <td>Ketua Peneliti</td>
                <td class="value">
                    <tr>
                        <td style="padding-left: 25px;">a. Nama Lengkap :</td>
                        <td class="value">{{ $review->ketua_tim }}</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 25px;">b. NIDN :</td>
                        <td class="value">{{ $review->nidn }}</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 25px;">c. Jabatan Fungsional :</td>
                        <td class="value">{{ $review->jabatan }}</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 25px;">d. H-Index (Scopus) :</td>
                        <td class="value">{{ $review->scopus }}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding-left: 25px;">e. Anggota Peneliti :</td>
                        <td class="value">
                            <ol>
                                @php
                                    $anggotaList = explode(',', $review->anggota);
                                @endphp
                                @foreach($anggotaList as $anggota)
                                    <li>{{ trim($anggota) }}</li>
                                @endforeach
                            </ol>
                        </td>
                    </tr>
                </td>
            </tr>
            <tr>
                <td>Keseluruhan Biaya Penelitian</td>
                <td class="value">
                    <tr>
                        <td style="padding-left: 25px;">a. Usul Penelitian :</td>
                        <td class="value">Rp. {{ number_format($review->biaya_usulan, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 25px;">b. Direkomendasikan :</td>
                        <td class="value">
                            @if($review->biaya_disarankan)
                                Rp. {{ number_format($review->biaya_disarankan, 0, ',', '.') }}
                            @else
                                &nbsp; <!-- Menampilkan spasi kosong -->
                            @endif
                        </td>
                    </tr>
                    
                </td>
            </tr>
        </table><br>
        
        <table class="bordered-table" style="margin-bottom: 0.3rem";>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kriteria Penilaian</th>
                    <th>Bobot (%)</th>
                    <th>Skor</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Penguasaan materi dan keterkaitan antara usulan penelitian dengan Topik Penelitian ITH</td>
                    <td>20</td>
                    <td>{{ $review->skor_1 }}</td>
                    <td>{{ $review->skor_1 * 20 }}</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Kesesuaian latar belakang, permasalahan, dan tujuan serta kemutakhiran pustaka</td>
                    <td>20</td>
                    <td>{{ $review->skor_2 }}</td>
                    <td>{{ $review->skor_2 * 20 }}</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>
                        <span>Metode Penelitian:</span><br>
                        <span>a. Makna Ilmiah</span><br>
                        <span>b. Orisinalitas</span><br>
                        <span>c. Pola pendekatan dan Kesesuaian mode</span><br>
                    </td>
                    <td>20</td>
                    <td>{{ $review->skor_3 }}</td>
                    <td>{{ $review->skor_3 * 20 }}</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Memiliki peta jalan (roadmap) penelitian</td>
                    <td>10</td>
                    <td>{{ $review->skor_4 }}</td>
                    <td>{{ $review->skor_4 * 10 }}</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>
                        <span>Potensi tercapainya luaran:</span><br>
                        <span>a. Produk/Proses teknologi</span><br>
                        <span>b. Publikasi, HAKI, Buku ajar, Teknologi tepat guna, Model/kebijakan, Rekayasa sosial, dan lain-lain</span><br>
                        <span>c. Pengkajian, pengembangan dan penerapan IPTEKS-SOSBUD</span>
                    </td>
                    <td>30</td>
                    <td>{{ $review->skor_5 }}</td>
                    <td>{{ $review->skor_5 * 30 }}</td>
                </tr>
                <tr>
                    <td colspan="2">Jumlah</td>
                    <td>100</td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <small>Keterangan :<br> Skor: 1, 2, 3, 4, 5, 6, 7 (1 = Buruk; 2 = Sangat Kurang; 3 = Kurang; 4 = Cukup; 5 = Baik; 6 = Sangat Baik; 7 = Sangat Baik);<br> Nilai = Bobot x Skor;</small>

        <h4 style="margin-bottom: 0.4rem;"><br>Komentar Penilai :</h4>
        <p style="margin-top: 0; text-align: justify;">
            @if($review->komentar)
                {{ $review->komentar }}
            @else
                ........................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................
            @endif
        </p>


        <div style="float: right; text-align: right;">
            <p style='margin-right: 10rem;'>Parepare,</p>
            <p>Reviewer, {{ $review->reviewer_name }}</p>
            <br><br><br>
            <p>(Prof. Dr. Eng. Ir. Intan Sari Areni, S.T., M.T., IPU)</p>
        </div>
        
    </body>
</html>
