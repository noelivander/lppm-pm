<x-reviewer-layout>
    <x-slot name="header">
        {{ __('Tinjau Laporan Akhir Penelitian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <!-- Header Section -->
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h3 class="fw-bold mb-1 text-primary">
                            <i class="fa fa-clipboard-check me-2"></i>Monev Laporan Akhir
                        </h3>
                        <p class="text-muted mb-0">Lakukan penilaian ketercapaian luaran penelitian.</p>
                    </div>
                    <a href="{{ route('penelitian-rev.laporan-akhir.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                @if(session('success'))
                    <div class="modern-alert modern-alert-success mb-3 fade-in-up">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-check-circle fa-lg me-3"></i>
                            <div>
                                <strong>Berhasil!</strong> {{ session('success') }}
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="modern-alert modern-alert-danger mb-3 fade-in-up">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-exclamation-triangle fa-lg me-3"></i>
                            <div>
                                <strong>Gagal!</strong> {{ session('error') }}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Info Card -->
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-header bg-soft-primary">
                        <h5 class="mb-0 fw-bold"><i class="fa fa-info-circle me-2"></i>Informasi Proposal</h5>
                    </div>
                    <div class="modern-card-body">
                        <div class="row g-4">
                            <div class="col-md-6 col-lg-8">
                                <p class="text-muted text-uppercase small fw-bold mb-1">Judul Penelitian</p>
                                <h5 class="fw-bold text-dark mb-0">{{ $proposal->judul ?? '-' }}</h5>
                            </div>
                            <div class="col-md-6 col-lg-4 text-lg-end">
                                <p class="text-muted text-uppercase small fw-bold mb-1">Total Dana Disetujui</p>
                                @php
                                    $danaDisetujui = $proposal->biaya_disetujui > 0 ? $proposal->biaya_disetujui : (optional($proposal->revisionParent)->biaya_disetujui ?? 0);
                                @endphp
                                <h5 class="fw-bold text-success mb-0">Rp {{ number_format($danaDisetujui, 0, ',', '.') }}</h5>
                            </div>
                            <div class="col-md-12">
                                <hr class="my-0">
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <p class="text-muted text-uppercase small fw-bold mb-1">Ketua Peneliti</p>
                                <div class="fw-semibold">{{ $ketuaPeneliti->nama ?? '-' }}</div>
                            </div>
                             <div class="col-md-6 col-lg-3">
                                <p class="text-muted text-uppercase small fw-bold mb-1">Bidang Fokus</p>
                                <div class="fw-semibold">{{ $bidangPenelitian }}</div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <p class="text-muted text-uppercase small fw-bold mb-1">Skema</p>
                                <span class="badge bg-soft-info text-info rounded-pill px-3">{{ $skema }}</span>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <p class="text-muted text-uppercase small fw-bold mb-1">Lama Penelitian</p>
                                <div>{{ $lamaPenelitian }} Tahun</div>
                            </div>
                        </div>
                    </div>
                </div>

                 <!-- Lampiran Section -->
                 <div class="modern-card mb-4 fade-in-up delay-100">
                    <div class="modern-card-header bg-soft-info">
                        <h5 class="mb-0 fw-bold"><i class="fa fa-file-alt me-2"></i>Dokumen Laporan</h5>
                    </div>
                    <div class="modern-card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="doc-card d-flex align-items-center p-3 border rounded-3 h-100 {{ $latestLaporan->laporan_akhir ? 'bg-soft-success border-success' : 'bg-light' }}">
                                    <div class="me-3">
                                        <div class="icon-box {{ $latestLaporan->laporan_akhir ? 'bg-success text-white' : 'bg-secondary text-white' }} rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                            <i class="fa fa-file-pdf fa-lg"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bold">Laporan Akhir Lengkap</h6>
                                        <p class="text-muted small mb-0">{{ $latestLaporan->laporan_akhir ? 'Siap diperiksa' : 'Belum diunggah' }}</p>
                                    </div>
                                    @if($latestLaporan->laporan_akhir)
                                        <a href="{{ asset('storage/' . $latestLaporan->laporan_akhir) }}" target="_blank"
                                            class="modern-btn modern-btn-sm modern-btn-success">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="doc-card d-flex align-items-center p-3 border rounded-3 h-100 {{ $latestLaporan->laporan_keuangan_tahap_2 ? 'bg-soft-warning border-warning' : 'bg-light' }}">
                                     <div class="me-3">
                                        <div class="icon-box {{ $latestLaporan->laporan_keuangan_tahap_2 ? 'bg-warning text-dark' : 'bg-secondary text-white' }} rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                            <i class="fa fa-file-invoice-dollar fa-lg"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bold">Laporan Keuangan (100%)</h6>
                                         <p class="text-muted small mb-0">{{ $latestLaporan->laporan_keuangan_tahap_2 ? 'Siap diperiksa' : 'Belum diunggah' }}</p>
                                    </div>
                                    @if($latestLaporan->laporan_keuangan_tahap_2)
                                        <a href="{{ asset('storage/' . $latestLaporan->laporan_keuangan_tahap_2) }}"
                                            target="_blank" class="modern-btn modern-btn-sm modern-btn-warning">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($formPenelitian) && $formPenelitian->count() > 0)
                    <form action="{{ route('penelitian-rev.laporan-akhir.store', $proposal->id) }}" method="POST">
                        @csrf
                        
                        <!-- Loop Komponen -->
                        @foreach($formPenelitian as $komponen)
                            @php
                                $statusSubs = $komponen->subKomponen->where('tipe', 'status');
                                $itemSubs = $komponen->subKomponen->where('tipe', 'item');
                            @endphp

                            <div class="modern-card mb-4 fade-in-up delay-200">
                                <div class="modern-card-header bg-white border-bottom py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 fw-bold text-primary">{{ $komponen->komponen_penilaian }}</h5>
                                        <div class="badge bg-secondary rounded-pill">Nilai: <span id="total_display_{{ $komponen->id }}">0.00</span></div>
                                    </div>
                                </div>
                                <div class="modern-card-body p-4">
                                    
                                    <!-- Section 1: Ketercapaian (Status) -->
                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-uppercase small text-muted mb-3">
                                            <i class="fa fa-chart-pie me-1"></i> Status Ketercapaian
                                        </label>
                                        
                                        @if($statusSubs->count() > 0)
                                            <div class="row g-3">
                                                @foreach($statusSubs as $status)
                                                    <div class="col-md-6 col-xl-2dot4"> <!-- Custom column width if possible, else col-md-4 -->
                                                        <input type="radio" class="btn-check status-radio" 
                                                            name="status[{{ $komponen->id }}]" 
                                                            id="status_{{ $status->id }}" 
                                                            value="{{ $status->id }}"
                                                            data-skor="{{ $status->skor }}"
                                                            data-komponen-id="{{ $komponen->id }}"
                                                            {{ (old('status.'.$komponen->id) == $status->id || (isset($existingStatus[$komponen->id]) && $existingStatus[$komponen->id] == $status->id)) ? 'checked' : '' }}
                                                            required>
                                                        
                                                        <label class="status-card h-100 d-flex flex-column align-items-center justify-content-center p-3 text-center border rounded-3 position-relative" for="status_{{ $status->id }}">
                                                            <div class="check-icon position-absolute top-0 end-0 m-2 text-primary opacity-0">
                                                                <i class="fa fa-check-circle"></i>
                                                            </div>
                                                            <span class="mb-2 fw-semibold">{{ $status->keterangan }}</span>
                                                            <span class="badge bg-light text-dark border">Bobot: {{ $status->skor }}%</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="alert alert-soft-secondary">Tidak ada opsi status.</div>
                                        @endif
                                    </div>

                                    <hr class="border-dashed my-4">

                                    <!-- Section 2: Penilaian Kualitas (Items) -->
                                    <div>
                                         <label class="form-label fw-bold text-uppercase small text-muted mb-3">
                                            <i class="fa fa-list-check me-1"></i> Penilaian Kualitas
                                        </label>

                                        @if($itemSubs->count() > 0)
                                            <div class="d-flex bg-light p-2 rounded-top border-bottom fw-bold small text-uppercase text-muted">
                                                <div class="flex-grow-1 px-3">Item Penilaian</div>
                                                <div class="text-center" style="width: 320px;">Berikan Skor</div>
                                            </div>
                                            <div class="list-group list-group-flush border rounded-bottom">
                                                @foreach($itemSubs as $item)
                                                    <div class="list-group-item p-3 d-flex flex-wrap align-items-center gap-3">
                                                        <div class="flex-grow-1">
                                                            <span class="fw-medium text-dark">{{ $item->keterangan }}</span>
                                                        </div>
                                                        <div class="d-flex gap-2 justify-content-end" style="width: 320px; min-width: 320px;">
                                                            @foreach([100 => 'Sangat Baik', 75 => 'Baik', 50 => 'Cukup', 25 => 'Kurang'] as $score => $label)
                                                                <input type="radio" class="btn-check item-radio" 
                                                                    name="grades[{{ $komponen->id }}][{{ $item->id }}]" 
                                                                    id="grade_{{ $item->id }}_{{ $score }}" 
                                                                    value="{{ $score }}"
                                                                    data-komponen-id="{{ $komponen->id }}"
                                                                    {{ (old('grades.'.$komponen->id.'.'.$item->id) == $score || (isset($existingGrades[$komponen->id][$item->id]) && $existingGrades[$komponen->id][$item->id] == $score)) ? 'checked' : '' }}
                                                                    required>
                                                                
                                                                <label class="btn btn-outline-grading btn-sm flex-fill position-relative" for="grade_{{ $item->id }}_{{ $score }}" title="{{ $label }}">
                                                                    <span class="score-val">{{ $score }}</span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                             <div class="alert alert-soft-secondary">Tidak ada item penilaian.</div>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        @endforeach

                        <!-- Comment & Actions -->
                        <div class="modern-card mb-5 fade-in-up delay-300">
                             <div class="modern-card-body p-4">
                                <label class="form-label fw-bold text-dark">
                                    <i class="fa fa-comment-alt me-2"></i>Catatan Tambahan Reviewer
                                </label>
                                <textarea class="modern-form-textarea" name="catatan_umum" rows="4" 
                                    placeholder="Berikan catatan atau masukan tambahan untuk peneliti (Opsional)...">{{ old('catatan_umum', $existingReview->catatan_umum ?? '') }}</textarea>
                                
                                <div class="d-flex justify-content-end gap-3 mt-4">
                                    <button type="submit" name="action" value="draft" class="modern-btn modern-btn-secondary px-4">
                                        <i class="fa fa-save me-2"></i>Simpan Draft
                                    </button>
                                     <button type="submit" name="action" value="submit" class="modern-btn modern-btn-primary px-4 shadow-sm">
                                        <i class="fa fa-paper-plane me-2"></i>Simpan & Selesaikan
                                    </button>
                                </div>
                             </div>
                        </div>

                    </form>
                @else
                    <div class="alert alert-warning">Form penilaian belum dikonfigurasi oleh admin.</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Additional CSS -->
    <style>
        .col-xl-2dot4 {
            flex: 0 0 auto;
            width: 20%;
        }
        @media (max-width: 1200px) {
            .col-xl-2dot4 { width: 33.333%; }
        }
        @media (max-width: 768px) {
            .col-xl-2dot4 { width: 50%; }
        }

        /* Status Cards */
        .status-card {
            cursor: pointer;
            transition: all 0.2s ease;
            background: #fff;
            border-color: #e2e8f0;
        }
        .status-card:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
            transform: translateY(-2px);
        }
        .btn-check:checked + .status-card {
            border-color: var(--bs-primary);
            background-color: rgba(var(--bs-primary-rgb), 0.05);
            box-shadow: 0 4px 6px -1px rgba(var(--bs-primary-rgb), 0.1);
        }
        .btn-check:checked + .status-card .check-icon {
            opacity: 1 !important;
        }
        .btn-check:checked + .status-card .badge {
            background-color: var(--bs-primary) !important;
            color: #fff !important;
            border: none !important;
        }

        /* Grading Buttons */
        .btn-outline-grading {
            border: 1px solid #e2e8f0;
            color: #64748b;
            font-weight: 600;
        }
        .btn-outline-grading:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }
        .btn-check:checked + .btn-outline-grading {
             background-color: var(--bs-primary);
             color: white;
             border-color: var(--bs-primary);
             box-shadow: 0 2px 4px rgba(var(--bs-primary-rgb), 0.2);
        }

        .border-dashed {
            border-top-style: dashed !important;
        }
    </style>

    <!-- Calc Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function calculateScore(komponenId) {
                // 1. Status
                const statusInput = document.querySelector(`input[name="status[${komponenId}]"]:checked`);
                const statusScore = statusInput ? parseFloat(statusInput.getAttribute('data-skor')) : 0;

                // 2. Average Items
                const itemInputs = document.querySelectorAll(`input[data-komponen-id="${komponenId}"].item-radio:checked`);
                let totalItems = 0;
                let countItems = 0;
                itemInputs.forEach(inp => {
                    totalItems += parseFloat(inp.value);
                    countItems++;
                });

                const avgItemScore = countItems > 0 ? (totalItems / countItems) : 0;

                // 3. Final: Avg Item * (Status% / 100)
                // Example: Items Avg 100, Status 80% (0.8) -> 80
                const final = avgItemScore * (statusScore / 100);

                const display = document.getElementById(`total_display_${komponenId}`);
                if(display) display.textContent = final.toFixed(2);
            }

            // Init calculation
            const componentIds = [...new Set([...document.querySelectorAll('.status-radio')].map(el => el.getAttribute('data-komponen-id')))];
            componentIds.forEach(id => calculateScore(id));

            // Listeners
            document.body.addEventListener('change', function(e) {
                if(e.target.classList.contains('status-radio') || e.target.classList.contains('item-radio')) {
                    const id = e.target.getAttribute('data-komponen-id');
                    if(id) calculateScore(id);
                }
            });
        });
    </script>
</x-reviewer-layout>