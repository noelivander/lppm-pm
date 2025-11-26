<x-admin-layout>
    <x-slot name="header">
        {{ __('Penelitian & Pengabdian/Pengaturan/Kelola RAB') }}
    </x-slot>

    <x-admin.heading name="Penelitian & Pengabdian/Pengaturan/Kelola RAB">
    </x-admin.heading>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tabs Navigation -->
    <div class="modern-card mb-4 fade-in-up">
        <div class="modern-card-header">
            <ul class="nav nav-tabs card-header-tabs" id="rabTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="kelompok-tab" data-bs-toggle="tab" data-bs-target="#kelompok" 
                        type="button" role="tab" aria-controls="kelompok" aria-selected="true">
                        <i class="fa fa-layer-group me-2"></i>Kelompok RAB
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="komponen-tab" data-bs-toggle="tab" data-bs-target="#komponen" 
                        type="button" role="tab" aria-controls="komponen" aria-selected="false">
                        <i class="fa fa-cubes me-2"></i>Komponen RAB
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="satuan-tab" data-bs-toggle="tab" data-bs-target="#satuan" 
                        type="button" role="tab" aria-controls="satuan" aria-selected="false">
                        <i class="fa fa-ruler me-2"></i>Satuan RAB
                    </button>
                </li>
            </ul>
        </div>

        <div class="modern-card-body">
            <div class="tab-content" id="rabTabsContent">
                <!-- Tab Kelompok RAB -->
                <div class="tab-pane fade show active" id="kelompok" role="tabpanel" aria-labelledby="kelompok-tab">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><i class="fa fa-layer-group me-2"></i>Daftar Kelompok RAB</h5>
                        <button class="modern-btn modern-btn-primary" data-bs-toggle="modal" data-bs-target="#addKelompokModal">
                            <i class="fa fa-plus me-1"></i> Tambah Kelompok
                        </button>
                    </div>
                    <div class="modern-table-container">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Kelompok</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kelompokRab as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td><strong>{{ $item->nama }}</strong></td>
                                    <td>
                                        @if($item->deskripsi)
                                            <small class="text-muted">{{ Str::limit($item->deskripsi, 50) }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->is_active)
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
                                            <button type="button" class="modern-btn modern-btn-warning modern-btn-sm" 
                                                onclick="editKelompok({{ $item->id }})" title="Edit">
                                                <i class="fa fa-edit me-1"></i> Ubah
                                            </button>
                                            <button type="button" class="modern-btn modern-btn-danger modern-btn-sm" 
                                                onclick="deleteKelompok({{ $item->id }})" title="Hapus">
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
                                            <p>Belum ada kelompok RAB yang ditambahkan</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Komponen RAB -->
                <div class="tab-pane fade" id="komponen" role="tabpanel" aria-labelledby="komponen-tab">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><i class="fa fa-cubes me-2"></i>Daftar Komponen RAB</h5>
                        <button class="modern-btn modern-btn-primary" data-bs-toggle="modal" data-bs-target="#addKomponenModal">
                            <i class="fa fa-plus me-1"></i> Tambah Komponen
                        </button>
                    </div>
                    <div class="modern-table-container">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Komponen</th>
                                    <th>Deskripsi</th>
                                    <th>Satuan Tersedia</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($komponenRab as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td><strong>{{ $item->nama }}</strong></td>
                                    <td>
                                        @if($item->deskripsi)
                                            <small class="text-muted">{{ Str::limit($item->deskripsi, 50) }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $assignedSatuan = $item->satuan->where('is_active', true);
                                        @endphp
                                        @if($assignedSatuan->count() > 0)
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($assignedSatuan as $satuan)
                                                    <span class="status-badge kode" title="{{ $satuan->nama }}">
                                                        {{ $satuan->singkatan ?? $satuan->nama }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted small">Belum ada satuan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->is_active)
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
                                            <button type="button" class="modern-btn modern-btn-primary modern-btn-sm" 
                                                onclick="assignSatuan({{ $item->id }})" title="Atur Satuan">
                                                <i class="fa fa-link me-1"></i> Atur Satuan
                                            </button>
                                            <button type="button" class="modern-btn modern-btn-warning modern-btn-sm" 
                                                onclick="editKomponen({{ $item->id }})" title="Edit">
                                                <i class="fa fa-edit me-1"></i> Ubah
                                            </button>
                                            <button type="button" class="modern-btn modern-btn-danger modern-btn-sm" 
                                                onclick="deleteKomponen({{ $item->id }})" title="Hapus">
                                                <i class="fa fa-trash me-1"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fa fa-inbox fa-2x mb-2"></i>
                                            <p>Belum ada komponen RAB yang ditambahkan</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Satuan RAB -->
                <div class="tab-pane fade" id="satuan" role="tabpanel" aria-labelledby="satuan-tab">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><i class="fa fa-ruler me-2"></i>Daftar Satuan RAB</h5>
                        <button class="modern-btn modern-btn-primary" data-bs-toggle="modal" data-bs-target="#addSatuanModal">
                            <i class="fa fa-plus me-1"></i> Tambah Satuan
                        </button>
                    </div>
                    <div class="modern-table-container">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Satuan</th>
                                    <th>Singkatan</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($satuanRab as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td><strong>{{ $item->nama }}</strong></td>
                                    <td>
                                        @if($item->singkatan)
                                            <span class="status-badge kode">{{ $item->singkatan }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->deskripsi)
                                            <small class="text-muted">{{ Str::limit($item->deskripsi, 50) }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->is_active)
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
                                            <button type="button" class="modern-btn modern-btn-warning modern-btn-sm" 
                                                onclick="editSatuan({{ $item->id }})" title="Edit">
                                                <i class="fa fa-edit me-1"></i> Ubah
                                            </button>
                                            <button type="button" class="modern-btn modern-btn-danger modern-btn-sm" 
                                                onclick="deleteSatuan({{ $item->id }})" title="Hapus">
                                                <i class="fa fa-trash me-1"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fa fa-inbox fa-2x mb-2"></i>
                                            <p>Belum ada satuan RAB yang ditambahkan</p>
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

    <!-- Include Modals - Will be in separate file or continue here -->
    @include('admin.ppm.pengaturan.rab.modals')

    <x-slot name="scripts">
        <script>
            // Kelompok RAB Functions
            function editKelompok(id) {
                const editBtn = event.target.closest('button');
                const originalText = editBtn.innerHTML;
                editBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Loading...';
                editBtn.disabled = true;
                
                fetch(`{{ url('/administrator/rab/kelompok') }}/${id}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) throw new Error(data.error);
                        
                        document.getElementById('edit_kelompok_nama').value = data.nama || '';
                        document.getElementById('edit_kelompok_deskripsi').value = data.deskripsi || '';
                        document.getElementById('edit_kelompok_is_active').checked = data.is_active == 1;
                        document.getElementById('editKelompokForm').action = `{{ url('/administrator/rab/kelompok') }}/${id}`;
                        
                        new bootstrap.Modal(document.getElementById('editKelompokModal')).show();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengambil data. Silakan coba lagi.');
                    })
                    .finally(() => {
                        editBtn.innerHTML = originalText;
                        editBtn.disabled = false;
                    });
            }

            function deleteKelompok(id) {
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteKelompokModal'));
                document.getElementById('deleteKelompokForm').action = `{{ url('/administrator/rab/kelompok') }}/${id}`;
                deleteModal.show();
            }

            function confirmDeleteKelompok() {
                const form = document.getElementById('deleteKelompokForm');
                const submitBtn = document.getElementById('deleteKelompokBtn');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Menghapus...';
                submitBtn.disabled = true;
                form.submit();
            }

            // Komponen RAB Functions
            function editKomponen(id) {
                const editBtn = event.target.closest('button');
                const originalText = editBtn.innerHTML;
                editBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Loading...';
                editBtn.disabled = true;
                
                fetch(`{{ url('/administrator/rab/komponen') }}/${id}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) throw new Error(data.error);
                        
                        document.getElementById('edit_komponen_nama').value = data.nama || '';
                        document.getElementById('edit_komponen_deskripsi').value = data.deskripsi || '';
                        document.getElementById('edit_komponen_is_active').checked = data.is_active == 1;
                        document.getElementById('editKomponenForm').action = `{{ url('/administrator/rab/komponen') }}/${id}`;
                        
                        new bootstrap.Modal(document.getElementById('editKomponenModal')).show();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengambil data. Silakan coba lagi.');
                    })
                    .finally(() => {
                        editBtn.innerHTML = originalText;
                        editBtn.disabled = false;
                    });
            }

            function deleteKomponen(id) {
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteKomponenModal'));
                document.getElementById('deleteKomponenForm').action = `{{ url('/administrator/rab/komponen') }}/${id}`;
                deleteModal.show();
            }

            function confirmDeleteKomponen() {
                const form = document.getElementById('deleteKomponenForm');
                const submitBtn = document.getElementById('deleteKomponenBtn');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Menghapus...';
                submitBtn.disabled = true;
                form.submit();
            }

            // Satuan RAB Functions
            function editSatuan(id) {
                const editBtn = event.target.closest('button');
                const originalText = editBtn.innerHTML;
                editBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Loading...';
                editBtn.disabled = true;
                
                fetch(`{{ url('/administrator/rab/satuan') }}/${id}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) throw new Error(data.error);
                        
                        document.getElementById('edit_satuan_nama').value = data.nama || '';
                        document.getElementById('edit_satuan_singkatan').value = data.singkatan || '';
                        document.getElementById('edit_satuan_deskripsi').value = data.deskripsi || '';
                        document.getElementById('edit_satuan_is_active').checked = data.is_active == 1;
                        document.getElementById('editSatuanForm').action = `{{ url('/administrator/rab/satuan') }}/${id}`;
                        
                        new bootstrap.Modal(document.getElementById('editSatuanModal')).show();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengambil data. Silakan coba lagi.');
                    })
                    .finally(() => {
                        editBtn.innerHTML = originalText;
                        editBtn.disabled = false;
                    });
            }

            function deleteSatuan(id) {
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteSatuanModal'));
                document.getElementById('deleteSatuanForm').action = `{{ url('/administrator/rab/satuan') }}/${id}`;
                deleteModal.show();
            }

            function confirmDeleteSatuan() {
                const form = document.getElementById('deleteSatuanForm');
                const submitBtn = document.getElementById('deleteSatuanBtn');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Menghapus...';
                submitBtn.disabled = true;
                form.submit();
            }

            // Assign Satuan to Komponen Functions
            function assignSatuan(komponenId) {
                const assignModal = new bootstrap.Modal(document.getElementById('assignSatuanModal'));
                const checkboxesContainer = document.getElementById('assignSatuanCheckboxes');
                
                // Show loading
                checkboxesContainer.innerHTML = '<div class="text-center text-muted py-3"><i class="fa fa-spinner fa-spin me-2"></i>Memuat satuan...</div>';
                assignModal.show();

                // Fetch komponen data and satuan
                Promise.all([
                    fetch(`{{ url('/administrator/rab/komponen') }}/${komponenId}/edit`),
                    fetch(`{{ url('/administrator/rab/komponen') }}/${komponenId}/satuan`)
                ])
                .then(responses => Promise.all(responses.map(r => r.json())))
                .then(([komponenData, satuanData]) => {
                    if (komponenData.error || satuanData.error) {
                        throw new Error(komponenData.error || satuanData.error);
                    }

                    // Set komponen info
                    document.getElementById('assign_komponen_id').value = komponenId;
                    document.getElementById('assign_komponen_nama').value = komponenData.nama;

                    // Get assigned satuan IDs
                    const assignedIds = satuanData.assigned ? satuanData.assigned.map(s => s.id) : [];
                    const allSatuan = satuanData.all || [];

                    // Build checkboxes
                    if (allSatuan.length === 0) {
                        checkboxesContainer.innerHTML = '<div class="text-center text-muted py-3">Belum ada satuan yang tersedia</div>';
                    } else {
                        let html = '';
                        allSatuan.forEach(satuan => {
                            const isChecked = assignedIds.includes(satuan.id);
                            html += `
                                <div class="form-check mb-2">
                                    <input class="form-check-input satuan-checkbox" type="checkbox" 
                                        value="${satuan.id}" id="satuan_${satuan.id}" ${isChecked ? 'checked' : ''}>
                                    <label class="form-check-label" for="satuan_${satuan.id}">
                                        <strong>${satuan.nama}</strong>
                                        ${satuan.singkatan ? `<span class="text-muted small">(${satuan.singkatan})</span>` : ''}
                                    </label>
                                </div>
                            `;
                        });
                        checkboxesContainer.innerHTML = html;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    checkboxesContainer.innerHTML = '<div class="alert alert-danger">Terjadi kesalahan saat memuat data</div>';
                });
            }

            function saveSatuanAssignment() {
                const komponenId = document.getElementById('assign_komponen_id').value;
                const checkboxes = document.querySelectorAll('.satuan-checkbox:checked');
                const satuanIds = Array.from(checkboxes).map(cb => cb.value);

                const submitBtn = event.target;
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Menyimpan...';
                submitBtn.disabled = true;

                fetch(`{{ url('/administrator/rab/komponen') }}/${komponenId}/assign-satuan`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ satuan_ids: satuanIds })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById('assignSatuanModal')).hide();
                        location.reload(); // Reload to show updated assignments
                    } else {
                        throw new Error(data.error || 'Terjadi kesalahan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan: ' + error.message);
                })
                .finally(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
            }
        </script>
    </x-slot>
</x-admin-layout>

