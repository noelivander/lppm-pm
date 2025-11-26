<!-- ===== KELOMPOK RAB MODALS ===== -->

<!-- Add Kelompok Modal -->
<div class="modal fade" id="addKelompokModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modern-card">
            <div class="modal-header modern-card-header">
                <h5 class="modal-title mb-0">
                    <i class="fa fa-plus-circle me-2"></i>Form Tambah Kelompok RAB
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('rab.store.kelompok') }}">
                @csrf
                <div class="modal-body modern-card-body">
                    <div class="modern-form-group">
                        <label for="kelompok_nama" class="modern-form-label">
                            <i class="fa fa-layer-group me-2"></i>Nama Kelompok <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama" id="kelompok_nama" class="modern-form-input" placeholder="Contoh: Honorarium, Perjalanan, Operasional" required>
                    </div>
                    <div class="modern-form-group">
                        <label for="kelompok_deskripsi" class="modern-form-label">
                            <i class="fa fa-info-circle me-2"></i>Deskripsi
                        </label>
                        <textarea name="deskripsi" id="kelompok_deskripsi" class="modern-form-textarea" rows="3" placeholder="Masukkan deskripsi (opsional)"></textarea>
                    </div>
                    <div class="modern-form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="kelompok_is_active" value="1" checked>
                            <label class="form-check-label" for="kelompok_is_active">
                                <i class="fa fa-check-circle me-2"></i>Aktifkan Kelompok RAB
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer modern-card-footer">
                    <button type="button" class="modern-btn modern-btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="fa fa-save me-1"></i> Simpan Kelompok
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Kelompok Modal -->
<div class="modal fade" id="editKelompokModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modern-card">
            <div class="modal-header modern-card-header">
                <h5 class="modal-title mb-0">
                    <i class="fa fa-edit me-2"></i>Form Edit Kelompok RAB
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editKelompokForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body modern-card-body">
                    <div class="modern-form-group">
                        <label for="edit_kelompok_nama" class="modern-form-label">
                            <i class="fa fa-layer-group me-2"></i>Nama Kelompok <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama" id="edit_kelompok_nama" class="modern-form-input" required>
                    </div>
                    <div class="modern-form-group">
                        <label for="edit_kelompok_deskripsi" class="modern-form-label">
                            <i class="fa fa-info-circle me-2"></i>Deskripsi
                        </label>
                        <textarea name="deskripsi" id="edit_kelompok_deskripsi" class="modern-form-textarea" rows="3"></textarea>
                    </div>
                    <div class="modern-form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="edit_kelompok_is_active" value="1">
                            <label class="form-check-label" for="edit_kelompok_is_active">
                                <i class="fa fa-check-circle me-2"></i>Aktifkan Kelompok RAB
                            </label>
                        </div>
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

<!-- Delete Kelompok Modal -->
<div class="modal fade" id="deleteKelompokModal" tabindex="-1">
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
                    <h6>Apakah Anda yakin ingin menghapus kelompok RAB ini?</h6>
                    <p class="text-muted">Tindakan ini tidak dapat dibatalkan dan akan menghapus kelompok RAB secara permanen.</p>
                </div>
            </div>
            <div class="modal-footer modern-card-footer">
                <button type="button" class="modern-btn modern-btn-secondary" data-bs-dismiss="modal">
                    <i class="fa fa-times me-1"></i> Batal
                </button>
                <form id="deleteKelompokForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" id="deleteKelompokBtn" class="modern-btn modern-btn-danger" onclick="confirmDeleteKelompok()">
                        <i class="fa fa-trash me-1"></i> Hapus Kelompok
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ===== KOMPONEN RAB MODALS ===== -->

<!-- Add Komponen Modal -->
<div class="modal fade" id="addKomponenModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modern-card">
            <div class="modal-header modern-card-header">
                <h5 class="modal-title mb-0">
                    <i class="fa fa-plus-circle me-2"></i>Form Tambah Komponen RAB
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('rab.store.komponen') }}">
                @csrf
                <div class="modal-body modern-card-body">
                    <div class="modern-form-group">
                        <label for="komponen_nama" class="modern-form-label">
                            <i class="fa fa-cubes me-2"></i>Nama Komponen <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama" id="komponen_nama" class="modern-form-input" placeholder="Contoh: SDM, Material, Jasa, Transportasi" required>
                    </div>
                    <div class="modern-form-group">
                        <label for="komponen_deskripsi" class="modern-form-label">
                            <i class="fa fa-info-circle me-2"></i>Deskripsi
                        </label>
                        <textarea name="deskripsi" id="komponen_deskripsi" class="modern-form-textarea" rows="3" placeholder="Masukkan deskripsi (opsional)"></textarea>
                    </div>
                    <div class="modern-form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="komponen_is_active" value="1" checked>
                            <label class="form-check-label" for="komponen_is_active">
                                <i class="fa fa-check-circle me-2"></i>Aktifkan Komponen RAB
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer modern-card-footer">
                    <button type="button" class="modern-btn modern-btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="fa fa-save me-1"></i> Simpan Komponen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Komponen Modal -->
<div class="modal fade" id="editKomponenModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modern-card">
            <div class="modal-header modern-card-header">
                <h5 class="modal-title mb-0">
                    <i class="fa fa-edit me-2"></i>Form Edit Komponen RAB
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editKomponenForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body modern-card-body">
                    <div class="modern-form-group">
                        <label for="edit_komponen_nama" class="modern-form-label">
                            <i class="fa fa-cubes me-2"></i>Nama Komponen <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama" id="edit_komponen_nama" class="modern-form-input" required>
                    </div>
                    <div class="modern-form-group">
                        <label for="edit_komponen_deskripsi" class="modern-form-label">
                            <i class="fa fa-info-circle me-2"></i>Deskripsi
                        </label>
                        <textarea name="deskripsi" id="edit_komponen_deskripsi" class="modern-form-textarea" rows="3"></textarea>
                    </div>
                    <div class="modern-form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="edit_komponen_is_active" value="1">
                            <label class="form-check-label" for="edit_komponen_is_active">
                                <i class="fa fa-check-circle me-2"></i>Aktifkan Komponen RAB
                            </label>
                        </div>
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

<!-- Delete Komponen Modal -->
<div class="modal fade" id="deleteKomponenModal" tabindex="-1">
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
                    <h6>Apakah Anda yakin ingin menghapus komponen RAB ini?</h6>
                    <p class="text-muted">Tindakan ini tidak dapat dibatalkan dan akan menghapus komponen RAB secara permanen.</p>
                </div>
            </div>
            <div class="modal-footer modern-card-footer">
                <button type="button" class="modern-btn modern-btn-secondary" data-bs-dismiss="modal">
                    <i class="fa fa-times me-1"></i> Batal
                </button>
                <form id="deleteKomponenForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" id="deleteKomponenBtn" class="modern-btn modern-btn-danger" onclick="confirmDeleteKomponen()">
                        <i class="fa fa-trash me-1"></i> Hapus Komponen
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ===== SATUAN RAB MODALS ===== -->

<!-- Add Satuan Modal -->
<div class="modal fade" id="addSatuanModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modern-card">
            <div class="modal-header modern-card-header">
                <h5 class="modal-title mb-0">
                    <i class="fa fa-plus-circle me-2"></i>Form Tambah Satuan RAB
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('rab.store.satuan') }}">
                @csrf
                <div class="modal-body modern-card-body">
                    <div class="modern-form-group">
                        <label for="satuan_nama" class="modern-form-label">
                            <i class="fa fa-ruler me-2"></i>Nama Satuan <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama" id="satuan_nama" class="modern-form-input" placeholder="Contoh: pcs, buah, paket, hari" required>
                    </div>
                    <div class="modern-form-group">
                        <label for="satuan_singkatan" class="modern-form-label">
                            <i class="fa fa-tag me-2"></i>Singkatan
                        </label>
                        <input type="text" name="singkatan" id="satuan_singkatan" class="modern-form-input" placeholder="Contoh: pcs, bth, pkt (opsional)">
                    </div>
                    <div class="modern-form-group">
                        <label for="satuan_deskripsi" class="modern-form-label">
                            <i class="fa fa-info-circle me-2"></i>Deskripsi
                        </label>
                        <textarea name="deskripsi" id="satuan_deskripsi" class="modern-form-textarea" rows="3" placeholder="Masukkan deskripsi (opsional)"></textarea>
                    </div>
                    <div class="modern-form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="satuan_is_active" value="1" checked>
                            <label class="form-check-label" for="satuan_is_active">
                                <i class="fa fa-check-circle me-2"></i>Aktifkan Satuan RAB
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer modern-card-footer">
                    <button type="button" class="modern-btn modern-btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="fa fa-save me-1"></i> Simpan Satuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Satuan Modal -->
<div class="modal fade" id="editSatuanModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modern-card">
            <div class="modal-header modern-card-header">
                <h5 class="modal-title mb-0">
                    <i class="fa fa-edit me-2"></i>Form Edit Satuan RAB
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editSatuanForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body modern-card-body">
                    <div class="modern-form-group">
                        <label for="edit_satuan_nama" class="modern-form-label">
                            <i class="fa fa-ruler me-2"></i>Nama Satuan <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama" id="edit_satuan_nama" class="modern-form-input" required>
                    </div>
                    <div class="modern-form-group">
                        <label for="edit_satuan_singkatan" class="modern-form-label">
                            <i class="fa fa-tag me-2"></i>Singkatan
                        </label>
                        <input type="text" name="singkatan" id="edit_satuan_singkatan" class="modern-form-input">
                    </div>
                    <div class="modern-form-group">
                        <label for="edit_satuan_deskripsi" class="modern-form-label">
                            <i class="fa fa-info-circle me-2"></i>Deskripsi
                        </label>
                        <textarea name="deskripsi" id="edit_satuan_deskripsi" class="modern-form-textarea" rows="3"></textarea>
                    </div>
                    <div class="modern-form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="edit_satuan_is_active" value="1">
                            <label class="form-check-label" for="edit_satuan_is_active">
                                <i class="fa fa-check-circle me-2"></i>Aktifkan Satuan RAB
                            </label>
                        </div>
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

<!-- Delete Satuan Modal -->
<div class="modal fade" id="deleteSatuanModal" tabindex="-1">
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
                    <h6>Apakah Anda yakin ingin menghapus satuan RAB ini?</h6>
                    <p class="text-muted">Tindakan ini tidak dapat dibatalkan dan akan menghapus satuan RAB secara permanen.</p>
                </div>
            </div>
            <div class="modal-footer modern-card-footer">
                <button type="button" class="modern-btn modern-btn-secondary" data-bs-dismiss="modal">
                    <i class="fa fa-times me-1"></i> Batal
                </button>
                <form id="deleteSatuanForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" id="deleteSatuanBtn" class="modern-btn modern-btn-danger" onclick="confirmDeleteSatuan()">
                        <i class="fa fa-trash me-1"></i> Hapus Satuan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ===== ASSIGN SATUAN TO KOMPONEN MODAL ===== -->

<!-- Assign Satuan Modal -->
<div class="modal fade" id="assignSatuanModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modern-card">
            <div class="modal-header modern-card-header">
                <h5 class="modal-title mb-0">
                    <i class="fa fa-link me-2"></i>Atur Satuan untuk Komponen
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body modern-card-body">
                <div class="modern-form-group">
                    <label class="modern-form-label">
                        <i class="fa fa-cubes me-2"></i>Komponen
                    </label>
                    <input type="text" id="assign_komponen_nama" class="modern-form-input" readonly>
                    <input type="hidden" id="assign_komponen_id">
                </div>
                <div class="modern-form-group">
                    <label class="modern-form-label">
                        <i class="fa fa-ruler me-2"></i>Pilih Satuan yang Tersedia
                    </label>
                    <div id="assignSatuanCheckboxes" class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                        <div class="text-center text-muted py-3">
                            <i class="fa fa-spinner fa-spin me-2"></i>Memuat satuan...
                        </div>
                    </div>
                    <small class="text-muted">Centang satuan yang ingin digunakan untuk komponen ini</small>
                </div>
            </div>
            <div class="modal-footer modern-card-footer">
                <button type="button" class="modern-btn modern-btn-secondary" data-bs-dismiss="modal">
                    <i class="fa fa-times me-1"></i> Batal
                </button>
                <button type="button" class="modern-btn modern-btn-primary" onclick="saveSatuanAssignment()">
                    <i class="fa fa-save me-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

