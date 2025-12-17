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
                                                                {{ $item->subKriteria->keterangan ?? 'Kriteria' }}</div>
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
    </style>
</x-admin-layout>