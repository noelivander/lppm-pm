<x-admin-layout>
    <x-slot name="header">
        {{ __('Penelitian & Pengabdian/Pengaturan/Form Penilaian Review') }}
    </x-slot>

    @if(session('success'))
        <div class="modern-alert modern-alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="modern-alert modern-alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="modern-alert modern-alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <!-- Tabs Navigation -->
            <div class="modern-card fade-in-up">
                <div class="modern-card-header d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><i class="fa fa-clipboard-list me-2"></i>Form Penilaian Review</h4>
                </div>

                <div class="modern-card-body">
                    <ul class="nav nav-tabs modern-nav-tabs mb-4" id="formReviewTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="penelitian-tab" data-bs-toggle="tab" data-bs-target="#penelitian" 
                                type="button" role="tab" aria-controls="penelitian" aria-selected="true">
                                <i class="fa fa-flask me-2"></i>Penelitian
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pengabdian-tab" data-bs-toggle="tab" data-bs-target="#pengabdian" 
                                type="button" role="tab" aria-controls="pengabdian" aria-selected="false">
                                <i class="fa fa-handshake me-2"></i>Pengabdian
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="formReviewTabsContent">
                        <!-- Tab Penelitian -->
                        <div class="tab-pane fade show active" id="penelitian" role="tabpanel" aria-labelledby="penelitian-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0"><i class="fa fa-flask me-2"></i>Daftar Kriteria Penilaian - Penelitian</h5>
                                <button class="modern-btn modern-btn-primary" data-bs-toggle="modal" data-bs-target="#addFormModal" onclick="setJenis('penelitian')">
                                    <i class="fa fa-plus me-1"></i> Tambah Kriteria
                                </button>
                            </div>
                            <div class="modern-table-container">
                                <table class="modern-table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kriteria Penilaian</th>
                                            <th>Bobot (%)</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($formPenelitian as $index => $form)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><strong>{{ $form->kriteria_penilaian }}</strong></td>
                                                <td><strong class="text-primary">{{ $form->bobot == floor($form->bobot) ? number_format($form->bobot, 0) : number_format($form->bobot, 2) }}%</strong></td>
                                                <td>
                                                    @if($form->is_active)
                                                        <span class="status-badge selesai">
                                                            <i class="fa fa-check-circle me-1"></i>Aktif
                                                        </span>
                                                    @else
                                                        <span class="status-badge pending">
                                                            <i class="fa fa-times-circle me-1"></i>Nonaktif
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <button type="button" class="modern-btn modern-btn-warning modern-btn-sm" onclick="editForm({{ $form->id }})" title="Edit">
                                                            <i class="fa fa-edit me-1"></i> Ubah
                                                        </button>
                                                        <button type="button" class="modern-btn modern-btn-danger modern-btn-sm" onclick="deleteForm({{ $form->id }})" title="Hapus">
                                                            <i class="fa fa-trash me-1"></i> Hapus
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fa fa-inbox fa-2x mb-2"></i>
                                                        <p>Belum ada kriteria penilaian untuk penelitian</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab Pengabdian -->
                        <div class="tab-pane fade" id="pengabdian" role="tabpanel" aria-labelledby="pengabdian-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0"><i class="fa fa-handshake me-2"></i>Daftar Kriteria Penilaian - Pengabdian</h5>
                                <button class="modern-btn modern-btn-primary" data-bs-toggle="modal" data-bs-target="#addFormModal" onclick="setJenis('pengabdian')">
                                    <i class="fa fa-plus me-1"></i> Tambah Kriteria
                                </button>
                            </div>
                            <div class="modern-table-container">
                                <table class="modern-table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kriteria Penilaian</th>
                                            <th>Bobot (%)</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($formPengabdian as $index => $form)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><strong>{{ $form->kriteria_penilaian }}</strong></td>
                                                <td><strong class="text-primary">{{ $form->bobot == floor($form->bobot) ? number_format($form->bobot, 0) : number_format($form->bobot, 2) }}%</strong></td>
                                                <td>
                                                    @if($form->is_active)
                                                        <span class="status-badge selesai">
                                                            <i class="fa fa-check-circle me-1"></i>Aktif
                                                        </span>
                                                    @else
                                                        <span class="status-badge pending">
                                                            <i class="fa fa-times-circle me-1"></i>Nonaktif
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <button type="button" class="modern-btn modern-btn-warning modern-btn-sm" onclick="editForm({{ $form->id }})" title="Edit">
                                                            <i class="fa fa-edit me-1"></i> Ubah
                                                        </button>
                                                        <button type="button" class="modern-btn modern-btn-danger modern-btn-sm" onclick="deleteForm({{ $form->id }})" title="Hapus">
                                                            <i class="fa fa-trash me-1"></i> Hapus
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fa fa-inbox fa-2x mb-2"></i>
                                                        <p>Belum ada kriteria penilaian untuk pengabdian</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="addFormModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modern-card">
                <div class="modal-header modern-card-header">
                    <h5 class="modal-title mb-0" id="modalTitle">
                        <i class="fa fa-plus-circle me-2"></i>Form Tambah Kriteria Penilaian
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" id="formReviewForm" action="{{ route('form-penilaian-review.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="jenis" id="formJenis" value="penelitian">
                    <div class="modal-body modern-card-body">
                        <div class="modern-form-group">
                            <label for="kriteria_penilaian" class="modern-form-label">
                                <i class="fa fa-list me-2"></i>Kriteria Penilaian <span class="text-danger">*</span>
                            </label>
                            <textarea name="kriteria_penilaian" id="kriteria_penilaian" class="modern-form-input" rows="3" placeholder="Masukkan kriteria penilaian" required></textarea>
                        </div>

                        <div class="modern-form-group">
                            <label for="bobot" class="modern-form-label">
                                <i class="fa fa-percent me-2"></i>Bobot (%) <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="bobot" id="bobot" class="modern-form-input" placeholder="Masukkan bobot (0-100)" min="0" max="100" step="0.01" required>
                            <small class="text-muted">Total bobot semua kriteria sebaiknya 100%</small>
                        </div>

                        <div class="modern-form-group">
                            <label for="urutan" class="modern-form-label">
                                <i class="fa fa-sort-numeric-down me-2"></i>Urutan
                            </label>
                            <input type="number" name="urutan" id="urutan" class="modern-form-input" placeholder="Urutan (opsional)" min="0">
                        </div>

                        <div class="modern-form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                                <label class="form-check-label" for="is_active">
                                    <i class="fa fa-check-circle me-2"></i>Aktif
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modern-card-footer">
                        <button type="button" class="modern-btn modern-btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="modern-btn modern-btn-primary">
                            <i class="fa fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteFormModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content modern-card">
                <div class="modal-header modern-card-header">
                    <h5 class="modal-title mb-0">
                        <i class="fa fa-exclamation-triangle me-2 text-warning"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body modern-card-body">
                    <div class="text-center">
                        <i class="fa fa-trash fa-3x text-danger mb-3"></i>
                        <h6>Apakah Anda yakin ingin menghapus kriteria penilaian ini?</h6>
                        <p class="text-muted">Tindakan ini tidak dapat dibatalkan dan akan menghapus kriteria penilaian secara permanen.</p>
                    </div>
                </div>
                <div class="modal-footer modern-card-footer">
                    <button type="button" class="modern-btn modern-btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times me-1"></i> Batal
                    </button>
                    <form id="deleteFormForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" id="deleteFormBtn" class="modern-btn modern-btn-danger" onclick="confirmDeleteForm()">
                            <i class="fa fa-trash me-1"></i> Hapus Kriteria
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
    <script>
        // Handle tab activation based on URL fragment
        document.addEventListener('DOMContentLoaded', function() {
            const hash = window.location.hash;
            if (hash === '#pengabdian') {
                // Activate pengabdian tab
                const pengabdianTab = new bootstrap.Tab(document.getElementById('pengabdian-tab'));
                pengabdianTab.show();
            } else if (hash === '#penelitian') {
                // Activate penelitian tab
                const penelitianTab = new bootstrap.Tab(document.getElementById('penelitian-tab'));
                penelitianTab.show();
            }
        });

        function setJenis(jenis) {
            document.getElementById('formJenis').value = jenis;
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('formReviewForm').action = '{{ route("form-penilaian-review.store") }}';
            document.getElementById('modalTitle').innerHTML = '<i class="fa fa-plus-circle me-2"></i>Form Tambah Kriteria Penilaian';
            
            // Reset form
            document.getElementById('formReviewForm').reset();
            document.getElementById('is_active').checked = true; // Default checked
        }

        function editForm(id) {
            const editBtn = event.target.closest('button');
            const originalText = editBtn.innerHTML;
            editBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Loading...';
            editBtn.disabled = true;
            
            fetch(`/administrator/form-penilaian-review/${id}/edit`)
                .then(response => {
                    if (!response.ok) {
                        // Check if response is JSON
                        const contentType = response.headers.get("content-type");
                        if (contentType && contentType.includes("application/json")) {
                            return response.json().then(data => {
                                throw new Error(data.error || 'Terjadi kesalahan saat mengambil data');
                            });
                        } else {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        throw new Error(data.error);
                    }
                    
                    const form = data.form;
                    
                    document.getElementById('formJenis').value = form.jenis;
                    document.getElementById('formMethod').value = 'PUT';
                    document.getElementById('formReviewForm').action = `/administrator/form-penilaian-review/${id}`;
                    document.getElementById('modalTitle').innerHTML = '<i class="fa fa-edit me-2"></i>Form Edit Kriteria Penilaian';
                    
                    document.getElementById('kriteria_penilaian').value = form.kriteria_penilaian;
                    document.getElementById('bobot').value = form.bobot;
                    document.getElementById('urutan').value = form.urutan || '';
                    document.getElementById('is_active').checked = form.is_active == 1;
                    
                    // Add hidden _method field for PUT
                    let methodInput = document.querySelector('input[name="_method"]');
                    if (!methodInput) {
                        methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'PUT';
                        document.getElementById('formReviewForm').appendChild(methodInput);
                    } else {
                        methodInput.value = 'PUT';
                    }
                    
                    new bootstrap.Modal(document.getElementById('addFormModal')).show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengambil data: ' + error.message);
                })
                .finally(() => {
                    editBtn.innerHTML = originalText;
                    editBtn.disabled = false;
                });
        }

        function deleteForm(id) {
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteFormModal'));
            document.getElementById('deleteFormForm').action = `/administrator/form-penilaian-review/${id}`;
            deleteModal.show();
        }

        function confirmDeleteForm() {
            const form = document.getElementById('deleteFormForm');
            const submitBtn = document.getElementById('deleteFormBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Menghapus...';
            submitBtn.disabled = true;
            form.submit();
        }
    </script>
    </x-slot>

    <style>
        .modern-nav-tabs {
            border-bottom: 2px solid var(--border-color, #e2e8f0);
            padding: 0;
        }

        .modern-nav-tabs .nav-item {
            margin-bottom: -2px;
        }

        .modern-nav-tabs .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            padding: 0.875rem 1.5rem;
            color: var(--text-secondary, #334155);
            font-weight: 500;
            transition: all 0.3s ease;
            background: transparent;
            border-radius: 0;
        }

        .modern-nav-tabs .nav-link:hover {
            color: var(--primary-color, #4f46e5);
            background: rgba(79, 70, 229, 0.05);
            border-bottom-color: rgba(79, 70, 229, 0.3);
        }

        .modern-nav-tabs .nav-link.active {
            color: var(--primary-color, #4f46e5);
            background: rgba(79, 70, 229, 0.08);
            border-bottom-color: var(--primary-color, #4f46e5);
            font-weight: 600;
        }

        .modern-nav-tabs .nav-link i {
            font-size: 0.875rem;
        }

        .fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }

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
    </style>
</x-admin-layout>

