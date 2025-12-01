<x-dosen-layout>
    <x-slot name="header">
        {{ __('Detail Proposal Penelitian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center mb-3">
                    <div>
                        <h3 class="mb-1">
                            <i class="fa fa-file-alt me-2"></i>{{ $penelitian->judul ?? 'Tanpa Judul' }}
                        </h3>
                        <p class="text-muted mb-0">Detail lengkap proposal penelitian yang Anda ajukan.</p>
                    </div>
                    <a href="{{ route('penelitian-dos.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>

                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="modern-card p-4 mb-4">
                            <h5 class="fw-semibold mb-3">Informasi Utama</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="text-muted small text-uppercase">Judul</div>
                                    <div class="fw-semibold">{{ $penelitian->judul ?? '-' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-muted small text-uppercase">Skema</div>
                                    <div class="fw-semibold">{{ $penelitian->skema ?? '-' }}</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-muted small text-uppercase">Status</div>
                                    <span class="status-badge 
                                        @if ($penelitian->status === 'Pending') pending
                                        @elseif ($penelitian->status === 'Diproses') diproses
                                        @elseif ($penelitian->status === 'Disetujui') selesai
                                        @elseif ($penelitian->status === 'Ditolak') ditolak
                                        @endif">
                                        {{ $penelitian->status ?? '-' }}
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-muted small text-uppercase">Periode</div>
                                    <div class="fw-semibold">{{ optional($penelitian->created_at)->format('Y') ?? '-' }}</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-muted small text-uppercase">Biaya Diusulkan</div>
                                    <div class="fw-semibold">
                                        {{ $penelitian->biaya_diusulkan ? 'Rp ' . number_format($penelitian->biaya_diusulkan, 0, ',', '.') : '-' }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="text-muted small text-uppercase">Ringkasan</div>
                                    <p class="mb-0">{{ $penelitian->ringkasan_proposal ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="modern-card p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-semibold mb-0">Anggota Tim</h5>
                                <span class="badge bg-light text-dark">{{ $penelitian->anggota->count() }} orang</span>
                            </div>

                            @if ($penelitian->anggota->isEmpty())
                                <div class="modern-alert modern-alert-info mb-0">
                                    <i class="fa fa-info-circle me-2"></i>Belum ada data anggota tim.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="modern-table">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Peran</th>
                                                <th>NIDN</th>
                                                <th>Email</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($penelitian->anggota as $anggota)
                                                <tr>
                                                    <td>{{ $anggota->nama }}</td>
                                                    <td>{{ $anggota->peran }}</td>
                                                    <td>{{ $anggota->nidn ?? '-' }}</td>
                                                    <td>{{ $anggota->email ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>

                        <div class="modern-card p-4">
                            <h5 class="fw-semibold mb-3">RAB Singkat</h5>
                            @if ($penelitian->rab->isEmpty())
                                <div class="modern-alert modern-alert-info mb-0">
                                    <i class="fa fa-info-circle me-2"></i>Belum ada data RAB.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="modern-table">
                                        <thead>
                                            <tr>
                                                <th>Kelompok</th>
                                                <th>Item</th>
                                                <th>Volume</th>
                                                <th>Biaya</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($penelitian->rab as $rab)
                                                <tr>
                                                    <td>{{ $rab->kelompok }}</td>
                                                    <td>{{ $rab->item }}</td>
                                                    <td>{{ $rab->volume ? $rab->volume . ' ' . $rab->satuan : '-' }}</td>
                                                    <td>{{ $rab->total ? 'Rp ' . number_format($rab->total, 0, ',', '.') : '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="modern-card p-4 mb-4">
                            <h5 class="fw-semibold mb-3">Dokumen Proposal</h5>
                            @if ($penelitian->dokumen_proposal)
                                <a href="{{ route('penelitian.downloadProposal', $penelitian->id) }}" class="modern-btn modern-btn-primary w-100 mb-3">
                                    <i class="fa fa-file-download me-2"></i>Unduh Proposal
                                </a>
                            @else
                                <div class="modern-alert modern-alert-warning">
                                    <i class="fa fa-exclamation-circle me-2"></i>Tidak ada berkas terunggah.
                                </div>
                            @endif

                            <div class="small text-muted">
                                <div class="d-flex justify-content-between">
                                    <span>Admin Status</span>
                                    <span class="fw-semibold text-capitalize">{{ $penelitian->admin_status ?? '-' }}</span>
                                </div>
                                <div class="mt-2">
                                    <div class="text-uppercase small">Catatan Admin</div>
                                    <p class="mb-0">{{ $penelitian->admin_comment ?? 'Belum ada catatan' }}</p>
                                </div>
                            </div>
                        </div>

                        @if ($timeline && $timeline->revision_start_date && $timeline->revision_end_date)
                            <div class="modern-card p-4">
                                <h6 class="fw-semibold mb-2">Periode Revisi</h6>
                                <p class="mb-1">
                                    <i class="fa fa-calendar-alt me-2"></i>
                                    {{ $timeline->revision_start_date->format('d M Y H:i') }} -
                                    {{ $timeline->revision_end_date->format('d M Y H:i') }}
                                </p>
                                @if ($currentDate->between($timeline->revision_start_date, $timeline->revision_end_date))
                                    <div class="modern-alert modern-alert-success mb-0">
                                        <i class="fa fa-check-circle me-2"></i>Periode revisi sedang berlangsung.
                                    </div>
                                @else
                                    <div class="modern-alert modern-alert-secondary mb-0">
                                        <i class="fa fa-clock me-2"></i>Periode revisi belum/telah berakhir.
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dosen-layout>

