<x-reviewer-layout>
    <x-slot name="header">
        {{ __('Tinjau Laporan Kemajuan Pengabdian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-lg-10 col-xl-9 mx-auto">
                <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h3 class="mb-0 d-flex align-items-center gap-2">
                        <i class="fa fa-eye"></i>
                        <span>Tinjau Laporan Kemajuan</span>
                    </h3>
                    <a href="{{ route('pengabdian-rev.laporan-kemajuan.index') }}" class="modern-btn modern-btn-outline">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                @if(session('error'))
                    <div class="modern-alert modern-alert-danger mb-4">
                        <i class="fa fa-exclamation-triangle me-2"></i>{{ session('error') }}
                    </div>
                @endif

                <div class="modern-card p-4 mb-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                        <div>
                            <p class="text-muted text-uppercase small fw-semibold mb-1">Judul Proposal</p>
                            <h4 class="fw-bold mb-1">{{ $proposal->judul ?? '-' }}</h4>
                            <p class="mb-0 text-muted">
                                oleh <strong>{{ $proposal->user->name ?? '-' }}</strong>
                            </p>
                        </div>
                        <div class="text-md-end">
                            <p class="text-muted text-uppercase small fw-semibold mb-1">Skema</p>
                            <span class="status-badge skema">{{ $proposal->revisionParent->skema ?? $proposal->skema ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="row mt-4 g-3">
                        <div class="col-md-4">
                            <p class="text-muted text-uppercase small fw-semibold mb-1">Status Laporan</p>
                            @php
                                $statusDisplay = $latestLaporan->status === 'Pending' ? 'Pending' : 'Selesai';
                                $statusClass = $statusDisplay === 'Selesai' ? 'selesai' : 'pending';
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ $statusDisplay }}</span>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted text-uppercase small fw-semibold mb-1">Tahap</p>
                            <div class="fw-semibold">{{ $latestLaporan->tahap ?? '-' }}</div>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted text-uppercase small fw-semibold mb-1">Tanggal Upload</p>
                            <div class="fw-semibold">{{ optional($latestLaporan->created_at)->format('d M Y H:i') ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="modern-card p-4 mb-4">
                    <h5 class="fw-semibold mb-3">Lampiran</h5>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div>
                                <p class="mb-0 fw-semibold">Laporan Kemajuan</p>
                                <small class="text-muted">File utama kemajuan kegiatan</small>
                            </div>
                            @if($latestLaporan->laporan_kemajuan)
                                <a href="{{ asset('storage/' . $latestLaporan->laporan_kemajuan) }}" target="_blank" class="modern-btn modern-btn-primary modern-btn-sm">
                                    <i class="fa fa-file-pdf me-1"></i> Lihat Dokumen
                                </a>
                            @else
                                <span class="text-muted small">Belum tersedia</span>
                            @endif
                        </div>
                        <div class="list-group-item px-0 d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div>
                                <p class="mb-0 fw-semibold">Laporan Keuangan Tahap 1</p>
                                <small class="text-muted">Dokumen realisasi penggunaan dana</small>
                            </div>
                            @if($latestLaporan->laporan_keuangan_tahap_1)
                                <a href="{{ asset('storage/' . $latestLaporan->laporan_keuangan_tahap_1) }}" target="_blank" class="modern-btn modern-btn-outline modern-btn-sm">
                                    <i class="fa fa-file-invoice-dollar me-1"></i> Lihat Dokumen
                                </a>
                            @else
                                <span class="text-muted small">Belum tersedia</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="modern-alert modern-alert-info">
                    <i class="fa fa-info-circle me-2"></i>
                    Form penilaian laporan kemajuan akan ditempatkan di halaman ini setelah reviewer meninjau lampiran.
                </div>
            </div>
        </div>
    </div>

    <style>
        .list-group-item {
            border: none;
        }
    </style>
</x-reviewer-layout>

