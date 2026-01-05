<x-admin-layout>
    <x-slot name="header">
        {{ __('Penelitian & Pengabdian/Pengaturan/Form Penilaian Laporan Akhir') }}
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

    @if(session('warning'))
        <div class="modern-alert modern-alert-warning alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-triangle me-2"></i>{{ session('warning') }}
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
                    <h4 class="mb-0"><i class="fa fa-clipboard-check me-2"></i>Form Penilaian Laporan Akhir</h4>
                </div>

                <div class="modern-card-body">
                    <ul class="nav nav-tabs modern-nav-tabs mb-4" id="formPenilaianTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="penelitian-tab" data-bs-toggle="tab"
                                data-bs-target="#penelitian" type="button" role="tab" aria-controls="penelitian"
                                aria-selected="true">
                                <i class="fa fa-flask me-2"></i>Penelitian
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pengabdian-tab" data-bs-toggle="tab"
                                data-bs-target="#pengabdian" type="button" role="tab" aria-controls="pengabdian"
                                aria-selected="false">
                                <i class="fa fa-handshake me-2"></i>Pengabdian
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="formPenilaianTabsContent">
                        <!-- Tab Penelitian -->
                        <div class="tab-pane fade show active" id="penelitian" role="tabpanel"
                            aria-labelledby="penelitian-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0"><i class="fa fa-flask me-2"></i>Daftar Komponen Penilaian - Penelitian
                                </h5>
                                <button class="modern-btn modern-btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addFormModal" onclick="setJenisV4('penelitian')">
                                    <i class="fa fa-plus me-1"></i> Tambah Komponen
                                </button>
                            </div>
                            <div class="modern-table-container">
                                <table class="modern-table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Komponen Penilaian</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($formPenelitian as $index => $form)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><strong>{{ $form->komponen_penilaian }}</strong></td>
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
                                                        <button type="button"
                                                            class="modern-btn modern-btn-warning modern-btn-sm"
                                                            onclick="editForm({{ $form->id }})" title="Edit">
                                                            <i class="fa fa-edit me-1"></i> Ubah
                                                        </button>
                                                        <button type="button"
                                                            class="modern-btn modern-btn-danger modern-btn-sm"
                                                            onclick="deleteForm({{ $form->id }})" title="Hapus">
                                                            <i class="fa fa-trash me-1"></i> Hapus
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
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
                                <h5 class="mb-0"><i class="fa fa-handshake me-2"></i>Daftar Komponen Penilaian -
                                    Pengabdian</h5>
                                <button class="modern-btn modern-btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addFormModal" onclick="setJenisV4('pengabdian')">
                                    <i class="fa fa-plus me-1"></i> Tambah Komponen
                                </button>
                            </div>
                            <div class="modern-table-container">
                                <table class="modern-table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Komponen Penilaian</th>
                                            <th>Sub Komponen</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $rowNumber = 1;
                                        @endphp
                                        @forelse($formPengabdian as $kategori => $komponenList)
                                            @php
                                                // Calculate total rows for this kategori (including kategori header)
                                                $kategoriTotalRows = 1; // 1 for kategori header row
                                                foreach ($komponenList as $komponen) {
                                                    $subCount = $komponen->subKomponen->count();
                                                    $kategoriTotalRows += $subCount > 0 ? $subCount : 1;
                                                }
                                            @endphp
                                            {{-- Kategori Header Row --}}
                                            <tr class="kategori-header-row">
                                                <td rowspan="{{ $kategoriTotalRows }}">{{ $rowNumber }}</td>
                                                <td colspan="4" class="kategori-header-cell" style="text-align: center;">
                                                    <strong>{{ $kategori ?? '-' }}</strong>
                                                </td>
                                            </tr>
                                            @foreach($komponenList as $komponenIndex => $form)
                                                @php
                                                    $subKomponenCount = $form->subKomponen->count();
                                                    $komponenRowspan = $subKomponenCount > 0 ? $subKomponenCount : 1;
                                                    $totalNilai = $form->subKomponen->sum('skor'); // Changed from 'nilai' to 'skor'
                                                    $komponenFirstRow = true;
                                                @endphp
                                                @if($subKomponenCount > 0)
                                                    @foreach($form->subKomponen as $subIndex => $sub)
                                                        <tr>
                                                            @if($komponenFirstRow)
                                                                <td rowspan="{{ $komponenRowspan }}">
                                                                    <strong>{{ $form->komponen_penilaian }}</strong>
                                                                </td>
                                                                @php $komponenFirstRow = false; @endphp
                                                            @endif
                                                            <td>
                                                                <strong>{{ $sub->keterangan }}</strong>
                                                                <strong
                                                                    class="text-primary ms-2">{{ $sub->skor == floor($sub->skor) ? number_format($sub->skor, 0) : number_format($sub->skor, 2) }}</strong>
                                                            </td>
                                                            @if($subIndex === 0)
                                                                <td rowspan="{{ $komponenRowspan }}" style="vertical-align: middle;">
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
                                                                <td rowspan="{{ $komponenRowspan }}" style="vertical-align: middle;">
                                                                    <div class="d-flex gap-2">
                                                                        <button type="button"
                                                                            class="modern-btn modern-btn-warning modern-btn-sm"
                                                                            onclick="editForm({{ $form->id }})" title="Edit">
                                                                            <i class="fa fa-edit me-1"></i> Ubah
                                                                        </button>
                                                                        <button type="button"
                                                                            class="modern-btn modern-btn-danger modern-btn-sm"
                                                                            onclick="deleteForm({{ $form->id }})" title="Hapus">
                                                                            <i class="fa fa-trash me-1"></i> Hapus
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td><strong>{{ $form->komponen_penilaian }}</strong></td>
                                                        <td class="text-muted">-</td>
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
                                                                <button type="button"
                                                                    class="modern-btn modern-btn-warning modern-btn-sm"
                                                                    onclick="editForm({{ $form->id }})" title="Edit">
                                                                    <i class="fa fa-edit me-1"></i> Ubah
                                                                </button>
                                                                <button type="button"
                                                                    class="modern-btn modern-btn-danger modern-btn-sm"
                                                                    onclick="deleteForm({{ $form->id }})" title="Hapus">
                                                                    <i class="fa fa-trash me-1"></i> Hapus
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            @php $rowNumber++; @endphp
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
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
                <form method="POST" id="formPenilaianForm" action="{{ route('form-penilaian-laporan-akhir.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="jenis" id="formJenis" value="penelitian">
                    <div class="modal-body modern-card-body">
                        <!-- Kategori (only for pengabdian) -->
                        <div class="modern-form-group" id="kategoriGroup" style="display: none;">
                            <label for="kategori" class="modern-form-label">
                                <i class="fa fa-tag me-2"></i>Kategori <span class="text-danger">*</span>
                            </label>
                            <div class="position-relative">
                                <select id="kategoriSelect" class="modern-form-select"
                                    onchange="handleKategoriChange()">
                                    <option value="">-- Pilih Kategori atau Ketik Baru --</option>
                                    @foreach($kategoriList as $kat)
                                        <option value="{{ $kat }}">{{ $kat }}</option>
                                    @endforeach
                                    <option value="__NEW__" style="font-weight: 600; color: #4f46e5;">+ Ketik Kategori
                                        Baru</option>
                                </select>
                                <input type="text" name="kategori" id="kategori" class="modern-form-input mt-2"
                                    style="display: none;" placeholder="Masukkan kategori baru" autocomplete="off">
                                <small class="text-muted d-block mt-1">
                                    <i class="fa fa-info-circle me-1"></i>Pilih dari dropdown atau pilih "Ketik Kategori
                                    Baru" untuk menambah kategori baru
                                </small>
                            </div>
                        </div>

                        <div class="modern-form-group">
                            <label for="komponen_penilaian" class="modern-form-label">
                                <i class="fa fa-list me-2"></i>Komponen Penilaian <span class="text-danger">*</span>
                            </label>
                            <textarea name="komponen_penilaian" id="komponen_penilaian" class="modern-form-input"
                                rows="3" placeholder="Masukkan komponen penilaian" required></textarea>
                        </div>

                        <div class="modern-form-group">
                            <label for="urutan" class="modern-form-label">
                                <i class="fa fa-sort-numeric-down me-2"></i>Urutan
                            </label>
                            <input type="number" name="urutan" id="urutan" class="modern-form-input"
                                placeholder="Urutan (opsional)" min="0">
                        </div>

                        <div class="modern-form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                    value="1" checked>
                                <label class="form-check-label" for="is_active">
                                    <i class="fa fa-check-circle me-2"></i>Aktif
                                </label>
                            </div>
                        </div>

                        <!-- Sub Komponen Section (only for pengabdian) -->
                        <div id="subKomponenSection" style="display: none;">
                            <!-- Sub Komponen for Pengabdian -->
                            <div id="pengabdianSubsSection" style="display: none;">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="modern-form-label mb-0">
                                        <i class="fa fa-list-ul me-2"></i>Sub Komponen <span
                                            class="text-danger">*</span>
                                    </label>
                                    <button type="button" class="modern-btn modern-btn-secondary modern-btn-sm"
                                        onclick="addSubKomponen()">
                                        <i class="fa fa-plus me-1"></i> Tambah Sub Komponen
                                    </button>
                                </div>
                                <div id="subKomponenContainer">
                                    <!-- Dynamic Inputs -->
                                </div>
                            </div>

                            <!-- Complex Structure for Penelitian (Decoupled) -->
                            <div id="penelitianComplexSection" style="display: none;">
                                <!-- Section 1: Pilihan Status -->
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <label class="modern-form-label mb-0">
                                            <i class="fa fa-list-ul me-2"></i>Pilihan/Opsi Status Penilaian <span
                                                class="text-danger">*</span>
                                        </label>
                                        <button type="button" class="modern-btn modern-btn-secondary modern-btn-sm"
                                            onclick="addStatusOption()">
                                            <i class="fa fa-plus me-1"></i> Tambah Opsi Status
                                        </button>
                                    </div>
                                    <div id="statusOptionsContainer">
                                        <!-- Dynamic Status Options -->
                                    </div>
                                    <small class="text-muted"><i class="fa fa-info-circle me-1"></i>Opsi ini akan
                                        menjadi pilihan radio button (mis: Telah Tercapai, Tidak Tercapai).</small>
                                </div>

                                <hr class="my-4">

                                <!-- Section 2: Item Penilaian -->
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <label class="modern-form-label mb-0">
                                            <i class="fa fa-tasks me-2"></i>Item Penilaian/Indikator <span
                                                class="text-danger">*</span>
                                        </label>
                                        <button type="button" class="modern-btn modern-btn-secondary modern-btn-sm"
                                            onclick="addItemPenilaian()">
                                            <i class="fa fa-plus me-1"></i> Tambah Item Penilaian
                                        </button>
                                    </div>
                                    <div id="gradeItemsContainer">
                                        <!-- Dynamic Grade Items -->
                                    </div>
                                    <small class="text-muted"><i class="fa fa-info-circle me-1"></i>Item ini akan
                                        dinilai (100, 75, 50, 25) terlepas dari status yang dipilih.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modern-card-footer">
                        <button type="button" class="modern-btn modern-btn-secondary"
                            data-bs-dismiss="modal">Batal</button>
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
                    <div class="text-center" id="deleteFormContent">
                        <i class="fa fa-spinner fa-spin fa-3x text-primary mb-3"></i>
                        <h6>Memeriksa status komponen penilaian...</h6>
                        <p class="text-muted">Mohon tunggu sebentar.</p>
                    </div>
                </div>
                <div class="modal-footer modern-card-footer">
                    <button type="button" class="modern-btn modern-btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times me-1"></i> Batal
                    </button>
                    <form id="deleteFormForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" id="deleteFormBtn" class="modern-btn modern-btn-danger"
                            onclick="confirmDeleteForm()">
                            <i class="fa fa-trash me-1"></i> Hapus Komponen
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            // 1. Global Variables
            let currentJenis = 'penelitian';
            let subKomponenIndex = 0;
            let statusOptionIndex = 0;
            let gradeItemIndex = 0;

            // 2. Helper Functions
            function removeElement(id) {
                const element = document.getElementById(id);
                if (element) element.remove();
            }

            function addStatusOption(deskripsi = '', skor = '') {
                const container = document.getElementById('statusOptionsContainer');
                const index = statusOptionIndex++;

                const html = `
                    <div class="modern-card mb-2 status-option-row" id="status_option_${index}">
                        <div class="modern-card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>Pilihan Status</strong>
                                <button type="button" class="modern-btn modern-btn-danger modern-btn-sm" onclick="removeElement('status_option_${index}')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-9">
                                    <input type="text" name="status_options[${index}][keterangan]" 
                                        class="modern-form-input" 
                                        placeholder="Label Status (mis: Telah tercapai / terlaksana)" 
                                        value="${deskripsi}" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" step="0.01" name="status_options[${index}][skor]" 
                                        class="modern-form-input" 
                                        placeholder="Skor (mis: 80)" 
                                        value="${skor}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', html);
            }

            function addItemPenilaian(deskripsi = '') {
                const container = document.getElementById('gradeItemsContainer');
                const index = gradeItemIndex++;

                const html = `
                    <div class="modern-card mb-2 grade-item-row" id="grade_item_${index}">
                        <div class="modern-card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>Item Penilaian</strong>
                                <button type="button" class="modern-btn modern-btn-danger modern-btn-sm" onclick="removeElement('grade_item_${index}')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                            <div class="row g-2">
                                <div class="col-12">
                                    <input type="text" name="grade_items[${index}][keterangan]" 
                                        class="modern-form-input" 
                                        placeholder="Deskripsi Item (mis: Kesesuaian metode)" 
                                        value="${deskripsi}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', html);
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
                removeElement(`subKomponen_${index}`);
            }

            // 3. Main Logic Functions
            window.setJenisV4 = function (jenis) {
                try {
                    currentJenis = jenis;

                    // Update Modal Title
                    document.getElementById('modalTitle').innerHTML = '<i class="fa fa-plus-circle me-2"></i>Form Tambah Komponen Penilaian';

                    // Set Form Values
                    document.getElementById('formJenis').value = jenis;
                    document.getElementById('formMethod').value = 'POST';
                    document.getElementById('formPenilaianForm').action = '{{ route("form-penilaian-laporan-akhir.store") }}';

                    // Reset Form
                    document.getElementById('formPenilaianForm').reset();
                    document.getElementById('is_active').checked = true;

                    // Clear Containers
                    const subContainer = document.getElementById('subKomponenContainer');
                    const statusContainer = document.getElementById('statusOptionsContainer');
                    const itemContainer = document.getElementById('gradeItemsContainer');
                    if (subContainer) subContainer.innerHTML = '';
                    if (statusContainer) statusContainer.innerHTML = '';
                    if (itemContainer) itemContainer.innerHTML = '';

                    // Reset Indices
                    subKomponenIndex = 0;
                    statusOptionIndex = 0;
                    gradeItemIndex = 0;

                    // Handle Kategori (Pengabdian only)
                    const kategoriGroup = document.getElementById('kategoriGroup');
                    const kategoriInput = document.getElementById('kategori');
                    const kategoriSelect = document.getElementById('kategoriSelect');
                    if (kategoriGroup) kategoriGroup.style.display = 'none';
                    if (kategoriInput) {
                        kategoriInput.style.display = 'none';
                        kategoriInput.required = false;
                        kategoriInput.value = '';
                    }
                    if (kategoriSelect) kategoriSelect.value = '';

                    // Toggle Sections
                    const subSection = document.getElementById('subKomponenSection');
                    const pengabdianSection = document.getElementById('pengabdianSubsSection');
                    const penelitianSection = document.getElementById('penelitianComplexSection');

                    // Default: Hide specific sections, show generic container
                    if (subSection) subSection.style.display = 'block';
                    if (pengabdianSection) pengabdianSection.style.display = 'none';
                    if (penelitianSection) penelitianSection.style.display = 'none';

                    if (jenis === 'penelitian') {
                        if (penelitianSection) {
                            penelitianSection.style.display = 'block';
                            // Add Default Status Options if empty
                            addStatusOption('Telah tercapai / terlaksana', 80);
                            addStatusOption('Berpotensi besar dapat tercapai', 60);
                            addStatusOption('Berpotensi dapat tercapai', 45);
                            addStatusOption('Kurang berpotensi dapat tercapai', 25);
                            addStatusOption('Tidak tercapai', 0);

                            // Add Default Item
                            addItemPenilaian();
                        }
                    } else if (jenis === 'pengabdian') {
                        if (pengabdianSection) {
                            pengabdianSection.style.display = 'block';
                            if (kategoriGroup) kategoriGroup.style.display = 'block';
                            if (document.getElementById('kategori')) document.getElementById('kategori').required = true;

                            addSubKomponen();
                        }
                    }

                } catch (e) {
                    console.error('Error in setJenisV4:', e);
                }
            };

            function handleKategoriChange() {
                const select = document.getElementById('kategoriSelect');
                const input = document.getElementById('kategori');

                if (select.value === '__NEW__') {
                    input.style.display = 'block';
                    input.value = '';
                    input.required = true;
                    input.focus();
                } else if (select.value) {
                    input.style.display = 'none';
                    input.value = select.value;
                    input.required = false;
                } else {
                    input.style.display = 'none';
                    input.value = '';
                    input.required = false;
                }
            }

            function editForm(id) {
                const editBtn = event.target.closest('button');
                const originalText = editBtn.innerHTML;
                editBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Loading...';
                editBtn.disabled = true;

                // Reset global indices
                subKomponenIndex = 0;
                statusOptionIndex = 0;
                gradeItemIndex = 0;
                // Clear
                document.getElementById('subKomponenContainer').innerHTML = '';
                document.getElementById('statusOptionsContainer').innerHTML = '';
                document.getElementById('gradeItemsContainer').innerHTML = '';

                fetch(`/administrator/form-penilaian-laporan-akhir/${id}/edit`)
                    .then(response => {
                        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        if (data.error) throw new Error(data.error);

                        const form = data.form;
                        currentJenis = form.jenis;

                        // Set Basic Info
                        document.getElementById('formJenis').value = form.jenis;
                        document.getElementById('formMethod').value = 'PUT';
                        document.getElementById('formPenilaianForm').action = `/administrator/form-penilaian-laporan-akhir/${id}`;
                        document.getElementById('modalTitle').innerHTML = '<i class="fa fa-edit me-2"></i>Form Edit Komponen Penilaian';
                        document.getElementById('komponen_penilaian').value = form.komponen_penilaian;
                        document.getElementById('urutan').value = form.urutan || '';
                        document.getElementById('is_active').checked = form.is_active == 1;

                        // Visibility Reset
                        const subSection = document.getElementById('subKomponenSection');
                        const pengabdianSection = document.getElementById('pengabdianSubsSection');
                        const penelitianSection = document.getElementById('penelitianComplexSection');
                        // Always show parent container
                        if (subSection) subSection.style.display = 'block';
                        if (pengabdianSection) pengabdianSection.style.display = 'none';
                        if (penelitianSection) penelitianSection.style.display = 'none';
                        document.getElementById('kategoriGroup').style.display = 'none';

                        if (form.jenis === 'pengabdian') {
                            if (pengabdianSection) pengabdianSection.style.display = 'block';
                            document.getElementById('kategoriGroup').style.display = 'block';

                            // Handle Kategori
                            const kategoriSelect = document.getElementById('kategoriSelect');
                            const kategoriInput = document.getElementById('kategori');
                            const val = form.kategori || '';

                            let optExists = false;
                            for (let i = 0; i < kategoriSelect.options.length; i++) {
                                if (kategoriSelect.options[i].value === val) optExists = true;
                            }

                            if (optExists && val) {
                                kategoriSelect.value = val;
                                kategoriInput.style.display = 'none';
                                kategoriInput.value = val;
                            } else if (val) {
                                kategoriSelect.value = '__NEW__';
                                kategoriInput.style.display = 'block';
                                kategoriInput.value = val;
                            } else {
                                kategoriSelect.value = '';
                                kategoriInput.style.display = 'none';
                            }

                            // Populate Subs
                            if (form.sub_komponen && form.sub_komponen.length > 0) {
                                form.sub_komponen.forEach(sub => {
                                    // Check for legacy 'nilai' or 'skor'
                                    const score = sub.nilai !== undefined ? sub.nilai : sub.skor;
                                    addSubKomponen(sub.sub_komponen || sub.keterangan, score);
                                });
                            } else {
                                addSubKomponen();
                            }

                        } else {
                            // Penelitian
                            if (penelitianSection) penelitianSection.style.display = 'block';

                            if (form.sub_komponen && form.sub_komponen.length > 0) {
                                form.sub_komponen.forEach(sub => {
                                    if (sub.tipe === 'status') {
                                        addStatusOption(sub.keterangan, sub.skor);
                                    } else if (sub.tipe === 'item') {
                                        addItemPenilaian(sub.keterangan);
                                    }
                                });
                            }

                            // Adding defaults if empty is skipped for Edit mode to respect saved data, 
                            // unless truly empty which suggests legacy data migration
                            if (document.getElementById('statusOptionsContainer').children.length === 0) {
                                addStatusOption('Telah tercapai / terlaksana', 80);
                                addStatusOption('Berpotensi besar dapat tercapai', 60);
                                addStatusOption('Berpotensi dapat tercapai', 45);
                                addStatusOption('Kurang berpotensi dapat tercapai', 25);
                                addStatusOption('Tidak tercapai', 0);
                            }
                            if (document.getElementById('gradeItemsContainer').children.length === 0) {
                                addItemPenilaian();
                            }
                        }
                        new bootstrap.Modal(document.getElementById('addFormModal')).show();
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Error loading data: ' + error.message);
                    })
                    .finally(() => {
                        editBtn.innerHTML = originalText;
                        editBtn.disabled = false;
                    });
            }

            function deleteForm(id) {
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteFormModal'));
                document.getElementById('deleteFormForm').action = `/administrator/form-penilaian-laporan-akhir/${id}`;
                document.getElementById('deleteFormContent').innerHTML = `<h6>Konfirmasi Hapus?</h6><p>Yakin ingin menghapus?</p>`;
                deleteModal.show();
            }

            // Re-implement delete/check-usage logic if needed, simplified for now to ensure syntax correctness first

            document.getElementById('formPenilaianForm').addEventListener('submit', function (e) {
                // Basic validation
                if (currentJenis === 'pengabdian') {
                    // Ensure kategori value is set correctly
                    const kategoriSelect = document.getElementById('kategoriSelect');
                    const kategoriInput = document.getElementById('kategori');

                    if (kategoriSelect.value === '__NEW__') {
                        // Use input value for new kategori
                        if (!kategoriInput.value.trim()) {
                            e.preventDefault();
                            alert('Mohon masukkan kategori baru');
                            kategoriInput.focus();
                            return false;
                        }
                    } else if (kategoriSelect.value) {
                        // Use select value
                        kategoriInput.value = kategoriSelect.value;
                    } else {
                        e.preventDefault();
                        alert('Mohon pilih atau masukkan kategori');
                        kategoriSelect.focus();
                        return false;
                    }

                    const subKomponenInputs = document.querySelectorAll('#subKomponenContainer input[name^="sub_komponen"]');
                    if (subKomponenInputs.length === 0) {
                        e.preventDefault();
                        alert('Minimal harus ada 1 sub komponen untuk Pengabdian');
                        return false;
                    }
                } else if (currentJenis === 'penelitian') {
                    const statusOptions = document.querySelectorAll('#statusOptionsContainer .status-option-row');
                    if (statusOptions.length === 0) {
                        e.preventDefault();
                        alert('Minimal harus ada 1 Pilihan Status untuk Penelitian');
                        return false;
                    }
                    const gradeItems = document.querySelectorAll('#gradeItemsContainer .grade-item-row');
                    if (gradeItems.length === 0) {
                        e.preventDefault();
                        alert('Minimal harus ada 1 Item Penilaian untuk Penelitian');
                        return false;
                    }
                }
            });

            // Tabs
            document.addEventListener('DOMContentLoaded', function () {
                const hash = window.location.hash;
                if (hash === '#pengabdian') {
                    new bootstrap.Tab(document.getElementById('pengabdian-tab')).show();
                } else if (hash === '#penelitian') {
                    new bootstrap.Tab(document.getElementById('penelitian-tab')).show();
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

        /* Kategori select styling - using modern-form-select class, no custom styling needed */

        /* Kategori header styling */
        .kategori-header-cell {
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.75rem 1.5rem;
            border-top: 1px solid rgba(226, 232, 240, 0.8);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }

        /* Hapus semua border vertikal - hanya tampilkan garis horizontal */
    </style>
</x-admin-layout>