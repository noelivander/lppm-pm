<x-reviewer-layout>
    <x-slot name="header">
        {{ __('Pengabdian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3 fade-in-up">
                    <h3 class="mb-3"><i class="fa fa-hands-helping me-2"></i>Proposal Pengabdian</h3>
                        @if (!$timeline)
                            <div class="modern-alert modern-alert-danger">
                                <i class="fa fa-exclamation-circle me-2"></i>Tidak ada jadwal review.
                            </div>
                        @elseif ($currentDate < $timeline->review_start_date)
                            <div class="modern-alert modern-alert-warning">
                                <i class="fa fa-clock me-2"></i>Review period will start in <span id="countdown"></span>.
                            </div>
                            <script>
                                var countdownDate = new Date("{{ $timeline->review_start_date }}").getTime();
                            </script>
                        @elseif ($currentDate > $timeline->review_end_date)
                            <div class="modern-alert modern-alert-danger">
                                <i class="fa fa-times-circle me-2"></i>The review period has ended.
                            </div>
                        @else
                            <div class="modern-alert modern-alert-info">
                                <i class="fa fa-info-circle me-2"></i>Review period is open. It will close in <span id="countdown"></span>.
                            </div>
                            <script>
                                var countdownDate = new Date("{{ $timeline->review_end_date }}").getTime();
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
                                        @foreach($statuses as $statusOption)
                                            <option value="{{ $statusOption }}" @selected(($filters['status'] ?? '') === $statusOption)>{{ $statusOption }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex gap-2">
                                    <button type="submit" class="modern-btn modern-btn-primary w-100">
                                        <i class="fa fa-filter me-1"></i> Terapkan
                                    </button>
                                    <a href="{{ route('pengabdian-rev.index') }}" class="modern-btn modern-btn-outline w-100">
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </form>

                        @if ($proposals->count() === 0)
                            <div class="modern-alert modern-alert-info">
                                <i class="fa fa-info-circle me-2"></i>Tidak ada proposal pengabdian saat ini.
                            </div>
                        @else
                        <div class="modern-table-container mb-4">
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
                                        // Cek apakah proposal ini sudah direview oleh reviewer lain
                                        $isReviewedByAnother = $existingReviews->where('pengabdian_id', $proposal->id)->where('reviewer_id', '!=', auth()->id())->count() > 0;
                                    @endphp
                                    <tr>
                                        <td class="col-no text-center">{{ $proposals->firstItem() + $loop->index }}</td>
                                        <td class="col-judul"><div class="fw-bold">{{ $proposal->judul }}</div></td>
                                        <td class="col-skema">
                                            <span class="status-badge skema">{{ $proposal->skema }}</span>
                                        </td>
                                        <td>{{ $proposal->created_at->year }}</td>
                                        <td>
                                            <span class="status-badge
                                                @if ($proposal->status === 'Pending') pending
                                                @elseif ($proposal->status === 'Diproses') diproses
                                                @elseif ($proposal->status === 'Selesai') selesai
                                                @endif">
                                                {{ $proposal->status }}
                                            </span>
                                        </td>
                                        <td>
                                            @php($inWindow = $timeline && $currentDate >= $timeline->review_start_date && $currentDate <= $timeline->review_end_date)
                                            <div class="d-flex gap-2">
                                            @if (in_array($proposal->id, $reviews))
                                                <a href="{{ route('pengabdian-rev.editReview', $proposal->id) }}" class="modern-btn modern-btn-warning modern-btn-sm @if(!$inWindow) disabled @endif" @if(!$inWindow) aria-disabled="true" tabindex="-1" @endif><i class="fa fa-edit me-1"></i> Edit</a>
                                                <a href="{{ route('pengabdian-rev.view_pdf', $proposal->id) }}" class="modern-btn modern-btn-danger modern-btn-sm"><i class="fa fa-file-download me-1"></i> PDF</a>
                                            {{-- @elseif ($isReviewedByAnother)
                                                <button class="btn btn-secondary" disabled>Telah Ditinjau</button> --}}
                                            @else
                                                <a href="{{ route('pengabdian-rev.review', $proposal->id) }}" class="modern-btn modern-btn-primary modern-btn-sm @if(!$inWindow) disabled @endif" @if(!$inWindow) aria-disabled="true" tabindex="-1" @endif><i class="fa fa-file me-1"></i> Review</a>
                                            @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-end modern-pagination">
                            {{ $proposals->links('pagination::bootstrap-5') }}
                        </div>
                </div>                
                @endif
            </div>
        </div>
    </div>
</x-reviewer-layout>

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
        overflow-x: auto;
    }
    .modern-table.modern-table-fixed {
        table-layout: fixed;
        width: 100%;
    }
    .modern-table.modern-table-fixed th,
    .modern-table.modern-table-fixed td {
        white-space: normal;
        word-break: break-word;
        vertical-align: top;
    }
    .modern-table.modern-table-fixed .col-judul {
        width: 35%;
    }
    .modern-table.modern-table-fixed .col-no {
        width: 60px;
        text-align: center;
    }
    .modern-table.modern-table-fixed .col-skema {
        width: 20%;
    }
    .modern-table .status-badge.skema {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: .35rem .7rem;
        min-height: 36px;
        line-height: 1.2;
        white-space: normal;
        max-width: 100%;
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
</style>
<script>
    // Countdown Timer (uses countdownDate set in the alert block above)
    if (typeof countdownDate !== 'undefined') {
        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countdownDate - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            var el = document.getElementById('countdown');
            if (el) {
                el.innerHTML = days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's ';
            }

            if (distance < 0) {
                clearInterval(x);
                if (el) {
                    el.innerHTML = 'EXPIRED';
                }
            }
        }, 1000);
    }
</script>
