<x-reviewer-layout>
    <x-slot name="header">
        {{ __('Laporan Kemajuan Pengabdian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3 fade-in-up">
                    <h3 class="mb-3 d-flex align-items-center gap-2">
                        <i class="fa fa-hands-helping"></i>
                        <span>Laporan Kemajuan Pengabdian</span>
                    </h3>

                    @php
                        $hasProgressReviewWindow = $timeline && $timeline->progress_review_start_date && $timeline->progress_review_end_date;
                        $isBeforeWindow = $hasProgressReviewWindow && $currentDate->lt($timeline->progress_review_start_date);
                        $isAfterWindow = $hasProgressReviewWindow && $currentDate->gt($timeline->progress_review_end_date);
                        $isWithinProgressReviewWindow = $hasProgressReviewWindow && $currentDate->between($timeline->progress_review_start_date, $timeline->progress_review_end_date);
                    @endphp

                    @if (!$timeline)
                        <div class="modern-alert modern-alert-danger">
                            <i class="fa fa-exclamation-circle me-2"></i>Belum ada timeline aktif untuk review laporan kemajuan.
                        </div>
                    @elseif (!$hasProgressReviewWindow)
                        <div class="modern-alert modern-alert-warning">
                            <i class="fa fa-clock me-2"></i>Periode review laporan kemajuan belum ditetapkan pada timeline aktif.
                        </div>
                    @elseif ($isBeforeWindow)
                        <div class="modern-alert modern-alert-warning">
                            <i class="fa fa-hourglass-start me-2"></i>Periode review laporan kemajuan akan dibuka pada
                            <strong>{{ $timeline->progress_review_start_date->format('d M Y H:i') }}</strong>.
                            <span class="ms-1">Hitung mundur: <span id="countdownReview"></span></span>
                        </div>
                        <script>
                            var progressCountdownDate = new Date("{{ $timeline->progress_review_start_date }}").getTime();
                        </script>
                    @elseif ($isAfterWindow)
                        <div class="modern-alert modern-alert-danger">
                            <i class="fa fa-times-circle me-2"></i>Periode review laporan kemajuan telah berakhir pada
                            <strong>{{ $timeline->progress_review_end_date->format('d M Y H:i') }}</strong>.
                        </div>
                    @else
                        <div class="modern-alert modern-alert-info">
                            <i class="fa fa-info-circle me-2"></i>Periode review laporan kemajuan sedang berlangsung hingga
                            <strong>{{ $timeline->progress_review_end_date->format('d M Y H:i') }}</strong>.
                            <span class="ms-1">Sisa waktu: <span id="countdownReview"></span></span>
                        </div>
                        <script>
                            var progressCountdownDate = new Date("{{ $timeline->progress_review_end_date }}").getTime();
                        </script>
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
                                <label class="modern-form-label text-uppercase small fw-semibold">Tahun</label>
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
                                    @foreach($statusOptions as $status)
                                        <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-flex gap-2">
                                <button type="submit" class="modern-btn modern-btn-primary w-100">
                                    <i class="fa fa-filter me-1"></i> Terapkan
                                </button>
                                <a href="{{ route('pengabdian-rev.laporan-kemajuan.index') }}" class="modern-btn modern-btn-outline w-100">Reset</a>
                            </div>
                        </div>
                    </form>

                    @if ($proposals->isEmpty())
                        <div class="modern-alert modern-alert-info">
                            <i class="fa fa-inbox me-2"></i>Belum ada laporan kemajuan pengabdian yang dapat Anda review saat ini.
                        </div>
                    @else
                        <div class="modern-table-container mb-3">
                            <table class="modern-table modern-table-fixed">
                                <thead>
                                    <tr>
                                        <th class="col-no text-center">#</th>
                                        <th class="col-judul">Judul</th>
                                        <th class="col-skema">Skema</th>
                                        <th>Tahun</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($proposals as $proposal)
                                        @php
                                            $latestLaporan = $proposal->laporanKemajuan->first();
                                            $parentProposal = $proposal->revisionParent;
                                            $skemaDisplay = $parentProposal->skema ?? $proposal->skema ?? '-';
                                            $yearDisplay = optional($parentProposal->created_at ?? $proposal->created_at)->format('Y') ?? '-';
                                            $statusDisplay = $latestLaporan->status ?? 'Pending';
                                            $statusClass = $statusDisplay === 'Selesai' ? 'selesai' : 'pending';
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $proposals->firstItem() + $loop->index }}</td>
                                            <td class="col-judul">
                                                <span class="fw-bold proposal-title">{{ $proposal->judul ?? '-' }}</span>
                                                <div class="text-muted small">Oleh: {{ $proposal->user->name ?? '-' }}</div>
                                            </td>
                                            <td class="col-skema">
                                                <span class="status-badge skema">{{ $skemaDisplay }}</span>
                                            </td>
                                            <td>{{ $yearDisplay }}</td>
                                            <td>
                                                <span class="status-badge {{ $statusClass }}">
                                                    {{ $statusDisplay }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('pengabdian-rev.laporan-kemajuan.create', $proposal->id) }}" class="modern-btn modern-btn-primary modern-btn-sm">
                                                    <i class="fa fa-eye me-1"></i> Tinjau
                                                </a>
                                            </td>
                                        </tr>
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

    <script>
        if (typeof progressCountdownDate !== 'undefined') {
            let countdownTimer = setInterval(function() {
                const now = new Date().getTime();
                const distance = progressCountdownDate - now;

                if (distance < 0) {
                    clearInterval(countdownTimer);
                    const el = document.getElementById('countdownReview');
                    if (el) {
                        el.innerHTML = 'Berakhir';
                    }
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                const el = document.getElementById('countdownReview');
                if (el) {
                    el.innerHTML = `${days}h ${hours}j ${minutes}m ${seconds}d`;
                }
            }, 1000);
        }
    </script>

    <style>
        .filter-card {
            border: 1px solid rgba(0,0,0,0.05);
            background: #fff;
            border-radius: 16px;
        }
        .modern-table-container {
            width: 100%;
            overflow-x: auto;
        }
        .modern-table.modern-table-fixed { table-layout: auto; width: 100%; min-width: 1040px; }
        .modern-table.modern-table-fixed th,
        .modern-table.modern-table-fixed td {
            white-space: nowrap;
            vertical-align: top;
        }
        .modern-table.modern-table-fixed .col-judul {
            width: clamp(260px, 35%, 420px);
            white-space: normal;
        }
        .modern-table.modern-table-fixed .col-no {
            width: 60px;
        }
        .modern-table.modern-table-fixed .col-skema {
            width: 18%;
            min-width: 200px;
        }
        .modern-table .status-badge.processing {
            background: rgba(245, 158, 11, 0.15);
            color: #b45309;
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
    </style>
</x-reviewer-layout>


