<x-admin-layout>
    <x-slot name="header">
        {{ __('Edit Timeline') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="modern-card fade-in-up">
                    <div class="modern-card-header d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="fa fa-calendar-edit me-2"></i>Edit Timeline</h4>
                        <a href="{{ route('timeline.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fa fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                    <form method="POST" action="{{ route('timeline.update', $timeline->id) }}" onsubmit="return validateTimeline()">
                @csrf
                @method('PUT')
                        <div class="modern-card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="period"><i class="fa fa-calendar-alt me-2"></i>Periode (Tahun) <span class="text-danger">*</span></label>
                                        <input type="number" name="period" id="period" class="modern-form-input" value="{{ old('period', $timeline->period) }}" placeholder="2025" required min="1900" max="2999" step="1" inputmode="numeric">
                                        <small class="text-muted">Masukkan tahun periode timeline (contoh: 2025). Hanya angka diperbolehkan.</small>
                                        @error('period')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="title"><i class="fa fa-tag me-2"></i>Judul <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title" class="modern-form-input" value="{{ old('title', $timeline->title) }}" placeholder="Misal: Timeline Penelitian 2025" required>
                                        @error('title')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="modern-form-group mb-4">
                                <label class="modern-form-label" for="description"><i class="fa fa-align-left me-2"></i>Deskripsi</label>
                                <textarea name="description" id="description" class="modern-form-input" rows="3" placeholder="Deskripsi timeline (opsional)">{{ old('description', $timeline->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4">

                            <!-- 1. Periode Upload Proposal -->
                            <h5 class="mb-3 text-primary"><i class="fa fa-upload me-2"></i>1. Periode Upload Proposal</h5>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="upload_start_date"></i>Upload Start Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="upload_start_date" id="upload_start_date" class="modern-form-input" value="{{ old('upload_start_date', $timeline->upload_start_date ? date('Y-m-d\TH:i', strtotime($timeline->upload_start_date)) : '') }}" required>
                                        @error('upload_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="upload_end_date"></i>Upload End Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="upload_end_date" id="upload_end_date" class="modern-form-input" value="{{ old('upload_end_date', $timeline->upload_end_date ? date('Y-m-d\TH:i', strtotime($timeline->upload_end_date)) : '') }}" required>
                                        @error('upload_end_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Periode Review Proposal -->
                            <h5 class="mb-3 text-primary"><i class="fa fa-clipboard-check me-2"></i>2. Periode Review Proposal</h5>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="review_start_date"></i>Review Start Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="review_start_date" id="review_start_date" class="modern-form-input" value="{{ old('review_start_date', $timeline->review_start_date ? date('Y-m-d\TH:i', strtotime($timeline->review_start_date)) : '') }}" required>
                                        @error('review_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="review_end_date"></i>Review End Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="review_end_date" id="review_end_date" class="modern-form-input" value="{{ old('review_end_date', $timeline->review_end_date ? date('Y-m-d\TH:i', strtotime($timeline->review_end_date)) : '') }}" required>
                                        @error('review_end_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                </div>

                            <!-- 3. Periode Revisi Proposal -->
                            <h5 class="mb-3 text-primary"><i class="fa fa-edit me-2"></i>3. Periode Revisi Proposal</h5>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="revision_start_date"></i>Revisi Start Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="revision_start_date" id="revision_start_date" class="modern-form-input" value="{{ old('revision_start_date', $timeline->revision_start_date ? date('Y-m-d\TH:i', strtotime($timeline->revision_start_date)) : '') }}" required>
                                        @error('revision_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="revision_end_date"></i>Revisi End Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="revision_end_date" id="revision_end_date" class="modern-form-input" value="{{ old('revision_end_date', $timeline->revision_end_date ? date('Y-m-d\TH:i', strtotime($timeline->revision_end_date)) : '') }}" required>
                                        @error('revision_end_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                </div>

                            <!-- 4. Periode Laporan Kemajuan -->
                            <h5 class="mb-3 text-primary"><i class="fa fa-chart-line me-2"></i>4. Periode Laporan Kemajuan</h5>
                            <div class="row mb-3">
                                
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="progress_submission_start_date"></i>Pengajuan Start Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="progress_submission_start_date" id="progress_submission_start_date" class="modern-form-input" value="{{ old('progress_submission_start_date', $timeline->progress_submission_start_date ? date('Y-m-d\TH:i', strtotime($timeline->progress_submission_start_date)) : '') }}" required>
                                        @error('progress_submission_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="progress_submission_end_date"></i>Pengajuan End Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="progress_submission_end_date" id="progress_submission_end_date" class="modern-form-input" value="{{ old('progress_submission_end_date', $timeline->progress_submission_end_date ? date('Y-m-d\TH:i', strtotime($timeline->progress_submission_end_date)) : '') }}" required>
                                        @error('progress_submission_end_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="progress_review_start_date"></i>Peninjauan Start Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="progress_review_start_date" id="progress_review_start_date" class="modern-form-input" value="{{ old('progress_review_start_date', $timeline->progress_review_start_date ? date('Y-m-d\TH:i', strtotime($timeline->progress_review_start_date)) : '') }}" required>
                                        @error('progress_review_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="progress_review_end_date"></i>Peninjauan End Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="progress_review_end_date" id="progress_review_end_date" class="modern-form-input" value="{{ old('progress_review_end_date', $timeline->progress_review_end_date ? date('Y-m-d\TH:i', strtotime($timeline->progress_review_end_date)) : '') }}" required>
                                        @error('progress_review_end_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                </div>

                            <!-- 5. Periode Laporan Akhir -->
                            <h5 class="mb-3 text-primary"><i class="fa fa-flag-checkered me-2"></i>5. Periode Laporan Akhir</h5>
                            <div class="row mb-3">
                                
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="final_submission_start_date"></i>Pengajuan Start Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="final_submission_start_date" id="final_submission_start_date" class="modern-form-input" value="{{ old('final_submission_start_date', $timeline->final_submission_start_date ? date('Y-m-d\TH:i', strtotime($timeline->final_submission_start_date)) : '') }}" required>
                                        @error('final_submission_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="final_submission_end_date"></i>Pengajuan End Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="final_submission_end_date" id="final_submission_end_date" class="modern-form-input" value="{{ old('final_submission_end_date', $timeline->final_submission_end_date ? date('Y-m-d\TH:i', strtotime($timeline->final_submission_end_date)) : '') }}" required>
                                        @error('final_submission_end_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="final_review_start_date"></i>Peninjauan Start Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="final_review_start_date" id="final_review_start_date" class="modern-form-input" value="{{ old('final_review_start_date', $timeline->final_review_start_date ? date('Y-m-d\TH:i', strtotime($timeline->final_review_start_date)) : '') }}" required>
                                        @error('final_review_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="final_review_end_date"></i>Peninjauan End Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="final_review_end_date" id="final_review_end_date" class="modern-form-input" value="{{ old('final_review_end_date', $timeline->final_review_end_date ? date('Y-m-d\TH:i', strtotime($timeline->final_review_end_date)) : '') }}" required>
                                        @error('final_review_end_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                </div>

                            <!-- Revisi Proposal Period -->
                            <div class="mb-4">
                                <h6 class="fw-bold text-gray-800 mb-3">
                                    <i class="fas fa-redo text-secondary me-2"></i>
                                    Periode Revisi Proposal <span class="text-muted small">(Opsional)</span>
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Tanggal & Waktu Mulai
                                        </label>
                                        <input type="datetime-local" 
                                               name="revisi_proposal_start_date" 
                                               id="revisi_proposal_start_date"
                                               class="form-control form-control-lg @error('revisi_proposal_start_date') is-invalid @enderror" 
                                               value="{{ old('revisi_proposal_start_date', $timeline->revisi_proposal_start_date ? $timeline->revisi_proposal_start_date->format('Y-m-d\TH:i') : '') }}">
                                        @error('revisi_proposal_start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Tanggal & Waktu Selesai
                                        </label>
                                        <input type="datetime-local" 
                                               name="revisi_proposal_end_date" 
                                               id="revisi_proposal_end_date"
                                               class="form-control form-control-lg @error('revisi_proposal_end_date') is-invalid @enderror" 
                                               value="{{ old('revisi_proposal_end_date', $timeline->revisi_proposal_end_date ? $timeline->revisi_proposal_end_date->format('Y-m-d\TH:i') : '') }}">
                                        @error('revisi_proposal_end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Laporan Kemajuan Period -->
                            <div class="mb-4">
                                <h6 class="fw-bold text-gray-800 mb-3">
                                    <i class="fas fa-chart-line text-success me-2"></i>
                                    Periode Laporan Kemajuan <span class="text-muted small">(Opsional)</span>
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Upload Mulai
                                        </label>
                                        <input type="datetime-local" 
                                               name="laporan_kemajuan_start_date" 
                                               id="laporan_kemajuan_start_date"
                                               class="form-control form-control-lg @error('laporan_kemajuan_start_date') is-invalid @enderror" 
                                               value="{{ old('laporan_kemajuan_start_date', $timeline->laporan_kemajuan_start_date ? $timeline->laporan_kemajuan_start_date->format('Y-m-d\TH:i') : '') }}">
                                        @error('laporan_kemajuan_start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Upload Selesai
                                        </label>
                                        <input type="datetime-local" 
                                               name="laporan_kemajuan_end_date" 
                                               id="laporan_kemajuan_end_date"
                                               class="form-control form-control-lg @error('laporan_kemajuan_end_date') is-invalid @enderror" 
                                               value="{{ old('laporan_kemajuan_end_date', $timeline->laporan_kemajuan_end_date ? $timeline->laporan_kemajuan_end_date->format('Y-m-d\TH:i') : '') }}">
                                        @error('laporan_kemajuan_end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Review Mulai
                                        </label>
                                        <input type="datetime-local" 
                                               name="laporan_kemajuan_review_start_date" 
                                               id="laporan_kemajuan_review_start_date"
                                               class="form-control form-control-lg @error('laporan_kemajuan_review_start_date') is-invalid @enderror" 
                                               value="{{ old('laporan_kemajuan_review_start_date', $timeline->laporan_kemajuan_review_start_date ? $timeline->laporan_kemajuan_review_start_date->format('Y-m-d\TH:i') : '') }}">
                                        @error('laporan_kemajuan_review_start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Review Selesai
                                        </label>
                                        <input type="datetime-local" 
                                               name="laporan_kemajuan_review_end_date" 
                                               id="laporan_kemajuan_review_end_date"
                                               class="form-control form-control-lg @error('laporan_kemajuan_review_end_date') is-invalid @enderror" 
                                               value="{{ old('laporan_kemajuan_review_end_date', $timeline->laporan_kemajuan_review_end_date ? $timeline->laporan_kemajuan_review_end_date->format('Y-m-d\TH:i') : '') }}">
                                        @error('laporan_kemajuan_review_end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Laporan Akhir Period -->
                            <div class="mb-4">
                                <h6 class="fw-bold text-gray-800 mb-3">
                                    <i class="fas fa-flag-checkered text-danger me-2"></i>
                                    Periode Laporan Akhir <span class="text-muted small">(Opsional)</span>
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Upload Mulai
                                        </label>
                                        <input type="datetime-local" 
                                               name="laporan_akhir_start_date" 
                                               id="laporan_akhir_start_date"
                                               class="form-control form-control-lg @error('laporan_akhir_start_date') is-invalid @enderror" 
                                               value="{{ old('laporan_akhir_start_date', $timeline->laporan_akhir_start_date ? $timeline->laporan_akhir_start_date->format('Y-m-d\TH:i') : '') }}">
                                        @error('laporan_akhir_start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Upload Selesai
                                        </label>
                                        <input type="datetime-local" 
                                               name="laporan_akhir_end_date" 
                                               id="laporan_akhir_end_date"
                                               class="form-control form-control-lg @error('laporan_akhir_end_date') is-invalid @enderror" 
                                               value="{{ old('laporan_akhir_end_date', $timeline->laporan_akhir_end_date ? $timeline->laporan_akhir_end_date->format('Y-m-d\TH:i') : '') }}">
                                        @error('laporan_akhir_end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Review Mulai
                                        </label>
                                        <input type="datetime-local" 
                                               name="laporan_akhir_review_start_date" 
                                               id="laporan_akhir_review_start_date"
                                               class="form-control form-control-lg @error('laporan_akhir_review_start_date') is-invalid @enderror" 
                                               value="{{ old('laporan_akhir_review_start_date', $timeline->laporan_akhir_review_start_date ? $timeline->laporan_akhir_review_start_date->format('Y-m-d\TH:i') : '') }}">
                                        @error('laporan_akhir_review_start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Review Selesai
                                        </label>
                                        <input type="datetime-local" 
                                               name="laporan_akhir_review_end_date" 
                                               id="laporan_akhir_review_end_date"
                                               class="form-control form-control-lg @error('laporan_akhir_review_end_date') is-invalid @enderror" 
                                               value="{{ old('laporan_akhir_review_end_date', $timeline->laporan_akhir_review_end_date ? $timeline->laporan_akhir_review_end_date->format('Y-m-d\TH:i') : '') }}">
                                        @error('laporan_akhir_review_end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <input type="hidden" name="is_active" value="0">
                                        <label class="modern-form-label" for="is_active">
                                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $timeline->is_active) ? 'checked' : '' }} class="me-2">
                                            Status Aktif
                                        </label>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="order"><i class="fa fa-sort-numeric-down me-2"></i>Urutan</label>
                                        <input type="number" name="order" id="order" class="modern-form-input" value="{{ old('order', $timeline->order ?? 0) }}" min="0">
                                        <small class="text-muted">Urutan tampil (0 = pertama)</small>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="modern-card-footer d-flex gap-2">
                            <button type="submit" class="modern-btn modern-btn-success"><i class="fa fa-save me-1"></i>Simpan</button>
                            <a href="{{ route('timeline.index') }}" class="modern-btn modern-btn-secondary"><i class="fa fa-times me-1"></i>Batal</a>
                        </div>
            </form>
        </div>
    </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const errors = @json($errors->all());
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Form Gagal',
                        html: errors.map(err => `<div class="text-start">• ${err}</div>`).join('')
                    });
                });
            </script>
        @endif
        <script>
            const timelineFields = [
                { start: 'upload_start_date', end: 'upload_end_date', name: 'Upload' },
                { start: 'review_start_date', end: 'review_end_date', name: 'Review' },
                { start: 'revision_start_date', end: 'revision_end_date', name: 'Revisi' },
                { start: 'progress_submission_start_date', end: 'progress_submission_end_date', name: 'Laporan Kemajuan - Pengajuan' },
                { start: 'progress_review_start_date', end: 'progress_review_end_date', name: 'Laporan Kemajuan - Peninjauan' },
                { start: 'final_submission_start_date', end: 'final_submission_end_date', name: 'Laporan Akhir - Pengajuan' },
                { start: 'final_review_start_date', end: 'final_review_end_date', name: 'Laporan Akhir - Peninjauan' },
            ];

            document.addEventListener('DOMContentLoaded', () => {
                const periodInput = document.getElementById('period');
                const dateInputs = [...new Set(timelineFields.flatMap(field => [field.start, field.end]))]
                    .map(id => document.getElementById(id))
                    .filter(Boolean);

                const getYearBounds = () => {
                    if (!periodInput) return null;
                    const year = parseInt(periodInput.value, 10);
                    if (!Number.isInteger(year) || year < 1900 || year > 2999) return null;
                    return {
                        start: `${year}-01-01T00:00`,
                        end: `${year}-12-31T23:59`
                    };
                };

                const applyYearLimits = () => {
                    const bounds = getYearBounds();
                    dateInputs.forEach(input => {
                        if (bounds) {
                            input.min = bounds.start;
                            input.max = bounds.end;
                        } else {
                            input.removeAttribute('min');
                            input.removeAttribute('max');
                        }
                    });
                };

                const applySequentialConstraints = () => {
                    const bounds = getYearBounds();
                    let currentMin = bounds ? bounds.start : '';

                    timelineFields.forEach(field => {
                        const startInput = document.getElementById(field.start);
                        const endInput = document.getElementById(field.end);
                        if (!startInput || !endInput) return;

                        if (currentMin) {
                            startInput.min = currentMin;
                        } else {
                            startInput.removeAttribute('min');
                        }
                        if (bounds) {
                            startInput.max = bounds.end;
                        } else {
                            startInput.removeAttribute('max');
                        }

                        const startValue = startInput.value;
                        if (startValue) {
                            endInput.min = startValue;
                        } else if (currentMin) {
                            endInput.min = currentMin;
                        } else {
                            endInput.removeAttribute('min');
                        }
                        if (bounds) {
                            endInput.max = bounds.end;
                        } else {
                            endInput.removeAttribute('max');
                        }

                        const endValue = endInput.value;
                        if (endValue) {
                            currentMin = endValue;
                        }
                    });
                };

                const handlePeriodChange = () => {
                    applyYearLimits();
                    applySequentialConstraints();
                };

                periodInput && periodInput.addEventListener('input', handlePeriodChange);
                dateInputs.forEach(input => {
                    input.addEventListener('input', applySequentialConstraints);
                });

                handlePeriodChange();
            });

            function showValidationError(message) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Validasi Timeline',
                    text: message
                });
            }

            function validateTimeline() {
                const periodInput = document.getElementById('period');
                if (periodInput) {
                    const periodValue = periodInput.value.trim();
                    const periodNumber = parseInt(periodValue, 10);
                    if (!/^\d{4}$/.test(periodValue) || periodNumber < 1900 || periodNumber > 2999) {
                        showValidationError('Periode harus berupa 4 digit angka antara 1900 dan 2999.');
                        return false;
                    }
                }

                let prevEnd = null;

                for (let i = 0; i < timelineFields.length; i++) {
                    const field = timelineFields[i];
                    const startInput = document.getElementById(field.start);
                    const endInput = document.getElementById(field.end);

                    if (!startInput || !endInput) continue;

                    const startValue = startInput.value;
                    const endValue = endInput.value;

                    if (!startValue || !endValue) {
                        showValidationError(`${field.name}: Start dan End harus diisi.`);
                        return false;
                    }

                    const start = new Date(startValue);
                    const end = new Date(endValue);

                    if (end <= start) {
                        showValidationError(`${field.name}: End Date & Time harus lebih besar dari Start Date & Time.`);
                        return false;
                    }

                    if (prevEnd && start <= prevEnd) {
                        showValidationError(`${field.name}: Start Date & Time harus lebih besar dari periode sebelumnya.`);
                        return false;
                    }

                    prevEnd = end;
                }

                return true;
            }
        </script>
    </x-slot>
</x-admin-layout>
