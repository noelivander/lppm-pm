<x-dosen-layout>
    <x-slot name="header">
        {{ __('Revisi Proposal Penelitian') }}
    </x-slot>

    {{-- RAB options are now loaded from database via controller --}}

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3 fade-in-up">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                        <h3 class="mb-0">
                            <i class="fa fa-sync-alt me-2"></i>Revisi Proposal Penelitian
                        </h3>
                        <a href="{{ route('penelitian-dos.revisi.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fa fa-arrow-left me-2"></i>Kembali ke Daftar Revisi
                        </a>
                    </div>

                    @if (!$timeline || !$timeline->revision_start_date || !$timeline->revision_end_date)
                        <div class="modern-alert modern-alert-danger">
                            <i class="fa fa-exclamation-circle me-2"></i>Belum ada jadwal revisi yang aktif. Form dinonaktifkan.
                        </div>
                    @else
                        @if ($currentDate < $timeline->revision_start_date)
                            <div class="modern-alert modern-alert-warning">
                                <i class="fa fa-clock me-2"></i>Periode revisi akan dimulai pada <strong>{{ $timeline->revision_start_date->format('d M Y H:i') }}</strong>.
                            </div>
                            <script>
                                var countdownDate = new Date("{{ $timeline->revision_start_date }}").getTime();
                            </script>
                        @elseif ($currentDate >= $timeline->revision_start_date && $currentDate <= $timeline->revision_end_date)
                            <div class="modern-alert modern-alert-info">
                                <i class="fa fa-info-circle me-2"></i>Periode revisi sedang berlangsung. Sisa waktu <span id="countdown"></span>.
                            </div>
                            <script>
                                var countdownDate = new Date("{{ $timeline->revision_end_date }}").getTime();
                            </script>
                        @else
                            <div class="modern-alert modern-alert-danger">
                                <i class="fa fa-times-circle me-2"></i>Periode revisi telah berakhir pada <strong>{{ $timeline->revision_end_date->format('d M Y H:i') }}</strong>.
                            </div>
                        @endif
                    @endif

                    @php($revisionOpen = $timeline && $timeline->revision_start_date && $timeline->revision_end_date && $currentDate >= $timeline->revision_start_date && $currentDate <= $timeline->revision_end_date)
                    @php($uploadOpen = $revisionOpen)
                    @php($draft = $proposal)

                    @if ($errors->any())
                        <div class="modern-alert modern-alert-danger">
                            <i class="fa fa-exclamation-circle me-2"></i>Kirim revisi gagal. Mohon periksa kembali isian berikut:
                            <ul class="mb-0 mt-2 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="modern-alert modern-alert-danger">
                            <i class="fa fa-times-circle me-2"></i>{{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="modern-alert modern-alert-success">
                            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    @php($feedbackSource = $originalProposal ?? $proposal)

                    <div class="modern-card mt-4">
                        <div class="modern-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div>
                                <h4 class="mb-0"><i class="fa fa-comments me-2"></i>Catatan untuk Revisi</h4>
                            </div>
                        </div>
                        <div class="modern-card-body">
                            <div class="mb-4">
                                <div class="text-uppercase small text-muted fw-semibold mb-1">Komentar Admin</div>
                                <p class="mb-0">
                                    {{ $feedbackSource->admin_comment ? $feedbackSource->admin_comment : 'Belum ada komentar dari admin.' }}
                                </p>
                            </div>
                            <div>
                                <div class="text-uppercase small text-muted fw-semibold mb-2">Komentar Reviewer</div>
                                @if(isset($reviews) && $reviews->count() > 0)
                                    <div class="row g-3">
                                        @foreach($reviews as $index => $review)
                                            <div class="col-md-6">
                                                <div class="modern-card h-100">
                                                    <div class="modern-card-body">
                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                            <span class="fw-semibold">Reviewer {{ $index + 1 }}</span>
                                                <span class="text-muted small">{{ $review->reviewer->name ?? 'Reviewer' }}</span>
                                                        </div>
                                                        <p class="mb-0">{{ $review->komentar ?? 'Tidak ada komentar.' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="modern-alert modern-alert-info mb-0">
                                        <i class="fa fa-info-circle me-2"></i>Belum ada komentar reviewer.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="modern-card mt-4">
                        <div class="modern-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div>
                                <h4 class="mb-0"><i class="fa fa-file-signature me-2"></i>Form Revisi Penelitian</h4>
                            </div>
                            @unless($uploadOpen)
                                <span class="status-badge locked">
                                    <i class="fa fa-lock"></i>Form dikunci
                                </span>
                            @endunless
                        </div>
                        <form method="POST" action="{{ route('penelitian-dos.revisi.store', $originalProposal->id ?? $proposal->id) }}" enctype="multipart/form-data" novalidate>
                            @csrf
                            <fieldset class="border-0 p-0 m-0" @disabled(!$uploadOpen)>
                                <div class="modern-card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="modern-form-group">
                                                <label for="judul" class="modern-form-label"></label>
                                                    <i class="fa fa-heading me-2"></i>Judul Penelitian
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="judul" id="judul" class="modern-form-input" placeholder="Masukkan judul penelitian..." value="{{ old('judul', $draft->judul ?? '') }}" required>
                                            </div>

                                            <div class="modern-form-group">
                                                <label for="lama_penelitian" class="modern-form-label">
                                                    <i class="fa fa-clock me-2"></i>Lama Penelitian
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="lama_penelitian" id="lama_penelitian" class="modern-form-input" placeholder="Contoh: 12 bulan" value="{{ old('lama_penelitian', $draft->lama_penelitian ?? '') }}" required>
                                            </div>

                                            <div class="modern-form-group">
                                                <label for="biaya_diusulkan" class="modern-form-label">
                                                    <i class="fa fa-money-bill me-2"></i>Biaya yang Diusulkan (Rp.)
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="biaya_diusulkan" id="biaya_diusulkan" class="modern-form-input" inputmode="numeric" pattern="[0-9]*" placeholder="Masukkan jumlah biaya..." value="{{ old('biaya_diusulkan', $draft->biaya_diusulkan ?? '') }}" required>
                                            </div>

                                            <div class="modern-form-group">
                                                <label for="ringkasan_proposal" class="modern-form-label">
                                                    <i class="fa fa-file-text me-2"></i>Ringkasan Proposal
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <textarea name="ringkasan_proposal" id="ringkasan_proposal" class="modern-form-textarea" placeholder="Tuliskan ringkasan proposal penelitian..." required>{{ old('ringkasan_proposal', $draft->ringkasan_proposal ?? '') }}</textarea>
                                                <div id="wordCount" class="text-muted small mt-1">0/500 words</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="modern-form-group">
                                                <label for="skema" class="modern-form-label">
                                                    <i class="fa fa-list me-2"></i>Skema Penelitian
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select name="skema" id="skema" class="modern-form-select" required>
                                                    <option value="" disabled {{ !old('skema', $draft->skema ?? '') ? 'selected' : '' }}>Pilih skema penelitian...</option>
                                                    @foreach($skemaPenelitian as $skema)
                                                        <option value="{{ $skema->nama }}" {{ old('skema', $draft->skema ?? '') == $skema->nama ? 'selected' : '' }}>{{ $skema->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="modern-form-group">
                                                <label for="luaran_wajib" class="modern-form-label">
                                                    <i class="fa fa-trophy me-2"></i>Luaran Wajib
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select name="luaran_wajib" id="luaran_wajib" class="modern-form-select" required>
                                                    <option value="" disabled {{ !old('luaran_wajib', $draft->luaran_wajib ?? '') ? 'selected' : '' }}>Pilih luaran wajib...</option>
                                                    @foreach($luaranWajibPenelitian as $luaran)
                                                        <option value="{{ $luaran->nama }}" {{ old('luaran_wajib', $draft->luaran_wajib ?? '') == $luaran->nama ? 'selected' : '' }}>{{ $luaran->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="modern-form-group" id="sintaOptions" style="display: none;">
                                                <label for="sinta_index" class="modern-form-label">
                                                    <i class="fa fa-star me-2"></i>Sinta Level
                                                    <span class="text-danger" id="sintaRequiredIndicator" style="display:none">*</span>
                                                </label>
                                                <select name="sinta_index" id="sinta_index" class="modern-form-select">
                                                    <option value="" disabled {{ !old('sinta_index', $draft->sinta_index ?? '') ? 'selected' : '' }}>Pilih level Sinta...</option>
                                                    <option value="Sinta 1" {{ old('sinta_index', $draft->sinta_index ?? '') == 'Sinta 1' ? 'selected' : '' }}>Sinta 1</option>
                                                    <option value="Sinta 2" {{ old('sinta_index', $draft->sinta_index ?? '') == 'Sinta 2' ? 'selected' : '' }}>Sinta 2</option>
                                                    <option value="Sinta 3" {{ old('sinta_index', $draft->sinta_index ?? '') == 'Sinta 3' ? 'selected' : '' }}>Sinta 3</option>
                                                    <option value="Sinta 4" {{ old('sinta_index', $draft->sinta_index ?? '') == 'Sinta 4' ? 'selected' : '' }}>Sinta 4</option>
                                                    <option value="Sinta 5" {{ old('sinta_index', $draft->sinta_index ?? '') == 'Sinta 5' ? 'selected' : '' }}>Sinta 5</option>
                                                    <option value="Sinta 6" {{ old('sinta_index', $draft->sinta_index ?? '') == 'Sinta 6' ? 'selected' : '' }}>Sinta 6</option>
                                                </select>
                                            </div>
                                            <div class="modern-form-group">
                                                <label for="luaran_tambahan" class="modern-form-label"><i class="fa fa-plus-circle me-2"></i>Luaran Tambahan</label>
                                                <select name="luaran_tambahan" id="luaran_tambahan" class="modern-form-select">
                                                    <option value="" disabled {{ !old('luaran_tambahan', $draft->luaran_tambahan ?? '') ? 'selected' : '' }}>Pilih luaran tambahan (opsional)...</option>
                                                    @foreach($luaranTambahanPenelitian as $luaran)
                                                        <option value="{{ $luaran->nama }}" {{ old('luaran_tambahan', $draft->luaran_tambahan ?? '') == $luaran->nama ? 'selected' : '' }}>{{ $luaran->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="modern-form-group">
                                                <label for="dokumen_proposal" class="modern-form-label">
                                                    <i class="fa fa-file-pdf me-2"></i>Dokumen Proposal Revisi (PDF)
                                                    <span class="text-danger">*</span>
                                                </label>
                                                @if(!$isEditingRevision)
                                                    <div class="text-muted small mb-2">Unggah dokumen revisi terbaru (maks. 10MB, format PDF).</div>
                                                @else
                                                    <div class="modern-alert modern-alert-info mb-2">
                                                        <i class="fa fa-info-circle me-2"></i>Anda boleh melewati unggah jika ingin menggunakan dokumen revisi sebelumnya.
                                                        @if(!empty($proposal->dokumen_proposal))
                                                            <br><small>File saat ini: <a href="{{ Storage::url($proposal->dokumen_proposal) }}" target="_blank" class="text-decoration-underline">{{ basename($proposal->dokumen_proposal) }}</a></small>
                                                        @endif
                                                    </div>
                                                @endif
                                                <input type="file" name="dokumen_proposal" id="dokumen_proposal" class="modern-form-input" accept="application/pdf" @required(!$isEditingRevision)>
                                                @error('dokumen_proposal')
                                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                <div class="mt-4">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                                        <h4 class="mb-0">
                                            <i class="fa fa-coins me-2"></i>Rencana Anggaran Biaya
                                        </h4>
                                        <button type="button" class="modern-btn modern-btn-secondary" id="addRabRow">
                                            <i class="fa fa-plus me-2"></i>Tambah Baris RAB
                                        </button>
                                    </div>

                                    <div class="modern-table-container">
                                        <table class="modern-table" id="rabTable">
                                            <thead>
                                                <tr>
                                                    <th>Kelompok RAB</th>
                                                    <th>Komponen</th>
                                                    <th>Item</th>
                                                    <th>Satuan</th>
                                                    <th>Volume</th>
                                                    <th>Harga Satuan</th>
                                                    <th>Total</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="6" class="text-end fw-bold">Total Anggaran</td>
                                                    <td class="text-end">
                                                        <span id="rabGrandTotal">Rp 0</span>
                                                        <input type="hidden" name="rab_total_anggaran" id="rabGrandTotalInput" value="0">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <template id="rabRowTemplate">
                                        <tr>
                                            <td>
                                                <select name="rab_kelompok[]" class="modern-form-select rab-kelompok-select" required>
                                                    <option value="" disabled selected>Pilih kelompok...</option>
                                                    @foreach($kelompokRab ?? [] as $kelompok)
                                                        <option value="{{ $kelompok->nama }}">{{ $kelompok->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="rab_komponen[]" class="modern-form-select rab-komponen-select" required>
                                                    <option value="" disabled selected>Pilih komponen...</option>
                                                    @foreach($komponenRab ?? [] as $komponen)
                                                        <option value="{{ $komponen->nama }}" data-komponen-id="{{ $komponen->id }}">{{ $komponen->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="rab_item[]" class="modern-form-input" placeholder="Nama item" required>
                                            </td>
                                            <td>
                                                <select name="rab_satuan[]" class="modern-form-select rab-satuan-select" required>
                                                    <option value="" disabled selected>Pilih komponen dulu...</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="rab_volume[]" class="modern-form-input rab-volume" inputmode="numeric" placeholder="0" required>
                                            </td>
                                            <td>
                                                <input type="text" name="rab_harga_satuan[]" class="modern-form-input rab-harga" inputmode="numeric" placeholder="0" required>
                                            </td>
                                            <td class="text-end">
                                                <span class="fw-bold rab-row-total">Rp 0</span>
                                                <input type="hidden" name="rab_total[]" class="rab-total-value" value="0">
                                            </td>
                                            <td>
                                                <button type="button" class="modern-btn modern-btn-danger modern-btn-sm remove-rab-row">
                                                    <i class="fa fa-trash me-1"></i>Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </div><br>

                                    <div class="mt-4">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                                            <h4 class="mb-0"><i class="fa fa-users me-2"></i>Tim Peneliti</h4>
                                            <button type="button" class="modern-btn modern-btn-secondary" id="addAnggota">
                                                <i class="fa fa-user-plus me-2"></i>Tambah Anggota
                                            </button>
                                        </div>
                                        <div class="modern-table-container">
                                            <table class="modern-table" id="anggotaTable">
                                                <thead>
                                                    <tr>
                                                        <th>Nama</th>
                                                        <th>Peran</th>
                                                        <th>Jabatan</th>
                                                        <th>NIDN/NIM</th>
                                                        <th>Email</th>
                                                        <th>Telepon</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div><br>
                                </div>
                            </fieldset>

                            <div class="modern-card-footer d-flex flex-wrap gap-2">
                                <a href="{{ route('penelitian-dos.revisi.index') }}" class="modern-btn modern-btn-secondary">
                                    <i class="fa fa-times me-1"></i>Batalkan
                                </a>
                                <button type="submit" class="modern-btn modern-btn-success" id="submitProposal" @disabled(!$uploadOpen)>
                                    <i class="fa fa-paper-plane me-1"></i>Kirim Revisi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        if (typeof countdownDate !== 'undefined') {
            var counter = setInterval(function() {
                var now = new Date().getTime();
                var distance = countdownDate - now;

                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                var el = document.getElementById('countdown');
                if (el) {
                    el.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
                }

                if (distance < 0) {
                    clearInterval(counter);
                    if (el) {
                        el.innerHTML = "EXPIRED";
                    }
                }
            }, 1000);
        }

        const ringkasanInput = document.getElementById('ringkasan_proposal');
        const wordCountElement = document.getElementById('wordCount');
        const biayaInput = document.getElementById('biaya_diusulkan');
        const sintaOptions = document.getElementById('sintaOptions');
        const sintaSelect = document.getElementById('sinta_index');
        const sintaRequiredIndicator = document.getElementById('sintaRequiredIndicator');
        const form = document.querySelector('form');
        const anggotaTableBody = document.querySelector('#anggotaTable tbody');
        const submitButton = document.getElementById('submitProposal');
        const dokumenProposalField = document.getElementById('dokumen_proposal');
        const rabTableBody = document.querySelector('#rabTable tbody');
        const rabTemplate = document.getElementById('rabRowTemplate');
        const rabAddBtn = document.getElementById('addRabRow');
        const rabGrandTotalDisplay = document.getElementById('rabGrandTotal');
        const rabGrandTotalInput = document.getElementById('rabGrandTotalInput');
        const existingDokumenAvailable = @json(($isEditingRevision ?? false) && !empty($proposal->dokumen_proposal));
        
        function updateWordCount() {
            const words = ringkasanInput.value.trim().split(/\s+/).filter(Boolean);
            if (words.length > 500) {
                ringkasanInput.value = words.slice(0, 500).join(' ');
            }
            wordCountElement.textContent = Math.min(words.length, 500) + '/500 words';
        }

        function restrictNumberInput(event) {
            event.target.value = event.target.value.replace(/[^0-9]/g, '');
        }

        function sanitizeNumber(value) {
            return parseInt((value || '').toString().replace(/[^0-9]/g, ''), 10) || 0;
        }

        function formatCurrency(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(value || 0);
        }

        function updateRabRowTotal(row) {
            if (!row) {
                return;
            }

            const volumeInput = row.querySelector('.rab-volume');
            const hargaInput = row.querySelector('.rab-harga');
            const totalDisplay = row.querySelector('.rab-row-total');
            const totalInput = row.querySelector('.rab-total-value');

            const volume = sanitizeNumber(volumeInput?.value);
            const harga = sanitizeNumber(hargaInput?.value);
            const total = volume * harga;

            if (totalDisplay) {
                totalDisplay.textContent = formatCurrency(total);
            }
            if (totalInput) {
                totalInput.value = total;
            }

            updateRabGrandTotal();
        }

        function updateRabGrandTotal() {
            const totals = Array.from(document.querySelectorAll('.rab-total-value')).map((input) => sanitizeNumber(input.value));
            const sum = totals.reduce((acc, value) => acc + value, 0);
            if (rabGrandTotalDisplay) {
                rabGrandTotalDisplay.textContent = formatCurrency(sum);
            }
            if (rabGrandTotalInput) {
                rabGrandTotalInput.value = sum;
            }
        }

        function updateSatuanByKomponen(selectElement, row, callback) {
            const komponenName = selectElement.value;
            const satuanSelect = row ? row.querySelector('.rab-satuan-select') : selectElement.closest('tr')?.querySelector('.rab-satuan-select');
            
            if (!satuanSelect || !komponenName) {
                if (satuanSelect) {
                    satuanSelect.innerHTML = '<option value="" disabled selected>Pilih komponen dulu...</option>';
                }
                if (callback) callback();
                return;
            }

            // Show loading
            satuanSelect.innerHTML = '<option value="">Memuat satuan...</option>';
            satuanSelect.disabled = true;

            // Fetch satuan for this komponen
            fetch(`{{ route('dosen.rab.get-satuan-by-komponen') }}?komponen=${encodeURIComponent(komponenName)}`)
                .then(response => response.json())
                .then(data => {
                    satuanSelect.innerHTML = '<option value="" disabled selected>Pilih satuan...</option>';
                    
                    if (data.satuan && data.satuan.length > 0) {
                        data.satuan.forEach(satuan => {
                            const option = document.createElement('option');
                            option.value = satuan.nama;
                            option.textContent = satuan.singkatan ? `${satuan.nama} (${satuan.singkatan})` : satuan.nama;
                            satuanSelect.appendChild(option);
                        });
                    } else {
                        satuanSelect.innerHTML = '<option value="" disabled>Belum ada satuan untuk komponen ini</option>';
                    }
                    satuanSelect.disabled = false;
                    
                    // Call callback after satuan is loaded
                    if (callback) callback();
                })
                .catch(error => {
                    console.error('Error loading satuan:', error);
                    satuanSelect.innerHTML = '<option value="" disabled>Error memuat satuan</option>';
                    satuanSelect.disabled = false;
                    if (callback) callback();
                });
        }

        function addRabRow() {
            if (!rabTemplate || !rabTableBody) {
                return;
            }

            const clone = rabTemplate.content.firstElementChild.cloneNode(true);
            const volumeInput = clone.querySelector('.rab-volume');
            const hargaInput = clone.querySelector('.rab-harga');
            const removeBtn = clone.querySelector('.remove-rab-row');
            const komponenSelect = clone.querySelector('.rab-komponen-select');

            if (volumeInput) {
                volumeInput.addEventListener('input', (event) => {
                    restrictNumberInput(event);
                    updateRabRowTotal(clone);
                });
            }

            if (hargaInput) {
                hargaInput.addEventListener('input', (event) => {
                    restrictNumberInput(event);
                    updateRabRowTotal(clone);
                });
            }

            // Add event listener for komponen change to update satuan
            if (komponenSelect) {
                komponenSelect.addEventListener('change', (event) => {
                    updateSatuanByKomponen(event.target, clone);
                    validateForm();
                });
            }

            if (removeBtn) {
                removeBtn.addEventListener('click', () => {
                    clone.remove();
                    updateRabGrandTotal();
                    validateForm();
                });
            }

            rabTableBody.appendChild(clone);
            updateRabRowTotal(clone);
            validateForm();
        }

        function toggleSintaOptions(event) {
            if (event.target.value === 'jurnal nasional terindeks sinta') {
                sintaOptions.style.display = 'block';
                sintaSelect.setAttribute('required', 'true');
                if (sintaRequiredIndicator) {
                    sintaRequiredIndicator.style.display = 'inline';
                }
            } else {
                sintaOptions.style.display = 'none';
                sintaSelect.removeAttribute('required');
                sintaSelect.value = '';
                if (sintaRequiredIndicator) {
                    sintaRequiredIndicator.style.display = 'none';
                }
            }
        }

        function addAnggotaRow() {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><input type="text" name="anggota_nama[]" class="modern-form-input" placeholder="Nama lengkap" required></td>
                <td>
                    <select name="anggota_peran[]" class="modern-form-select" required>
                        <option value="" disabled selected>Pilih peran...</option>
                        <option value="Ketua">Ketua</option>
                        <option value="Anggota">Anggota</option>
                    </select>
                </td>
                <td>
                    <select name="anggota_jabatan[]" class="modern-form-select" required>
                        <option value="" disabled selected>Pilih jabatan...</option>
                        <option value="Dosen">Dosen</option>
                        <option value="Mahasiswa">Mahasiswa</option>
                    </select>
                </td>
                <td><input type="text" name="anggota_nidn[]" class="modern-form-input" placeholder="NIDN/NIM" required></td>
                <td><input type="email" name="anggota_email[]" class="modern-form-input" placeholder="Email" required></td>
                <td>
                    <input type="text" name="anggota_telepon[]" class="modern-form-input" placeholder="No. Telepon" inputmode="numeric" pattern="[0-9]*" required>
                </td>
                <td>
                    <button type="button" class="modern-btn modern-btn-danger modern-btn-sm removeAnggota">
                        <i class="fa fa-trash me-1"></i>Hapus
                    </button>
                </td>
            `;

            row.querySelector('input[name="anggota_telepon[]"]').addEventListener('input', restrictNumberInput);
            row.querySelector('.removeAnggota').addEventListener('click', function () {
                row.remove();
                validateForm();
            });

            anggotaTableBody.appendChild(row);
            validateForm();
        }

        function validateForm() {
            if (!form || !submitButton) {
                return;
            }

            // Check if upload is open (from server-side)
            const uploadOpen = @json($uploadOpen ?? false);
            
            // Check if form has required elements
            const hasMember = anggotaTableBody && anggotaTableBody.children.length > 0;
            const hasRabRow = rabTableBody && rabTableBody.children.length > 0;
            
            // Validate anggota rows - check if at least one row is completely filled
            let anggotaValid = false;
            if (hasMember) {
                const anggotaRows = anggotaTableBody.querySelectorAll('tr');
                for (let row of anggotaRows) {
                    const nama = row.querySelector('input[name="anggota_nama[]"]');
                    // Skip empty rows (rows with no nama filled)
                    if (!nama || !nama.value.trim()) {
                        continue;
                    }
                    
                    const peran = row.querySelector('select[name="anggota_peran[]"]');
                    const jabatan = row.querySelector('select[name="anggota_jabatan[]"]');
                    const nidn = row.querySelector('input[name="anggota_nidn[]"]');
                    const email = row.querySelector('input[name="anggota_email[]"]');
                    const telepon = row.querySelector('input[name="anggota_telepon[]"]');
                    
                    // Check if this row is completely filled
                    const isRowComplete = 
                        nama.value.trim() &&
                        peran && peran.value &&
                        jabatan && jabatan.value &&
                        nidn && nidn.value.trim() &&
                        email && email.value.trim() && (email.validity.valid || email.value.includes('@')) &&
                        telepon && telepon.value.trim();
                    
                    if (isRowComplete) {
                        anggotaValid = true;
                        break; // At least one row is valid
                    }
                }
            } else {
                // If no anggota rows exist, it's invalid for submit
                anggotaValid = false;
            }
            
            // Validate RAB rows - check if at least one row is completely filled
            let rabRowsValid = false;
            if (hasRabRow) {
                const rabRows = rabTableBody.querySelectorAll('tr');
                for (let row of rabRows) {
                    const kelompok = row.querySelector('select[name="rab_kelompok[]"]');
                    // Skip empty rows (rows with no kelompok selected)
                    if (!kelompok || !kelompok.value) {
                        continue;
                    }
                    
                    const komponen = row.querySelector('select[name="rab_komponen[]"]');
                    const item = row.querySelector('input[name="rab_item[]"]');
                    const satuan = row.querySelector('select[name="rab_satuan[]"]');
                    const volume = row.querySelector('input[name="rab_volume[]"]');
                    const harga = row.querySelector('input[name="rab_harga_satuan[]"]');
                    
                    // Check if this row is completely filled
                    const volumeValue = volume && volume.value ? parseInt(volume.value) : 0;
                    const hargaValue = harga && harga.value ? parseFloat(harga.value) : 0;
                    const isRowComplete = 
                        kelompok.value &&
                        komponen && komponen.value &&
                        item && item.value.trim() &&
                        satuan && satuan.value &&
                        volumeValue > 0 &&
                        hargaValue >= 0;
                    
                    if (isRowComplete) {
                        rabRowsValid = true;
                        break; // At least one row is valid
                    }
                }
            } else {
                // If no RAB rows exist, it's invalid for submit
                rabRowsValid = false;
            }
            
            // Check basic form fields manually
            const judul = document.getElementById('judul');
            const skema = document.getElementById('skema');
            const luaranWajib = document.getElementById('luaran_wajib');
            const lamaPenelitian = document.getElementById('lama_penelitian');
            const biayaDiusulkan = document.getElementById('biaya_diusulkan');
            const ringkasanProposal = document.getElementById('ringkasan_proposal');
            const dokumenProposal = dokumenProposalField;
            
            // Dokumen revisi wajib file baru saat pertama kali, boleh pakai file lama saat edit
            const dokumenValid = dokumenProposal && (dokumenProposal.files.length > 0 || existingDokumenAvailable);
            
            const basicFieldsValid = 
                judul && judul.value.trim() &&
                skema && skema.value &&
                luaranWajib && luaranWajib.value &&
                lamaPenelitian && lamaPenelitian.value.trim() &&
                biayaDiusulkan && biayaDiusulkan.value.trim() &&
                ringkasanProposal && ringkasanProposal.value.trim() &&
                dokumenValid;
            
            // Check if sinta_index is required and filled
            let sintaValid = true;
            const sintaOptions = document.getElementById('sintaOptions');
            const sintaIndex = document.getElementById('sinta_index');
            if (sintaOptions && sintaOptions.style.display !== 'none') {
                sintaValid = sintaIndex && sintaIndex.value;
            }
            
            // Final validation - only for submit proposal, not for draft
            // For submit: all fields must be valid
            // For draft: no validation needed (handled by formnovalidate)
            const isValid = uploadOpen && basicFieldsValid && anggotaValid && rabRowsValid && sintaValid;
            
            // Only enable submit button if everything is valid and upload is open
            // Draft button is always enabled (has formnovalidate attribute)
            if (submitButton) {
                submitButton.disabled = !isValid;
            }
            
            // Debug log (can be removed later)
            if (!isValid && uploadOpen) {
                console.log('Validation failed:', {
                    uploadOpen,
                    basicFieldsValid,
                    anggotaValid,
                    rabRowsValid,
                    sintaValid
                });
            }
        }

        ringkasanInput.addEventListener('input', updateWordCount);
        biayaInput.addEventListener('input', restrictNumberInput);
        document.getElementById('luaran_wajib').addEventListener('change', toggleSintaOptions);
        document.getElementById('addAnggota').addEventListener('click', addAnggotaRow);
        if (rabAddBtn) {
            rabAddBtn.addEventListener('click', addRabRow);
        }

        form.addEventListener('input', validateForm);
        form.addEventListener('change', validateForm);
        
        // Also validate when file is selected or removed
        const dokumenProposalInput = dokumenProposalField;
        if (dokumenProposalInput) {
            dokumenProposalInput.addEventListener('change', validateForm);
            // Also validate when file input is cleared (if user removes file)
            dokumenProposalInput.addEventListener('input', validateForm);
        }
        
        // Also validate when select/input changes in RAB or anggota tables
        document.addEventListener('change', function(e) {
            if (e.target.matches('select[name^="rab_"], input[name^="rab_"], select[name^="anggota_"], input[name^="anggota_"]')) {
                validateForm();
            }
            
            // Handle komponen change to update satuan dynamically
            if (e.target.matches('.rab-komponen-select')) {
                const row = e.target.closest('tr');
                if (row) {
                    updateSatuanByKomponen(e.target, row);
                }
            }
        });

        window.addEventListener('load', function () {
            @if(isset($draft) && $draft)
                // Pre-fill anggota dari draft
                @if($draft->anggota && $draft->anggota->count() > 0)
                    @foreach($draft->anggota as $anggota)
                        addAnggotaRow();
                        const anggotaRows = document.querySelectorAll('#anggotaTable tbody tr');
                        const lastRow = anggotaRows[anggotaRows.length - 1];
                        if (lastRow) {
                            lastRow.querySelector('input[name="anggota_nama[]"]').value = '{{ $anggota->nama }}';
                            lastRow.querySelector('input[name="anggota_nidn[]"]').value = '{{ $anggota->nidn }}';
                            lastRow.querySelector('input[name="anggota_email[]"]').value = '{{ $anggota->email }}';
                            lastRow.querySelector('input[name="anggota_telepon[]"]').value = '{{ $anggota->telepon }}';
                            lastRow.querySelector('select[name="anggota_peran[]"]').value = '{{ $anggota->peran }}';
                            lastRow.querySelector('select[name="anggota_jabatan[]"]').value = '{{ $anggota->jabatan }}';
                        }
                    @endforeach
                @else
                    addAnggotaRow();
                @endif
                
                // Pre-fill RAB dari draft
                @if($draft->rab && $draft->rab->count() > 0)
                    let rabPopulateCount = 0;
                    const totalRabRows = {{ $draft->rab->count() }};
                    
                    @foreach($draft->rab as $rab)
                        addRabRow();
                        const rabRows = document.querySelectorAll('#rabTable tbody tr');
                        const lastRabRow = rabRows[rabRows.length - 1];
                        if (lastRabRow) {
                            lastRabRow.querySelector('select[name="rab_kelompok[]"]').value = '{{ $rab->kelompok }}';
                            
                            // Set komponen dan load satuan dengan callback
                            const komponenSelect = lastRabRow.querySelector('select[name="rab_komponen[]"]');
                            const satuanSelect = lastRabRow.querySelector('select[name="rab_satuan[]"]');
                            const satuanValue = '{{ $rab->satuan }}';
                            
                            if (komponenSelect && '{{ $rab->komponen }}') {
                                komponenSelect.value = '{{ $rab->komponen }}';
                                
                                // Load satuan with callback to set value after loading
                                updateSatuanByKomponen(komponenSelect, lastRabRow, function() {
                                    // Set satuan value after options are loaded
                                    if (satuanValue && satuanSelect) {
                                        satuanSelect.value = satuanValue;
                                    }
                                    
                                    // Set other fields
                                    lastRabRow.querySelector('input[name="rab_item[]"]').value = '{{ $rab->item }}';
                                    lastRabRow.querySelector('input[name="rab_volume[]"]').value = '{{ $rab->volume }}';
                                    lastRabRow.querySelector('input[name="rab_harga_satuan[]"]').value = '{{ $rab->harga_satuan }}';
                                    
                                    // Trigger change untuk update total
                                    const volumeInput = lastRabRow.querySelector('input[name="rab_volume[]"]');
                                    const hargaInput = lastRabRow.querySelector('input[name="rab_harga_satuan[]"]');
                                    if (volumeInput && hargaInput) {
                                        volumeInput.dispatchEvent(new Event('input'));
                                        hargaInput.dispatchEvent(new Event('input'));
                                    }
                                    
                                    // Increment counter and validate when all rows are done
                                    rabPopulateCount++;
                                    if (rabPopulateCount === totalRabRows) {
                                        setTimeout(validateForm, 200);
                                    }
                                });
                            } else {
                                // If no komponen, set other fields directly
                                lastRabRow.querySelector('input[name="rab_item[]"]').value = '{{ $rab->item }}';
                                lastRabRow.querySelector('input[name="rab_volume[]"]').value = '{{ $rab->volume }}';
                                lastRabRow.querySelector('input[name="rab_harga_satuan[]"]').value = '{{ $rab->harga_satuan }}';
                                
                                // Increment counter and validate when all rows are done
                                rabPopulateCount++;
                                if (rabPopulateCount === totalRabRows) {
                                    setTimeout(validateForm, 200);
                                }
                            }
                        }
                    @endforeach
                @else
                    addRabRow();
                @endif
            @else
                addAnggotaRow();
                addRabRow();
            @endif
            
            updateWordCount();
            
            // Delay validation slightly to ensure DOM is fully ready
            // Use longer delay to ensure all async operations (like satuan loading) are complete
            setTimeout(validateForm, 500);
        });
    </script>
</x-dosen-layout>

