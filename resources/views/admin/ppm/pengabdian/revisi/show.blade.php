<x-admin-layout>
    <x-slot name="header">
        {{ __('Detail Revisi Proposal Pengabdian') }}
    </x-slot>

    @php
        $statusClass = match($proposal->status) {
            'Selesai' => 'selesai',
            'Diproses' => 'diproses',
            default => 'pending',
        };
        $anggotaList = $proposal->anggota ?? collect();
        $rabItems = $proposal->rab ?? collect();
        $initialReviews = $initialReviews ?? collect();
    @endphp

    <div class="container-fluid pb-5">
        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0"><i class="fa fa-file-alt me-2"></i>Detail Proposal Revisi</h3>
                    <a href="{{ route('pengabdian-adm.revisi.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0"><i class="fa fa-file-alt me-2"></i>Ringkasan Review Reviewer (Tahap Awal)</h4>
                            <span class="text-muted small">{{ $initialReviews->count() }} review</span>
                        </div>

                        @if($initialReviews->count())
                            <div class="row">
                                @foreach($initialReviews as $index => $rev)
                                    <div class="col-md-6 mb-4">
                                        <div class="modern-card h-100">
                                            <div class="modern-card-body">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <div>
                                                        <div class="small text-muted">Reviewer {{ $index + 1 }}</div>
                                                        <div class="fw-bold">{{ $rev->reviewer->name ?? $rev->reviewer_name ?? 'Reviewer' }}</div>
                                                    </div>
                                                    <span class="badge bg-light text-muted">
                                                        {{ optional($rev->updated_at ?? $rev->created_at)->format('d M Y') ?? '-' }}
                                                    </span>
                                                </div>

                                                <div class="modern-table-container mb-3">
                                                    <table class="modern-table">
                                                        <thead>
                                                        <tr>
                                                            <th>Kriteria</th>
                                                            <th>Bobot</th>
                                                            <th>Skor</th>
                                                            <th>Nilai</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>Penguasaan materi & keterkaitan</td>
                                                            <td>20%</td>
                                                            <td>{{ $rev->skor_1 ?? '-' }}</td>
                                                            <td>{{ $rev->skor_1 ? ($rev->skor_1 * 20) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Kesesuaian latar belakang & tujuan</td>
                                                            <td>20%</td>
                                                            <td>{{ $rev->skor_2 ?? '-' }}</td>
                                                            <td>{{ $rev->skor_2 ? ($rev->skor_2 * 20) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Metode pengabdian</td>
                                                            <td>20%</td>
                                                            <td>{{ $rev->skor_3 ?? '-' }}</td>
                                                            <td>{{ $rev->skor_3 ? ($rev->skor_3 * 20) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Peta jalan</td>
                                                            <td>10%</td>
                                                            <td>{{ $rev->skor_4 ?? '-' }}</td>
                                                            <td>{{ $rev->skor_4 ? ($rev->skor_4 * 10) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Potensi luaran</td>
                                                            <td>30%</td>
                                                            <td>{{ $rev->skor_5 ?? '-' }}</td>
                                                            <td>{{ $rev->skor_5 ? ($rev->skor_5 * 30) : '-' }}</td>
                                                        </tr>
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td class="fw-bold">Total</td>
                                                            <td class="fw-bold">100%</td>
                                                            <td class="fw-bold">
                                                                {{ ($rev->skor_1 ?? 0) + ($rev->skor_2 ?? 0) + ($rev->skor_3 ?? 0) + ($rev->skor_4 ?? 0) + ($rev->skor_5 ?? 0) }}
                                                            </td>
                                                            <td class="fw-bold">
                                                                {{ (($rev->skor_1 ?? 0) * 20) + (($rev->skor_2 ?? 0) * 20) + (($rev->skor_3 ?? 0) * 20) + (($rev->skor_4 ?? 0) * 10) + (($rev->skor_5 ?? 0) * 30) }}
                                                            </td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>


                                                @if($rev->komentar)
                                                    <div class="mb-0">
                                                        <h6 class="mb-1">Komentar Reviewer</h6>
                                                        <p class="text-muted mb-0">{{ $rev->komentar }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="modern-alert modern-alert-info mb-0">
                                <i class="fa fa-info-circle me-2"></i>Belum ada data review awal dari reviewer.
                            </div>
                        @endif
                    </div>
                </div>

                @if (session('success'))
                    <div class="modern-alert modern-alert-success mb-3">
                        <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="modern-alert modern-alert-danger mb-3">
                        <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                            <div>
                                <span class="badge bg-light text-muted">
                                    Revisi untuk periode {{ $proposal->created_at?->format('Y') ?? '-' }}
                                </span>
                                <h3 class="mt-3 mb-1">{{ $proposal->judul }}</h3>
                                <p class="text-muted mb-0">
                                    Oleh <strong>{{ $proposal->user->name ?? '-' }}</strong>
                                    <span class="mx-2">•</span>
                                    Diperbarui {{ $proposal->updated_at?->format('d M Y H:i') ?? '-' }}
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
                                    <span class="label">Biaya Diusulkan</span>
                                    <span class="value">Rp {{ number_format($proposal->biaya_diusulkan ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-tile h-100">
                                    <span class="label">Durasi</span>
                                    <span class="value">{{ $proposal->lama_penelitian ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-tile h-100">
                                    <span class="label">Status Proposal Asli</span>
                                    <span class="value">{{ $originalProposal?->status ?? 'Disetujui' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-tile h-100">
                                    <span class="label">Luaran Wajib</span>
                                    <span class="value">{{ $proposal->luaran_wajib ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-tile h-100">
                                    <span class="label">Luaran Tambahan</span>
                                    <span class="value">{{ $proposal->luaran_tambahan ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 border rounded-3 mt-4">
                            <span class="text-muted text-uppercase small fw-semibold d-block mb-2">Ringkasan Proposal</span>
                            <p class="mb-0 text-muted">{{ $proposal->ringkasan_proposal ?? 'Ringkasan belum tersedia.' }}</p>
                        </div>
                    </div>
                </div>

                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
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
                                <i class="fa fa-info-circle me-2"></i>Data anggota belum tersedia.
                            </div>
                        @endif
                    </div>
                </div>

                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0"><i class="fa fa-money-bill-wave me-2"></i>Rencana Anggaran Biaya</h4>
                        </div>
                        @if($rabItems->count())
                            <div class="modern-table-container">
                                <table class="modern-table">
                                    <thead>
                                        <tr>
                                            <th>Kelompok</th>
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
                                <i class="fa fa-info-circle me-2"></i>Belum ada data RAB pada revisi ini.
                            </div>
                        @endif
                    </div>
                </div>

                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <h4 class="mb-3"><i class="fa fa-file-pdf me-2"></i>Dokumen Proposal Revisi</h4>
                        @if($fileUrl)
                            <iframe src="{{ $fileUrl }}" style="width: 100%; height: 700px; border: 1px solid #e5e7eb; border-radius: 12px;"></iframe>
                        @else
                            <div class="modern-alert modern-alert-warning">
                                <i class="fa fa-exclamation-triangle me-2"></i>Dokumen proposal tidak ditemukan.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <h5 class="mb-3"><i class="fa fa-info-circle me-2"></i>Informasi Revisi</h5>
                        <div class="info-tile mb-3">
                            <span class="label">Judul Proposal Asli</span>
                            <span class="value">{{ $originalProposal?->judul ?? '-' }}</span>
                        </div>
                        <ul class="list-unstyled mb-0 text-muted small">
                            <li class="mb-2">
                                <i class="fa fa-calendar me-2 text-primary"></i>
                                Unggahan revisi: {{ $proposal->created_at?->format('d M Y H:i') ?? '-' }}
                            </li>
                            <li class="mb-2">
                                <i class="fa fa-user me-2 text-primary"></i>
                                Pengusul: {{ $proposal->user->name ?? '-' }}
                            </li>
                            <li class="mb-0">
                                <i class="fa fa-calendar-check me-2 text-primary"></i>
                                Tahun usulan revisi: <strong>{{ $proposal->created_at?->format('Y') ?? '-' }}</strong>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <h5 class="mb-3"><i class="fa fa-comment-dots me-2"></i>Komentar Admin Sebelumnya</h5>
                        @if($originalProposal?->admin_comment)
                            <div class="modern-alert modern-alert-info mb-2">
                                <i class="fa fa-info-circle me-2"></i>{{ $originalProposal->admin_comment }}
                            </div>
                            <p class="text-muted small mb-0">
                                Status admin: <strong>{{ $originalProposal->admin_status === 'approved' ? 'Disetujui' : ($originalProposal->admin_status === 'rejected' ? 'Ditolak' : '-') }}</strong>
                            </p>
                        @else
                            <div class="modern-alert modern-alert-warning mb-0">
                                <i class="fa fa-info-circle me-2"></i>Tidak ada catatan admin pada proposal asli.
                            </div>
                        @endif
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
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .status-badge.selesai {
            background: #dcfce7;
            color: #166534;
        }
        .status-badge.diproses {
            background: #fef9c3;
            color: #854d0e;
        }
        .status-badge.pending {
            background: #e5e7eb;
            color: #4b5563;
        }
        .timeline {
            position: relative;
            padding-left: 1.5rem;
        }
        .timeline:before {
            content: '';
            position: absolute;
            left: 0.4rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e5e7eb;
        }
        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }
        .timeline-marker {
            position: absolute;
            left: 0;
            top: 0.45rem;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #2563eb;
        }
        .timeline-content {
            margin-left: 1.25rem;
        }
    </style>
</x-admin-layout>

 