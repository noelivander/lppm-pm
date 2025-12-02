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
                                        <input type="number" name="period" id="period" class="modern-form-input" value="{{ old('period') }}" placeholder="2025" required min="1900" max="2999" step="1" inputmode="numeric">
                                        <small class="text-muted">Masukkan tahun periode timeline (contoh: 2025). Hanya angka diperbolehkan.</small>
                                        @error('period')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="title"><i class="fa fa-tag me-2"></i>Judul <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title" class="modern-form-input" value="{{ old('title') }}" placeholder="Misal: Timeline Penelitian 2025" required>
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
                                        <label class="modern-form-label" for="upload_start_date"></i>Upload Start Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="upload_start_date" id="upload_start_date" class="modern-form-input" value="{{ old('upload_start_date') }}" required>
                                        @error('upload_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="upload_end_date"></i>Upload End Date & Time <span class="text-danger">*</span></label>
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
                                        <label class="modern-form-label" for="review_start_date"></i>Review Start Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="review_start_date" id="review_start_date" class="modern-form-input" value="{{ old('review_start_date') }}" required>
                                        @error('review_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="review_end_date"></i>Review End Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="review_end_date" id="review_end_date" class="modern-form-input" value="{{ old('review_end_date') }}" required>
                                        @error('review_end_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Periode Penyetujuan Admin -->
                            <h5 class="mb-3 text-primary"><i class="fa fa-gavel me-2"></i>3. Periode Penyetujuan Admin</h5>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="admin_decision_start_date"></i>Penyetujuan Admin Start Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="admin_decision_start_date" id="admin_decision_start_date" class="modern-form-input" value="{{ old('admin_decision_start_date') }}" required>
                                        @error('admin_decision_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="admin_decision_end_date"></i>Penyetujuan Admin End Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="admin_decision_end_date" id="admin_decision_end_date" class="modern-form-input" value="{{ old('admin_decision_end_date') }}" required>
                                        @error('admin_decision_end_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- 4. Periode Revisi Proposal (single) -->
                            <h5 class="mb-3 text-primary"><i class="fa fa-edit me-2"></i>4. Periode Revisi Proposal</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="revision_start_date"></i>Revisi Start Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="revision_start_date" id="revision_start_date" class="modern-form-input" value="{{ old('revision_start_date') }}" required>
                                        @error('revision_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="revision_end_date"></i>Revisi End Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="revision_end_date" id="revision_end_date" class="modern-form-input" value="{{ old('revision_end_date') }}" required>
                                        @error('revision_end_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- periode tinjau revisi dihapus; revisi hanya satu periode (start–end) -->

                            <!-- 5. Periode Laporan Kemajuan -->
                            <h5 class="mb-3 text-primary"><i class="fa fa-chart-line me-2"></i>5. Periode Laporan Kemajuan</h5>
                            <div class="row mb-3">
                                <div class="col-12">
                    
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="progress_submission_start_date"></i>Pengajuan Start Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="progress_submission_start_date" id="progress_submission_start_date" class="modern-form-input" value="{{ old('progress_submission_start_date') }}" required>
                                        @error('progress_submission_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="progress_submission_end_date"></i>Pengajuan End Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="progress_submission_end_date" id="progress_submission_end_date" class="modern-form-input" value="{{ old('progress_submission_end_date') }}" required>
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
                                        <input type="datetime-local" name="progress_review_start_date" id="progress_review_start_date" class="modern-form-input" value="{{ old('progress_review_start_date') }}" required>
                                        @error('progress_review_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                    </div>
                    <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="progress_review_end_date"></i>Peninjauan End Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="progress_review_end_date" id="progress_review_end_date" class="modern-form-input" value="{{ old('progress_review_end_date') }}" required>
                                        @error('progress_review_end_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                    </div>
                </div>

                            <!-- 6. Periode Laporan Akhir -->
                            <h5 class="mb-3 text-primary"><i class="fa fa-flag-checkered me-2"></i>6. Periode Laporan Akhir</h5>
                            <div class="row mb-3">
                                
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="final_submission_start_date"></i>Pengajuan Start Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="final_submission_start_date" id="final_submission_start_date" class="modern-form-input" value="{{ old('final_submission_start_date') }}" required>
                                        @error('final_submission_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="final_submission_end_date"></i>Pengajuan End Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="final_submission_end_date" id="final_submission_end_date" class="modern-form-input" value="{{ old('final_submission_end_date') }}" required>
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
                                        <input type="datetime-local" name="final_review_start_date" id="final_review_start_date" class="modern-form-input" value="{{ old('final_review_start_date') }}" required>
                                        @error('final_review_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                    </div>
                    <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="final_review_end_date"></i>Peninjauan End Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="final_review_end_date" id="final_review_end_date" class="modern-form-input" value="{{ old('final_review_end_date') }}" required>
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
                                {{-- <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="order"><i class="fa fa-sort-numeric-down me-2"></i>Urutan</label>
                                        <input type="number" name="order" id="order" class="modern-form-input" value="{{ old('order', 0) }}" min="0">
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
                { start: 'admin_decision_start_date', end: 'admin_decision_end_date', name: 'Penyetujuan Admin' },
                { start: 'revision_start_date', end: 'revision_end_date', name: 'Revisi - Pengajuan' },
                { start: 'revision_review_start_date', end: 'revision_review_end_date', name: 'Revisi - Peninjauan' },
                { start: 'progress_submission_start_date', end: 'progress_submission_end_date', name: 'Laporan Kemajuan - Pengajuan' },
                { start: 'progress_review_start_date', end: 'progress_review_end_date', name: 'Laporan Kemajuan - Peninjauan' },
                { start: 'final_submission_start_date', end: 'final_submission_end_date', name: 'Laporan Akhir - Pengajuan' },
                { start: 'final_review_start_date', end: 'final_review_end_date', name: 'Laporan Akhir - Peninjauan' },
            ];

            document.addEventListener('DOMContentLoaded', () => {
                const periodInput = document.getElementById('period');
                const titleInput = document.getElementById('title');
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

                    timelineFields.forEach((field, index) => {
                        const startInput = document.getElementById(field.start);
                        const endInput = document.getElementById(field.end);
                        if (!startInput || !endInput) return;

                        // Set min untuk start input berdasarkan periode sebelumnya
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

                        // Set min untuk end input berdasarkan start input
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

                        // Update currentMin untuk periode berikutnya
                        const endValue = endInput.value;
                        if (endValue) {
                            currentMin = endValue;
                        } else if (startValue) {
                            // Jika end belum diisi tapi start sudah, gunakan start sebagai min untuk periode berikutnya
                            currentMin = startValue;
                        }

                        // Validasi real-time dan tampilkan error jika ada
                        validateFieldPair(startInput, endInput, field.name);
                    });
                };

                const validateFieldPair = (startInput, endInput, fieldName) => {
                    const startValue = startInput.value;
                    const endValue = endInput.value;
                    
                    // Hapus error message sebelumnya
                    const existingError = startInput.parentElement.querySelector('.field-error');
                    if (existingError) {
                        existingError.remove();
                    }

                    if (startValue && endValue) {
                        const start = new Date(startValue);
                        const end = new Date(endValue);
                        
                        if (end <= start) {
                            showFieldError(startInput, `${fieldName}: End Date harus lebih besar dari Start Date.`);
                            return false;
                        }
                    }
                    
                    return true;
                };

                const showFieldError = (input, message) => {
                    const existingError = input.parentElement.querySelector('.field-error');
                    if (existingError) {
                        existingError.textContent = message;
                    } else {
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'text-danger small mt-1 field-error';
                        errorDiv.textContent = message;
                        input.parentElement.appendChild(errorDiv);
                    }
                    input.classList.add('is-invalid');
                };

                const handlePeriodChange = () => {
                    applyYearLimits();
                    applySequentialConstraints();
                };

                // Validasi period input
                if (periodInput) {
                    periodInput.addEventListener('input', () => {
                        const periodValue = periodInput.value.trim();
                        const periodNumber = parseInt(periodValue, 10);
                        const existingError = periodInput.parentElement.querySelector('.field-error');
                        
                        if (existingError) {
                            existingError.remove();
                        }
                        periodInput.classList.remove('is-invalid');
                        
                        if (periodValue && (!/^\d{4}$/.test(periodValue) || periodNumber < 1900 || periodNumber > 2999)) {
                            showFieldError(periodInput, 'Periode harus berupa 4 digit angka antara 1900 dan 2999.');
                        } else {
                            handlePeriodChange();
                        }
                    });
                    periodInput.addEventListener('blur', () => {
                        const periodValue = periodInput.value.trim();
                        if (!periodValue) {
                            showFieldError(periodInput, 'Periode wajib diisi.');
                        }
                    });
                }

                // Validasi title input
                if (titleInput) {
                    titleInput.addEventListener('input', () => {
                        const existingError = titleInput.parentElement.querySelector('.field-error');
                        if (existingError) {
                            existingError.remove();
                        }
                        titleInput.classList.remove('is-invalid');
                    });
                    titleInput.addEventListener('blur', () => {
                        if (!titleInput.value.trim()) {
                            showFieldError(titleInput, 'Judul wajib diisi.');
                        }
                    });
                }
                
                // Event listener untuk setiap input date
                dateInputs.forEach(input => {
                    input.addEventListener('input', () => {
                        applySequentialConstraints();
                        // Hapus error styling saat user mengubah nilai
                        input.classList.remove('is-invalid');
                        const errorDiv = input.parentElement.querySelector('.field-error');
                        if (errorDiv) {
                            errorDiv.remove();
                        }
                    });
                    input.addEventListener('change', applySequentialConstraints);
                    input.addEventListener('blur', () => {
                        if (!input.value) {
                            const fieldName = input.id.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                            showFieldError(input, `${fieldName} wajib diisi.`);
                        }
                    });
                });

                // Inisialisasi saat halaman dimuat
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
                // Validasi period
                const periodInput = document.getElementById('period');
                if (periodInput) {
                    const periodValue = periodInput.value.trim();
                    if (!periodValue) {
                        showValidationError('Periode wajib diisi.');
                        periodInput.focus();
                        return false;
                    }
                    const periodNumber = parseInt(periodValue, 10);
                    if (!/^\d{4}$/.test(periodValue) || periodNumber < 1900 || periodNumber > 2999) {
                        showValidationError('Periode harus berupa 4 digit angka antara 1900 dan 2999.');
                        periodInput.focus();
                        return false;
                    }
                }

                // Validasi title
                const titleInput = document.getElementById('title');
                if (titleInput) {
                    const titleValue = titleInput.value.trim();
                    if (!titleValue) {
                        showValidationError('Judul wajib diisi.');
                        titleInput.focus();
                        return false;
                    }
                    if (titleValue.length > 255) {
                        showValidationError('Judul tidak boleh lebih dari 255 karakter.');
                        titleInput.focus();
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
                        if (!startValue) {
                            startInput.focus();
                        } else {
                            endInput.focus();
                        }
                        return false;
                    }

                    const start = new Date(startValue);
                    const end = new Date(endValue);

                    if (end <= start) {
                        showValidationError(`${field.name}: End Date & Time harus lebih besar dari Start Date & Time.`);
                        endInput.focus();
                        return false;
                    }

                    if (prevEnd && start <= prevEnd) {
                        showValidationError(`${field.name}: Start Date & Time harus lebih besar dari periode sebelumnya.`);
                        startInput.focus();
                        return false;
                    }

                    prevEnd = end;
            }

            return true;
        }
    </script>
    </x-slot>
</x-admin-layout>
