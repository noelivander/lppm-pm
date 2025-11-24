<x-admin-layout>
    <x-admin.heading name="Timeline">
        @if($selectedPeriod)
            <a href="{{ route('admin.timeline.create', ['period' => $selectedPeriod]) }}" class="modern-btn modern-btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Tambah Timeline
            </a>
        @endif
    </x-admin.heading>

    <div class="modern-card mb-4 fade-in-up">
        <div class="modern-card-header d-flex align-items-start align-items-md-center justify-content-between flex-column flex-md-row gap-3">
            <div>
                <h6 class="m-0 fw-semibold text-primary">
                    <i class="fas fa-filter me-2"></i>Tahun Timeline
                </h6>
                <p class="text-muted small mb-0">Pilih atau buat tahun untuk mengelola timeline penelitian dan pengabdian.</p>
            </div>
        </div>
        <div class="modern-card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-gray-700 mb-2">Tahun Timeline</label>
                    <select id="periodSelector" class="form-select form-select-lg rounded-3">
                        <option value="">-- Pilih Tahun --</option>
                        @foreach($periods as $period)
                            <option value="{{ $period }}" {{ $selectedPeriod == $period ? 'selected' : '' }}>
                                {{ $period }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 d-flex flex-column flex-md-row gap-2">
            <a href="{{ route('admin.timeline.create') }}" class="modern-btn modern-btn-secondary flex-grow-1">
                <i class="fas fa-calendar-plus me-2"></i>Buat Timeline Baru
            </a>
                    @if($timelines->count() > 0)
                        <button type="button" class="modern-btn modern-btn-outline flex-grow-1" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>Cetak
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show fade-in-up" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($selectedPeriod)
        @if($timelines->count() > 0)
            <div class="row g-4">
                @foreach($timelines as $index => $timeline)
                    <div class="col-lg-6 col-xl-4">
                        <div class="modern-card timeline-card h-100 fade-in-up" data-timeline-id="{{ $timeline->id }}">
                            <div class="modern-card-header d-flex flex-column gap-3">
                                <div class="d-flex align-items-center justify-content-between gap-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="timeline-number badge bg-white text-primary shadow-sm">{{ $index + 1 }}</span>
                                        <div>
                                            <h5 class="mb-0 fw-bold text-gray-900">{{ $timeline->title }}</h5>
                                            <span class="badge bg-{{ $timeline->getStatusColor() }} px-3 py-2 mt-2 d-inline-flex align-items-center gap-2">
                                                <i class="fas fa-circle-notch"></i>{{ $timeline->getStatusLabel() }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-check form-switch m-0">
                                        <input class="form-check-input toggle-active" type="checkbox" data-id="{{ $timeline->id }}" {{ $timeline->is_active ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="modern-card-body">
                                @if($timeline->description)
                                    <p class="text-muted small mb-4">
                                        <i class="fas fa-info-circle me-1 text-primary"></i>{{ $timeline->description }}
                                    </p>
                                @endif

                                <div class="timeline-details">
                                    <div class="timeline-item mb-4">
                                        <div class="timeline-icon bg-primary-soft text-primary">
                                            <i class="fas fa-upload"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-semibold">Periode Upload</h6>
                                            <p class="mb-1 small text-muted"><i class="far fa-calendar me-1"></i>{{ $timeline->upload_start_date->format('d M Y, H:i') }}</p>
                                            <p class="mb-0 small text-muted"><i class="far fa-calendar-check me-1"></i>{{ $timeline->upload_end_date->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>

                                    <div class="timeline-item">
                                        <div class="timeline-icon bg-warning-soft text-warning">
                                            <i class="fas fa-clipboard-check"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-semibold">Periode Review</h6>
                                            <p class="mb-1 small text-muted"><i class="far fa-calendar me-1"></i>{{ $timeline->review_start_date->format('d M Y, H:i') }}</p>
                                            <p class="mb-0 small text-muted"><i class="far fa-calendar-check me-1"></i>{{ $timeline->review_end_date->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modern-card-footer d-flex justify-content-end gap-2 flex-wrap">
                                <a href="{{ route('admin.timeline.edit', $timeline->id) }}" class="modern-btn modern-btn-light modern-btn-sm">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                <button type="button" class="modern-btn modern-btn-danger modern-btn-sm delete-btn" data-id="{{ $timeline->id }}" data-title="{{ $timeline->title }}">
                                    <i class="fas fa-trash-alt me-1"></i>Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="modern-card fade-in-up text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-calendar-times fa-4x text-muted opacity-50"></i>
                </div>
                <h4 class="text-muted mb-3">Belum Ada Timeline</h4>
                <p class="text-muted mb-4">
                    Belum ada timeline untuk tahun <strong>{{ $selectedPeriod }}</strong>.<br>
                    Mulai dengan menambahkan timeline baru.
                </p>
                <a href="{{ route('admin.timeline.create', ['period' => $selectedPeriod]) }}" class="modern-btn modern-btn-primary modern-btn-lg">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Timeline Pertama
                </a>
            </div>
        @endif
    @else
        <div class="modern-card fade-in-up text-center py-5">
            <div class="mb-4">
                <i class="fas fa-calendar-alt fa-4x text-muted opacity-50"></i>
            </div>
            <h4 class="text-muted mb-3">Pilih Tahun Timeline</h4>
            <p class="text-muted mb-4">
                Silakan pilih tahun timeline dari dropdown di atas<br>
                atau buat timeline baru untuk memulai.
            </p>
            <a href="{{ route('admin.timeline.create') }}" class="modern-btn modern-btn-primary modern-btn-lg">
                <i class="fas fa-calendar-plus me-2"></i>Buat Timeline Baru
            </a>
        </div>
    @endif

    @push('styles')
    <style>
        .modern-card-header, .modern-card-body, .modern-card-footer {
            width: 100%;
        }
        .timeline-card .form-check-input {
            width: 2.75rem;
            height: 1.4rem;
        }
        .timeline-card .timeline-number {
            font-size: 1rem;
            padding: 0.4rem 0.85rem;
            border-radius: 999px;
        }
        .timeline-details .timeline-item {
            display: flex;
            gap: 1rem;
        }
        .timeline-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }
        .bg-primary-soft { background: rgba(124,58,237,0.12); }
        .bg-warning-soft { background: rgba(251,191,36,0.18); }
        @media (max-width: 991.98px) {
            .modern-card-header {
                flex-direction: column !important;
                align-items: flex-start !important;
            }
            .modern-card-header .d-flex.flex-column {
                width: 100%;
            }
            .modern-card-footer {
                flex-direction: column;
                align-items: stretch;
            }
            .modern-card-footer .modern-btn {
                width: 100%;
            }
        }
        @media (max-width: 575.98px) {
            .timeline-card .modern-card-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .modern-card-header .d-flex.align-items-start,
            .modern-card-header .d-flex.align-items-center {
                width: 100%;
            }
            .modern-card-body .row > div {
                width: 100%;
            }
            #periodSelector {
                width: 100%;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const periodSelector = document.getElementById('periodSelector');
            if (periodSelector) {
                periodSelector.addEventListener('change', function() {
                    if (this.value) {
                        window.location.href = `{{ route('admin.timeline.index') }}?period=${this.value}`;
                    } else {
                        window.location.href = `{{ route('admin.timeline.index') }}`;
                    }
                });
            }

            // Toggle Active Status
            document.querySelectorAll('.toggle-active').forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const timelineId = this.dataset.id;
                    const isActive = this.checked;

                    fetch(`/admin/timeline/${timelineId}/toggle-active`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show toast notification
                            showToast(data.message, 'success');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.checked = !isActive; // Revert on error
                        showToast('Terjadi kesalahan!', 'error');
                    });
                });
            });

            // Delete Timeline
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const timelineId = this.dataset.id;
                    const timelineTitle = this.dataset.title;

                    if (confirm(`Apakah Anda yakin ingin menghapus timeline "${timelineTitle}"?`)) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/admin/timeline/${timelineId}`;
                        
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}';
                        
                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'DELETE';
                        
                        form.appendChild(csrfToken);
                        form.appendChild(methodField);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });

            // Toast Notification Function
            function showToast(message, type = 'success') {
                const toast = document.createElement('div');
                toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
                toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                toast.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }
        });
    </script>
    @endpush
</x-admin-layout>
