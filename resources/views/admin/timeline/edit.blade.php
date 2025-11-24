<x-admin-layout>
    <div class="container-fluid px-4 py-4">
        <!-- Header -->
        <div class="mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.timeline.index', ['period' => $timeline->period]) }}">Timeline Management</a></li>
                    <li class="breadcrumb-item active">Edit Timeline</li>
                </ol>
            </nav>
            <h1 class="h3 mb-2 text-gray-800 fw-bold">
                <i class="fas fa-edit text-primary me-2"></i>
                Edit Timeline
            </h1>
            <p class="text-muted">Perbarui informasi timeline</p>
        </div>

        <div class="row">
            <div class="col-xl-8 col-lg-10 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient-primary text-white border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Informasi Timeline
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.timeline.update', $timeline->id) }}" method="POST" id="timelineForm">
                            @csrf
                            @method('PUT')

                            <!-- Period and Title -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-calendar-check text-primary me-2"></i>
                                        Tahun Timeline <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           name="period" 
                                           class="form-control form-control-lg @error('period') is-invalid @enderror" 
                                           value="{{ old('period', $timeline->period) }}" 
                                           placeholder="Contoh: 2025"
                                           required>
                                    @error('period')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Masukkan satu tahun (4 digit), contoh: 2025</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-tag text-primary me-2"></i>
                                        Judul Timeline <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           name="title" 
                                           class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                           value="{{ old('title', $timeline->title) }}" 
                                           placeholder="Contoh: Proposal Submission"
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-align-left text-primary me-2"></i>
                                    Deskripsi <span class="text-muted">(Opsional)</span>
                                </label>
                                <textarea name="description" 
                                          class="form-control @error('description') is-invalid @enderror" 
                                          rows="3" 
                                          placeholder="Deskripsi singkat tentang timeline ini...">{{ old('description', $timeline->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4">

                            <!-- Upload Period -->
                            <div class="mb-4">
                                <h6 class="fw-bold text-gray-800 mb-3">
                                    <i class="fas fa-upload text-primary me-2"></i>
                                    Periode Upload
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Tanggal & Waktu Mulai <span class="text-danger">*</span>
                                        </label>
                                        <input type="datetime-local" 
                                               name="upload_start_date" 
                                               id="upload_start_date"
                                               class="form-control form-control-lg @error('upload_start_date') is-invalid @enderror" 
                                               value="{{ old('upload_start_date', $timeline->upload_start_date->format('Y-m-d\TH:i')) }}"
                                               required>
                                        @error('upload_start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Tanggal & Waktu Selesai <span class="text-danger">*</span>
                                        </label>
                                        <input type="datetime-local" 
                                               name="upload_end_date" 
                                               id="upload_end_date"
                                               class="form-control form-control-lg @error('upload_end_date') is-invalid @enderror" 
                                               value="{{ old('upload_end_date', $timeline->upload_end_date->format('Y-m-d\TH:i')) }}"
                                               required>
                                        @error('upload_end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Review Period -->
                            <div class="mb-4">
                                <h6 class="fw-bold text-gray-800 mb-3">
                                    <i class="fas fa-clipboard-check text-warning me-2"></i>
                                    Periode Review
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Tanggal & Waktu Mulai <span class="text-danger">*</span>
                                        </label>
                                        <input type="datetime-local" 
                                               name="review_start_date" 
                                               id="review_start_date"
                                               class="form-control form-control-lg @error('review_start_date') is-invalid @enderror" 
                                               value="{{ old('review_start_date', $timeline->review_start_date->format('Y-m-d\TH:i')) }}"
                                               required>
                                        @error('review_start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Tanggal & Waktu Selesai <span class="text-danger">*</span>
                                        </label>
                                        <input type="datetime-local" 
                                               name="review_end_date" 
                                               id="review_end_date"
                                               class="form-control form-control-lg @error('review_end_date') is-invalid @enderror" 
                                               value="{{ old('review_end_date', $timeline->review_end_date->format('Y-m-d\TH:i')) }}"
                                               required>
                                        @error('review_end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Additional Settings -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-sort text-primary me-2"></i>
                                        Urutan <span class="text-muted">(Opsional)</span>
                                    </label>
                                    <input type="number" 
                                           name="order" 
                                           class="form-control @error('order') is-invalid @enderror" 
                                           value="{{ old('order', $timeline->order) }}" 
                                           min="0"
                                           placeholder="0">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Urutan tampilan timeline (semakin kecil semakin atas)</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-toggle-on text-primary me-2"></i>
                                        Status
                                    </label>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="is_active" 
                                               id="is_active" 
                                               {{ old('is_active', $timeline->is_active) ? 'checked' : '' }}
                                               style="width: 3rem; height: 1.5rem; cursor: pointer;">
                                        <label class="form-check-label ms-2" for="is_active">
                                            Timeline Aktif
                                        </label>
                                    </div>
                                    <div class="form-text">Timeline aktif akan ditampilkan kepada pengguna</div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2 justify-content-end mt-4 pt-3 border-top">
                                <a href="{{ route('admin.timeline.index', ['period' => $timeline->period]) }}" 
                                   class="btn btn-lg btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-lg btn-primary">
                                    <i class="fas fa-save me-2"></i>Perbarui Timeline
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('timelineForm');
            
            form.addEventListener('submit', function(e) {
                if (!validateTimeline()) {
                    e.preventDefault();
                }
            });

            function validateTimeline() {
                const uploadStart = new Date(document.getElementById('upload_start_date').value);
                const uploadEnd = new Date(document.getElementById('upload_end_date').value);
                const reviewStart = new Date(document.getElementById('review_start_date').value);
                const reviewEnd = new Date(document.getElementById('review_end_date').value);

                // Validate Upload Period
                if (uploadEnd <= uploadStart) {
                    alert('⚠️ Tanggal selesai upload harus lebih besar dari tanggal mulai upload!');
                    return false;
                }

                // Validate Review Start after Upload End
                if (reviewStart < uploadEnd) {
                    alert('⚠️ Tanggal mulai review harus setelah tanggal selesai upload!');
                    return false;
                }

                // Validate Review Period
                if (reviewEnd <= reviewStart) {
                    alert('⚠️ Tanggal selesai review harus lebih besar dari tanggal mulai review!');
                    return false;
                }

                return true;
            }
        });
    </script>
    @endpush
</x-admin-layout>
