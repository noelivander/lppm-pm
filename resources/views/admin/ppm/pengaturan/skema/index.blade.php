<x-admin-layout>
    <x-slot name="header">
        {{ __('Penelitian & Pengabdian/Pengaturan/Skema') }}
    </x-slot>

    <x-admin.heading name="Penelitian & Pengabdian/Pengaturan/Skema">
        <button class="modern-btn modern-btn-primary" data-bs-toggle="modal" data-bs-target="#addSkemaModal">
            <i class="fa fa-plus me-1"></i> Tambah Skema
        </button>
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

    <div class="row">
        <div class="col-lg-12">
            <div class="modern-table-container mb-4 fade-in-up">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Nama Skema</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($skema as $key => $value)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>
                                @if($value->kode)
                                    <span class="status-badge kode">{{ $value->kode }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold mb-1">{{ $value->nama }}</div>
                                @if($value->perihal)
                                    <small class="text-muted d-block mb-1">{{ Str::limit($value->perihal, 50) }}</small>
                                @endif
                                @if($value->jenis_skema)
                                    <span class="status-badge info">{{ $value->jenis_skema->nama }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($value->jenis == 'penelitian')
                                    <span class="status-badge primary">
                                        <i class="fa fa-flask me-1"></i>Penelitian
                                    </span>
                                @else
                                    <span class="status-badge success">
                                        <i class="fa fa-users me-1"></i>Pengabdian
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($value->is_shown)
                                    <span class="status-badge selesai">
                                        <i class="fa fa-eye me-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="status-badge pending">
                                        <i class="fa fa-eye-slash me-1"></i>Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button type="button" class="modern-btn modern-btn-warning modern-btn-sm" onclick="editSkema({{ $value->id }})" title="Edit">
                                        <i class="fa fa-edit me-1"></i> Ubah
                                    </button>
                                    <button type="button" class="modern-btn modern-btn-danger modern-btn-sm" onclick="deleteSkema({{ $value->id }})" title="Hapus">
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
                                    <p>Belum ada skema yang ditambahkan</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addSkemaModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modern-card">
                <div class="modal-header modern-card-header">
                    <h5 class="modal-title mb-0">
                        <i class="fa fa-plus-circle me-2"></i>Form Tambah Skema Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('skema.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body modern-card-body">
                        <div class="modern-form-group">
                            <label for="kode" class="modern-form-label">
                                <i class="fa fa-code me-2"></i>Kode Skema
                            </label>
                            <input type="text" name="kode" id="kode" class="modern-form-input" placeholder="Masukkan kode skema (opsional)">
                        </div>
                        
                        <div class="modern-form-group">
                            <label for="nama" class="modern-form-label">
                                <i class="fa fa-list me-2"></i>Nama Skema <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama" id="nama" class="modern-form-input" placeholder="Masukkan nama skema" required>
                        </div>
                        
                        <div class="modern-form-group">
                            <label for="perihal" class="modern-form-label">
                                <i class="fa fa-info-circle me-2"></i>Perihal
                            </label>
                            <input type="text" name="perihal" id="perihal" class="modern-form-input" placeholder="Masukkan perihal skema (opsional)">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <label for="jenis" class="modern-form-label">
                                        <i class="fa fa-flask me-2"></i>Jenis <span class="text-danger">*</span>
                                    </label>
                                    <select name="jenis" id="jenis" class="modern-form-select" required>
                                        <option value="">Pilih Jenis</option>
                                        <option value="penelitian">Penelitian</option>
                                        <option value="pengabdian">Pengabdian</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <label for="jenis_skema_id" class="modern-form-label">
                                        <i class="fa fa-tags me-2"></i>Kategori <span class="text-danger">*</span>
                                    </label>
                                    <select name="jenis_skema_id" id="jenis_skema_id" class="modern-form-select" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach(\App\Models\PPM\JenisSkema::where('is_shown', 1)->get() as $jenis)
                                            <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_research" id="is_research" value="1">
                                        <label class="form-check-label" for="is_research">
                                            <i class="fa fa-microscope me-2"></i>Tandai sebagai Riset
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_shown" id="is_shown" value="1" checked>
                                        <label class="form-check-label" for="is_shown">
                                            <i class="fa fa-eye me-2"></i>Tampilkan di Form Proposal
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="modern-form-group">
                            <label for="template_laporan_kemajuan" class="modern-form-label">
                                <i class="fa fa-file-word me-2"></i>Template Laporan Kemajuan
                            </label>
                            <input type="file" name="template_laporan_kemajuan" id="template_laporan_kemajuan" class="modern-form-input" accept=".doc,.docx,.pdf">
                            <small class="form-text text-muted">Format: Word (.doc, .docx) atau PDF (.pdf), maksimal 10MB</small>
                        </div>

                        <div class="modern-form-group">
                            <label for="template_laporan_keuangan_tahap_1" class="modern-form-label">
                                <i class="fa fa-file-pdf me-2"></i>Template Laporan Keuangan Tahap 1
                            </label>
                            <input type="file" name="template_laporan_keuangan_tahap_1" id="template_laporan_keuangan_tahap_1" class="modern-form-input" accept=".doc,.docx,.pdf">
                            <small class="form-text text-muted">Format: Word (.doc, .docx) atau PDF (.pdf), maksimal 10MB</small>
                        </div>
                    </div>
                    <div class="modal-footer modern-card-footer">
                        <button type="button" class="modern-btn modern-btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="modern-btn modern-btn-primary">
                            <i class="fa fa-save me-1"></i> Simpan Skema
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editSkemaModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modern-card">
                <div class="modal-header modern-card-header">
                    <h5 class="modal-title mb-0">
                        <i class="fa fa-edit me-2"></i>Form Edit Skema
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editSkemaForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body modern-card-body">
                        <div class="modern-form-group">
                            <label for="edit_kode" class="modern-form-label">
                                <i class="fa fa-code me-2"></i>Kode Skema
                            </label>
                            <input type="text" name="kode" id="edit_kode" class="modern-form-input" placeholder="Masukkan kode skema (opsional)">
                        </div>
                        
                        <div class="modern-form-group">
                            <label for="edit_nama" class="modern-form-label">
                                <i class="fa fa-list me-2"></i>Nama Skema <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama" id="edit_nama" class="modern-form-input" placeholder="Masukkan nama skema" required>
                        </div>
                        
                        <div class="modern-form-group">
                            <label for="edit_perihal" class="modern-form-label">
                                <i class="fa fa-info-circle me-2"></i>Perihal
                            </label>
                            <input type="text" name="perihal" id="edit_perihal" class="modern-form-input" placeholder="Masukkan perihal skema (opsional)">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <label for="edit_jenis" class="modern-form-label">
                                        <i class="fa fa-flask me-2"></i>Jenis <span class="text-danger">*</span>
                                    </label>
                                    <select name="jenis" id="edit_jenis" class="modern-form-select" required>
                                        <option value="">Pilih Jenis</option>
                                        <option value="penelitian">Penelitian</option>
                                        <option value="pengabdian">Pengabdian</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <label for="edit_jenis_skema_id" class="modern-form-label">
                                        <i class="fa fa-tags me-2"></i>Kategori <span class="text-danger">*</span>
                                    </label>
                                    <select name="jenis_skema_id" id="edit_jenis_skema_id" class="modern-form-select" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach(\App\Models\PPM\JenisSkema::where('is_shown', 1)->get() as $jenis)
                                            <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_research" id="edit_is_research" value="1">
                                        <label class="form-check-label" for="edit_is_research">
                                            <i class="fa fa-microscope me-2"></i>Tandai sebagai Riset
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_shown" id="edit_is_shown" value="1">
                                        <label class="form-check-label" for="edit_is_shown">
                                            <i class="fa fa-eye me-2"></i>Tampilkan di Form Proposal
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="modern-form-group">
                            <label for="edit_template_laporan_kemajuan" class="modern-form-label">
                                <i class="fa fa-file-word me-2"></i>Template Laporan Kemajuan
                            </label>
                            <input type="file" name="template_laporan_kemajuan" id="edit_template_laporan_kemajuan" class="modern-form-input" accept=".doc,.docx,.pdf">
                            <small class="form-text text-muted">Format: Word (.doc, .docx) atau PDF (.pdf), maksimal 10MB</small>
                            <div id="current_template_laporan_kemajuan" class="mt-2"></div>
                        </div>

                        <div class="modern-form-group">
                            <label for="edit_template_laporan_keuangan_tahap_1" class="modern-form-label">
                                <i class="fa fa-file-pdf me-2"></i>Template Laporan Keuangan Tahap 1
                            </label>
                            <input type="file" name="template_laporan_keuangan_tahap_1" id="edit_template_laporan_keuangan_tahap_1" class="modern-form-input" accept=".doc,.docx,.pdf">
                            <small class="form-text text-muted">Format: Word (.doc, .docx) atau PDF (.pdf), maksimal 10MB</small>
                            <div id="current_template_laporan_keuangan_tahap_1" class="mt-2"></div>
                        </div>
                    </div>
                    <div class="modal-footer modern-card-footer">
                        <button type="button" class="modern-btn modern-btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="modern-btn modern-btn-primary">
                            <i class="fa fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteSkemaModal" tabindex="-1">
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
                        <h6>Apakah Anda yakin ingin menghapus skema ini?</h6>
                        <p class="text-muted">Tindakan ini tidak dapat dibatalkan dan akan menghapus skema secara permanen.</p>
                    </div>
                </div>
                <div class="modal-footer modern-card-footer">
                    <button type="button" class="modern-btn modern-btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times me-1"></i> Batal
                    </button>
                    <form id="deleteSkemaForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" id="deleteSkemaBtn" class="modern-btn modern-btn-danger" onclick="confirmDeleteSkema()">
                            <i class="fa fa-trash me-1"></i> Hapus Skema
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function editSkema(id) {
                // Show loading state
                const editBtn = event.target;
                const originalText = editBtn.innerHTML;
                editBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Loading...';
                editBtn.disabled = true;
                
                fetch(`{{ url('/administrator/skema') }}/${id}/edit`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.error) {
                            throw new Error(data.error);
                        }
                        
                        // Populate form fields
                        document.getElementById('edit_kode').value = data.skema.kode || '';
                        document.getElementById('edit_nama').value = data.skema.nama;
                        document.getElementById('edit_perihal').value = data.skema.perihal || '';
                        document.getElementById('edit_jenis').value = data.skema.jenis;
                        document.getElementById('edit_jenis_skema_id').value = data.skema.jenis_skema_id;
                        document.getElementById('edit_is_research').checked = data.skema.is_research == 1;
                        document.getElementById('edit_is_shown').checked = data.skema.is_shown == 1;
                        
                        // Show current template files if they exist
                        const currentTemplateKemajuan = document.getElementById('current_template_laporan_kemajuan');
                        const currentTemplateKeuangan = document.getElementById('current_template_laporan_keuangan_tahap_1');
                        const storageUrl = '{{ asset("storage") }}';
                        
                        if (data.skema.template_laporan_kemajuan) {
                            const fileName = data.skema.template_laporan_kemajuan.split('/').pop();
                            const fileUrl = storageUrl + '/' + data.skema.template_laporan_kemajuan;
                            currentTemplateKemajuan.innerHTML = `
                                <div class="alert alert-info py-2 px-3 mb-0">
                                    <i class="fa fa-file me-2"></i>
                                    <strong>File saat ini:</strong> 
                                    <a href="${fileUrl}" target="_blank" class="text-decoration-none">
                                        ${fileName}
                                    </a>
                                    <small class="d-block text-muted mt-1">Unggah file baru untuk mengganti</small>
                                </div>
                            `;
                        } else {
                            currentTemplateKemajuan.innerHTML = '';
                        }
                        
                        if (data.skema.template_laporan_keuangan_tahap_1) {
                            const fileName = data.skema.template_laporan_keuangan_tahap_1.split('/').pop();
                            const fileUrl = storageUrl + '/' + data.skema.template_laporan_keuangan_tahap_1;
                            currentTemplateKeuangan.innerHTML = `
                                <div class="alert alert-info py-2 px-3 mb-0">
                                    <i class="fa fa-file me-2"></i>
                                    <strong>File saat ini:</strong> 
                                    <a href="${fileUrl}" target="_blank" class="text-decoration-none">
                                        ${fileName}
                                    </a>
                                    <small class="d-block text-muted mt-1">Unggah file baru untuk mengganti</small>
                                </div>
                            `;
                        } else {
                            currentTemplateKeuangan.innerHTML = '';
                        }
                        
                        // Set form action
                        document.getElementById('editSkemaForm').action = `{{ url('/administrator/skema') }}/${id}`;
                        
                        // Show modal
                        new bootstrap.Modal(document.getElementById('editSkemaModal')).show();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengambil data skema. Silakan coba lagi.');
                    })
                    .finally(() => {
                        // Restore button state
                        editBtn.innerHTML = originalText;
                        editBtn.disabled = false;
                    });
            }

            function deleteSkema(id) {
                // Show modern confirmation modal
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteSkemaModal'));
                document.getElementById('deleteSkemaForm').action = `{{ url('/administrator/skema') }}/${id}`;
                deleteModal.show();
            }
            
            function confirmDeleteSkema() {
                const form = document.getElementById('deleteSkemaForm');
                const submitBtn = document.getElementById('deleteSkemaBtn');
                
                // Show loading state
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Menghapus...';
                submitBtn.disabled = true;
                
                // Submit form
                form.submit();
            }
        </script>
    </x-slot>
</x-admin-layout>