<x-admin-layout>
    <div class="container-fluid px-4 py-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-2 text-gray-800 fw-bold">
                    <i class="fas fa-calendar-alt text-primary me-2"></i>
                    Timeline Management
                </h1>
                <p class="text-muted mb-0">Kelola jadwal timeline penelitian dan pengabdian per periode</p>
            </div>
            <div>
                @if($selectedPeriod)
                    <a href="{{ route('admin.timeline.create', ['period' => $selectedPeriod]) }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Timeline
                    </a>
                @endif
            </div>
        </div>

        <!-- Period Selector Card -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-gray-700 mb-2">
                            <i class="fas fa-filter me-2"></i>Pilih Periode Akademik
                        </label>
                        <select id="periodSelector" class="form-select form-select-lg" style="border-radius: 10px;">
                            <option value="">-- Pilih Periode --</option>
                            @foreach($periods as $period)
                                <option value="{{ $period }}" {{ $selectedPeriod == $period ? 'selected' : '' }}>
                                    {{ $period }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-2 mt-3 mt-md-0 justify-content-md-end">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#newPeriodModal">
                                <i class="fas fa-calendar-plus me-2"></i>Buat Periode Baru
                            </button>
                            @if($timelines->count() > 0)
                                <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                                    <i class="fas fa-print me-2"></i>Cetak
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($selectedPeriod)
            @if($timelines->count() > 0)
                <!-- Timeline Cards Grid -->
                <div class="row g-4">
                    @foreach($timelines as $index => $timeline)
                        <div class="col-lg-6 col-xl-4">
                            <div class="card timeline-card h-100 border-0 shadow-sm" data-timeline-id="{{ $timeline->id }}">
                                <!-- Card Header with Status Badge -->
                                <div class="card-header bg-gradient-primary text-white border-0 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <div class="d-flex align-items-center">
                                        <div class="timeline-number me-3">
                                            <span class="badge bg-white text-primary" style="font-size: 1rem; padding: 0.5rem 0.75rem;">
                                                {{ $index + 1 }}
                                            </span>
                                        </div>
                                        <h5 class="mb-0 fw-bold">{{ $timeline->title }}</h5>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input toggle-active" type="checkbox" 
                                               data-id="{{ $timeline->id }}" 
                                               {{ $timeline->is_active ? 'checked' : '' }}
                                               style="cursor: pointer; width: 3rem; height: 1.5rem;">
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body p-4">
                                    @if($timeline->description)
                                        <p class="text-muted small mb-3">
                                            <i class="fas fa-info-circle me-1"></i>
                                            {{ $timeline->description }}
                                        </p>
                                    @endif

                                    <!-- Status Badge -->
                                    <div class="mb-3">
                                        <span class="badge bg-{{ $timeline->getStatusColor() }} px-3 py-2">
                                            <i class="fas fa-circle-notch me-1"></i>
                                            {{ $timeline->getStatusLabel() }}
                                        </span>
                                    </div>

                                    <!-- Timeline Details -->
                                    <div class="timeline-details">
                                        <!-- Upload Period -->
                                        <div class="timeline-item mb-3">
                                            <div class="d-flex align-items-start">
                                                <div class="timeline-icon bg-primary bg-opacity-10 text-primary me-3">
                                                    <i class="fas fa-upload"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 fw-semibold text-gray-800">Periode Upload</h6>
                                                    <p class="mb-0 small text-muted">
                                                        <i class="far fa-calendar me-1"></i>
                                                        {{ $timeline->upload_start_date->format('d M Y, H:i') }}
                                                    </p>
                                                    <p class="mb-0 small text-muted">
                                                        <i class="far fa-calendar-check me-1"></i>
                                                        {{ $timeline->upload_end_date->format('d M Y, H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Review Period -->
                                        <div class="timeline-item">
                                            <div class="d-flex align-items-start">
                                                <div class="timeline-icon bg-warning bg-opacity-10 text-warning me-3">
                                                    <i class="fas fa-clipboard-check"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 fw-semibold text-gray-800">Periode Review</h6>
                                                    <p class="mb-0 small text-muted">
                                                        <i class="far fa-calendar me-1"></i>
                                                        {{ $timeline->review_start_date->format('d M Y, H:i') }}
                                                    </p>
                                                    <p class="mb-0 small text-muted">
                                                        <i class="far fa-calendar-check me-1"></i>
                                                        {{ $timeline->review_end_date->format('d M Y, H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Footer with Actions -->
                                <div class="card-footer bg-light border-0">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('admin.timeline.edit', $timeline->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger delete-btn" 
                                                data-id="{{ $timeline->id }}"
                                                data-title="{{ $timeline->title }}">
                                            <i class="fas fa-trash-alt me-1"></i>Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-calendar-times fa-4x text-muted opacity-50"></i>
                        </div>
                        <h4 class="text-muted mb-3">Belum Ada Timeline</h4>
                        <p class="text-muted mb-4">
                            Belum ada timeline untuk periode <strong>{{ $selectedPeriod }}</strong>.<br>
                            Mulai dengan menambahkan timeline baru.
                        </p>
                        <a href="{{ route('admin.timeline.create', ['period' => $selectedPeriod]) }}" 
                           class="btn btn-primary btn-lg">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Timeline Pertama
                        </a>
                    </div>
                </div>
            @endif
        @else
            <!-- No Period Selected -->
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-calendar-alt fa-4x text-muted opacity-50"></i>
                    </div>
                    <h4 class="text-muted mb-3">Pilih Periode Akademik</h4>
                    <p class="text-muted mb-4">
                        Silakan pilih periode akademik dari dropdown di atas<br>
                        atau buat periode baru untuk memulai.
                    </p>
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#newPeriodModal">
                        <i class="fas fa-calendar-plus me-2"></i>Buat Periode Baru
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- New Period Modal -->
    <div class="modal fade" id="newPeriodModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-calendar-plus me-2"></i>Buat Periode Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="newPeriodForm">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Periode Akademik</label>
                            <input type="text" class="form-control form-control-lg" id="newPeriodInput" 
                                   placeholder="Contoh: 2025/2026" required>
                            <div class="form-text">Format: YYYY/YYYY</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="createPeriodBtn">
                        <i class="fas fa-check me-2"></i>Buat & Lanjutkan
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .timeline-card {
            transition: all 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
        }

        .timeline-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .timeline-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .timeline-details {
            position: relative;
        }

        .timeline-item {
            position: relative;
        }

        .timeline-item:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 19px;
            top: 45px;
            width: 2px;
            height: calc(100% - 20px);
            background: linear-gradient(to bottom, #e9ecef 0%, transparent 100%);
        }

        .card-header.bg-gradient-primary {
            padding: 1.25rem;
        }

        .form-check-input:checked {
            background-color: #10b981;
            border-color: #10b981;
        }

        .badge {
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        @media print {
            .btn, .form-check, .card-footer {
                display: none !important;
            }
        }

        /* Animation for cards */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .timeline-card {
            animation: fadeInUp 0.5s ease-out;
        }

        .timeline-card:nth-child(1) { animation-delay: 0.1s; }
        .timeline-card:nth-child(2) { animation-delay: 0.2s; }
        .timeline-card:nth-child(3) { animation-delay: 0.3s; }
        .timeline-card:nth-child(4) { animation-delay: 0.4s; }
        .timeline-card:nth-child(5) { animation-delay: 0.5s; }
        .timeline-card:nth-child(6) { animation-delay: 0.6s; }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Period Selector
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

            // Create New Period
            const createPeriodBtn = document.getElementById('createPeriodBtn');
            const newPeriodInput = document.getElementById('newPeriodInput');
            
            if (createPeriodBtn) {
                createPeriodBtn.addEventListener('click', function() {
                    const period = newPeriodInput.value.trim();
                    
                    if (!period) {
                        alert('Silakan masukkan periode akademik!');
                        return;
                    }

                    // Validate format (YYYY/YYYY)
                    const periodRegex = /^\d{4}\/\d{4}$/;
                    if (!periodRegex.test(period)) {
                        alert('Format periode tidak valid! Gunakan format: YYYY/YYYY (contoh: 2025/2026)');
                        return;
                    }

                    // Redirect to create page with period parameter
                    window.location.href = `{{ route('admin.timeline.create') }}?period=${period}`;
                });

                // Allow Enter key to submit
                newPeriodInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        createPeriodBtn.click();
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
