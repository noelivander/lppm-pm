<x-dosen-layout>
    <x-slot name="header">
        {{ __('Penelitian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3 fade-in-up">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                        <h3 class="mb-0">
                            <i class="fa fa-file-alt me-2"></i>Tambah Usulan Penelitian
                        </h3>
                        <a href="{{ route('penelitian-dos.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fa fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                    </div>

                    @if (!$timeline)
                        <div class="modern-alert modern-alert-danger">
                            <i class="fa fa-exclamation-circle me-2"></i>Belum ada jadwal unggah yang aktif. Anda tidak dapat menambahkan usulan saat ini.
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
                                <i class="fa fa-info-circle me-2"></i>Periode unggah sedang berlangsung. Akan berakhir dalam <span id="countdown"></span>.
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
                                <h4 class="mb-0"><i class="fa fa-file-signature me-2"></i>Form Usulan Penelitian</h4>
                            </div>
                            @unless($uploadOpen)
                                <span class="badge bg-secondary">Form dikunci</span>
                            @endunless
                        </div>
                        <form method="POST" action="{{ route('penelitian-dos.store') }}" enctype="multipart/form-data">
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
                                                <input type="text" name="judul" id="judul" class="modern-form-input" placeholder="Masukkan judul penelitian..." required>
                                            </div>

                                            <div class="modern-form-group">
                                                <label for="lama_penelitian" class="modern-form-label">
                                                    <i class="fa fa-clock me-2"></i>Lama Penelitian
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="lama_penelitian" id="lama_penelitian" class="modern-form-input" placeholder="Contoh: 12 bulan" required>
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
                                                <textarea name="ringkasan_proposal" id="ringkasan_proposal" class="modern-form-textarea" placeholder="Tuliskan ringkasan proposal penelitian..." required></textarea>
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
                                                    <option value="" disabled selected>Pilih skema penelitian...</option>
                                                    @foreach($skemaPenelitian as $skema)
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
                                                    @foreach($luaranWajibPenelitian as $luaran)
                                                        <option value="{{ $luaran->nama }}">{{ $luaran->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="modern-form-group" id="sintaOptions" style="display: none;">
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
                                                <label for="luaran_tambahan" class="modern-form-label"><i class="fa fa-plus-circle me-2"></i>Luaran Tambahan</label>
                                                <select name="luaran_tambahan" id="luaran_tambahan" class="modern-form-select">
                                                    <option value="" disabled selected>Pilih luaran tambahan (opsional)...</option>
                                                    @foreach($luaranTambahanPenelitian as $luaran)
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
                                    </div>
                                </div>
                            </fieldset>

                            <div class="modern-card-footer d-flex flex-wrap gap-2">
                                <a href="{{ route('penelitian-dos.index') }}" class="modern-btn modern-btn-secondary">
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
            if (!form) {
                return;
            }

            const hasMember = anggotaTableBody.children.length > 0;
            const formValid = form.checkValidity() && hasMember;
            submitButton.disabled = !formValid || submitButton.hasAttribute('disabled');
        }

        ringkasanInput.addEventListener('input', updateWordCount);
        biayaInput.addEventListener('input', restrictNumberInput);
        document.getElementById('luaran_wajib').addEventListener('change', toggleSintaOptions);
        document.getElementById('addAnggota').addEventListener('click', addAnggotaRow);
        form.addEventListener('input', validateForm);

        window.addEventListener('load', function () {
            addAnggotaRow();
            updateWordCount();
            validateForm();
        });
    </script>
</x-dosen-layout>

