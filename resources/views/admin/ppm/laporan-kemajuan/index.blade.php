<x-admin-layout>
    <x-slot name="header">
        {{ __('Monitoring Laporan Kemajuan') }}
    </x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="mb-3 fade-in-up">
                <h3 class="mb-4">
                    <i class="fa fa-chart-line me-2"></i>Monitoring Laporan Kemajuan
                </h3>

                @if(session('success'))
                    <div class="modern-alert modern-alert-success">
                        <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="modern-alert modern-alert-danger">
                        <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                    </div>
                @endif

                <form method="GET" action="{{ route('admin.laporan-kemajuan.index') }}"
                    class="modern-card p-3 mb-3 filter-card">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="modern-form-label text-uppercase small fw-semibold">Cari Judul /
                                Peneliti</label>
                            <input type="text" name="search" value="{{ request('search') }}" class="modern-form-input"
                                placeholder="Cari judul atau nama...">
                        </div>
                        <div class="col-md-3">
                            <label class="modern-form-label text-uppercase small fw-semibold">Skema</label>
                            <select name="skema" class="modern-form-select">
                                <option value="">Semua Skema</option>
                                @foreach($filterSkemas as $skema)
                                    <option value="{{ $skema }}" {{ request('skema') == $skema ? 'selected' : '' }}>
                                        {{ $skema }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="modern-form-label text-uppercase small fw-semibold">Tahun</label>
                            <select name="year" class="modern-form-select">
                                <option value="">Semua Tahun</option>
                                @foreach($filterYears as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 d-flex gap-2">
                            <button type="submit" class="modern-btn modern-btn-primary w-100">
                                <i class="fa fa-filter me-1"></i> Terapkan
                            </button>
                            <a href="{{ route('admin.laporan-kemajuan.index') }}"
                                class="modern-btn modern-btn-outline w-100 fa-center">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>

                @if ($laporanKemajuans->count() === 0)
                    <div class="modern-alert modern-alert-info">
                        <i class="fa fa-info-circle me-2"></i>Tidak ada laporan kemajuan yang ditemukan (atau belum dimonev
                        oleh 2 reviewer).
                    </div>
                @else
                    <div class="modern-table-container mb-3">
                        <table class="modern-table modern-table-fixed">
                            <thead>
                                <tr>
                                    <th class="col-no text-center">#</th>
                                    <th class="col-judul">Judul Kegiatan</th>
                                    <th class="text-center">Skema</th>
                                    <th class="text-center">Tahun</th>
                                    <th class="text-center">Disubmit Pada</th>
                                    <th class="text-center">Hasil Monev</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporanKemajuans as $index => $laporan)
                                    @php
                                        $proposal = $laporan->penelitian ?? $laporan->pengabdian;
                                        $jenis = $laporan->penelitian ? 'Penelitian' : 'Pengabdian';
                                    @endphp
                                    <tr>
                                        <td class="col-no text-center">{{ $laporanKemajuans->firstItem() + $index }}</td>
                                        <td class="col-judul">
                                            <div class="fw-bold proposal-title">{{ $proposal->judul ?? '-' }}</div>
                                            <small class="text-muted">Oleh: {{ $laporan->user->name ?? '-' }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="status-badge skema">
                                                {{ $proposal->skema ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ $laporan->created_at->year }}</td>
                                        <td class="text-center">
                                            {{ $laporan->created_at->format('d M Y') }}
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $reviewCount = $laporan->reviews()->where('status', 'selesai')->count();
                                            @endphp
                                            @if($jenis === 'Penelitian')
                                                @if($reviewCount >= 1)
                                                    <a class="modern-btn modern-btn-secondary modern-btn-sm" data-bs-toggle="modal" data-bs-target="#monevLaporanModal{{ $laporan->id }}">
                                                        <i class="fas fa-search me-1"></i> Hasil Monev
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            @else
                                                @if($reviewCount >= 2)
                                                    <a href="{{ route('admin.laporan-kemajuan.download-pdf', $laporan->id) }}"
                                                        target="_blank"
                                                        class="modern-btn modern-btn-secondary modern-btn-sm">
                                                        <i class="fa fa-download me-1"></i> Download PDF
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.laporan-kemajuan.show', $laporan->id) }}"
                                                class="modern-btn modern-btn-primary modern-btn-sm">
                                                <i class="fa fa-eye me-1"></i> Detail
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Modal untuk Monev Laporan Kemajuan (Penelitian) -->
                                    @if($jenis === 'Penelitian')
                                        @php
                                            $reviewCount = $laporan->reviews()->where('status', 'selesai')->count();
                                        @endphp
                                        @if($reviewCount >= 1)
                                            <div class="modal fade" id="monevLaporanModal{{ $laporan->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content modern-card">
                                                        <div class="modal-header modern-card-header">
                                                            <h5 class="modal-title mb-0">
                                                                <i class="fa fa-search me-2"></i>Hasil Monev Laporan Kemajuan
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body modern-card-body">
                                                            @php
                                                                $laporanReviews = \App\Models\LaporanKemajuanReview::where('laporan_kemajuan_id', $laporan->id)
                                                                    ->where('status', 'selesai')
                                                                    ->get();
                                                            @endphp

                                                            @if ($laporanReviews->count() > 0)
                                                                <div class="row">
                                                                    @foreach ($laporanReviews as $index => $laporanReview)
                                                                        <div class="col-md-6 mb-3">
                                                                            <div class="modern-card">
                                                                                <div class="modern-card-body text-center">
                                                                                    <i class="fa fa-file-alt fa-3x text-primary mb-3"></i>
                                                                                    <h6 class="mb-2">Monev {{ $index + 1 }}</h6>
                                                                                    <p class="text-muted small mb-3">Klik untuk melihat detail monev</p>
                                                                                    <a href="{{ route('admin.laporan-kemajuan.download-pdf', $laporan->id) }}?review_number={{ $index + 1 }}" 
                                                                                       target="_blank"
                                                                                       class="modern-btn modern-btn-primary">
                                                                                        <i class="fa fa-eye me-1"></i> Lihat Monev
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <div class="text-center py-4">
                                                                    <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                                                    <h6 class="text-muted">Monev belum tersedia</h6>
                                                                    <p class="text-muted">Monev akan muncul setelah laporan kemajuan dimonev oleh reviewer</p>
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
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end modern-pagination mt-2">
                        {{ $laporanKemajuans->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>

<style>
    .filter-card {
        border: 1px solid rgba(0, 0, 0, 0.05);
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
        vertical-align: middle;
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

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: .4rem .75rem;
        min-height: 38px;
        line-height: 1.2;
        white-space: nowrap;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.025em;
    }

    .status-badge.skema {
        background-color: #e0f2fe;
        /* Light Blue */
        color: #0369a1;
        /* Dark Blue */
    }

    .status-badge.selesai {
        background-color: #dcfce7;
        /* Light Green */
        color: #15803d;
        /* Dark Green */
    }

    .modern-btn.modern-btn-outline {
        border: 1px solid #d1d5db;
        background: #fff;
        color: #374151;
        transition: all .2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .modern-btn.modern-btn-outline:hover {
        border-color: #9ca3af;
        color: #111827;
        background: #f9fafb;
    }

    .fa-center {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modern-pagination nav {
        width: auto;
    }

    .modern-pagination nav>.d-none.flex-sm-fill {
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
        box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.05);
    }

    .modern-pagination .page-link:hover {
        background: #e5e7eb;
        color: #111827;
        box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.08);
    }

    .modern-pagination .page-item.active .page-link {
        background: linear-gradient(120deg, #1f2937, #111827);
        color: #fff;
        box-shadow: 0 10px 20px rgba(17, 24, 39, .25);
    }

    .modern-pagination .page-link:focus {
        box-shadow: none;
    }
</style>