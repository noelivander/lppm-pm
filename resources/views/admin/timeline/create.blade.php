<x-admin-layout>
    <x-slot name="header">
        {{ __('Buat Timeline') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="modern-card fade-in-up">
                    <div class="modern-card-header d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="fa fa-calendar-plus me-2"></i>Buat Timeline</h4>
                        <a href="{{ route('timeline.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fa fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                    <form method="POST" action="{{ route('timeline.store') }}" onsubmit="return validateTimeline()">
                        @csrf
                        <div class="modern-card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="period"><i class="fa fa-calendar-alt me-2"></i>Periode (Tahun) <span class="text-danger">*</span></label>
                                        <input type="text" name="period" id="period" class="modern-form-input" value="{{ old('period') }}" placeholder="Misal: 2025, 2026, 2027" required>
                                        <small class="text-muted">Masukkan tahun periode timeline (contoh: 2025)</small>
                                        @error('period')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="title"><i class="fa fa-tag me-2"></i>Judul</label>
                                        <input type="text" name="title" id="title" class="modern-form-input" value="{{ old('title') }}" placeholder="Misal: Timeline Penelitian 2025">
                                        @error('title')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="modern-form-group mb-4">
                                <label class="modern-form-label" for="description"><i class="fa fa-align-left me-2"></i>Deskripsi</label>
                                <textarea name="description" id="description" class="modern-form-input" rows="3" placeholder="Deskripsi timeline (opsional)">{{ old('description') }}</textarea>
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
                                        <label class="modern-form-label" for="upload_start_date"><i class="fa fa-calendar me-2"></i>Upload Start Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="upload_start_date" id="upload_start_date" class="modern-form-input" value="{{ old('upload_start_date') }}" required>
                                        @error('upload_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="upload_end_date"><i class="fa fa-calendar me-2"></i>Upload End Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="upload_end_date" id="upload_end_date" class="modern-form-input" value="{{ old('upload_end_date') }}" required>
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
                                        <label class="modern-form-label" for="review_start_date"><i class="fa fa-calendar me-2"></i>Review Start Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="review_start_date" id="review_start_date" class="modern-form-input" value="{{ old('review_start_date') }}" required>
                                        @error('review_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="review_end_date"><i class="fa fa-calendar me-2"></i>Review End Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="review_end_date" id="review_end_date" class="modern-form-input" value="{{ old('review_end_date') }}" required>
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
                                        <label class="modern-form-label" for="revision_start_date"><i class="fa fa-calendar me-2"></i>Revisi Start Date & Time</label>
                                        <input type="datetime-local" name="revision_start_date" id="revision_start_date" class="modern-form-input" value="{{ old('revision_start_date') }}">
                                        @error('revision_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="revision_end_date"><i class="fa fa-calendar me-2"></i>Revisi End Date & Time</label>
                                        <input type="datetime-local" name="revision_end_date" id="revision_end_date" class="modern-form-input" value="{{ old('revision_end_date') }}">
                                        @error('revision_end_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- 4. Periode Laporan Kemajuan -->
                            <h5 class="mb-3 text-primary"><i class="fa fa-chart-line me-2"></i>4. Periode Laporan Kemajuan</h5>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <small class="text-muted d-block mb-2"><strong>Pengajuan:</strong></small>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="progress_submission_start_date"><i class="fa fa-calendar me-2"></i>Pengajuan Start Date & Time</label>
                                        <input type="datetime-local" name="progress_submission_start_date" id="progress_submission_start_date" class="modern-form-input" value="{{ old('progress_submission_start_date') }}">
                                        @error('progress_submission_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="progress_submission_end_date"><i class="fa fa-calendar me-2"></i>Pengajuan End Date & Time</label>
                                        <input type="datetime-local" name="progress_submission_end_date" id="progress_submission_end_date" class="modern-form-input" value="{{ old('progress_submission_end_date') }}">
                                        @error('progress_submission_end_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <small class="text-muted d-block mb-2"><strong>Peninjauan/Revisi:</strong></small>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="progress_review_start_date"><i class="fa fa-calendar me-2"></i>Peninjauan Start Date & Time</label>
                                        <input type="datetime-local" name="progress_review_start_date" id="progress_review_start_date" class="modern-form-input" value="{{ old('progress_review_start_date') }}">
                                        @error('progress_review_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="progress_review_end_date"><i class="fa fa-calendar me-2"></i>Peninjauan End Date & Time</label>
                                        <input type="datetime-local" name="progress_review_end_date" id="progress_review_end_date" class="modern-form-input" value="{{ old('progress_review_end_date') }}">
                                        @error('progress_review_end_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- 5. Periode Laporan Akhir -->
                            <h5 class="mb-3 text-primary"><i class="fa fa-flag-checkered me-2"></i>5. Periode Laporan Akhir</h5>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <small class="text-muted d-block mb-2"><strong>Pengajuan:</strong></small>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="final_submission_start_date"><i class="fa fa-calendar me-2"></i>Pengajuan Start Date & Time</label>
                                        <input type="datetime-local" name="final_submission_start_date" id="final_submission_start_date" class="modern-form-input" value="{{ old('final_submission_start_date') }}">
                                        @error('final_submission_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="final_submission_end_date"><i class="fa fa-calendar me-2"></i>Pengajuan End Date & Time</label>
                                        <input type="datetime-local" name="final_submission_end_date" id="final_submission_end_date" class="modern-form-input" value="{{ old('final_submission_end_date') }}">
                                        @error('final_submission_end_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <small class="text-muted d-block mb-2"><strong>Peninjauan/Revisi:</strong></small>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="final_review_start_date"><i class="fa fa-calendar me-2"></i>Peninjauan Start Date & Time</label>
                                        <input type="datetime-local" name="final_review_start_date" id="final_review_start_date" class="modern-form-input" value="{{ old('final_review_start_date') }}">
                                        @error('final_review_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="final_review_end_date"><i class="fa fa-calendar me-2"></i>Peninjauan End Date & Time</label>
                                        <input type="datetime-local" name="final_review_end_date" id="final_review_end_date" class="modern-form-input" value="{{ old('final_review_end_date') }}">
                                        @error('final_review_end_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
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
                                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="me-2">
                                            Status Aktif
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="order"><i class="fa fa-sort-numeric-down me-2"></i>Urutan</label>
                                        <input type="number" name="order" id="order" class="modern-form-input" value="{{ old('order', 0) }}" min="0">
                                        <small class="text-muted">Urutan tampil (0 = pertama)</small>
                                    </div>
                                </div>
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
        <script>
            function validateTimeline() {
                const fields = [
                    { start: 'upload_start_date', end: 'upload_end_date', name: 'Upload' },
                    { start: 'review_start_date', end: 'review_end_date', name: 'Review' },
                    { start: 'revision_start_date', end: 'revision_end_date', name: 'Revisi', optional: true },
                    { start: 'progress_submission_start_date', end: 'progress_submission_end_date', name: 'Laporan Kemajuan - Pengajuan', optional: true },
                    { start: 'progress_review_start_date', end: 'progress_review_end_date', name: 'Laporan Kemajuan - Peninjauan', optional: true },
                    { start: 'final_submission_start_date', end: 'final_submission_end_date', name: 'Laporan Akhir - Pengajuan', optional: true },
                    { start: 'final_review_start_date', end: 'final_review_end_date', name: 'Laporan Akhir - Peninjauan', optional: true },
                ];

                let prevEnd = null;

                for (let i = 0; i < fields.length; i++) {
                    const field = fields[i];
                    const startInput = document.getElementById(field.start);
                    const endInput = document.getElementById(field.end);

                    if (!startInput || !endInput) continue;

                    const startValue = startInput.value;
                    const endValue = endInput.value;

                    // Skip validation if both are empty and field is optional
                    if (field.optional && !startValue && !endValue) {
                        continue;
                    }

                    // If one is filled, both must be filled
                    if ((startValue && !endValue) || (!startValue && endValue)) {
                        alert(`⚠ ${field.name}: Start dan End harus diisi keduanya atau dikosongkan keduanya.`);
                        return false;
                    }

                    if (startValue && endValue) {
                        const start = new Date(startValue);
                        const end = new Date(endValue);

                        if (end <= start) {
                            alert(`⚠ ${field.name}: End Date & Time harus lebih besar dari Start Date & Time.`);
                            return false;
                        }

                        // Check if current start is after previous end
                        if (prevEnd && start <= prevEnd) {
                            alert(`⚠ ${field.name}: Start Date & Time harus lebih besar dari periode sebelumnya.`);
                            return false;
                        }

                        prevEnd = end;
                    }
                }

                return true;
            }
        </script>
    </x-slot>
</x-admin-layout>
