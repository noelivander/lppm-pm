<x-dosen-layout>
    <x-slot name="header">
        {{ __('Buat Laporan Kemajuan Pengabdian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3 fade-in-up">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                        <h3 class="mb-0">
                            <i class="fa fa-chart-line me-2"></i>{{ $isEdit ? 'Edit' : 'Buat' }} Laporan Kemajuan Pengabdian
                        </h3>
                        <a href="{{ route('pengabdian-dos.laporan-kemajuan.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fa fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                    </div>

                    @if (!$timeline || !$timeline->progress_submission_start_date || !$timeline->progress_submission_end_date)
                        <div class="modern-alert modern-alert-danger">
                            <i class="fa fa-exclamation-circle me-2"></i>Belum ada jadwal pengajuan laporan kemajuan yang aktif. Form dinonaktifkan.
                        </div>
                    @else
                        @if (!$isWithinProgressWindow)
                            <div class="modern-alert modern-alert-warning">
                                <i class="fa fa-clock me-2"></i>
                                @if ($currentDate < $timeline->progress_submission_start_date)
                                    Periode pengajuan laporan kemajuan akan dimulai pada <strong>{{ $timeline->progress_submission_start_date->format('d M Y H:i') }}</strong>.
                                @else
                                    Periode pengajuan laporan kemajuan telah berakhir pada <strong>{{ $timeline->progress_submission_end_date->format('d M Y H:i') }}</strong>.
                                @endif
                            </div>
                        @else
                            <div class="modern-alert modern-alert-info">
                                <i class="fa fa-info-circle me-2"></i>Periode pengajuan laporan kemajuan sedang berlangsung. Akan berakhir pada <strong>{{ $timeline->progress_submission_end_date->format('d M Y H:i') }}</strong>.
                            </div>
                        @endif
                    @endif

                    <!-- Informasi Proposal -->
                    <div class="modern-card mb-4">
                        <div class="modern-card-header">
                            <h5 class="mb-0">
                                <i class="fa fa-info-circle me-2"></i>Informasi Proposal
                            </h5>
                        </div>
                        <div class="modern-card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="modern-form-label">Judul Proposal</label>
                                        <div class="fw-bold">{{ $proposal->judul }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="modern-form-label">Skema</label>
                                        <div>
                                            <span class="status-badge skema">{{ $proposal->revisionParent->skema ?? $proposal->skema ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="modern-form-label">Periode Usulan</label>
                                        <div>{{ optional($proposal->revisionParent->created_at ?? $proposal->created_at)->format('Y') ?? '-' }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="modern-form-label">Tanggal Upload Revisi</label>
                                        <div>{{ optional($proposal->created_at)->format('d M Y H:i') ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Template Download -->
                    @if($skema)
                        <div class="modern-card mb-4">
                            <div class="modern-card-header">
                                <h5 class="mb-0">
                                    <i class="fa fa-download me-2"></i>Template Laporan
                                </h5>
                            </div>
                            <div class="modern-card-body">
                                <div class="row">
                                    @if($skema->template_laporan_kemajuan)
                                        <div class="col-md-6 mb-3">
                                            <div class="modern-alert modern-alert-info">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <i class="fa fa-file-word me-2"></i>
                                                        <strong>Template Laporan Kemajuan</strong>
                                                        <small class="d-block text-muted mt-1">Unduh template untuk diisi</small>
                                                    </div>
                                                    <a href="{{ asset('storage/' . $skema->template_laporan_kemajuan) }}" 
                                                       class="modern-btn modern-btn-primary modern-btn-sm" 
                                                       download>
                                                        <i class="fa fa-download me-1"></i> Unduh
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-6 mb-3">
                                            <div class="modern-alert modern-alert-warning">
                                                <i class="fa fa-exclamation-triangle me-2"></i>
                                                <strong>Template Laporan Kemajuan</strong>
                                                <small class="d-block text-muted mt-1">Template belum tersedia untuk skema ini</small>
                                            </div>
                                        </div>
                                    @endif

                                    @if($skema->template_laporan_keuangan_tahap_1)
                                        <div class="col-md-6 mb-3">
                                            <div class="modern-alert modern-alert-info">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <i class="fa fa-file-pdf me-2"></i>
                                                        <strong>Template Laporan Keuangan Tahap 1</strong>
                                                        <small class="d-block text-muted mt-1">Unduh template untuk diisi</small>
                                                    </div>
                                                    <a href="{{ asset('storage/' . $skema->template_laporan_keuangan_tahap_1) }}" 
                                                       class="modern-btn modern-btn-primary modern-btn-sm" 
                                                       download>
                                                        <i class="fa fa-download me-1"></i> Unduh
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-6 mb-3">
                                            <div class="modern-alert modern-alert-warning">
                                                <i class="fa fa-exclamation-triangle me-2"></i>
                                                <strong>Template Laporan Keuangan Tahap 1</strong>
                                                <small class="d-block text-muted mt-1">Template belum tersedia untuk skema ini</small>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="modern-alert modern-alert-warning mb-4">
                            <i class="fa fa-exclamation-triangle me-2"></i>Skema tidak ditemukan. Template tidak tersedia.
                        </div>
                    @endif

                    <!-- Form Upload Laporan -->
                    <div class="modern-card">
                        <div class="modern-card-header">
                            <h5 class="mb-0">
                                <i class="fa fa-upload me-2"></i>Upload Laporan
                            </h5>
                        </div>
                        <div class="modern-card-body">
                            <form method="POST" action="{{ route('pengabdian-dos.laporan-kemajuan.store', $proposal->id) }}" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="modern-form-group">
                                    <label for="laporan_kemajuan" class="modern-form-label">
                                        <i class="fa fa-file-pdf me-2"></i>Laporan Kemajuan <span class="text-danger">*</span>
                                    </label>
                                    @if($isEdit && $laporanKemajuan && $laporanKemajuan->laporan_kemajuan)
                                        @php
                                            $fileExists = Storage::disk('public')->exists($laporanKemajuan->laporan_kemajuan);
                                        @endphp
                                        @if($fileExists)
                                            <div class="modern-alert modern-alert-info mb-2">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <i class="fa fa-file-pdf me-2"></i>
                                                        <strong>File saat ini:</strong> 
                                                        <a href="{{ asset('storage/' . $laporanKemajuan->laporan_kemajuan) }}" target="_blank" class="text-decoration-none fw-semibold" style="color: #1e40af;">
                                                            {{ basename($laporanKemajuan->laporan_kemajuan) }}
                                                        </a>
                                                        <small class="d-block text-muted mt-1">Unggah file baru untuk mengganti</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="modern-alert modern-alert-warning mb-2">
                                                <i class="fa fa-exclamation-triangle me-2"></i>File tidak ditemukan. Silakan unggah ulang file.
                                            </div>
                                        @endif
                                    @endif
                                    <input type="file" 
                                           name="laporan_kemajuan" 
                                           id="laporan_kemajuan" 
                                           class="modern-form-input" 
                                           accept=".pdf"
                                           {{ !$isWithinProgressWindow ? 'disabled' : '' }}
                                           {{ !$isEdit ? 'required' : '' }}>
                                    <small class="form-text text-muted">Format: PDF (.pdf) saja, maksimal 10MB</small>
                                    <div id="laporan_kemajuan_error" class="text-danger small mt-1" style="display: none;"></div>
                                </div>

                                <div class="modern-form-group">
                                    <label for="laporan_keuangan_tahap_1" class="modern-form-label">
                                        <i class="fa fa-file-pdf me-2"></i>Laporan Keuangan Tahap 1 <span class="text-danger">*</span>
                                    </label>
                                    @if($isEdit && $laporanKemajuan && $laporanKemajuan->laporan_keuangan_tahap_1)
                                        @php
                                            $fileExists = Storage::disk('public')->exists($laporanKemajuan->laporan_keuangan_tahap_1);
                                        @endphp
                                        @if($fileExists)
                                            <div class="modern-alert modern-alert-info mb-2">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <i class="fa fa-file-pdf me-2"></i>
                                                        <strong>File saat ini:</strong> 
                                                        <a href="{{ asset('storage/' . $laporanKemajuan->laporan_keuangan_tahap_1) }}" target="_blank" class="text-decoration-none fw-semibold" style="color: #1e40af;">
                                                            {{ basename($laporanKemajuan->laporan_keuangan_tahap_1) }}
                                                        </a>
                                                        <small class="d-block text-muted mt-1">Unggah file baru untuk mengganti</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="modern-alert modern-alert-warning mb-2">
                                                <i class="fa fa-exclamation-triangle me-2"></i>File tidak ditemukan. Silakan unggah ulang file.
                                            </div>
                                        @endif
                                    @endif
                                    <input type="file" 
                                           name="laporan_keuangan_tahap_1" 
                                           id="laporan_keuangan_tahap_1" 
                                           class="modern-form-input" 
                                           accept=".pdf"
                                           {{ !$isWithinProgressWindow ? 'disabled' : '' }}
                                           {{ !$isEdit ? 'required' : '' }}>
                                    <small class="form-text text-muted">Format: PDF (.pdf) saja, maksimal 10MB</small>
                                    <div id="laporan_keuangan_tahap_1_error" class="text-danger small mt-1" style="display: none;"></div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('pengabdian-dos.laporan-kemajuan.index') }}" class="modern-btn modern-btn-secondary">
                                        <i class="fa fa-times me-1"></i> Batal
                                    </a>
                                    <button type="submit" 
                                            class="modern-btn modern-btn-primary"
                                            {{ !$isWithinProgressWindow ? 'disabled' : '' }}>
                                        <i class="fa fa-save me-1"></i> {{ $isEdit ? 'Update' : 'Simpan' }} Laporan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dosen-layout>

<x-slot name="scripts">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[enctype="multipart/form-data"]');
            const laporanKemajuanInput = document.getElementById('laporan_kemajuan');
            const laporanKeuanganInput = document.getElementById('laporan_keuangan_tahap_1');
            const laporanKemajuanError = document.getElementById('laporan_kemajuan_error');
            const laporanKeuanganError = document.getElementById('laporan_keuangan_tahap_1_error');
            const maxSize = 10 * 1024 * 1024; // 10MB in bytes

            function validateFileSize(input, errorDiv, fieldName) {
                if (input.files && input.files[0]) {
                    const file = input.files[0];
                    const fileSize = file.size;
                    
                    // Check file extension
                    if (!file.name.toLowerCase().endsWith('.pdf')) {
                        errorDiv.textContent = 'Format file harus PDF (.pdf)';
                        errorDiv.style.display = 'block';
                        input.value = '';
                        return false;
                    }
                    
                    // Check file size
                    if (fileSize > maxSize) {
                        const sizeInMB = (fileSize / (1024 * 1024)).toFixed(2);
                        errorDiv.textContent = `Ukuran file terlalu besar (${sizeInMB} MB). Maksimal 10MB.`;
                        errorDiv.style.display = 'block';
                        input.value = '';
                        return false;
                    }
                    
                    // Clear error if valid
                    errorDiv.style.display = 'none';
                    return true;
                }
                return true;
            }

            laporanKemajuanInput.addEventListener('change', function() {
                validateFileSize(this, laporanKemajuanError, 'laporan kemajuan');
            });

            laporanKeuanganInput.addEventListener('change', function() {
                validateFileSize(this, laporanKeuanganError, 'laporan keuangan tahap 1');
            });

            form.addEventListener('submit', function(e) {
                let isValid = true;
                const hasExistingKemajuan = {{ $isEdit && $laporanKemajuan && $laporanKemajuan->laporan_kemajuan ? 'true' : 'false' }};
                const hasExistingKeuangan = {{ $isEdit && $laporanKemajuan && $laporanKemajuan->laporan_keuangan_tahap_1 ? 'true' : 'false' }};

                // Validasi hanya jika file dipilih (untuk edit, file tidak wajib jika sudah ada)
                if (laporanKemajuanInput.files && laporanKemajuanInput.files[0]) {
                    if (!validateFileSize(laporanKemajuanInput, laporanKemajuanError, 'laporan kemajuan')) {
                        isValid = false;
                    }
                } else if (!hasExistingKemajuan) {
                    // Jika tidak ada file yang dipilih dan tidak ada file existing, wajib upload
                    laporanKemajuanError.textContent = 'File laporan kemajuan wajib diupload.';
                    laporanKemajuanError.style.display = 'block';
                    isValid = false;
                }

                if (laporanKeuanganInput.files && laporanKeuanganInput.files[0]) {
                    if (!validateFileSize(laporanKeuanganInput, laporanKeuanganError, 'laporan keuangan tahap 1')) {
                        isValid = false;
                    }
                } else if (!hasExistingKeuangan) {
                    // Jika tidak ada file yang dipilih dan tidak ada file existing, wajib upload
                    laporanKeuanganError.textContent = 'File laporan keuangan tahap 1 wajib diupload.';
                    laporanKeuanganError.style.display = 'block';
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>
</x-slot>



