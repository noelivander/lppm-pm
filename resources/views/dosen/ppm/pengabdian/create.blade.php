<x-dosen-layout>
    <x-slot name="header">
        {{ __('Pengabdian') }}
    </x-slot>

    @php
        $rabKelompokOptions = [
            'Honorarium' => 'Honorarium',
            'Perjalanan' => 'Perjalanan',
            'Operasional' => 'Operasional',
            'Peralatan' => 'Peralatan',
            'Lainnya' => 'Lainnya',
        ];

        $rabKomponenOptions = [
            'SDM' => 'Sumber Daya Manusia',
            'Material' => 'Material / Bahan',
            'Jasa' => 'Jasa / Konsultan',
            'Transportasi' => 'Transportasi',
            'Lainnya' => 'Lainnya',
        ];
    @endphp

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3 fade-in-up">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                        <h3 class="mb-0"><i class="fa fa-hands-helping me-2"></i>Tambah Usulan Pengabdian</h3>
                        <a href="{{ route('pengabdian-dos.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fa fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                    </div>

                    @if (!$timeline)
                        <div class="modern-alert modern-alert-danger">
                            <i class="fa fa-exclamation-circle me-2"></i>Belum ada jadwal unggah aktif. Form dalam keadaan terkunci.
                        </div>
                    @else
                        @if ($currentDate < $timeline->upload_start_date)
                            <div class="modern-alert modern-alert-warning">
                                <i class="fa fa-clock me-2"></i>Periode unggah akan dimulai dalam <span id="countdown"></span>.
                            </div>
                            <script>
                                var countdownDate = new Date("{{ $timeline->upload_start_date }}").getTime();
                            </script>
                        @elseif ($currentDate >= $timeline->upload_start_date && $currentDate <= $timeline->upload_end_date)
                            <div class="modern-alert modern-alert-info">
                                <i class="fa fa-info-circle me-2"></i>Periode unggah dibuka. Sisa waktu <span id="countdown"></span>.
                            </div>
                            <script>
                                var countdownDate = new Date("{{ $timeline->upload_end_date }}").getTime();
                            </script>
                        @else
                            <div class="modern-alert modern-alert-danger">
                                <i class="fa fa-times-circle me-2"></i>Periode unggah telah berakhir.
                            </div>
                        @endif
                    @endif

                    @php($uploadOpen = $timeline && $currentDate >= $timeline->upload_start_date && $currentDate <= $timeline->upload_end_date)

                    <div class="modern-card mt-4">
                        <div class="modern-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div>
                                <h4 class="mb-0"><i class="fa fa-file-alt me-2"></i>Form Usulan Pengabdian</h4>
                            </div>
                            @unless($uploadOpen)
                                <span class="badge bg-secondary">Form dikunci</span>
                            @endunless
                        </div>
                        <form method="POST" action="{{ route('pengabdian-dos.store') }}" enctype="multipart/form-data">
                            @csrf
                            <fieldset class="border-0 p-0 m-0" @disabled(!$uploadOpen)>
                                <div class="modern-card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="modern-form-group">
                                                <label for="judul" class="modern-form-label">
                                                    <i class="fa fa-heading me-2"></i>Judul Pengabdian
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="judul" id="judul" class="modern-form-input" placeholder="Masukkan judul pengabdian..." required>
                                            </div>

                                            <div class="modern-form-group">
                                                <label for="lama_penelitian" class="modern-form-label">
                                                    <i class="fa fa-clock me-2"></i>Lama Pengabdian
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="lama_penelitian" id="lama_penelitian" class="modern-form-input" placeholder="Contoh: 6 bulan" required>
                                            </div>

                                            <div class="modern-form-group">
                                                <label for="biaya_diusulkan" class="modern-form-label">
                                                    <i class="fa fa-money-bill me-2"></i>Biaya yang Diusulkan (Rp.)
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="biaya_diusulkan" id="biaya_diusulkan" class="modern-form-input" inputmode="numeric" pattern="[0-9]*" placeholder="Masukkan jumlah biaya..." required>
                                            </div>

                                            <div class="modern-form-group">
                                                <label for="ringkasan_proposal" class="modern-form-label">
                                                    <i class="fa fa-file-text me-2"></i>Ringkasan Proposal
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <textarea name="ringkasan_proposal" id="ringkasan_proposal" class="modern-form-textarea" placeholder="Tuliskan ringkasan proposal pengabdian..." required></textarea>
                                                <div id="wordCount" class="text-muted small mt-1">0/500 words</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="modern-form-group">
                                                <label for="skema" class="modern-form-label">
                                                    <i class="fa fa-list me-2"></i>Skema Pengabdian
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select name="skema" id="skema" class="modern-form-select" required>
                                                    <option value="" disabled selected>Pilih skema pengabdian...</option>
                                                    @foreach($skemaPengabdian as $skema)
                                                        <option value="{{ $skema->nama }}">{{ $skema->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="modern-form-group">
                                                <label for="luaran_wajib" class="modern-form-label">
                                                    <i class="fa fa-trophy me-2"></i>Luaran Wajib
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select name="luaran_wajib" id="luaran_wajib" class="modern-form-select" required>
                                                    <option value="" disabled selected>Pilih luaran wajib...</option>
                                                    @foreach($luaranWajibPengabdian as $luaran)
                                                        <option value="{{ $luaran->nama }}">{{ $luaran->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="modern-form-group" id="sintaOptions" style="display:none;">
                                                <label for="sinta_index" class="modern-form-label">
                                                    <i class="fa fa-star me-2"></i>Sinta Level
                                                    <span class="text-danger" id="sintaRequiredIndicator" style="display:none">*</span>
                                                </label>
                                                <select name="sinta_index" id="sinta_index" class="modern-form-select">
                                                    <option value="" disabled selected>Pilih level Sinta...</option>
                                                    <option value="Sinta 1">Sinta 1</option>
                                                    <option value="Sinta 2">Sinta 2</option>
                                                    <option value="Sinta 3">Sinta 3</option>
                                                    <option value="Sinta 4">Sinta 4</option>
                                                    <option value="Sinta 5">Sinta 5</option>
                                                    <option value="Sinta 6">Sinta 6</option>
                                                </select>
                                            </div>

                                            <div class="modern-form-group">
                                                <label for="luaran_tambahan" class="modern-form-label"><i class="fa fa-plus-square me-2"></i>Luaran Tambahan</label>
                                                <select name="luaran_tambahan" id="luaran_tambahan" class="modern-form-select">
                                                    <option value="" disabled selected>Pilih luaran tambahan (opsional)...</option>
                                                    @foreach($luaranTambahanPengabdian as $luaran)
                                                        <option value="{{ $luaran->nama }}">{{ $luaran->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="modern-form-group">
                                                <label for="dokumen_proposal" class="modern-form-label">
                                                    <i class="fa fa-file-pdf me-2"></i>Dokumen Proposal (PDF)
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="file" name="dokumen_proposal" id="dokumen_proposal" class="modern-form-input" accept="application/pdf" required>
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
                                    </div><br>

                                    <template id="rabRowTemplate">
                                        <tr>
                                            <td>
                                                <select name="rab_kelompok[]" class="modern-form-select" required>
                                                    <option value="" disabled selected>Pilih kelompok...</option>
                                                    @foreach($rabKelompokOptions as $value => $label)
                                                        <option value="{{ $value }}">{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="rab_komponen[]" class="modern-form-select" required>
                                                    <option value="" disabled selected>Pilih komponen...</option>
                                                    @foreach($rabKomponenOptions as $value => $label)
                                                        <option value="{{ $value }}">{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="rab_item[]" class="modern-form-input" placeholder="Nama item" required>
                                            </td>
                                            <td>
                                                <input type="text" name="rab_satuan[]" class="modern-form-input" placeholder="pcs/buah/OK" required>
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
                                </div>

                                    <div class="mt-4">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                                            <h4 class="mb-0"><i class="fa fa-users me-2"></i>Tim Pengabdian</h4>
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
                                <a href="{{ route('pengabdian-dos.index') }}" class="modern-btn modern-btn-secondary">
                                    <i class="fa fa-times me-1"></i>Batalkan
                                </a>
                                <button type="submit" class="modern-btn modern-btn-success" id="submitProposal" @disabled(!$uploadOpen)>
                                    <i class="fa fa-paper-plane me-1"></i>Submit Proposal
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
        const rabTableBody = document.querySelector('#rabTable tbody');
        const rabTemplate = document.getElementById('rabRowTemplate');
        const rabAddBtn = document.getElementById('addRabRow');
        const rabGrandTotalDisplay = document.getElementById('rabGrandTotal');
        const rabGrandTotalInput = document.getElementById('rabGrandTotalInput');

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

        function addRabRow() {
            if (!rabTemplate || !rabTableBody) {
                return;
            }

            const clone = rabTemplate.content.firstElementChild.cloneNode(true);
            const volumeInput = clone.querySelector('.rab-volume');
            const hargaInput = clone.querySelector('.rab-harga');
            const removeBtn = clone.querySelector('.remove-rab-row');

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
                    const peran = row.querySelector('select[name="anggota_peran[]"]');
                    const jabatan = row.querySelector('select[name="anggota_jabatan[]"]');
                    const nidn = row.querySelector('input[name="anggota_nidn[]"]');
                    const email = row.querySelector('input[name="anggota_email[]"]');
                    const telepon = row.querySelector('input[name="anggota_telepon[]"]');
                    
                    // Check if this row is completely filled
                    const isRowComplete = 
                        nama && nama.value.trim() &&
                        peran && peran.value &&
                        jabatan && jabatan.value &&
                        nidn && nidn.value.trim() &&
                        email && email.value.trim() && email.validity.valid &&
                        telepon && telepon.value.trim();
                    
                    if (isRowComplete) {
                        anggotaValid = true;
                        break; // At least one row is valid
                    }
                }
            }
            
            // Validate RAB rows - check if at least one row is completely filled
            let rabRowsValid = false;
            if (hasRabRow) {
                const rabRows = rabTableBody.querySelectorAll('tr');
                for (let row of rabRows) {
                    const kelompok = row.querySelector('select[name="rab_kelompok[]"]');
                    const komponen = row.querySelector('select[name="rab_komponen[]"]');
                    const item = row.querySelector('input[name="rab_item[]"]');
                    const satuan = row.querySelector('input[name="rab_satuan[]"]');
                    const volume = row.querySelector('input[name="rab_volume[]"]');
                    const harga = row.querySelector('input[name="rab_harga_satuan[]"]');
                    
                    // Check if this row is completely filled
                    const isRowComplete = 
                        kelompok && kelompok.value &&
                        komponen && komponen.value &&
                        item && item.value.trim() &&
                        satuan && satuan.value.trim() &&
                        volume && volume.value && parseInt(volume.value) > 0 &&
                        harga && harga.value && parseFloat(harga.value) >= 0;
                    
                    if (isRowComplete) {
                        rabRowsValid = true;
                        break; // At least one row is valid
                    }
                }
            }
            
            // Check basic form fields manually
            const judul = document.getElementById('judul');
            const skema = document.getElementById('skema');
            const luaranWajib = document.getElementById('luaran_wajib');
            const lamaPenelitian = document.getElementById('lama_penelitian');
            const biayaDiusulkan = document.getElementById('biaya_diusulkan');
            const ringkasanProposal = document.getElementById('ringkasan_proposal');
            const dokumenProposal = document.getElementById('dokumen_proposal');
            
            const basicFieldsValid = 
                judul && judul.value.trim() &&
                skema && skema.value &&
                luaranWajib && luaranWajib.value &&
                lamaPenelitian && lamaPenelitian.value.trim() &&
                biayaDiusulkan && biayaDiusulkan.value.trim() &&
                ringkasanProposal && ringkasanProposal.value.trim() &&
                dokumenProposal && dokumenProposal.files.length > 0;
            
            // Check if sinta_index is required and filled
            let sintaValid = true;
            const sintaOptions = document.getElementById('sintaOptions');
            const sintaIndex = document.getElementById('sinta_index');
            if (sintaOptions && sintaOptions.style.display !== 'none') {
                sintaValid = sintaIndex && sintaIndex.value;
            }
            
            // Final validation
            const isValid = uploadOpen && basicFieldsValid && anggotaValid && rabRowsValid && sintaValid;
            
            // Only enable button if everything is valid and upload is open
            submitButton.disabled = !isValid;
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
        
        // Also validate when file is selected
        const dokumenProposalInput = document.getElementById('dokumen_proposal');
        if (dokumenProposalInput) {
            dokumenProposalInput.addEventListener('change', validateForm);
        }
        
        // Also validate when select/input changes in RAB or anggota tables
        document.addEventListener('change', function(e) {
            if (e.target.matches('select[name^="rab_"], input[name^="rab_"], select[name^="anggota_"], input[name^="anggota_"]')) {
                validateForm();
            }
        });

        window.addEventListener('load', function () {
            addAnggotaRow();
            addRabRow();
            updateWordCount();
            
            // Delay validation slightly to ensure DOM is fully ready
            setTimeout(validateForm, 100);
        });
    </script>
</x-dosen-layout>
