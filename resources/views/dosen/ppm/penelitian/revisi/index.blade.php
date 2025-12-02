<x-dosen-layout>
    <x-slot name="header">
        {{ __('Revisi Proposal Penelitian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3 fade-in-up">
                    @php
                        $hasRevisionWindow = $timeline && $timeline->revision_start_date && $timeline->revision_end_date;
                        $isWithinRevisionWindow = $hasRevisionWindow && $currentDate->between($timeline->revision_start_date, $timeline->revision_end_date);
                    @endphp
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                        <div>
                            <h3 class="mb-1">
                                <i class="fa fa-sync-alt me-2"></i>Revisi Proposal Penelitian
                            </h3>
                        </div>

                    </div>

                    @if (!$timeline)
                        <div class="modern-alert modern-alert-danger">
                            <i class="fa fa-exclamation-circle me-2"></i>Belum ada timeline aktif untuk revisi proposal.
                        </div>
                    @else
                        <div class="modern-alert {{ $isWithinRevisionWindow ? 'modern-alert-info' : 'modern-alert-warning' }}">
                            <i class="fa fa-clock me-2"></i>
                            Periode revisi: <strong>{{ $timeline->revision_start_date?->format('d M Y H:i') ?? '-' }}</strong>
                            s/d <strong>{{ $timeline->revision_end_date?->format('d M Y H:i') ?? '-' }}</strong>.
                            @unless($isWithinRevisionWindow)
                                <span class="ms-1">Periode revisi belum dimulai atau sudah berakhir.</span>
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
                                <a href="{{ route('penelitian-dos.revisi.index') }}" class="modern-btn modern-btn-outline w-100">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    @if ($proposals->isEmpty())
                        <div class="modern-alert modern-alert-info">
                            <i class="fa fa-inbox me-2"></i>Belum ada proposal yang memenuhi kriteria filter ini.
                        </div>
                    @else
                        <div class="modern-table-container mb-3">
                            <table class="modern-table modern-table-fixed">
                                <thead>
                                    <tr>
                                        <th class="col-no text-center">#</th>
                                        <th class="col-judul">Judul</th>
                                        <th class="col-skema">Skema</th>
                                        <th>Periode</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($proposals as $proposal)
                                        @php
                                            $revision = $proposal->revisionChild;
                                            if ($revision) {
                                                $revisionState = $revision->status ?? 'Diproses';
                                                if ($revisionState === 'Pending') {
                                                    $revisionState = 'Diproses';
                                                }
                                            } else {
                                                $revisionState = 'Pending';
                                            }

                                            $statusClass = match($revisionState) {
                                                'Diproses' => 'diproses',
                                                'Selesai' => 'selesai',
                                                default => 'pending',
                                            };
                                            $canEditRevision = $revisionState !== 'Selesai';
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $proposals->firstItem() + $loop->index }}</td>
                                            <td class="col-judul">
                                                <div class="fw-bold proposal-title">{{ $proposal->judul ?? '-' }}</div>
                                            </td>
                                            <td class="col-skema">
                                                <span class="status-badge skema">{{ $proposal->skema ?? '-' }}</span>
                                            </td>
                                            <td>{{ optional($proposal->created_at)->format('Y') ?? '-' }}</td>
                                            <td>
                                                <span class="status-badge {{ $statusClass }}">
                                                    {{ $revisionState }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if($revision && !$canEditRevision)
                                                    @php
                                                        $revisionReviews = \App\Models\Review::where('penelitian_id', $revision->id)
                                                            ->whereNotNull('revision_comment')
                                                            ->get();
                                                    @endphp
                                                    <div class="d-flex justify-content-center gap-2">
                                                        @if($revisionReviews->count())
                                                            <button type="button"
                                                                    class="modern-btn modern-btn-secondary modern-btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#lihatKomentarRevisiPenelitian{{ $revision->id }}">
                                                                <i class="fa fa-comment-dots me-1"></i> Lihat Komentar
                                                            </button>
                                                        @endif
                                                    </div>

                                                    @if($revisionReviews->count())
                                                        <!-- Modal komentar revisi reviewer -->
                                                        <div class="modal fade" id="lihatKomentarRevisiPenelitian{{ $revision->id }}" tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content modern-card">
                                                                    <div class="modal-header modern-card-header">
                                                                        <h5 class="modal-title mb-0">
                                                                            <i class="fa fa-comments me-2 text-primary"></i>
                                                                            Komentar Reviewer terhadap Revisi
                                                                        </h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body modern-card-body">
                                                                        @foreach($revisionReviews as $rev)
                                                                            <div class="mb-3">
                                                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                                                    <span class="fw-semibold">
                                                                                        <i class="fa fa-user-circle me-1 text-secondary"></i>
                                                                                        {{ $rev->reviewer->name ?? $rev->reviewer_name ?? 'Reviewer' }}
                                                                                    </span>
                                                                                    <span class="text-muted small">
                                                                                        {{ optional($rev->updated_at ?? $rev->created_at)->format('d M Y H:i') }}
                                                                                    </span>
                                                                                </div>
                                                                                <div class="modern-alert modern-alert-info">
                                                                                    <i class="fa fa-comment-dots me-2"></i>
                                                                                    {{ $rev->revision_comment }}
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="modal-footer modern-card-footer">
                                                                        <button type="button" class="modern-btn modern-btn-secondary modern-btn-sm" data-bs-dismiss="modal">
                                                                            <i class="fa fa-times me-1"></i> Tutup
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @else
                                                    <a href="{{ route('penelitian-dos.revisi.create', $proposal->id) }}" class="modern-btn modern-btn-sm {{ $revision ? 'modern-btn-primary' : 'modern-btn-warning' }}">
                                                        <i class="fa {{ $revision ? 'fa-pen' : 'fa-edit' }} me-1"></i>{{ $revision ? 'Edit' : 'Revisi' }}
                                                    </a>
                                                @endif
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
</style>

