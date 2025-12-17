<x-admin-layout>
    <x-slot name="header">
        {{ __('Detail Laporan Kemajuan') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0"><i class="fa fa-chart-line me-2"></i>Detail Laporan Kemajuan</h3>
                    <a href="{{ route('admin.laporan-kemajuan.index') }}" class="modern-btn modern-btn-secondary">
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
                        <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Column: Reviews and Documents -->
            <div class="col-lg-8">
                <!-- Proposal Info Card -->
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                            <div>
                                <span class="badge bg-light text-muted">
                                    {{ $jenis }} Tahap {{ $laporan->tahap }}
                                </span>
                                <h3 class="mt-3 mb-1">{{ $proposal->judul ?? '-' }}</h3>
                                <p class="text-muted mb-0">
                                    Oleh <strong>{{ $laporan->user->name ?? '-' }}</strong>
                                    <span class="mx-2">•</span>
                                    Diunggah {{ $laporan->created_at->format('d M Y H:i') }}
                                </p>
                            </div>
                        </div>

                        <div class="row mt-4 g-3">
                            <div class="col-md-6">
                                <div class="info-tile h-100">
                                    <span class="label">Skema</span>
                                    <span class="value">{{ $proposal->skema ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-tile h-100">
                                    <span class="label">Status Laporan</span>
                                    <span class="value">{{ ucfirst($laporan->status ?? 'Draft') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review Results -->
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0"><i class="fa fa-clipboard-check me-2"></i>Hasil Monitoring & Evaluasi</h4>
                            <span class="text-muted small">{{ $laporan->reviews->count() }} review</span>
                        </div>

                        @forelse($laporan->reviews as $index => $review)
                            <div class="border rounded-3 p-4 mb-4 bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                                    <div>
                                        <h5 class="fw-bold mb-0">Reviewer {{ $index + 1 }}</h5>
                                        <small class="text-muted">{{ $review->reviewer->name ?? 'Reviewer' }}</small>
                                    </div>
                                    <span class="badge bg-white text-dark border">
                                        {{ $review->updated_at->format('d M Y') }}
                                    </span>
                                </div>

                                <div class="modern-table-container mb-3">
                                    <table class="modern-table table-sm">
                                        @if($review->jenis == 'penelitian')
                                            <thead>
                                                <tr>
                                                    <th style="width: 40%">Komponen Penilaian</th>
                                                    <th>Komentar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($review->items as $item)
                                                    <tr>
                                                        <td>{{ $item->formPenilaian->komponen_penilaian ?? '-' }}</td>
                                                        <td>{{ $item->komentar ?? '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        @else
                                            {{-- Struktur tabel lengkap untuk pengabdian seperti di reviewer --}}
                                            @php
                                                $formPengabdian = $formPengabdianPerReview[$review->id] ?? null;
                                            @endphp
                                            @if(isset($formPengabdian) && $formPengabdian->count() > 0)
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50px;">No</th>
                                                        <th>Komponen</th>
                                                        <th>Sub Komponen</th>
                                                        <th style="width: 120px; text-align: center;">Nilai</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php 
                                                        $rowNumber = 1;
                                                        $reviewItemsMap = [];
                                                        foreach ($review->items as $item) {
                                                            $reviewItemsMap[$item->form_penilaian_laporan_kemajuan_id] = $item;
                                                        }
                                                    @endphp
                                                    @foreach($formPengabdian as $kategori => $komponenList)
                                                        @php
                                                            // Calculate total rows for this kategori (including kategori header)
                                                            $kategoriTotalRows = 1; // 1 for kategori header row
                                                            foreach ($komponenList as $komponen) {
                                                                $subCount = $komponen->subKomponen->count();
                                                                $kategoriTotalRows += $subCount > 0 ? $subCount : 1;
                                                            }
                                                        @endphp
                                                        {{-- Kategori Header Row --}}
                                                        <tr class="kategori-header-row">
                                                            <td rowspan="{{ $kategoriTotalRows }}">{{ $rowNumber }}</td>
                                                            <td colspan="3" class="kategori-header-cell" style="text-align: center;">
                                                                <strong>{{ $kategori ?? '-' }}</strong>
                                                            </td>
                                                        </tr>
                                                        @foreach($komponenList as $komponen)
                                                            @php
                                                                $subKomponenCount = $komponen->subKomponen->count();
                                                                $komponenRowspan = $subKomponenCount > 0 ? $subKomponenCount : 1;
                                                                $komponenFirstRow = true;
                                                                $reviewItem = $reviewItemsMap[$komponen->id] ?? null;
                                                                $selectedSubId = $reviewItem->form_penilaian_laporan_kemajuan_sub_id ?? null;
                                                            @endphp
                                                            @if($subKomponenCount > 0)
                                                                @foreach($komponen->subKomponen as $sub)
                                                                    <tr>
                                                                        @if($komponenFirstRow)
                                                                            <td rowspan="{{ $komponenRowspan }}"><strong>{{ $komponen->komponen_penilaian }}</strong></td>
                                                                            @php $komponenFirstRow = false; @endphp
                                                                        @endif
                                                                        <td>{{ $sub->sub_komponen }}</td>
                                                                        <td style="text-align: center;">
                                                                            @if($selectedSubId == $sub->id && $reviewItem)
                                                                                <span class="status-badge nilai">{{ number_format($reviewItem->nilai, 2) }}</span>
                                                                            @else
                                                                                <span class="text-muted">-</span>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td><strong>{{ $komponen->komponen_penilaian }}</strong></td>
                                                                    <td class="text-muted">-</td>
                                                                    <td class="text-muted" style="text-align: center;">
                                                                        @if($reviewItem)
                                                                            <span class="status-badge nilai">{{ number_format($reviewItem->nilai, 2) }}</span>
                                                                        @else
                                                                            <span class="text-muted">-</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                        @php $rowNumber++; @endphp
                                                    @endforeach
                                                    {{-- Total Row --}}
                                                    <tr class="total-row" style="background-color: #f8f9fa; font-weight: bold;">
                                                        <td colspan="3" style="text-align: right; padding-right: 20px;">
                                                            <strong>TOTAL NILAI:</strong>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <span class="status-badge nilai" style="font-size: 1.1em; font-weight: bold;">{{ number_format($review->items->sum('nilai'), 2) }}</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            @else
                                                {{-- Fallback jika formPengabdian tidak tersedia --}}
                                                <thead>
                                                    <tr>
                                                        <th>Kriteria</th>
                                                        <th class="text-end" style="width: 80px;">Skor</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($review->items as $item)
                                                        <tr>
                                                            <td>
                                                                <div class="fw-bold small">
                                                                    {{ $item->formPenilaian->komponen_penilaian ?? '' }}</div>
                                                                <div class="text-muted small">
                                                                    {{ $item->subKriteria->sub_komponen ?? 'Kriteria' }}</div>
                                                            </td>
                                                            <td class="text-end fw-bold">{{ $item->nilai }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr class="bg-white">
                                                        <td class="fw-bold text-end">Total Skor</td>
                                                        <td class="fw-bold text-end text-primary">{{ $review->items->sum('nilai') }}
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            @endif
                                        @endif
                                    </table>
                                </div>

                                <div class="mt-3">
                                    <h6 class="fw-bold small text-uppercase text-muted mb-2">Komentar / Saran</h6>
                                    <div class="p-3 bg-white border rounded">
                                        <p class="mb-0 fst-italic text-muted">
                                            "{{ $review->catatan_umum ?? 'Tidak ada komentar.' }}"</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="modern-alert modern-alert-info">
                                <i class="fa fa-info-circle me-2"></i>Belum ada data review yang tersedia.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column: Files -->
            <div class="col-lg-4">
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <h5 class="mb-3"><i class="fa fa-folder-open me-2"></i>Dokumen Laporan</h5>

                        <!-- Laporan Kemajuan File -->
                        <div class="d-flex align-items-center p-3 border rounded mb-3 bg-light hover-shadow transition">
                            <i class="fa fa-file-pdf text-danger fa-2x me-3"></i>
                            <div class="flex-grow-1 overflow-hidden">
                                <h6 class="mb-0 text-truncate">Laporan Kemajuan</h6>
                                <small class="text-muted">PDF Document</small>
                            </div>
                            @if($laporan->laporan_kemajuan)
                                <a href="{{ Storage::url($laporan->laporan_kemajuan) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary ms-2">
                                    <i class="fa fa-download"></i>
                                </a>
                            @else
                                <span class="text-muted small ms-2">-</span>
                            @endif
                        </div>

                        <!-- Laporan Keuangan File -->
                        <div class="d-flex align-items-center p-3 border rounded bg-light hover-shadow transition">
                            <i class="fa fa-file-invoice-dollar text-success fa-2x me-3"></i>
                            <div class="flex-grow-1 overflow-hidden">
                                <h6 class="mb-0 text-truncate">Laporan Keuangan</h6>
                                <small class="text-muted">Tahap 1</small>
                            </div>
                            @if($laporan->laporan_keuangan_tahap_1)
                                <a href="{{ Storage::url($laporan->laporan_keuangan_tahap_1) }}" target="_blank"
                                    class="btn btn-sm btn-outline-success ms-2">
                                    <i class="fa fa-download"></i>
                                </a>
                            @else
                                <span class="text-muted small ms-2">-</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <h5 class="mb-3"><i class="fa fa-user-circle me-2"></i>Informasi Peneliti</h5>
                        <div class="text-center mb-3">
                            <div class="avatar-circle mx-auto mb-2 bg-primary text-white d-flex align-items-center justify-content-center display-6 fw-bold"
                                style="width: 64px; height: 64px; border-radius: 50%;">
                                {{ substr($laporan->user->name ?? 'U', 0, 1) }}
                            </div>
                            <h6 class="fw-bold mb-0">{{ $laporan->user->name ?? '-' }}</h6>
                            <small class="text-muted">{{ $laporan->user->email ?? '-' }}</small>
                        </div>
                        <hr class="my-3">
                        <ul class="list-unstyled mb-0 text-muted small">
                            <li class="mb-2 d-flex justify-content-between">
                                <span><i class="fa fa-id-card me-2 text-primary"></i>NIDN/NIP</span>
                                <span
                                    class="fw-semibold text-dark">{{ $laporan->user->nidn ?? $laporan->user->nip ?? '-' }}</span>
                            </li>
                            <li class="mb-2 d-flex justify-content-between">
                                <span><i class="fa fa-university me-2 text-primary"></i>Prodi</span>
                                <span
                                    class="fw-semibold text-dark">{{ $laporan->user->prodi->nama_prodi ?? '-' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .info-tile {
            padding: 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: #f9fafb;
        }

        .info-tile .label {
            display: block;
            font-size: 0.78rem;
            text-transform: uppercase;
            color: #6b7280;
            letter-spacing: .05em;
        }

        .info-tile .value {
            font-size: 1rem;
            font-weight: 600;
            color: #111827;
        }

        .hover-shadow:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .transition {
            transition: all 0.2s ease;
        }

        /* Styling untuk tabel monev pengabdian */
        .status-badge.nilai {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
            border: 1px solid #3b82f6;
            text-transform: none;
            letter-spacing: 0.02em;
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            font-weight: 600;
            display: inline-block;
        }

        .kategori-header-cell {
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.75rem 1.5rem;
            border-top: 1px solid rgba(226, 232, 240, 0.8);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            background-color: #f8f9fa;
        }

        .kategori-header-row td:first-child {
            border-right: 1px solid rgba(226, 232, 240, 0.5);
        }

        /* Border vertikal untuk semua kolom */
        .modern-table thead th:not(:last-child),
        .modern-table tbody td:not(:last-child) {
            border-right: 1px solid rgba(226, 232, 240, 0.5);
        }

        /* Border horizontal untuk semua baris termasuk komponen dan sub komponen */
        .modern-table tbody tr {
            border-bottom: 1px solid rgba(226, 232, 240, 0.5) !important;
        }

        .modern-table tbody td {
            border-bottom: 1px solid rgba(226, 232, 240, 0.5) !important;
        }

        /* Pastikan baris terakhir kategori tidak memiliki border bottom (kecuali total-row) */
        .modern-table tbody tr:last-child:not(.total-row) {
            border-bottom: none !important;
        }

        .modern-table tbody tr:last-child:not(.total-row) td {
            border-bottom: none !important;
        }

        .total-row {
            background-color: #f8f9fa !important;
            border-top: 2px solid #3b82f6 !important;
            border-bottom: 2px solid #3b82f6 !important;
        }

        .total-row td {
            padding: 1rem !important;
            font-size: 1.05em;
        }
    </style>
</x-admin-layout>