<x-reviewer-layout>
    <x-slot name="header">
        {{ __('Review Penelitian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h3>Proposal Penelitian</h3>
                        <h5 class="mb-3">"{{ $proposal->judul }}"</h5>
                        <iframe src="{{ Storage::url($proposal->dokumen_proposal) }}" style="width:100%; height:700px;"></iframe>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form action="{{ route('penelitian.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="penelitian_id" value="{{ $proposal->id }}">
                            <input type="hidden" name="reviewer_id" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="reviewer_name" value="{{ auth()->user()->name }}">
                            <input type="hidden" id="judul_kegiatan" name="judul_kegiatan" value="{{ $proposal->judul }}">

                            <h3>Formulir Penilaian Proposal Penelitian</h3><br>
                            

                            <div class="form-group">
                                <div class="row">
                                    <!-- Left column (informasi) -->
                                    <div class="col-md-6">
                                        <div class="form-group d-flex align-items-baseline">
                                            <label for="ketua_tim" class="form-label" style="font-weight: bold; width: 40%;">Ketua Tim Pelaksana :</label>
                                            <div style="width: 60%;">
                                                <span class="form-text">{{ $ketuaTimName }}</span>
                                                <input type="hidden" name="ketua_tim" value="{{ $ketuaTimName }}">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group d-flex align-items-baseline">
                                            <label for="nidn" class="form-label" style="font-weight: bold; width: 40%;">NIDN :</label>
                                            <div style="width: 60%;">
                                                <span class="form-text">{{ $nidn }}</span>
                                                <input type="hidden" name="nidn" value="{{ $nidn }}">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group d-flex align-items-baseline">
                                            <label for="jabatan" class="form-label" style="font-weight: bold; width: 40%;">Jabatan :</label>
                                            <div style="width: 60%;">
                                                <span class="form-text">{{ $jabatan }}</span>
                                                <input type="hidden" name="jabatan" value="{{ $jabatan }}">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group d-flex align-items-baseline" style="margin-bottom: 10px;">
                                            <label for="anggota" class="form-label" style="font-weight: bold; width: 40%;">Anggota Peneliti :</label>
                                            <div class="form-group">
                                                <div style="width: 100%; word-wrap: break-word;">
                                                    @foreach(explode(',', $anggotaNames) as $anggota)
                                                        <span class="form-text">{{ trim($anggota) }}<br></span>
                                                    @endforeach
                                                    <input type="hidden" name="anggota" value="{{ $anggotaNames }}">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group d-flex align-items-baseline">
                                            <label for="biaya_usulan" class="form-label" style="font-weight: bold; width: 40%;">Biaya yang Diusulkan :</label>
                                            <div style="width: 60%;">
                                                <span class="form-text">Rp. {{ number_format($biayaUsulan, 0, ',', '.') }}</span>
                                                <input type="hidden" name="biaya_usulan" value="{{ $biayaUsulan }}">
                                            </div>
                                        </div>
                                    </div>
                            
                                    <!-- Right column (form Scopus and Disarankan) -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="scopus" class="form-label" style="font-weight: bold;">H-Index (Scopus):</label>
                                            <input type="text" id="scopus" name="scopus" class="form-control" style="margin-bottom: 20px;">
                                        </div>
                            
                                        <div class="form-group">
                                            <label for="disarankan" class="form-label" style="font-weight: bold;">Disarankan:</label>
                                            <input type="text" id="disarankan" name="disarankan" class="form-control" style="margin-bottom: 10px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <br>

                            <h4>Kriteria Penilaian</h4>
                            <table class="table table-hover table-responsive mb-4">
                                <thead class="thead-light bg-primary text-white">
                                    <tr>
                                        <th>No.</th>
                                        <th>Kriteria Penilaian</th>
                                        <th style="width: 15%;">Bobot (%)</th>
                                        <th style="width: 15%;">Skor</th>
                                        <th style="width: 15%;">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td style="text-align: left;">Penguasaan materi dan keterkaitan antara usulan penelitian dengan Topik Penelitian ITH</td>
                                        <td class="bobot">20</td>
                                        <td>
                                            <input type="number" name="skor_1" class="form-control skor" data-bobot="20" required>
                                        </td>
                                        <td>
                                            <input type="number" name="nilai_1" class="form-control nilai" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td style="text-align: left;">Kesesuaian latar belakang, permasalahan, dan tujuan serta kemutakhiran pustaka</td>
                                        <td class="bobot">20</td>
                                        <td>
                                            <input type="number" name="skor_2" class="form-control skor" data-bobot="20" required>
                                        </td>
                                        <td>
                                            <input type="number" name="nilai_2" class="form-control nilai" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td style="text-align: left;">
                                            Metode Penelitian:
                                            <ul style="padding-left: 20px; margin: 0;">
                                                <li>Makna Ilmiah</li>
                                                <li>Orisinalitas</li>
                                                <li>Pola pendekatan dan kesesuaian mode</li>
                                            </ul>
                                        </td>
                                        <td class="bobot">20</td>
                                        <td>
                                            <input type="number" name="skor_3" class="form-control skor" data-bobot="20" required>
                                        </td>
                                        <td>
                                            <input type="number" name="nilai_3" class="form-control nilai" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td style="text-align: left;">Memiliki peta jalan (roadmap) penelitian</td>
                                        <td class="bobot">10</td>
                                        <td>
                                            <input type="number" name="skor_4" class="form-control skor" data-bobot="10" required>
                                        </td>
                                        <td>
                                            <input type="number" name="nilai_4" class="form-control nilai" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td style="text-align: left;">
                                            Potensi tercapainya luaran:
                                            <ul style="padding-left: 20px; margin: 0;">
                                                <li>Publikasi Jurnal Nasional</li>
                                                <li>Produk/Proses teknologi</li>
                                                <li>Publikasi, HKI, buku ajar, teknologi tepat guna, model/kebijakan, rekayasa sosial, dan lain-lain</li>
                                                <li>Pengkajian, pengembangan, dan penerapan IPTEKS-SOSBUD</li>
                                            </ul>
                                        </td>
                                        <td class="bobot">30</td>
                                        <td>
                                            <input type="number" name="skor_5" class="form-control skor" data-bobot="30" required>
                                        </td>
                                        <td>
                                            <input type="number" name="nilai_5" class="form-control nilai" readonly>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" style="text-align: left; font-weight: bold;">Jumlah:</td>
                                        <td id="jumlah_bobot" class="text-center">100</td>
                                        <td>
                                            <input type="number" id="total_skor" class="form-control" readonly>
                                        </td>
                                        <td>
                                            <input type="number" id="total_nilai" class="form-control" readonly>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <span>Keterangan : <br>
                                <small>Skor : 1, 2, 3, 4, 5, 6, 7 (1 = Buruk; 2 = Sangat Kurang; 3 = Kurang; 5 = Cukup; 6 = Baik; 7 = Sangat Baik); <br>
                                Nilai = Bobot x Skor <br>
                                </small>
                            </span>

                            <div class="form-group">
                                <br>
                                <label for="komentar" style="font-weight: bold;">Komentar Penilai:</label>
                                <textarea id="komentar" name="komentar" class="form-control" oninput="updateWordCount()"></textarea>
                                <div id="wordCount" class="text-muted small">0/120 words</div> <!-- Word count will be displayed here -->
                            </div>
                            
                            <script>
                            // Function to count words
                            function countWords(text) {
                                const words = text.trim().split(/\s+/).filter(function(word) {
                                    return word.length > 0;
                                });
                                return words.length;
                            }
                            
                            // Function to update word count and limit it
                            function updateWordCount() {
                                const komentarText = document.getElementById('komentar').value;
                                const wordCount = countWords(komentarText);
                                
                                // Limit the text to 120 words
                                if (wordCount > 120) {
                                    document.getElementById('komentar').value = komentarText.split(/\s+/).slice(0, 120).join(' ');
                                    document.getElementById('wordCount').textContent = "120/120 words";
                                } else {
                                    document.getElementById('wordCount').textContent = `${wordCount}/120 words`;
                                }
                            }
                            </script>
                            

                            <br><button type="submit" class="btn btn-success mt-3" id="submitProposal">Submit Penilaian</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.skor').forEach(input => {
            input.addEventListener('input', function () {
                const bobot = parseInt(this.dataset.bobot);
                const nilaiField = this.closest('tr').querySelector('.nilai');
                const skor = parseInt(this.value);

                // Validasi rentang skor 1-7
                if (skor < 1 || skor > 7) {
                    this.value = '';
                    nilaiField.value = '';
                } else {
                    // Hitung nilai (Skor x Bobot)
                    nilaiField.value = skor * bobot;
                }

                // Update total
                updateTotals();
            });
        });

        function updateTotals() {
            let totalSkor = 0;
            let totalNilai = 0;

            document.querySelectorAll('.skor').forEach(skor => {
                totalSkor += parseInt(skor.value) || 0;
            });

            document.querySelectorAll('.nilai').forEach(nilai => {
                totalNilai += parseInt(nilai.value) || 0;
            });

            document.getElementById('total_skor').value = totalSkor;
            document.getElementById('total_nilai').value = totalNilai;
        }

        // Validasi input skor secara real-time
        document.querySelectorAll('.skor').forEach(input => {
            input.addEventListener('input', function () {
                const bobot = parseInt(this.dataset.bobot);
                const nilaiField = this.closest('tr').querySelector('.nilai');
                const skor = parseInt(this.value);

                // Validasi rentang skor 1-7
                if (skor < 1 || skor > 7 || isNaN(skor)) {
                    this.classList.add('is-invalid'); // Tambahkan highlight merah
                    nilaiField.value = '';
                } else {
                    this.classList.remove('is-invalid'); // Hapus highlight merah
                    nilaiField.value = skor * bobot;
                }

                updateTotals();
                validateForm(); // Validasi form keseluruhan
            });
        });

        // Fungsi untuk menghitung total skor dan nilai
        function updateTotals() {
            let totalSkor = 0;
            let totalNilai = 0;

            document.querySelectorAll('.skor').forEach(skor => {
                totalSkor += parseInt(skor.value) || 0;
            });

            document.querySelectorAll('.nilai').forEach(nilai => {
                totalNilai += parseInt(nilai.value) || 0;
            });

            document.getElementById('total_skor').value = totalSkor;
            document.getElementById('total_nilai').value = totalNilai;
        }

        // Fungsi untuk validasi semua skor sebelum submit
        function validateForm() {
            const skorInputs = document.querySelectorAll('.skor');
            let allValid = true;

            skorInputs.forEach(input => {
                if (!input.value || parseInt(input.value) < 1 || parseInt(input.value) > 7) {
                    input.classList.add('is-invalid');
                    allValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            // Enable/disable tombol submit berdasarkan validasi
            const submitButton = document.getElementById('submitProposal');
            submitButton.disabled = !allValid;
        }

        // Inisialisasi validasi pada load awal
        document.addEventListener('DOMContentLoaded', validateForm);

    </script>
</x-reviewer-layout>