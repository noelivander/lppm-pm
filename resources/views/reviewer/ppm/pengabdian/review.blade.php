<x-reviewer-layout>
    <x-slot name="header">
        {{ __('Review Pengabdian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0"><i class="fa fa-clipboard me-2"></i>Form Review</h3>
                    <a href="{{ route('pengabdian-rev.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                @if ($timeline && $timeline->review_start_date && $timeline->review_end_date)
                    @if ($currentDate < $timeline->review_start_date)
                        <div class="modern-alert modern-alert-warning mb-3">
                            <i class="fa fa-clock me-2"></i>Periode review akan dimulai pada <strong>{{ $timeline->review_start_date->format('d F Y H:i') }}</strong>.
                        </div>
                    @elseif ($currentDate > $timeline->review_end_date)
                        <div class="modern-alert modern-alert-danger mb-3">
                            <i class="fa fa-times-circle me-2"></i>Periode review telah berakhir pada <strong>{{ $timeline->review_end_date->format('d F Y H:i') }}</strong>. Anda tidak dapat melakukan review.
                        </div>
                    @else
                        <div class="modern-alert modern-alert-info mb-3">
                            <i class="fa fa-info-circle me-2"></i>Periode review sedang berlangsung. Akan berakhir pada <strong>{{ $timeline->review_end_date->format('d F Y H:i') }}</strong>.
                        </div>
                    @endif
                @endif

                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <h3>Proposal Pengabdian</h3>
                        <h5 class="mb-3">"{{ $judul }}"</h5>
                        <iframe src="{{ Storage::url($proposal->dokumen_proposal) }}" style="width:100%; height:700px;"></iframe>
                    </div>
                </div>

                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <form action="{{ route('pengabdian.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="pengabdian_id" value="{{ $proposal->id }}">
                            <input type="hidden" name="reviewer_id" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="reviewer_name" value="{{ auth()->user()->name }}">
                            <input type="hidden" id="judul_kegiatan" name="judul_kegiatan" value="{{ $judul }}">

                            <h3 class="mb-3"><i class="fa fa-clipboard-check me-2"></i>Formulir Penilaian Proposal Pengabdian</h3>

                            <div class="mb-4">
                                <br>
                                <h4 class="mb-3"><i class="fa fa-info-circle me-2"></i>Informasi Proposal</h4>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column p-3 border rounded-3 h-100">
                                            <span class="text-muted text-uppercase small fw-semibold">Skema</span>
                                            <span class="fw-bold">{{ $proposal->skema ?? '-' }}</span>
                                            
                                            <span class="text-muted text-uppercase small fw-semibold mt-3">Luaran Wajib</span>
                                            <span class="fw-bold">{{ $proposal->luaran_wajib ?? '-' }}</span>
                                            <span class="text-muted text-uppercase small fw-semibold mt-3">Luaran Tambahan</span>
                                            <span class="fw-bold">{{ $proposal->luaran_tambahan ?? '–' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column p-3 border rounded-3 h-100">
                                            <span class="text-muted text-uppercase small fw-semibold">Durasi</span>
                                            <span class="fw-bold">{{ $proposal->lama_penelitian ?? '-' }}</span>
                                            
                                            <span class="text-muted text-uppercase small fw-semibold mt-3">Biaya Diusulkan</span>
                                            <span class="fw-bold">Rp {{ number_format($biayaUsulan ?? 0, 0, ',', '.') }}</span>
                                            <span class="text-muted text-uppercase small fw-semibold mt-3">Status</span>
                                            <span class="fw-bold">{{ $proposal->status ?? 'Belum ditentukan' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-3 border rounded-3">
                                            <span class="text-muted text-uppercase small fw-semibold d-block mb-2">Ringkasan Proposal</span>
                                            <p class="mb-0 text-muted">{{ $proposal->ringkasan_proposal ?? 'Ringkasan belum tersedia.' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <br>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="mb-0"><i class="fa fa-users me-2"></i>Tim Pelaksana</h4>
                                    <span class="text-muted small">{{ $anggotaList->count() }} anggota</span>
                                </div>
                                @if($anggotaList->count())
                                    <div class="modern-table-container">
                                        <table class="modern-table">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Peran</th>
                                                    <th>Jabatan</th>
                                                    <th>NIDN/NIM</th>
                                                    <th>Email</th>
                                                    <th>Telepon</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($anggotaList as $anggota)
                                                    <tr>
                                                        <td>{{ $anggota->nama ?? '-' }}</td>
                                                        <td>{{ ucfirst($anggota->peran ?? '-') }}</td>
                                                        <td>{{ $anggota->jabatan ?? '-' }}</td>
                                                        <td>{{ $anggota->nidn ?? $anggota->nim ?? '-' }}</td>
                                                        <td>{{ $anggota->email ?? '-' }}</td>
                                                        <td>{{ $anggota->telepon ?? '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="modern-alert modern-alert-info">
                                        <i class="fa fa-info-circle me-2"></i>Belum ada data anggota pelaksana.
                                    </div>
                                @endif
                                <input type="hidden" name="anggota" value="{{ $anggotaNames }}">
                            </div>

                            <div class="mb-4">
                                <br>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="mb-0"><i class="fa fa-money-bill-wave me-2"></i>Rencana Anggaran Biaya</h4>
                                    
                                </div>
                                @if($rabItems->count())
                                    <div class="modern-table-container">
                                        <table class="modern-table">
                                            <thead>
                                                <tr>
                                                    <th>Kelompok RAB</th>
                                                    <th>Komponen</th>
                                                    <th>Item</th>
                                                    <th>Satuan</th>
                                                    <th class="text-end">Volume</th>
                                                    <th class="text-end">Harga Satuan</th>
                                                    <th class="text-end">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $totalRab = 0; @endphp
                                                @foreach($rabItems as $rab)
                                                    @php
                                                        $volume = (float) ($rab->volume ?? 0);
                                                        $harga = (float) ($rab->harga_satuan ?? 0);
                                                        $subtotal = $volume * $harga;
                                                        $totalRab += $subtotal;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $rab->kelompok ?? '-' }}</td>
                                                        <td>{{ $rab->komponen ?? '-' }}</td>
                                                        <td>{{ $rab->item ?? '-' }}</td>
                                                        <td>{{ $rab->satuan ?? '-' }}</td>
                                                        <td class="text-end">{{ $volume ?: '-' }}</td>
                                                        <td class="text-end">Rp {{ number_format($harga, 0, ',', '.') }}</td>
                                                        <td class="text-end">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="6" class="text-end fw-bold">Total</td>
                                                    <td class="text-end fw-bold">Rp {{ number_format($totalRab, 0, ',', '.') }}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                @else
                                    <div class="modern-alert modern-alert-info">
                                        <i class="fa fa-info-circle me-2"></i>Belum ada data RAB.
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <br>
                                <div class="row">
                                    <!-- Left column (informasi) -->
                                    <div class="col-md-6">
                                        
                                        <div class="modern-form-group">
                                            <label for="scopus" class="modern-form-label"><i class="fa fa-chart-line me-2"></i>H-Index (Scopus)</label>
                                            <input type="text" id="scopus" name="scopus" class="modern-form-input" @if(!$canReview) disabled @endif>
                                        </div>
                                    </div>
                            
                                    <!-- Right column (Biaya Disarankan) -->
                                    <div class="col-md-6">
                                        
                                        <div class="modern-form-group">
                                            <label for="disarankan" class="modern-form-label">
                                                <i class="fa fa-lightbulb me-2"></i>Biaya Disarankan (Rp)
                                            </label>
                                            <input
                                                type="text"
                                                id="disarankan"
                                                name="disarankan"
                                                class="modern-form-input"
                                                inputmode="numeric"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                placeholder="Contoh: 12000000"
                                                value="{{ old('disarankan', $biayaUsulan ?? null) }}"
                                                @if(!$canReview) disabled @endif
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <br>

                            <h4 class="mb-2"><i class="fa fa-list-check me-2"></i>Kriteria Penilaian</h4>
                            <div class="modern-table-container mb-3">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kriteria Penilaian</th>
                                        <th style="width: 15%;">Bobot (%)</th>
                                        <th style="width: 15%;">Skor</th>
                                        <th style="width: 15%;">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($formKriteria && $formKriteria->count() > 0)
                                        @foreach($formKriteria as $index => $kriteria)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td style="text-align: left;">{!! nl2br(e($kriteria->kriteria_penilaian)) !!}</td>
                                                <td class="bobot">{{ $kriteria->bobot == floor($kriteria->bobot) ? number_format($kriteria->bobot, 0) : number_format($kriteria->bobot, 2) }}</td>
                                                <td>
                                                    <input type="number" name="skor[{{ $kriteria->id }}]" class="modern-form-input skor" data-bobot="{{ $kriteria->bobot }}" data-kriteria-id="{{ $kriteria->id }}" min="1" max="7" @if(!$canReview) disabled @else required @endif>
                                                </td>
                                                <td>
                                                    <input type="number" name="nilai[{{ $kriteria->id }}]" class="modern-form-input nilai" data-kriteria-id="{{ $kriteria->id }}" readonly>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        {{-- Fallback to hardcoded form if no active form review --}}
                                        <tr>
                                            <td>1</td>
                                            <td style="text-align: left;">Penguasaan materi dan keterkaitan antara usulan penelitian dengan Topik Penelitian ITH</td>
                                            <td class="bobot">20</td>
                                            <td>
                                                <input type="number" name="skor_1" class="modern-form-input skor" data-bobot="20" @if(!$canReview) disabled @else required @endif>
                                            </td>
                                            <td>
                                                <input type="number" name="nilai_1" class="modern-form-input nilai" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td style="text-align: left;">Kesesuaian latar belakang, permasalahan, dan tujuan serta kemutakhiran pustaka</td>
                                            <td class="bobot">20</td>
                                            <td>
                                                <input type="number" name="skor_2" class="modern-form-input skor" data-bobot="20" @if(!$canReview) disabled @else required @endif>
                                            </td>
                                            <td>
                                                <input type="number" name="nilai_2" class="modern-form-input nilai" readonly>
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
                                                <input type="number" name="skor_3" class="modern-form-input skor" data-bobot="20" @if(!$canReview) disabled @else required @endif>
                                            </td>
                                            <td>
                                                <input type="number" name="nilai_3" class="modern-form-input nilai" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td style="text-align: left;">Memiliki peta jalan (roadmap) penelitian</td>
                                            <td class="bobot">10</td>
                                            <td>
                                                <input type="number" name="skor_4" class="modern-form-input skor" data-bobot="10" @if(!$canReview) disabled @else required @endif>
                                            </td>
                                            <td>
                                                <input type="number" name="nilai_4" class="modern-form-input nilai" readonly>
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
                                                <input type="number" name="skor_5" class="modern-form-input skor" data-bobot="30" @if(!$canReview) disabled @else required @endif>
                                            </td>
                                            <td>
                                                <input type="number" name="nilai_5" class="modern-form-input nilai" readonly>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" style="text-align: left; font-weight: bold;">Jumlah:</td>
                                        <td id="jumlah_bobot" class="text-center">
                                            @if($formKriteria && $formKriteria->count() > 0)
                                                {{ $formKriteria->sum('bobot') == floor($formKriteria->sum('bobot')) ? number_format($formKriteria->sum('bobot'), 0) : number_format($formKriteria->sum('bobot'), 2) }}
                                            @else
                                                100
                                            @endif
                                        </td>
                                        <td>
                                            <input type="number" id="total_skor" class="modern-form-input" readonly>
                                        </td>
                                        <td>
                                            <input type="number" id="total_nilai" class="modern-form-input" readonly>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            </div>
                            <span>Keterangan : <br>
                                <small>Skor : 1, 2, 3, 4, 5, 6, 7 (1 = Buruk; 2 = Sangat Kurang; 3 = Kurang; 5 = Cukup; 6 = Baik; 7 = Sangat Baik); <br>
                                Nilai = Bobot x Skor <br>
                                </small>
                            </span>

                            <div class="modern-form-group">
                                <br>
                                <label for="komentar" class="modern-form-label">
                                    <i class="fa fa-comment-dots me-2"></i>Komentar Penilai
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea
                                    id="komentar"
                                    name="komentar"
                                    class="modern-form-textarea"
                                    oninput="updateWordCount()"
                                    @if($canReview) required @else disabled @endif
                                >{{ old('komentar') }}</textarea>
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
                            

                            @if($canReview)
                                <br><button type="submit" class="modern-btn modern-btn-primary mt-2" id="submitProposal"><i class="fa fa-paper-plane me-1"></i> Submit Penilaian</button>
                            @else
                                <br><button type="button" class="modern-btn modern-btn-secondary mt-2" disabled>
                                    <i class="fa fa-lock me-1"></i> Periode Review Tidak Aktif
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.skor').forEach(input => {
            input.addEventListener('input', function () {
                const bobot = parseFloat(this.dataset.bobot);
                const nilaiField = this.closest('tr').querySelector('.nilai');
                const skor = parseInt(this.value);

                // Validasi rentang skor 1-7
                if (skor < 1 || skor > 7) {
                    this.value = '';
                    nilaiField.value = '';
                } else {
                    // Hitung nilai (Skor x Bobot)
                    nilaiField.value = (skor * bobot).toFixed(2);
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
                totalNilai += parseFloat(nilai.value) || 0;
            });

            document.getElementById('total_skor').value = totalSkor;
            document.getElementById('total_nilai').value = totalNilai.toFixed(2);
        }

        // Validasi input skor secara real-time
        document.querySelectorAll('.skor').forEach(input => {
            input.addEventListener('input', function () {
                const bobot = parseFloat(this.dataset.bobot);
                const nilaiField = this.closest('tr').querySelector('.nilai');
                const skor = parseInt(this.value);

                // Validasi rentang skor 1-7
                if (skor < 1 || skor > 7 || isNaN(skor)) {
                    this.classList.add('is-invalid'); // Tambahkan highlight merah
                    nilaiField.value = '';
                } else {
                    this.classList.remove('is-invalid'); // Hapus highlight merah
                    nilaiField.value = (skor * bobot).toFixed(2);
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
                totalNilai += parseFloat(nilai.value) || 0;
            });

            document.getElementById('total_skor').value = totalSkor;
            document.getElementById('total_nilai').value = totalNilai.toFixed(2);
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