<x-admin-layout>
    <x-slot name="header">
        {{ __('Penelitian & Pengabdian/Pengaturan/Form Penilaian Laporan Kemajuan') }}
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show modern-card" role="alert" style="margin-bottom: 1.5rem; border-left: 4px solid #10b981;">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show modern-card" role="alert" style="margin-bottom: 1.5rem; border-left: 4px solid #ef4444;">
            <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show modern-card" role="alert" style="margin-bottom: 1.5rem; border-left: 4px solid #ef4444;">
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
                    <h4 class="mb-0"><i class="fa fa-clipboard-check me-2"></i>Form Penilaian Laporan Kemajuan</h4>
                </div>

                <div class="modern-card-body">
                    <ul class="nav nav-tabs modern-nav-tabs mb-4" id="formPenilaianTabs" role="tablist">
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

                    <div class="tab-content" id="formPenilaianTabsContent">
                        <!-- Tab Penelitian -->
                        <div class="tab-pane fade show active" id="penelitian" role="tabpanel" aria-labelledby="penelitian-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0"><i class="fa fa-flask me-2"></i>Daftar Komponen Penilaian - Penelitian</h5>
                                <button class="modern-btn modern-btn-primary" data-bs-toggle="modal" data-bs-target="#addFormModal" onclick="setJenis('penelitian')">
                                    <i class="fa fa-plus me-1"></i> Tambah Komponen
                                </button>
                            </div>
                            <div class="modern-table-container">
                                <table class="modern-table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Komponen Penilaian</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($formPenelitian as $index => $form)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><strong>{{ $form->komponen_penilaian }}</strong></td>
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
                                                <td colspan="3" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fa fa-inbox fa-2x mb-2"></i>
                                                        <p>Belum ada komponen penilaian untuk penelitian</p>
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
                                <h5 class="mb-0"><i class="fa fa-handshake me-2"></i>Daftar Komponen Penilaian - Pengabdian</h5>
                                <button class="modern-btn modern-btn-primary" data-bs-toggle="modal" data-bs-target="#addFormModal" onclick="setJenis('pengabdian')">
                                    <i class="fa fa-plus me-1"></i> Tambah Komponen
                                </button>
                            </div>
                            <div class="modern-table-container">
                                <table class="modern-table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kategori</th>
                                            <th>Komponen Penilaian</th>
                                            <th>Sub Komponen</th>
                                            <th>Nilai</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($formPengabdian as $index => $form)
                                            @php
                                                $subKomponenCount = $form->subKomponen->count();
                                                $rowspan = $subKomponenCount > 0 ? $subKomponenCount : 1;
                                                $totalNilai = $form->subKomponen->sum('nilai');
                                            @endphp
                                            @if($subKomponenCount > 0)
                                                @foreach($form->subKomponen as $subIndex => $sub)
                                                    <tr>
                                                        @if($subIndex === 0)
                                                            <td rowspan="{{ $rowspan }}">
                                                                {{ $index + 1 }}
                                                            </td>
                                                            <td rowspan="{{ $rowspan }}">
                                                                <strong>{{ $form->kategori ?? '-' }}</strong>
                                                            </td>
                                                            <td rowspan="{{ $rowspan }}">
                                                                <strong>{{ $form->komponen_penilaian }}</strong>
                                                            </td>
                                                        @endif
                                                        <td>
                                                            <strong>{{ $sub->sub_komponen }}</strong>
                                                            <span class="badge bg-primary ms-2">{{ number_format($sub->nilai, 2) }}</span>
                                                        </td>
                                                        @if($subIndex === 0)
                                                            <td rowspan="{{ $rowspan }}" style="vertical-align: middle;">
                                                                <strong class="text-primary">{{ number_format($totalNilai, 2) }}</strong>
                                                            </td>
                                                            <td rowspan="{{ $rowspan }}" style="vertical-align: middle;">
                                                                <div class="d-flex gap-2">
                                                                    <button type="button" class="modern-btn modern-btn-warning modern-btn-sm" onclick="editForm({{ $form->id }})" title="Edit">
                                                                        <i class="fa fa-edit me-1"></i> Ubah
                                                                    </button>
                                                                    <button type="button" class="modern-btn modern-btn-danger modern-btn-sm" onclick="deleteForm({{ $form->id }})" title="Hapus">
                                                                        <i class="fa fa-trash me-1"></i> Hapus
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td><strong>{{ $form->kategori ?? '-' }}</strong></td>
                                                    <td><strong>{{ $form->komponen_penilaian }}</strong></td>
                                                    <td class="text-muted">-</td>
                                                    <td class="text-muted">-</td>
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
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fa fa-inbox fa-2x mb-2"></i>
                                                        <p>Belum ada komponen penilaian untuk pengabdian</p>
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
                        <i class="fa fa-plus-circle me-2"></i>Form Tambah Komponen Penilaian
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" id="formPenilaianForm" action="{{ route('form-penilaian-laporan-kemajuan.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="jenis" id="formJenis" value="penelitian">
                    <div class="modal-body modern-card-body">
                        <!-- Kategori (only for pengabdian) -->
                        <div class="modern-form-group" id="kategoriGroup" style="display: none;">
                            <label for="kategori" class="modern-form-label">
                                <i class="fa fa-tag me-2"></i>Kategori <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="kategori" id="kategori" class="modern-form-input" placeholder="Masukkan kategori">
                        </div>

                        <div class="modern-form-group">
                            <label for="komponen_penilaian" class="modern-form-label">
                                <i class="fa fa-list me-2"></i>Komponen Penilaian <span class="text-danger">*</span>
                            </label>
                            <textarea name="komponen_penilaian" id="komponen_penilaian" class="modern-form-input" rows="3" placeholder="Masukkan komponen penilaian" required></textarea>
                        </div>

                        <div class="modern-form-group">
                            <label for="urutan" class="modern-form-label">
                                <i class="fa fa-sort-numeric-down me-2"></i>Urutan
                            </label>
                            <input type="number" name="urutan" id="urutan" class="modern-form-input" placeholder="Urutan (opsional)" min="0">
                        </div>

                        <!-- Sub Komponen Section (only for pengabdian) -->
                        <div id="subKomponenSection" style="display: none;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="modern-form-label mb-0">
                                    <i class="fa fa-list-ul me-2"></i>Sub Komponen <span class="text-danger">*</span>
                                </label>
                                <button type="button" class="modern-btn modern-btn-secondary modern-btn-sm" onclick="addSubKomponen()">
                                    <i class="fa fa-plus me-1"></i> Tambah Sub Komponen
                                </button>
                            </div>
                            <div id="subKomponenContainer">
                                <!-- Sub komponen akan ditambahkan di sini via JavaScript -->
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

    <x-slot name="scripts">
    <script>
        let currentJenis = 'penelitian';
        let subKomponenIndex = 0;

        function setJenis(jenis) {
            currentJenis = jenis;
            document.getElementById('formJenis').value = jenis;
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('formPenilaianForm').action = '{{ route("form-penilaian-laporan-kemajuan.store") }}';
            document.getElementById('modalTitle').innerHTML = '<i class="fa fa-plus-circle me-2"></i>Form Tambah Komponen Penilaian';
            
            // Reset form
            document.getElementById('formPenilaianForm').reset();
            document.getElementById('subKomponenContainer').innerHTML = '';
            subKomponenIndex = 0;
            
            // Show/hide kategori and sub komponen section
            if (jenis === 'pengabdian') {
                document.getElementById('kategoriGroup').style.display = 'block';
                document.getElementById('kategori').required = true;
                document.getElementById('subKomponenSection').style.display = 'block';
                addSubKomponen(); // Add first sub komponen
            } else {
                document.getElementById('kategoriGroup').style.display = 'none';
                document.getElementById('kategori').required = false;
                document.getElementById('subKomponenSection').style.display = 'none';
            }
        }

        function addSubKomponen(subKomponen = '', nilai = '') {
            const container = document.getElementById('subKomponenContainer');
            const index = subKomponenIndex++;
            
            const subKomponenHtml = `
                <div class="modern-card mb-3" id="subKomponen_${index}">
                    <div class="modern-card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong>Sub Komponen ${index + 1}</strong>
                            <button type="button" class="modern-btn modern-btn-danger modern-btn-sm" onclick="removeSubKomponen(${index})">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-8">
                                <input type="text" name="sub_komponen[${index}][sub_komponen]" 
                                    class="modern-form-input" 
                                    placeholder="Masukkan sub komponen" 
                                    value="${subKomponen}" required>
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="sub_komponen[${index}][nilai]" 
                                    class="modern-form-input" 
                                    placeholder="Nilai" 
                                    step="0.01" 
                                    min="0" 
                                    value="${nilai}" required>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', subKomponenHtml);
        }

        function removeSubKomponen(index) {
            const element = document.getElementById(`subKomponen_${index}`);
            if (element) {
                element.remove();
            }
        }

        function editForm(id) {
            fetch(`{{ url('admin/form-penilaian-laporan-kemajuan') }}/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    const form = data.form;
                    currentJenis = form.jenis;
                    
                    document.getElementById('formJenis').value = form.jenis;
                    document.getElementById('formMethod').value = 'PUT';
                    document.getElementById('formPenilaianForm').action = `{{ url('admin/form-penilaian-laporan-kemajuan') }}/${id}`;
                    document.getElementById('modalTitle').innerHTML = '<i class="fa fa-edit me-2"></i>Form Edit Komponen Penilaian';
                    
                    document.getElementById('kategori').value = form.kategori || '';
                    document.getElementById('komponen_penilaian').value = form.komponen_penilaian;
                    document.getElementById('urutan').value = form.urutan || '';
                    
                    // Show/hide kategori and sub komponen section
                    if (form.jenis === 'pengabdian') {
                        document.getElementById('kategoriGroup').style.display = 'block';
                        document.getElementById('kategori').required = true;
                        document.getElementById('subKomponenSection').style.display = 'block';
                        
                        // Clear and populate sub komponen
                        document.getElementById('subKomponenContainer').innerHTML = '';
                        subKomponenIndex = 0;
                        
                        if (form.sub_komponen && form.sub_komponen.length > 0) {
                            form.sub_komponen.forEach(sub => {
                                addSubKomponen(sub.sub_komponen, sub.nilai);
                            });
                        } else {
                            addSubKomponen(); // Add first sub komponen
                        }
                    } else {
                        document.getElementById('kategoriGroup').style.display = 'none';
                        document.getElementById('kategori').required = false;
                        document.getElementById('subKomponenSection').style.display = 'none';
                    }
                    
                    // Add hidden _method field for PUT
                    let methodInput = document.querySelector('input[name="_method"]');
                    if (!methodInput) {
                        methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'PUT';
                        document.getElementById('formPenilaianForm').appendChild(methodInput);
                    } else {
                        methodInput.value = 'PUT';
                    }
                    
                    new bootstrap.Modal(document.getElementById('addFormModal')).show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengambil data');
                });
        }

        function deleteForm(id) {
            if (confirm('Apakah Anda yakin ingin menghapus komponen penilaian ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('admin/form-penilaian-laporan-kemajuan') }}/${id}`;
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Handle form submission
        document.getElementById('formPenilaianForm').addEventListener('submit', function(e) {
            if (currentJenis === 'pengabdian') {
                const subKomponenInputs = document.querySelectorAll('input[name^="sub_komponen"]');
                if (subKomponenInputs.length === 0) {
                    e.preventDefault();
                    alert('Minimal harus ada 1 sub komponen untuk pengabdian');
                    return false;
                }
            }
        });
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
