<x-dosen-layout>
    <x-slot name="header">
        {{ __('Laporan Akhir Pengabdian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3 fade-in-up">
                    @php
                        $hasWindow = $timeline && $timeline->final_submission_start_date && $timeline->final_submission_end_date;
                        $isWithinWindow = $hasWindow && $currentDate->between($timeline->final_submission_start_date, $timeline->final_submission_end_date);
                    @endphp
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                        <div>
                            <h3 class="mb-1">
                                <i class="fa fa-chart-line me-2"></i>Laporan Akhir Pengabdian
                            </h3>
                        </div>
                    </div>

                    @if (!$timeline)
                        <div class="modern-alert modern-alert-danger">
                            <i class="fa fa-exclamation-circle me-2"></i>Belum ada timeline aktif untuk laporan akhir.
                        </div>
                    @else
                        <div class="modern-alert {{ $isWithinWindow ? 'modern-alert-info' : 'modern-alert-warning' }}">
                            <i class="fa fa-clock me-2"></i>
                            Periode pengajuan laporan akhir: <strong>{{ $timeline->final_submission_start_date?->format('d M Y H:i') ?? '-' }}</strong>
                            s/d <strong>{{ $timeline->final_submission_end_date?->format('d M Y H:i') ?? '-' }}</strong>.
                            @unless($isWithinWindow)
                                <span class="ms-1">Periode pengajuan belum dimulai atau sudah berakhir.</span>
                            @endunless
                        </div>
                    @endif

                    <form method="GET" class="modern-card p-3 mb-3 filter-card">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="modern-form-label text-uppercase small fw-semibold">Cari Judul</label>
                                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" class="modern-form-input" placeholder="Cari judul proposal...">
                            </div>
                            <div class="col-md-2">
                                <label class="modern-form-label text-uppercase small fw-semibold">Skema</label>
                                <select name="skema" class="modern-form-select">
                                    <option value="">Semua Skema</option>
                                    @foreach($filterSkemas as $skemaOption)
                                        <option value="{{ $skemaOption }}" @selected(($filters['skema'] ?? '') === $skemaOption)>{{ $skemaOption }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="modern-form-label text-uppercase small fw-semibold">Tahun Usulan</label>
                                <select name="year" class="modern-form-select">
                                    <option value="">Semua Tahun</option>
                                    @foreach($filterYears as $yearOption)
                                        <option value="{{ $yearOption }}" @selected(($filters['year'] ?? '') == $yearOption)>{{ $yearOption }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="modern-form-label text-uppercase small fw-semibold">Status</label>
                                <select name="status" class="modern-form-select">
                                    <option value="">Semua Status</option>
                                    <option value="Pending" @selected(($filters['status'] ?? '') === 'Pending')>Pending</option>
                                    <option value="Diproses" @selected(($filters['status'] ?? '') === 'Diproses')>Diproses</option>
                                    <option value="Selesai" @selected(($filters['status'] ?? '') === 'Selesai')>Selesai</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex gap-2">
                                <button type="submit" class="modern-btn modern-btn-primary w-100">
                                    <i class="fa fa-filter me-1"></i> Terapkan
                                </button>
                                <a href="{{ route('pengabdian-dos.laporan-akhir.index') }}" class="modern-btn modern-btn-outline w-100">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    @if ($proposals->isEmpty())
                        <div class="modern-alert modern-alert-info">
                            <i class="fa fa-inbox me-2"></i>Belum ada proposal yang memenuhi syarat (Laporan Kemajuan Disetujui).
                        </div>
                    @else
                        <div class="modern-table-container mb-3">
                            <table class="modern-table modern-table-fixed">
                                <thead>
                                    <tr>
                                        <th class="col-no text-center">#</th>
                                        <th class="col-judul">Judul</th>
                                        <th class="col-skema">Skema</th>
                                        <th>Periode Usulan</th>
                                        <th>Tgl Upload</th>
                                        <th>Status</th>
                                        <th class="text-center">Hasil Review</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($proposals as $proposal)
                                        @php
                                            $parentProposal = $proposal->revisionParent;
                                            $laporanAkhir = \App\Models\LaporanAkhir::where('pengabdian_id', $proposal->id)->first();
                                            $hasLaporan = $laporanAkhir !== null;
                                            
                                            $reviewCount = 0;
                                            if ($hasLaporan) {
                                                $reviewCount = $reviewCounts[$laporanAkhir->id] ?? 0;
                                                
                                                if ($reviewCount == 0) {
                                                    $statusDisplay = 'Pending';
                                                    $statusClass = 'pending';
                                                } elseif ($reviewCount == 1) {
                                                    $statusDisplay = 'Diproses';
                                                    $statusClass = 'diproses';
                                                } else { // reviewCount >= 2
                                                    $statusDisplay = 'Selesai';
                                                    $statusClass = 'selesai';
                                                }
                                            }
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $proposals->firstItem() + $loop->index }}</td>
                                            <td class="col-judul">
                                                <div class="fw-bold proposal-title">{{ $proposal->judul ?? '-' }}</div>
                                            </td>
                                            <td class="col-skema">
                                                <span class="status-badge skema">{{ $parentProposal->skema ?? $proposal->skema ?? '-' }}</span>
                                            </td>
                                            <td>{{ optional($parentProposal->created_at ?? $proposal->created_at)->format('Y') ?? '-' }}</td>
                                            <td>
                                                {{ $hasLaporan ? optional($laporanAkhir->updated_at)->format('d M Y H:i') : '-' }}
                                            </td>
                                            <td>
                                                @if($hasLaporan)
                                                    <span class="status-badge {{ $statusClass }}">
                                                        {{ $statusDisplay ?? $laporanAkhir->status }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">Belum Upload</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($hasLaporan && $reviewCount >= 1)
                                                    <button class="modern-btn modern-btn-secondary modern-btn-sm" data-bs-toggle="modal" data-bs-target="#reviewLaporanModal{{ $proposal->id }}">
                                                        <i class="fas fa-search me-1"></i> Hasil Review
                                                    </button>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                @if($hasLaporan)
                                                    <a href="{{ route('pengabdian-dos.laporan-akhir.create', $proposal->id) }}" class="modern-btn modern-btn-warning modern-btn-sm">
                                                        <i class="fa fa-edit me-1"></i>Edit
                                                    </a>
                                                @else
                                                    <a href="{{ route('pengabdian-dos.laporan-akhir.create', $proposal->id) }}" class="modern-btn modern-btn-primary modern-btn-sm">
                                                        <i class="fa fa-file-alt me-1"></i>Buat Laporan
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                        </tr>

                                        <!-- Modal untuk Review Laporan Akhir -->
                                        @if($hasLaporan && $reviewCount >= 1)
                                            <div class="modal fade" id="reviewLaporanModal{{ $proposal->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content modern-card">
                                                        <div class="modal-header modern-card-header">
                                                            <h5 class="modal-title mb-0">
                                                                <i class="fa fa-search me-2"></i>Hasil Review Laporan Akhir
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body modern-card-body">
                                                            @php
                                                                $laporanReviews = \App\Models\LaporanAkhirReview::where('laporan_akhir_id', $laporanAkhir->id)
                                                                    ->where('status', 'selesai')
                                                                    ->get();
                                                            @endphp

                                                            @if ($hasLaporan && $reviewCount >= 1)
                                                                <div class="text-center py-4">
                                                                    <i class="fa fa-file-pdf fa-4x text-danger mb-3"></i>
                                                                    <h5 class="mb-3">Hasil Penilaian Laporan Akhir</h5>
                                                                    <p class="text-muted mb-4">
                                                                        Lihat hasil penilaian lengkap dari seluruh reviewer dalam satu dokumen PDF.
                                                                    </p>
                                                                    
                                                                    <a href="{{ route('pengabdian-dos.laporan-akhir.view-reviews', ['pengabdian_id' => $proposal->id]) }}" 
                                                                       class="modern-btn modern-btn-primary modern-btn-lg" target="_blank">
                                                                        <i class="fa fa-file-pdf me-2"></i> Lihat Hasil Review Lengkap
                                                                    </a>
                                                                </div>
                                                            @else
                                                                <div class="text-center py-4">
                                                                    <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                                                    <h6 class="text-muted">Review belum tersedia</h6>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="modern-btn modern-btn-secondary" data-bs-dismiss="modal">
                                                                <i class="fa fa-times me-1"></i> Tutup
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end modern-pagination">
                            {{ $proposals->links('pagination::bootstrap-5') }}
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
</x-dosen-layout>

<style>
    .filter-card {
        border: 1px solid rgba(0,0,0,0.05);
        background: #fff;
        border-radius: 16px;
    }
    .filter-card .modern-form-label {
        font-size: 0.78rem;
        letter-spacing: .04em;
        color: #6b7280;
    }
    .modern-table-container {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .modern-table-container .modern-table {
        min-width: 960px;
    }
    .modern-table.modern-table-fixed {
        table-layout: auto;
        width: 100%;
    }
    .modern-table.modern-table-fixed th,
    .modern-table.modern-table-fixed td {
        white-space: nowrap;
        vertical-align: top;
    }
    .modern-table.modern-table-fixed .col-judul {
        width: clamp(260px, 35%, 420px);
        min-width: 260px;
        max-width: 420px;
        white-space: normal;
        word-break: break-word;
        overflow-wrap: anywhere;
    }
    .modern-table.modern-table-fixed .col-judul .proposal-title {
        display: block;
        white-space: normal;
    }
    .modern-table.modern-table-fixed .col-no {
        width: 60px;
        text-align: center;
    }
    .modern-table.modern-table-fixed .col-skema {
        width: 18%;
        min-width: 180px;
    }
    .modern-table .status-badge.skema {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: .4rem .75rem;
        min-height: 38px;
        line-height: 1.2;
        white-space: nowrap;
        max-width: 100%;
    }
    .proposal-title {
        font-weight: 600;
    }
    .modern-btn.modern-btn-outline {
        border: 1px solid #d1d5db;
        background: #fff;
        color: #374151;
        transition: all .2s ease;
    }
    .modern-btn.modern-btn-outline:hover {
        border-color: #9ca3af;
        color: #111827;
        background: #f9fafb;
    }
    .modern-pagination nav {
        width: auto;
    }
    .modern-pagination nav > .d-none.flex-sm-fill {
        gap: 1rem;
        align-items: center;
    }
    .modern-pagination .pagination {
        gap: .35rem;
        align-items: center;
    }
    .modern-pagination .page-link {
        border-radius: 999px !important;
        border: none;
        background: #f3f4f6;
        color: #1f2937;
        padding: .45rem .85rem;
        font-weight: 600;
        min-width: 40px;
        text-align: center;
        transition: all .2s ease;
        box-shadow: inset 0 0 0 1px rgba(0,0,0,0.05);
    }
    .modern-pagination .page-link:hover {
        background: #e5e7eb;
        color: #111827;
        box-shadow: inset 0 0 0 1px rgba(0,0,0,0.08);
    }
    .modern-pagination .page-item.active .page-link {
        background: linear-gradient(120deg,#1f2937,#111827);
        color: #fff;
        box-shadow: 0 10px 20px rgba(17,24,39,.25);
    }
    .modern-pagination .page-link:focus {
        box-shadow: none;
    }
    
    /* Status Badge Styles */
    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.4rem 0.85rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 600;
        text-align: center;
        white-space: nowrap;
    }
    .status-badge.pending {
        background-color: #fef3c7;
        color: #92400e;
    }
    .status-badge.diproses {
        background-color: #dbeafe;
        color: #1e40af;
    }
    .status-badge.selesai {
        background-color: #d1fae5;
        color: #065f46;
    }
</style>
