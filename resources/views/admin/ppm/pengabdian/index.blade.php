<x-admin-layout>
    <x-slot name="header">
        {{ __('Pengabdian') }}
    </x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="mb-3 fade-in-up">
                    <h3 class="mb-3">
                        <i class="fa fa-hands-helping me-2"></i>Daftar Proposal Pengabdian
                    </h3>
                    <p class="text-muted mb-4">Proposal yang sudah direview lengkap oleh 2 reviewer</p>

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

                    @if (!$timeline)
                        <div class="modern-alert modern-alert-danger">
                            <i class="fa fa-exclamation-circle me-2"></i>Tidak ada jadwal penyetujuan admin.
                        </div>
                    @elseif (!$timeline->admin_decision_start_date || !$timeline->admin_decision_end_date)
                        <div class="modern-alert modern-alert-warning">
                            <i class="fa fa-exclamation-triangle me-2"></i>Periode penyetujuan admin belum ditentukan.
                        </div>
                    @elseif ($currentDate < $timeline->admin_decision_start_date)
                        <div class="modern-alert modern-alert-warning">
                            <i class="fa fa-clock me-2"></i>Periode penyetujuan admin akan dimulai pada <strong>{{ $timeline->admin_decision_start_date->format('d F Y H:i') }}</strong>.
                        </div>
                    @elseif ($currentDate > $timeline->admin_decision_end_date)
                        <div class="modern-alert modern-alert-danger">
                            <i class="fa fa-times-circle me-2"></i>Periode penyetujuan admin telah berakhir pada <strong>{{ $timeline->admin_decision_end_date->format('d F Y H:i') }}</strong>.
                        </div>
                    @else
                        <div class="modern-alert modern-alert-info">
                            <i class="fa fa-info-circle me-2"></i>Periode penyetujuan admin sedang berlangsung. Akan berakhir pada <strong>{{ $timeline->admin_decision_end_date->format('d F Y H:i') }}</strong>.
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
                                <select name="admin_status" class="modern-form-select">
                                    <option value="">Semua Status</option>
                                    @foreach($adminStatuses as $key => $label)
                                        <option value="{{ $key }}" @selected(($filters['admin_status'] ?? '') === $key)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-flex gap-2">
                                <button type="submit" class="modern-btn modern-btn-primary w-100">
                                    <i class="fa fa-filter me-1"></i> Terapkan
                                </button>
                                <a href="{{ route('pengabdian-adm.index') }}" class="modern-btn modern-btn-outline w-100">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    @if ($proposals->count() === 0)
                        <div class="modern-alert modern-alert-info">
                            <i class="fa fa-info-circle me-2"></i>Tidak ada proposal pengabdian yang sudah direview lengkap.
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
                                        <tr>
                                            <td class="col-no text-center">{{ $proposals->firstItem() + $loop->index }}</td>
                                            <td class="col-judul">
                                                <div class="fw-bold proposal-title">{{ $proposal->judul }}</div>
                                                <small class="text-muted">Oleh: {{ $proposal->user->name ?? '-' }}</small>
                                            </td>
                                            <td class="col-skema">
                                                <span class="status-badge skema">{{ $proposal->skema }}</span>
                                            </td>
                                            <td>{{ $proposal->created_at->year }}</td>
                                            <td>
                                                @if($proposal->admin_status === 'approved')
                                                    <span class="status-badge selesai">
                                                        <i class="fa fa-check-circle me-1"></i>Disetujui
                                                    </span>
                                                @elseif($proposal->admin_status === 'rejected')
                                                    <span class="status-badge ditolak">
                                                        <i class="fa fa-times-circle me-1"></i>Ditolak
                                                    </span>
                                                @else
                                                    <span class="status-badge pending">
                                                        <i class="fa fa-clock me-1"></i>Pending
                                                    </span>
                                                @endif
                                            </td>
                                    
                                            <td>
                                                @if($proposal->admin_status)
                                                    <a href="{{ route('pengabdian-adm.show', $proposal->id) }}" class="modern-btn modern-btn-warning modern-btn-sm">
                                                        <i class="fa fa-edit me-1"></i> Edit
                                                    </a>
                                                @else
                                                    <a href="{{ route('pengabdian-adm.show', $proposal->id) }}" class="modern-btn modern-btn-primary modern-btn-sm">
                                                        <i class="fa fa-eye me-1"></i> Inspect
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end modern-pagination mt-2">
                            {{ $proposals->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
            </div>
        </div>
    </div>
</x-admin-layout>

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
