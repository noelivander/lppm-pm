<x-reviewer-layout>
    <x-slot name="header">
        {{ __('Tinjau Laporan Kemajuan Penelitian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h3 class="mb-0 d-flex align-items-center gap-2">
                        <i class="fa fa-eye"></i>
                        <span>Tinjau Laporan Kemajuan</span>
                    </h3>
                    <a href="{{ route('penelitian-rev.laporan-kemajuan.index') }}"
                        class="modern-btn modern-btn-secondary">
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

                @if(!$isWithinProgressReviewWindow)
                    <div class="modern-alert modern-alert-warning mb-3">
                        <i class="fa fa-lock me-2"></i>Periode review laporan kemajuan tidak aktif. Form tetap dapat
                        dilihat, namun aksi simpan dinonaktifkan.
                    </div>
                @endif

                <!-- Informasi Penelitian -->
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-header">
                        <h5 class="mb-0"><i class="fa fa-info-circle me-2"></i>Informasi Penelitian</h5>
                    </div>
                    <div class="modern-card-body">
                        <div class="row g-4">
                            <div class="col-md-6 col-lg-4">
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Judul Penelitian</p>
                                <h6 class="fw-bold mb-0 text-break">{{ $proposal->judul ?? '-' }}</h6>
                            </div>
                            <div class="col-md-6 col-lg-2">
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Bidang Penelitian</p>
                                <div class="fw-semibold">{{ $bidangPenelitian }}</div>
                            </div>
                            <div class="col-md-6 col-lg-2">
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Skema</p>
                                <span class="status-badge skema">{{ $skema }}</span>
                            </div>
                            <div class="col-md-6 col-lg-2">
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Jurusan/Prodi</p>
                                <div class="fw-semibold">{{ $jurusanProdi }}</div>
                            </div>
                            <div class="col-md-6 col-lg-2">
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Lama Penelitian</p>
                                <div class="fw-semibold">{{ $lamaPenelitian ?? '-'}}</div>
                            </div>
                            <div class="col-12">
                                <hr class="my-3">
                                <p class="text-muted text-uppercase small fw-semibold mb-2">Ketua Peneliti</p>
                                @if($ketuaPeneliti)
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <span class="text-muted small">Nama Lengkap:</span>
                                            <div class="fw-semibold">{{ $ketuaPeneliti->nama ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="text-muted small">NIDN:</span>
                                            <div class="fw-semibold">{{ $ketuaPeneliti->nidn ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="text-muted small">Jabatan Fungsional:</span>
                                            <div class="fw-semibold">{{ $ketuaPeneliti->jabatan ?? '-' }}</div>
                                        </div>
                                    </div>
                                @else
                                    <div class="fw-semibold">-</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lampiran -->
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-header">
                        <h5 class="mb-0"><i class="fa fa-paperclip me-2"></i>Lampiran</h5>
                    </div>
                    <div class="modern-card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div
                                    class="d-flex flex-wrap align-items-center justify-content-between gap-2 p-3 border rounded">
                                    <div>
                                        <p class="mb-1 fw-semibold">Laporan Kemajuan</p>
                                        <small class="text-muted">File utama kemajuan kegiatan</small>
                                    </div>
                                    @if($latestLaporan->laporan_kemajuan)
                                        <a href="{{ asset('storage/' . $latestLaporan->laporan_kemajuan) }}" target="_blank"
                                            class="modern-btn modern-btn-primary modern-btn-sm">
                                            <i class="fa fa-file-pdf me-1"></i> Lihat Dokumen
                                        </a>
                                    @else
                                        <span class="text-muted small">Belum tersedia</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div
                                    class="d-flex flex-wrap align-items-center justify-content-between gap-2 p-3 border rounded">
                                    <div>
                                        <p class="mb-1 fw-semibold">Laporan Keuangan Tahap 1</p>
                                        <small class="text-muted">Dokumen realisasi penggunaan dana</small>
                                    </div>
                                    @if($latestLaporan->laporan_keuangan_tahap_1)
                                        <a href="{{ asset('storage/' . $latestLaporan->laporan_keuangan_tahap_1) }}"
                                            target="_blank" class="modern-btn modern-btn-outline modern-btn-sm">
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

                @if(isset($formPenelitian) && $formPenelitian->count() > 0)
                    <form action="{{ route('penelitian-rev.laporan-kemajuan.store', $proposal->id) }}" method="POST"
                        class="mb-4">
                        @csrf
                        <div class="modern-card fade-in-up">
                            <div
                                class="modern-card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <h5 class="mb-0"><i class="fa fa-clipboard-check me-2"></i>Form Penilaian Laporan Kemajuan
                                </h5>
                            </div>
                            <div class="modern-card-body">
                                <div class="modern-table-container mb-3">
                                    <table class="modern-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 60px;">No</th>
                                                <th style="width: 35%;">Komponen Penilaian</th>
                                                <th>Komentar Reviewer</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($formPenelitian as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <div class="fw-semibold">{{ $item->komponen_penilaian }}</div>
                                                    </td>
                                                    <td>
                                                        <textarea
                                                            class="modern-form-textarea @error('komentar.' . $item->id) is-invalid @enderror"
                                                            rows="3" name="komentar[{{ $item->id }}]"
                                                            placeholder="Tulis komentar untuk komponen ini...">{{ old('komentar.' . $item->id, $existingKomentar[$item->id] ?? '') }}</textarea>
                                                        @error('komentar.' . $item->id)
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="modern-form-group">
                                    <label class="modern-form-label fw-semibold">
                                        <i class="fa fa-comment-dots me-2"></i>Catatan Tambahan
                                    </label>
                                    <textarea class="modern-form-textarea @error('catatan_umum') is-invalid @enderror"
                                        rows="4" name="catatan_umum"
                                        placeholder="Catatan umum terkait laporan kemajuan...">{{ old('catatan_umum', optional($existingReview)->catatan_umum) }}</textarea>
                                    @error('catatan_umum')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="action-footer d-flex flex-wrap justify-content-end">
                                    @if(!$isWithinProgressReviewWindow)
                                        <button type="button" class="modern-btn modern-btn-secondary" disabled>
                                            <i class="fa fa-lock me-1"></i> Periode review tidak aktif
                                        </button>
                                    @else
                                        @if(optional($existingReview)->status === 'selesai')
                                            <button type="submit" name="action" value="submit"
                                                class="modern-btn modern-btn-primary">
                                                <i class="fa fa-check me-1"></i> Simpan &amp; Selesaikan
                                            </button>
                                        @else
                                            <button type="submit" name="action" value="draft"
                                                class="modern-btn modern-btn-secondary">
                                                <i class="fa fa-save me-1"></i> Simpan Draft
                                            </button>
                                            <button type="submit" name="action" value="submit"
                                                class="modern-btn modern-btn-primary">
                                                <i class="fa fa-check me-1"></i> Simpan &amp; Selesaikan
                                            </button>
                                        @endif
                                    @endif
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