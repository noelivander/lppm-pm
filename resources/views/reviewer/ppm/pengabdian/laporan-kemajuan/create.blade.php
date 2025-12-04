<x-reviewer-layout>
    <x-slot name="header">
        {{ __('Tinjau Laporan Kemajuan Pengabdian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h3 class="mb-0 d-flex align-items-center gap-2">
                        <i class="fa fa-eye"></i>
                        <span>Tinjau Laporan Kemajuan</span>
                    </h3>
                    <a href="{{ route('pengabdian-rev.laporan-kemajuan.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                @if(session('success'))
                    <div class="modern-alert modern-alert-success mb-3">
                        <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="modern-alert modern-alert-danger mb-3">
                        <i class="fa fa-exclamation-triangle me-2"></i>{{ session('error') }}
                    </div>
                @endif

                <div class="row g-3 mb-4">
                    <div class="col-lg-6">
                        <div class="modern-card h-100 fade-in-up">
                            <div class="modern-card-body">
                                <div class="row g-3 align-items-start">
                                    <div class="col-sm-8">
                                        <p class="text-muted text-uppercase small fw-semibold mb-1">Judul Proposal</p>
                                        <h4 class="fw-bold mb-1 text-break">{{ $proposal->judul ?? '-' }}</h4>
                                        <p class="mb-0 text-muted">
                                            oleh <strong>{{ $proposal->user->name ?? '-' }}</strong>
                                        </p>
                                    </div>
                                    <div class="col-sm-4 text-sm-end">
                                        <p class="text-muted text-uppercase small fw-semibold mb-1">Skema</p>
                                        <span class="status-badge skema">{{ $proposal->revisionParent->skema ?? $proposal->skema ?? '-' }}</span>
                                    </div>
                                </div>
                                <hr class="text-muted my-4">
                                <div class="row gy-3 gx-4">
                                    <div class="col-sm-6">
                                        <p class="text-muted text-uppercase small fw-semibold mb-1">Status Laporan</p>
                                        @php
                                            $statusDisplay = $latestLaporan->status ?? 'Pending';
                                            $statusClass = $statusDisplay === 'Selesai' ? 'selesai' : 'pending';
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">{{ $statusDisplay }}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-muted text-uppercase small fw-semibold mb-1">Tanggal Upload</p>
                                        <div class="fw-semibold">{{ optional($latestLaporan->created_at)->format('d M Y H:i') ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="modern-card h-100 fade-in-up">
                            <div class="modern-card-body">
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
                        </div>
                    </div>
                </div>

                @if(isset($formPengabdian) && $formPengabdian->count() > 0)
                    <form action="{{ route('pengabdian-rev.laporan-kemajuan.store', $proposal->id) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="modern-card fade-in-up">
                            <div class="modern-card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <h5 class="mb-0"><i class="fa fa-clipboard-check me-2"></i>Form Penilaian Laporan Kemajuan</h5>
                            </div>
                            <div class="modern-card-body">
                                <div class="modern-table-container">
                                    <table class="modern-table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kategori</th>
                                                <th>Komponen</th>
                                                <th>Sub Komponen</th>
                                                <th style="width: 120px;">Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $rowNumber = 1; @endphp
                                            @foreach($formPengabdian as $kategori => $komponenList)
                                                @php
                                                    $kategoriRowspan = 0;
                                                    foreach ($komponenList as $komponen) {
                                                        $subCount = $komponen->subKomponen->count();
                                                        $kategoriRowspan += $subCount > 0 ? $subCount : 1;
                                                    }
                                                    $kategoriFirstRow = true;
                                                @endphp
                                                @foreach($komponenList as $komponen)
                                                    @php
                                                        $subKomponenCount = $komponen->subKomponen->count();
                                                        $komponenRowspan = $subKomponenCount > 0 ? $subKomponenCount : 1;
                                                        $komponenFirstRow = true;
                                                    @endphp
                                                    @if($subKomponenCount > 0)
                                                        @foreach($komponen->subKomponen as $sub)
                                                            <tr>
                                                                @if($kategoriFirstRow && $komponenFirstRow)
                                                                    <td rowspan="{{ $kategoriRowspan }}">{{ $rowNumber }}</td>
                                                                    <td rowspan="{{ $kategoriRowspan }}"><strong>{{ $kategori ?? '-' }}</strong></td>
                                                                    @php $kategoriFirstRow = false; @endphp
                                                                @endif
                                                                @if($komponenFirstRow)
                                                                    <td rowspan="{{ $komponenRowspan }}"><strong>{{ $komponen->komponen_penilaian }}</strong></td>
                                                                    @php $komponenFirstRow = false; @endphp
                                                                @endif
                                                                <td>{{ $sub->sub_komponen }}</td>
                                                                <td>
                                                                    <input
                                                                        type="number"
                                                                        name="nilai[{{ $komponen->id }}][{{ $sub->id }}]"
                                                                        class="modern-form-input @error('nilai.' . $komponen->id . '.' . $sub->id) is-invalid @enderror"
                                                                        min="0" max="100" step="1"
                                                                        placeholder="0-100"
                                                                        value="{{ old('nilai.' . $komponen->id . '.' . $sub->id, $existingNilai[$komponen->id][$sub->id] ?? '') }}"
                                                                    >
                                                                    @error('nilai.' . $komponen->id . '.' . $sub->id)
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            @if($kategoriFirstRow)
                                                                <td rowspan="{{ $kategoriRowspan }}">{{ $rowNumber }}</td>
                                                                <td rowspan="{{ $kategoriRowspan }}"><strong>{{ $kategori ?? '-' }}</strong></td>
                                                                @php $kategoriFirstRow = false; @endphp
                                                            @endif
                                                            <td><strong>{{ $komponen->komponen_penilaian }}</strong></td>
                                                            <td class="text-muted">-</td>
                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    name="nilai[{{ $komponen->id }}][0]"
                                                                    class="modern-form-input @error('nilai.' . $komponen->id . '.0') is-invalid @enderror"
                                                                    min="0" max="100" step="1"
                                                                    placeholder="0-100"
                                                                    value="{{ old('nilai.' . $komponen->id . '.0', $existingNilai[$komponen->id][0] ?? '') }}"
                                                                >
                                                                @error('nilai.' . $komponen->id . '.0')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                @php $rowNumber++; @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="modern-form-group mt-3">
                                    <label class="modern-form-label fw-semibold">
                                        <i class="fa fa-comment-dots me-2"></i>Catatan Tambahan
                                    </label>
                                    <textarea
                                        class="modern-form-textarea @error('catatan_umum') is-invalid @enderror"
                                        rows="4"
                                        name="catatan_umum"
                                        placeholder="Catatan umum terkait laporan kemajuan..."
                                    >{{ old('catatan_umum', optional($existingReview)->catatan_umum) }}</textarea>
                                    @error('catatan_umum')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="action-footer d-flex flex-wrap justify-content-end">
                                    <button type="submit" name="action" value="draft" class="modern-btn modern-btn-secondary">
                                        <i class="fa fa-save me-1"></i> Simpan Draft
                                    </button>
                                    <button type="submit" name="action" value="submit" class="modern-btn modern-btn-primary">
                                        <i class="fa fa-check me-1"></i> Simpan &amp; Selesaikan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="modern-alert modern-alert-info">
                        <i class="fa fa-info-circle me-2"></i>
                        Belum ada form penilaian laporan kemajuan yang dikonfigurasi di admin.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .list-group-item {
            border: none;
        }

        .modern-btn.modern-btn-outline {
            border: 1px solid var(--modern-primary, #0061f2);
            color: var(--modern-primary, #0061f2);
            background-color: transparent;
        }

        .modern-btn.modern-btn-outline:hover,
        .modern-btn.modern-btn-outline:focus {
            background-color: var(--modern-primary, #0061f2);
            color: #fff;
        }
        .action-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.08);
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            gap: 0.75rem;
        }
    </style>
</x-reviewer-layout>

