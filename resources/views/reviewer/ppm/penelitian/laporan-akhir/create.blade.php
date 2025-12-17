<x-reviewer-layout>
    <x-slot name="header">
        {{ __('Tinjau Laporan Akhir Penelitian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h3 class="mb-0 d-flex align-items-center gap-2">
                        <i class="fa fa-eye"></i>
                        <span>Tinjau Laporan Akhir</span>
                    </h3>
                    <a href="{{ route('penelitian-rev.laporan-akhir.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                @if(session('success'))
                    <div class="modern-alert modern-alert-success mb-3">
                        <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="modern-alert modern-alert-danger mb-3">
                        <i class="fa fa-exclamation-triangle me-2"></i>{{ session('error') }}
                    </div>
                @endif

                @if(!$isWithinFinalReviewWindow)
                    <div class="modern-alert modern-alert-warning mb-3">
                        <i class="fa fa-lock me-2"></i>Periode review laporan akhir tidak aktif. Form tetap dapat
                        dilihat, namun aksi simpan dinonaktifkan.
                    </div>
                @endif

                <!-- Informasi Penelitian -->
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-header">
                        <h5 class="mb-0"><i class="fa fa-info-circle me-2"></i>Informasi Penelitian</h5>
                    </div>
                    <div class="modern-card-body">
                        <div class="row g-4">
                            <div class="col-md-6 col-lg-4">
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Judul Penelitian</p>
                                <h6 class="fw-bold mb-0 text-break">{{ $proposal->judul ?? '-' }}</h6>
                            </div>
                            <div class="col-md-6 col-lg-2">
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Bidang Penelitian</p>
                                <div class="fw-semibold">{{ $bidangPenelitian }}</div>
                            </div>
                            <div class="col-md-6 col-lg-2">
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Skema</p>
                                <span class="status-badge skema">{{ $skema }}</span>
                            </div>
                            <div class="col-md-6 col-lg-2">
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Jurusan/Prodi</p>
                                <div class="fw-semibold">{{ $jurusanProdi }}</div>
                            </div>
                            <div class="col-md-6 col-lg-2">
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Lama Penelitian</p>
                                <div class="fw-semibold">{{ $lamaPenelitian ?? '-'}}</div>
                            </div>
                            <div class="col-12">
                                <hr class="my-3">
                                <p class="text-muted text-uppercase small fw-semibold mb-2">Ketua Peneliti</p>
                                @if($ketuaPeneliti)
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <span class="text-muted small">Nama Lengkap:</span>
                                            <div class="fw-semibold">{{ $ketuaPeneliti->nama ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="text-muted small">NIDN:</span>
                                            <div class="fw-semibold">{{ $ketuaPeneliti->nidn ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="text-muted small">Jabatan Fungsional:</span>
                                            <div class="fw-semibold">{{ $ketuaPeneliti->jabatan ?? '-' }}</div>
                                        </div>
                                    </div>
                                @else
                                    <div class="fw-semibold">-</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lampiran -->
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-header">
                        <h5 class="mb-0"><i class="fa fa-paperclip me-2"></i>Lampiran</h5>
                    </div>
                    <div class="modern-card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div
                                    class="d-flex flex-wrap align-items-center justify-content-between gap-2 p-3 border rounded">
                                    <div>
                                        <p class="mb-1 fw-semibold">Laporan Akhir</p>
                                        <small class="text-muted">File utama laporan akhir kegiatan</small>
                                    </div>
                                    @if($latestLaporan->laporan_akhir)
                                        <a href="{{ asset('storage/' . $latestLaporan->laporan_akhir) }}" target="_blank"
                                            class="modern-btn modern-btn-primary modern-btn-sm">
                                            <i class="fa fa-file-pdf me-1"></i> Lihat Dokumen
                                        </a>
                                    @else
                                        <span class="text-muted small">Belum tersedia</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div
                                    class="d-flex flex-wrap align-items-center justify-content-between gap-2 p-3 border rounded">
                                    <div>
                                        <p class="mb-1 fw-semibold">Laporan Keuangan Tahap 2</p>
                                        <small class="text-muted">Dokumen realisasi penggunaan dana (100%)</small>
                                    </div>
                                    @if($latestLaporan->laporan_keuangan_tahap_2)
                                        <a href="{{ asset('storage/' . $latestLaporan->laporan_keuangan_tahap_2) }}"
                                            target="_blank" class="modern-btn modern-btn-outline modern-btn-sm">
                                            <i class="fa fa-file-invoice-dollar me-1"></i> Lihat Dokumen
                                        </a>
                                    @else
                                        <span class="text-muted small">Belum tersedia</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($formPenelitian) && $formPenelitian->count() > 0)
                    <form action="{{ route('penelitian-rev.laporan-akhir.store', $proposal->id) }}" method="POST"
                        class="mb-4">
                        @csrf
                        <div class="modern-card fade-in-up">
                            <div
                                class="modern-card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <h5 class="mb-0"><i class="fa fa-clipboard-check me-2"></i>Form Penilaian Laporan Akhir</h5>
                            </div>
                            <div class="modern-card-body">
                                <div class="modern-table-container">
                                    <table class="modern-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 40px;">No</th>
                                                <th>Komponen Penilaian</th>
                                                <th style="width: 25%;">Status</th>
                                                <th style="width: 25%;">Item Penilaian</th>
                                                <th style="width: 15%;">Bobot</th>
                                                <th style="width: 80px; text-align: center;">Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($formPenelitian as $index => $item)
                                                {{-- Filter Sub Components --}}
                                                @php
                                                    $statusSubs = $item->subKomponen->where('tipe', 'status');
                                                    $itemSubs = $item->subKomponen->where('tipe', 'item');
                                                    $bobotSubs = $item->subKomponen->where('tipe', 'bobot'); // If any exist in DB

                                                    $hasBobotDb = $bobotSubs->count() > 0;

                                                    // Standard Bobot Options (Fallback if not in DB)
                                                    $standardBobot = [
                                                        ['label' => 'Sangat Baik (100%)', 'value' => 1.0],
                                                        ['label' => 'Baik (75%)', 'value' => 0.75],
                                                        ['label' => 'Cukup (50%)', 'value' => 0.50],
                                                        ['label' => 'Kurang (25%)', 'value' => 0.25],
                                                    ];

                                                    $currentStatusId = old('status.' . $item->id, $existingSelectedStatus[$item->id] ?? null);
                                                    $currentBobotVal = old('bobot.' . $item->id, $existingSelectedBobot[$item->id] ?? null);
                                                    // If bobot val works as ID, fine. If as numeric, fine.

                                                    // Calculate initial item value for display
                                                    $initStatusScore = 0;
                                                    if ($currentStatusId) {
                                                        $s = $statusSubs->firstWhere('id', $currentStatusId);
                                                        if ($s)
                                                            $initStatusScore = $s->skor;
                                                    }

                                                    $initBobotMult = 0;
                                                    if ($currentBobotVal) {
                                                        if ($hasBobotDb && $currentBobotVal > 1) { // Assume ID
                                                            $b = $bobotSubs->firstWhere('id', $currentBobotVal);
                                                            if ($b)
                                                                $initBobotMult = $b->skor / 100; // Assuming stored as 100, 75
                                                        } else {
                                                            $initBobotMult = (float) $currentBobotVal;
                                                        }
                                                    }
                                                    $initNilai = $initStatusScore * $initBobotMult;
                                                @endphp
                                                <tr class="review-row" data-item-id="{{ $item->id }}">
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <strong>{{ $item->komponen_penilaian }}</strong>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column gap-2">
                                                            @foreach($statusSubs as $status)
                                                                <div class="form-check">
                                                                    <input class="form-check-input status-radio" type="radio"
                                                                        name="status[{{ $item->id }}]"
                                                                        id="status_{{ $item->id }}_{{ $status->id }}"
                                                                        value="{{ $status->id }}" data-skor="{{ $status->skor }}" {{ $currentStatusId == $status->id ? 'checked' : '' }} required>
                                                                    <label class="form-check-label small"
                                                                        for="status_{{ $item->id }}_{{ $status->id }}">
                                                                        {{ $status->keterangan }} <span
                                                                            class="badge bg-light text-dark border ms-1">{{ (float) $status->skor }}</span>
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <ul class="ps-3 mb-0 small text-muted">
                                                            @foreach($itemSubs as $descItem)
                                                                <li>{{ $descItem->keterangan }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column gap-1">
                                                            @if($hasBobotDb)
                                                                @foreach($bobotSubs as $bobot)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input bobot-radio" type="radio"
                                                                            name="bobot[{{ $item->id }}]"
                                                                            id="bobot_{{ $item->id }}_{{ $bobot->id }}"
                                                                            value="{{ $bobot->id }}"
                                                                            data-mult="{{ $bobot->skor / 100 }}" {{ $currentBobotVal == $bobot->id ? 'checked' : '' }} required>
                                                                        <label class="form-check-label small"
                                                                            for="bobot_{{ $item->id }}_{{ $bobot->id }}">
                                                                            {{ $bobot->keterangan }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                @foreach($standardBobot as $idx => $opt)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input bobot-radio" type="radio"
                                                                            name="bobot[{{ $item->id }}]"
                                                                            id="bobot_{{ $item->id }}_{{ $idx }}"
                                                                            value="{{ $opt['value'] }}" data-mult="{{ $opt['value'] }}"
                                                                            {{ (string) $currentBobotVal === (string) $opt['value'] ? 'checked' : '' }} required>
                                                                        <label class="form-check-label small"
                                                                            for="bobot_{{ $item->id }}_{{ $idx }}">
                                                                            {{ $opt['label'] }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        <span class="status-badge nilai"
                                                            id="nilai_display_{{ $item->id }}">{{ number_format($initNilai, 2) }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            {{-- Total Row --}}
                                            <tr class="total-row" style="background-color: #f8f9fa;">
                                                <td colspan="5" style="text-align: right; padding-right: 20px;">
                                                    <strong>TOTAL NILAI:</strong>
                                                </td>
                                                <td style="text-align: center;">
                                                    <span id="total-final" class="status-badge nilai"
                                                        style="font-size: 1.1em; font-weight: bold;">0.00</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="modern-form-group mt-3">
                                    <label class="modern-form-label fw-semibold">
                                        <i class="fa fa-comment-dots me-2"></i>Catatan Tambahan
                                    </label>
                                    <textarea class="modern-form-textarea @error('catatan_umum') is-invalid @enderror"
                                        rows="4" name="catatan_umum"
                                        placeholder="Catatan umum terkait laporan akhir...">{{ old('catatan_umum', optional($existingReview)->catatan_umum) }}</textarea>
                                    @error('catatan_umum')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="action-footer d-flex flex-wrap justify-content-end">
                                    @if(!$isWithinFinalReviewWindow)
                                        <button type="button" class="modern-btn modern-btn-secondary" disabled>
                                            <i class="fa fa-lock me-1"></i> Periode review tidak aktif
                                        </button>
                                    @else
                                        @if(optional($existingReview)->status === 'selesai')
                                            <button type="submit" name="action" value="submit"
                                                class="modern-btn modern-btn-primary">
                                                <i class="fa fa-check me-1"></i> Simpan &amp; Selesaikan
                                            </button>
                                        @else
                                            <button type="submit" name="action" value="draft"
                                                class="modern-btn modern-btn-secondary">
                                                <i class="fa fa-save me-1"></i> Simpan Draft
                                            </button>
                                            <button type="submit" name="action" value="submit"
                                                class="modern-btn modern-btn-primary">
                                                <i class="fa fa-check me-1"></i> Simpan &amp; Selesaikan
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="modern-alert modern-alert-info">
                        <i class="fa fa-info-circle me-2"></i>
                        Belum ada form penilaian laporan akhir penelitian yang dikonfigurasi di admin.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .list-group-item {
            border: none;
        }

        .modern-btn.modern-btn-outline {
            border: 1px solid var(--modern-primary, #0061f2);
            color: var(--modern-primary, #0061f2);
            background-color: transparent;
        }

        .modern-btn.modern-btn-outline:hover,
        .modern-btn.modern-btn-outline:focus {
            background-color: var(--modern-primary, #0061f2);
            color: #fff;
        }

        .action-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.08);
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            gap: 0.75rem;
        }

        .status-badge.nilai {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
            border: 1px solid #3b82f6;
            text-transform: none;
            letter-spacing: 0.02em;
            font-weight: bold;
        }

        /* Border vertikal untuk semua kolom */
        .modern-table thead th:not(:last-child),
        .modern-table tbody td:not(:last-child) {
            border-right: 1px solid rgba(226, 232, 240, 0.5);
        }

        .modern-table tbody tr {
            border-bottom: 1px solid rgba(226, 232, 240, 0.5) !important;
        }

        .total-row {
            border-top: 2px solid #3b82f6 !important;
            border-bottom: 2px solid #3b82f6 !important;
        }

        .total-row td {
            font-size: 1.05em;
            padding: 1rem !important;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const rows = document.querySelectorAll('.review-row');

            function updateRowTotal(row, itemId) {
                // Find selected status
                const statusRadio = row.querySelector(`input[name="status[${itemId}]"]:checked`);
                const statusScore = statusRadio ? parseFloat(statusRadio.getAttribute('data-skor')) : 0;

                // Find selected bobot
                const bobotRadio = row.querySelector(`input[name="bobot[${itemId}]"]:checked`);
                const bobotMult = bobotRadio ? parseFloat(bobotRadio.getAttribute('data-mult')) : 0;

                const final = statusScore * bobotMult;

                const display = document.getElementById(`nilai_display_${itemId}`);
                if (display) {
                    display.textContent = final.toFixed(2);
                }
                return final;
            }

            function updateTotal() {
                let grandTotal = 0;
                rows.forEach(row => {
                    const itemId = row.getAttribute('data-item-id');
                    grandTotal += updateRowTotal(row, itemId);
                });

                const totalFinal = document.getElementById('total-final');
                if (totalFinal) {
                    totalFinal.textContent = grandTotal.toFixed(2);
                }
            }

            // Attach listeners
            const allRadios = document.querySelectorAll('input[type="radio"]');
            allRadios.forEach(radio => {
                radio.addEventListener('change', updateTotal);
            });

            // Init
            updateTotal();
        });
    </script>
</x-reviewer-layout>