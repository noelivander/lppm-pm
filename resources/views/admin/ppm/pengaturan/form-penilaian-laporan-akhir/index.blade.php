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
                                    data-bs-target="#addFormModal" onclick="setJenis('penelitian')">
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
                                            <th>Item</th>
                                            <th>Bobot</th>
                                            <th>Aktif</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($formPenelitian as $index => $form)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <strong>{{ $form->komponen_penilaian }}</strong>
                                                </td>
                                                <td>
                                                    {{-- Kriteria / Status --}}
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach($form->subKomponen->where('tipe', 'status') as $status)
                                                            <li>
                                                                <small class="text-muted">{{ $status->keterangan }}</small>
                                                                <span
                                                                    class="badge bg-light text-dark">{{ (float) $status->skor }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>
                                                    {{-- Items --}}
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach($form->subKomponen->where('tipe', 'item') as $item)
                                                            <li class="mb-1 border-bottom pb-1">
                                                                <small>{{ $item->keterangan }}</small>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>
                                                    {{-- Bobot (Static for now as per image assumption) --}}
                                                    <div class="text-xs text-muted">
                                                        Sangat Baik (100%)<br>
                                                        Baik (75%)<br>
                                                        Cukup (50%)<br>
                                                        Kurang (25%)
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($form->is_active)
                                                        <span class="status-badge selesai">Aktif</span>
                                                    @else
                                                        <span class="status-badge pending">Nonaktif</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <button type="button"
                                                            class="modern-btn modern-btn-warning modern-btn-sm"
                                                            onclick="editForm({{ $form->id }})" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        <button type="button"
                                                            class="modern-btn modern-btn-danger modern-btn-sm"
                                                            onclick="deleteForm({{ $form->id }})" title="Hapus">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4">
                                                    <div class="text-muted">Belum ada komponen penilaian untuk penelitian
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
                                    data-bs-target="#addFormModal" onclick="setJenis('pengabdian')">
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
                                        <i class="fa fa-list-ul me-2"></i>Sub Komponen <span class="text-danger">*</span>
                                    </label>
                                    <button type="button" class="modern-btn modern-btn-secondary modern-btn-sm" onclick="addSubKomponen()">
                                        <i class="fa fa-plus me-1"></i> Tambah Sub Komponen
                                    </button>
                                </div>
                                <div id="subKomponenContainer">
                                    <!-- Dynamic Inputs -->
                                </div>
                            </div>

                            <!-- Complex Structure for Penelitian -->
                            <div id="penelitianComplexSection" style="display: none;">
                                <hr>
                                <!-- Kriteria / Status -->
                                <div class="mb-4">
                                    <label class="fw-bold mb-2">Kriteria Status (Skor Induk)</label>
                                    <small class="d-block text-muted mb-2">Contoh: "Telah tercapai (80)", "Berpotensi
                                        (60)"</small>
                                    <div id="kriteriaContainer">
                                        <!-- Dynamic Kriteria -->
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm mt-2"
                                        onclick="addKriteria()">
                                        <i class="fa fa-plus me-1"></i> Tambah Kriteria
                                    </button>
                                </div>

                                <hr>
                                <!-- Items -->
                                <div class="mb-3">
                                    <label class="fw-bold mb-2">Item Penilaian</label>
                                    <small class="d-block text-muted mb-2">Contoh: "Kualitas dokumen", "Kesesuaian
                                        isi"</small>
                                    <div id="itemPenilaianContainer">
                                        <!-- Dynamic Items -->
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm mt-2"
                                        onclick="addItemPenilaian()">
                                        <i class="fa fa-plus me-1"></i> Tambah Item
                                    </button>
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
            // Handle tab activation based on URL fragment
            document.addEventListener('DOMContentLoaded', function () {
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

            let currentJenis = 'penelitian';
            let subKomponenIndex = 0;

            function handleKategoriChange() {
                const select = document.getElementById('kategoriSelect');
                const input = document.getElementById('kategori');

                if (select.value === '__NEW__') {
                    // Show input for new kategori
                    input.style.display = 'block';
                    input.value = '';
                    input.required = true;
                    input.focus();
                } else if (select.value) {
                    // Hide input and set value from select
                    input.style.display = 'none';
                    input.value = select.value;
                    input.required = false;
                } else {
                    // Reset
                    input.style.display = 'none';
                    input.value = '';
                    input.required = false;
                }
            }

            function setJenis(jenis) {
                currentJenis = jenis;
                document.getElementById('formJenis').value = jenis;
                document.getElementById('formMethod').value = 'POST';
                document.getElementById('formPenilaianForm').action = '{{ route("form-penilaian-laporan-akhir.store") }}';
                document.getElementById('modalTitle').innerHTML = '<i class="fa fa-plus-circle me-2"></i>Form Tambah Komponen Penilaian';

                // Reset form
                document.getElementById('formPenilaianForm').reset();
                document.getElementById('is_active').checked = true; // Default checked

                // Clear all dynamic sections
                document.getElementById('subKomponenContainer').innerHTML = '';
                document.getElementById('kriteriaContainer').innerHTML = '';
                document.getElementById('itemPenilaianContainer').innerHTML = '';
                subKomponenIndex = 0; // Reset index for subKomponen

                // Reset kategori dropdown
                const kategoriSelect = document.getElementById('kategoriSelect');
                const kategoriInput = document.getElementById('kategori');
                if (kategoriSelect) {
                    kategoriSelect.value = '';
                    kategoriInput.style.display = 'none';
                    kategoriInput.value = '';
                }


                // Reset display of main sections
                document.getElementById('subKomponenSection').style.display = 'block'; // Always show the parent container
                document.getElementById('pengabdianSubsSection').style.display = 'none';
                document.getElementById('penelitianComplexSection').style.display = 'none';
                document.getElementById('kategoriGroup').style.display = 'none';
                document.getElementById('kategori').required = false;

                if (jenis === 'pengabdian') {
                    // Pengabdian Logic
                    document.getElementById('kategoriGroup').style.display = 'block';
                    document.getElementById('kategori').required = true;
                    document.getElementById('pengabdianSubsSection').style.display = 'block';

                    if (document.getElementById('subKomponenContainer').children.length === 0) {
                        addSubKomponen();
                    }
                } else if (jenis === 'penelitian') {
                    // Penelitian Logic
                    document.getElementById('penelitianComplexSection').style.display = 'block';

                    if (document.getElementById('kriteriaContainer').children.length === 0) {
                        addKriteria();
                    }
                    if (document.getElementById('itemPenilaianContainer').children.length === 0) {
                        addItemPenilaian();
                    }
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

            function addKriteria(deskripsi = '', bobot = '') {
                const container = document.getElementById('kriteriaContainer');
                const index = container.children.length;

                const html = `
                    <div class="row mb-2 kriteria-row">
                        <div class="col-md-7">
                            <input type="text" name="kriteria[${index}][deskripsi]" class="form-control" placeholder="Label Status (mis: Berpotensi)" value="${deskripsi}" required>
                        </div>
                        <div class="col-md-3">
                            <input type="number" step="0.01" name="kriteria[${index}][bobot]" class="form-control" placeholder="Skor (mis: 60)" value="${bobot}" required>
                        </div>
                        <div class="col-md-2">
                             <button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.kriteria-row').remove()">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', html);
            }

            function addItemPenilaian(deskripsi = '') {
                const container = document.getElementById('itemPenilaianContainer');
                const html = `
                    <div class="input-group mb-2 item-row">
                        <input type="text" name="item_penilaian[]" class="form-control" placeholder="Item Penilaian (mis: Kualitas Dokumen)" value="${deskripsi}" required>
                        <button type="button" class="btn btn-outline-danger" onclick="this.closest('.item-row').remove()">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', html);
            }

            function editForm(id) {
                const editBtn = event.target.closest('button');
                const originalText = editBtn.innerHTML;
                editBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Loading...';
                editBtn.disabled = true;

                document.getElementById('subKomponenContainer').innerHTML = '';
                document.getElementById('kriteriaContainer').innerHTML = '';
                document.getElementById('itemPenilaianContainer').innerHTML = '';
                subKomponenIndex = 0; // Reset index global

                fetch(`/administrator/form-penilaian-laporan-akhir/${id}/edit`)
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
                        currentJenis = form.jenis;

                        document.getElementById('formJenis').value = form.jenis;
                        document.getElementById('formMethod').value = 'PUT';
                        document.getElementById('formPenilaianForm').action = `/administrator/form-penilaian-laporan-akhir/${id}`;
                        document.getElementById('modalTitle').innerHTML = '<i class="fa fa-edit me-2"></i>Form Edit Komponen Penilaian';

                        document.getElementById('komponen_penilaian').value = form.komponen_penilaian;
                        document.getElementById('urutan').value = form.urutan || '';
                        document.getElementById('is_active').checked = form.is_active == 1;

                        // Reset displays
                        document.getElementById('subKomponenSection').style.display = 'block'; // Always show the parent container
                        document.getElementById('pengabdianSubsSection').style.display = 'none';
                        document.getElementById('penelitianComplexSection').style.display = 'none';

                        if (form.jenis === 'pengabdian') {
                            document.getElementById('kategoriGroup').style.display = 'block';
                            document.getElementById('pengabdianSubsSection').style.display = 'block';

                            // Handle kategori dropdown (existing logic...)
                            const kategoriSelect = document.getElementById('kategoriSelect');
                            const kategoriInput = document.getElementById('kategori');
                            const kategoriValue = form.kategori || '';

                            // Check if kategori exists in dropdown
                            const optionExists = Array.from(kategoriSelect.options).some(opt => opt.value === kategoriValue);

                            if (optionExists && kategoriValue) {
                                // Set select value
                                kategoriSelect.value = kategoriValue;
                                kategoriInput.style.display = 'none';
                                kategoriInput.value = kategoriValue;
                                kategoriInput.required = false;
                            } else if (kategoriValue) {
                                // Kategori baru, show input
                                kategoriSelect.value = '__NEW__';
                                kategoriInput.style.display = 'block';
                                kategoriInput.value = kategoriValue;
                                kategoriInput.required = true;
                            } else {
                                // Reset
                                kategoriSelect.value = '';
                                kategoriInput.style.display = 'none';
                                kategoriInput.value = '';
                                kategoriInput.required = true;
                            }
                        } else {
                            // Penelitian
                            document.getElementById('kategoriGroup').style.display = 'none';
                            document.getElementById('kategori').required = false;
                            document.getElementById('penelitianComplexSection').style.display = 'block';
                        }

                        // Populate Data
                        if (form.jenis === 'pengabdian') {
                            if (form.sub_komponen && form.sub_komponen.length > 0) {
                                form.sub_komponen.forEach(sub => {
                                    addSubKomponen(sub.sub_komponen, sub.nilai);
                                });
                            } else {
                                addSubKomponen();
                            }
                        } else if (form.jenis === 'penelitian') {
                            // Populate Kriteria
                            if (form.kriteria && form.kriteria.length > 0) {
                                form.kriteria.forEach(k => addKriteria(k.deskripsi, k.bobot));
                            } else {
                                addKriteria();
                            }
                            // Populate Items
                            if (form.item_penilaian && form.item_penilaian.length > 0) {
                                form.item_penilaian.forEach(i => addItemPenilaian(i));
                            } else {
                                addItemPenilaian();
                            }
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
                        alert('Terjadi kesalahan saat mengambil data: ' + error.message);
                    })
                    .finally(() => {
                        editBtn.innerHTML = originalText;
                        editBtn.disabled = false;
                    });
            }

            function deleteForm(id) {
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteFormModal'));
                document.getElementById('deleteFormForm').action = `/administrator/form-penilaian-laporan-akhir/${id}`;

                // Reset content to loading state
                const contentDiv = document.getElementById('deleteFormContent');
                contentDiv.innerHTML = `
                <i class="fa fa-spinner fa-spin fa-3x text-primary mb-3"></i>
                <h6>Memeriksa status komponen penilaian...</h6>
                <p class="text-muted">Mohon tunggu sebentar.</p>
            `;

                // Check if form has been used
                fetch(`{{ url('administrator/form-penilaian-laporan-akhir') }}/${id}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            throw new Error(data.error);
                        }

                        // Check if form has been used
                        fetch(`{{ url('administrator/form-penilaian-laporan-akhir') }}/${id}/check-usage`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Failed to check usage');
                                }
                                return response.json();
                            })
                            .then(usageData => {
                                const isUsed = usageData.used || false;

                                if (isUsed) {
                                    // Form has been used - show warning
                                    contentDiv.innerHTML = `
                                    <i class="fa fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                    <h6 class="text-warning">Komponen penilaian sudah pernah digunakan!</h6>
                                    <p class="text-muted mb-2">
                                        Komponen penilaian ini sudah pernah digunakan dalam laporan akhir. 
                                        Untuk menjaga integritas data historis, komponen ini akan <strong>dinonaktifkan</strong> 
                                        bukan dihapus.
                                    </p>
                                    <p class="text-muted small">
                                        <i class="fa fa-info-circle me-1"></i>
                                        Data historis tetap aman dan dapat diakses.
                                    </p>
                                `;
                                    document.getElementById('deleteFormBtn').innerHTML = '<i class="fa fa-ban me-1"></i> Nonaktifkan Komponen';
                                } else {
                                    // Form hasn't been used - can delete
                                    contentDiv.innerHTML = `
                                    <i class="fa fa-trash fa-3x text-danger mb-3"></i>
                                    <h6>Apakah Anda yakin ingin menghapus komponen penilaian ini?</h6>
                                    <p class="text-muted">Tindakan ini tidak dapat dibatalkan dan akan menghapus komponen penilaian secara permanen.</p>
                                `;
                                    document.getElementById('deleteFormBtn').innerHTML = '<i class="fa fa-trash me-1"></i> Hapus Komponen';
                                }
                            })
                            .catch(error => {
                                console.error('Error checking usage:', error);
                                // If check fails, show default delete message
                                contentDiv.innerHTML = `
                                <i class="fa fa-trash fa-3x text-danger mb-3"></i>
                                <h6>Apakah Anda yakin ingin menghapus komponen penilaian ini?</h6>
                                <p class="text-muted">Tindakan ini tidak dapat dibatalkan dan akan menghapus komponen penilaian secara permanen.</p>
                            `;
                                document.getElementById('deleteFormBtn').innerHTML = '<i class="fa fa-trash me-1"></i> Hapus Komponen';
                            });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // If edit fails, show default delete message
                        const contentDiv = document.getElementById('deleteFormContent');
                        contentDiv.innerHTML = `
                        <i class="fa fa-trash fa-3x text-danger mb-3"></i>
                        <h6>Apakah Anda yakin ingin menghapus komponen penilaian ini?</h6>
                        <p class="text-muted">Tindakan ini tidak dapat dibatalkan dan akan menghapus komponen penilaian secara permanen.</p>
                    `;
                        document.getElementById('deleteFormBtn').innerHTML = '<i class="fa fa-trash me-1"></i> Hapus Komponen';
                    });

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

            // Handle form submission
            document.getElementById('formPenilaianForm').addEventListener('submit', function (e) {
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
                    const kriteriaRows = document.querySelectorAll('#kriteriaContainer .kriteria-row');
                    if (kriteriaRows.length === 0) {
                        e.preventDefault();
                        alert('Minimal harus ada 1 Kriteria Status untuk Penelitian');
                        return false;
                    }
                    const itemRows = document.querySelectorAll('#itemPenilaianContainer .item-row');
                    if (itemRows.length === 0) {
                        e.preventDefault();
                        alert('Minimal harus ada 1 Item Penilaian untuk Penelitian');
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