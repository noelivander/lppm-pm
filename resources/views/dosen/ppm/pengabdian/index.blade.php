<x-dosen-layout>
    <x-slot name="header">
        {{ __('Pengabdian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3 fade-in-up">
                    @php
                        $uploadOpen = $timeline && $currentDate >= $timeline->upload_start_date && $currentDate <= $timeline->upload_end_date;
                        $hasDraft = isset($draft) && $draft;
                    @endphp
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                        <h3 class="mb-0"><i class="fa fa-hands-helping me-2"></i>Proposal Pengabdian</h3>
                        <div class="d-flex flex-wrap gap-2">
                            @if ($hasDraft)
                                <a href="{{ route('pengabdian-dos.create') }}" class="modern-btn modern-btn-warning">
                                    <i class="fa fa-edit me-2"></i> Lanjutkan Draft
                                </a>
                            @elseif ($uploadOpen)
                                <a href="{{ route('pengabdian-dos.create') }}" class="modern-btn modern-btn-primary">
                                    <i class="fa fa-plus me-2"></i> Tambah Usulan Baru
                                </a>
                            @else
                                <button class="modern-btn modern-btn-primary" disabled>
                                    <i class="fa fa-plus me-2"></i> Tambah Usulan Baru
                                </button>
                            @endif
                        </div>
                    </div>
                        @if (!$timeline)
                            <div class="modern-alert modern-alert-danger"><i class="fa fa-exclamation-circle me-2"></i>No upload schedule available. You cannot upload a proposal.</div>
                        @else
                            @if ($currentDate < $timeline->upload_start_date)
                                <div class="modern-alert modern-alert-warning"><i class="fa fa-clock me-2"></i>Upload period will start in <span id="countdown"></span>.</div>
                                <script>
                                    var countdownDate = new Date("{{ $timeline->upload_start_date }}").getTime();
                                </script>
                            @elseif ($currentDate >= $timeline->upload_start_date && $currentDate <= $timeline->upload_end_date)
                                <div class="modern-alert modern-alert-info"><i class="fa fa-info-circle me-2"></i>Upload period is open. It will close in <span id="countdown"></span>.</div>
                                <script>
                                    var countdownDate = new Date("{{ $timeline->upload_end_date }}").getTime();
                                </script>
                            @else
                                <div class="modern-alert modern-alert-danger"><i class="fa fa-times-circle me-2"></i>The upload period has ended.</div>
                            @endif
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
                                    <a href="{{ route('pengabdian-dos.index') }}" class="modern-btn modern-btn-outline w-100">
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </form>

                        @if ($pengabdian->count() === 0)
                            <div class="modern-alert modern-alert-info">
                                <i class="fa fa-info-circle me-2"></i>Belum ada proposal pengabdian.
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
                                        <th>Proposal</th>
                                        <th>Dokumen Review</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengabdian as $item)
                                        <tr>
                                            <td class="col-no text-center">{{ $pengabdian->firstItem() + $loop->index }}</td>
                                            <td class="col-judul">{{ $item->judul }}</td>
                                            <td class="col-skema">
                                                <span class="status-badge skema">{{ $item->skema }}</span>
                                            </td>
                                            <td>{{ $item->created_at->year }}</td>
                                            <td>
                                                <span class="status-badge
                                                    @if ($item->status === 'Pending') pending
                                                    @elseif ($item->status === 'Diproses') diproses
                                                    @elseif ($item->status === 'Selesai') selesai
                                                    @endif">
                                                    {{ $item->status }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($item->dokumen_proposal)
                                                    <a href="{{ Storage::url($item->dokumen_proposal) }}" class="modern-btn modern-btn-primary modern-btn-sm" target="_blank">
                                                        <i class="fas fa-file-download me-1"></i> Download PDF
                                                    </a>
                                                @else
                                                    <span class="text-muted">Tidak ada file</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="modern-btn modern-btn-secondary modern-btn-sm" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $item->id }}">
                                                    <i class="fas fa-search me-1"></i> Hasil Review
                                                </a>
                                            </td>
    
                                            <!-- Modal untuk Review -->
                                            <div class="modal fade" id="reviewModal{{ $item->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content modern-card">
                                                        <div class="modal-header modern-card-header">
                                                            <h5 class="modal-title mb-0">
                                                                <i class="fa fa-search me-2"></i>Hasil Review Pengabdian
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body modern-card-body">
                                                            @php
                                                                $reviews = \App\Models\Review::where('pengabdian_id', $item->id)->get();
                                                            @endphp
    
                                                            @if ($reviews->count() > 0)
                                                                <div class="row">
                                                                    @foreach ($reviews as $index => $review)
                                                                        <div class="col-md-6 mb-3">
                                                                            <div class="modern-card">
                                                                                <div class="modern-card-body text-center">
                                                                                    <i class="fa fa-file-alt fa-3x text-primary mb-3"></i>
                                                                                    <h6 class="mb-2">Review {{ $index + 1 }}</h6>
                                                                                    <p class="text-muted small mb-3">Klik untuk melihat detail review</p>
                                                                                    <a href="{{ route('pengabdian-dos.view-reviews', ['pengabdian_id' => $item->id, 'review_number' => $index + 1]) }}" 
                                                                                       class="modern-btn modern-btn-primary">
                                                                                        <i class="fa fa-eye me-1"></i> Lihat Review
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <div class="text-center py-4">
                                                                    <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                                                    <h6 class="text-muted">Review belum tersedia</h6>
                                                                    <p class="text-muted">Review akan muncul setelah proposal direview oleh reviewer</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer modern-card-footer">
                                                            <button type="button" class="modern-btn modern-btn-secondary" data-bs-dismiss="modal">
                                                                <i class="fa fa-times me-1"></i> Tutup
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                            <div class="d-flex justify-content-end modern-pagination">
                                {{ $pengabdian->links('pagination::bootstrap-5') }}
                            </div>
                        @endif      

                    </div>
                </div>
            </div>
        </div>
    </div>
    
</x-dosen-layout>
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
        width: 18%;
    }
    .modern-table .status-badge.skema {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: .4rem .75rem;
        min-height: 38px;
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