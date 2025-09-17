<x-dosen-layout>
    <x-slot name="header">
        {{ __('Penelitian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3 fade-in-up">
                    <h3 class="mb-3">
                        <i class="fa fa-flask me-2"></i>Proposal Penelitian
                    </h3>
                        @if (!$timeline)
                            <div class="modern-alert modern-alert-danger"><i class="fa fa-exclamation-circle me-2"></i>No upload schedule available. You cannot upload a proposal.</div>
                        @else
                            @if ($currentDate < $timeline->upload_start_date)
                                <div class="modern-alert modern-alert-warning"><i class="fa fa-clock me-2"></i>Upload period will start in <span id="countdown"></span>.</div>
                                <script>
                                    var countdownDate = new Date("{{ $timeline->upload_start_date }}").getTime();
                                </script>
                            @elseif ($currentDate >= $timeline->upload_start_date && $currentDate <= $timeline->upload_end_date)
                                <div class="modern-alert modern-alert-info"><i class="fa fa-info-circle me-2"></i>Upload period is open. It will close in <span id="countdown"></span>.</div>
                                <script>
                                    var countdownDate = new Date("{{ $timeline->upload_end_date }}").getTime();
                                </script>
                            @else
                                <div class="modern-alert modern-alert-danger"><i class="fa fa-times-circle me-2"></i>The upload period has ended.</div>
                            @endif
                        @endif
                        @if ($penelitian->isEmpty())
                            <div class="modern-alert modern-alert-info">
                                <i class="fa fa-info-circle me-2"></i>Belum ada proposal penelitian.
                            </div>
                        @else
                        <div class="modern-table-container mb-3">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Skema</th>
                                        <th>Tahun</th>
                                        <th>Status</th>
                                        <th>Dokumen Proposal</th>
                                        <th>Dokumen Review</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penelitian as $item)
                                        <tr>
                                            <td>
                                                <div class="fw-bold">{{ $item->judul }}</div>
                                            </td>
                                            <td>{{ $item->skema }}</td>
                                            <td>{{ $item->created_at->year }}</td>
                                            <td>
                                                <span class="status-badge
                                                    @if ($item->status === 'Pending') pending
                                                    @elseif ($item->status === 'Diproses') diproses
                                                    @elseif ($item->status === 'Selesai') selesai
                                                    @endif">
                                                    {{ $item->status }}
                                                </span>
                                            </td>
                                            
                                            <td>
                                                @if ($item->dokumen_proposal)
                                                    <a href="{{ route('penelitian.downloadProposal', $item->id) }}" class="modern-btn modern-btn-primary modern-btn-sm">
                                                        <i class="fas fa-file-download me-1"></i> Download PDF
                                                    </a>
                                                @else
                                                    <span class="text-muted">Tidak ada file</span>
                                                @endif
                                            </td>
                                            
                                            <td>
                                                <a class="modern-btn modern-btn-secondary modern-btn-sm" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $item->id }}">
                                                    <i class="fas fa-search me-1"></i> Hasil Review
                                                </a>
                                            </td>

                                        <div class="modal fade modern-modal" id="reviewModal{{ $item->id }}" tabindex="-1" aria-labelledby="reviewModalLabel{{ $item->id }}" aria-hidden="true" data-bs-backdrop="false" data-bs-keyboard="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="reviewModalLabel{{ $item->id }}">
                                                            <i class="fa fa-search me-2"></i>Pilih Review
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @php
                                                            $reviews = \App\Models\Review::where('penelitian_id', $item->id)->get();
                                                        @endphp

                                                        @if ($reviews->count() > 0)
                                                            <div class="d-grid gap-2">
                                                                @foreach ($reviews as $index => $review)
                                                                    <a href="{{ route('penelitian-dos.view-reviews', ['penelitian_id' => $item->id, 'review_number' => $index + 1]) }}" 
                                                                       class="modern-btn modern-btn-primary">
                                                                        <i class="fa fa-file-alt me-2"></i>Lihat Review {{ $index + 1 }}
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <div class="modern-alert modern-alert-info">
                                                                <i class="fa fa-info-circle me-2"></i>Review belum tersedia.
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @endif

                        <button class="modern-btn modern-btn-primary mt-2" id="addNewProposal" 
                            @if (!$timeline || $currentDate < $timeline->upload_start_date || $currentDate > $timeline->upload_end_date) 
                                disabled 
                            @endif>
                            <i class="fa fa-plus me-2"></i> Tambah Usulan Baru
                        </button>


                        <div id="proposalForm" style="display: none;" class="fade-in-up">
                            <div class="modern-card mt-4">
                                <div class="modern-card-header">
                                    <h4 class="mb-0">
                                        <i class="fa fa-file-alt me-2"></i>
                                        Form Usulan Penelitian
                                    </h4>
                                </div>
                                <form method="POST" action="{{ route('penelitian-dos.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modern-card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="modern-form-group">
                                                    <label for="judul" class="modern-form-label">
                                                        <i class="fa fa-heading me-2"></i>Judul Penelitian
                                                    </label>
                                                    <input type="text" name="judul" id="judul" class="modern-form-input" placeholder="Masukkan judul penelitian..." required>
                                                </div>
                                                
                                                <div class="modern-form-group">
                                                    <label for="lama_penelitian" class="modern-form-label">
                                                        <i class="fa fa-clock me-2"></i>Lama Penelitian
                                                    </label>
                                                    <input type="text" name="lama_penelitian" id="lama_penelitian" class="modern-form-input" placeholder="Contoh: 12 bulan" required>
                                                </div>
                                                
                                                <div class="modern-form-group">
                                                    <label for="biaya_diusulkan" class="modern-form-label">
                                                        <i class="fa fa-money-bill me-2"></i>Biaya yang Diusulkan (Rp.)
                                                    </label>
                                                    <input type="text" name="biaya_diusulkan" id="biaya_diusulkan" class="modern-form-input" inputmode="numeric" pattern="[0-9]*" placeholder="Masukkan jumlah biaya..." required>
                                                </div>
                                                
                                                <div class="modern-form-group">
                                                    <label for="ringkasan_proposal" class="modern-form-label">
                                                        <i class="fa fa-file-text me-2"></i>Ringkasan Proposal
                                                    </label>
                                                    <textarea name="ringkasan_proposal" id="ringkasan_proposal" class="modern-form-textarea" placeholder="Tuliskan ringkasan proposal penelitian..." required></textarea>
                                                    <div id="wordCount" class="text-muted small mt-1">0/500 words</div>
                                                </div>                            
                                            </div>
                                            <div class="col-md-6">
                                                <div class="modern-form-group">
                                                    <label for="skema" class="modern-form-label">
                                                        <i class="fa fa-list me-2"></i>Skema Penelitian
                                                    </label>
                                                    <select name="skema" id="skema" class="modern-form-select" required>
                                                        <option value="" disabled selected>Pilih skema penelitian...</option>
                                                        <option value="penelitian dasar">Penelitian Dasar</option>
                                                        <option value="penelitian lanjutan">Penelitian Lanjutan</option>
                                                    </select>
                                                </div>
                                                <div class="modern-form-group">
                                                    <label for="luaran_wajib" class="modern-form-label">
                                                        <i class="fa fa-trophy me-2"></i>Luaran Wajib
                                                    </label>
                                                    <select name="luaran_wajib" id="luaran_wajib" class="modern-form-select" required>
                                                        <option value="" disabled selected>Pilih luaran wajib...</option>
                                                        <option value="jurnal nasional terindeks sinta">Jurnal Nasional Terindeks Sinta</option>
                                                        <option value="jurnal internasional terindeks">Jurnal Internasional Terindeks</option>
                                                        <option value="jurnal internasional">Jurnal Internasional</option>
                                                        <option value="prosiding konferensi nasional">Prosiding Konferensi Nasional</option>
                                                        <option value="produk model prototype">Produk/Model/Prototype</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="modern-form-group" id="sintaOptions" style="display: none;">
                                                    <label for="sinta_index" class="modern-form-label">
                                                        <i class="fa fa-star me-2"></i>Sinta Level
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
                                    
                                    <style>
                                        .dropdown-wrapper {
                                            position: relative;
                                        }
                                    
                                        .dropdown-container {
                                            position: relative;
                                        }
                                    
                                        .custom-dropdown {
                                            appearance: none;
                                            -webkit-appearance: none; /* Untuk Safari */
                                            padding-right: 2.5rem; /* Beri ruang untuk ikon */
                                        }
                                    
                                        .custom-dropdown + .dropdown-icon {
                                            position: absolute;
                                            top: 50%;
                                            right: 1rem; /* Jarak dari kanan */
                                            transform: translateY(-50%);
                                            pointer-events: none; /* Ikon tidak mengganggu interaksi */
                                            font-size: 1rem;
                                            color: #6c757d; /* Warna ikon */
                                        }
                                    </style>
                                    
                                                
                                                <div class="modern-form-group">
                                                    <label for="luaran_tambahan" class="modern-form-label">
                                                        <i class="fa fa-plus-circle me-2"></i>Luaran Tambahan
                                                    </label>
                                                    <select name="luaran_tambahan" id="luaran_tambahan" class="modern-form-select">
                                                        <option value="" disabled selected>Pilih luaran tambahan (opsional)...</option>
                                                        <option value="bahan ajar">Bahan Ajar</option>
                                                        <option value="buku monografi">Buku Monografi</option>
                                                        <option value="haki">HAKI</option>
                                                        <option value="teknologi tepat guna">Teknologi Tepat Guna</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="modern-form-group">
                                                    <label for="dokumen_proposal" class="modern-form-label">
                                                        <i class="fa fa-file-pdf me-2"></i>Dokumen Proposal (PDF)
                                                    </label>
                                                    <input type="file" name="dokumen_proposal" id="dokumen_proposal" class="modern-form-input" accept="application/pdf" required>
                                                </div>

                                    <script>
                                        document.getElementById('ringkasan_proposal').addEventListener('input', function() {
                                            let text = this.value.trim(); // Ambil teks input
                                            let words = text.split(/\s+/).filter(function(word) { return word.length > 0; }); // Pisahkan kata
                                            let wordCount = words.length; // Hitung jumlah kata
                                    
                                            // Perbarui tampilan jumlah kata
                                            document.getElementById('wordCount').textContent = wordCount + "/500 words";
                                    
                                            // Cegah input lebih dari 500 kata
                                            if (wordCount > 500) {
                                                // Jika lebih dari 500 kata, potong teks menjadi 500 kata
                                                this.value = words.slice(0, 500).join(" ");
                                                document.getElementById('wordCount').textContent = "500/500 words";
                                            }
                                        });
                                    </script>                 
                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-2 mb-4 px-4">
                                            <h4 class="mb-3">
                                                <i class="fa fa-users me-2"></i>Tim Peneliti
                                            </h4>
                                            <button type="button" class="modern-btn modern-btn-primary mb-3" id="addAnggota">
                                                <i class="fa fa-plus me-2"></i>Tambah Anggota
                                            </button>
                                            
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
                                                        <!-- Rows for members will be dynamically added here -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                        <div class="modern-card-footer">
                                            <div class="d-flex gap-2">
                                                <button type="button" class="modern-btn modern-btn-secondary" onclick="document.getElementById('proposalForm').style.display='none'">
                                                    <i class="fa fa-times me-1"></i> Batal
                                                </button>
                                                <button type="submit" class="modern-btn modern-btn-success" id="submitProposal">
                                                    <i class="fa fa-paper-plane me-1"></i> Submit Proposal
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show the proposal form and add a default row for team members
        document.getElementById('addNewProposal').addEventListener('click', function() {
            const proposalForm = document.getElementById('proposalForm');

            // Toggle visibility of the proposal form
            if (proposalForm.style.display === 'none' || proposalForm.style.display === '') {
                proposalForm.style.display = 'block';
                
                // Check if there are no rows in the anggota table, and add a default row if necessary
                const table = document.getElementById('anggotaTable').getElementsByTagName('tbody')[0];
                if (table.rows.length === 0) {
                    addAnggotaRow();
                }
            } else {
                proposalForm.style.display = 'none';
            }
        });

        document.getElementById('luaran_wajib').addEventListener('change', function () {
            const sintaOptions = document.getElementById('sintaOptions');
            const sintaSelect = document.getElementById('sinta_index'); // Ambil elemen select untuk level Sinta

            if (this.value === 'jurnal nasional terindeks sinta') {
                sintaOptions.style.display = 'block'; // Tampilkan opsi tambahan
                sintaSelect.setAttribute('required', 'true');  // Menambahkan atribut required
            } else {
                sintaOptions.style.display = 'none'; // Sembunyikan opsi tambahan
                sintaSelect.removeAttribute('required'); // Hapus atribut required
                sintaSelect.value = ''; // Reset pilihan Sinta jika disembunyikan
            }

            validateForm();
        });
            
    
        // Validate the entire form
        function validateForm() {
            let isValid = document.getElementById('proposalForm').checkValidity();
            const anggotaRows = document.querySelectorAll('#anggotaTable tbody tr');
    
            // Ensure at least one member is present
            if (anggotaRows.length === 0) {
                isValid = false;
            }
    
            // Validate each input in the anggota table
            const anggotaInputs = document.querySelectorAll('#anggotaTable input, #anggotaTable select');
            anggotaInputs.forEach(function(input) {
                if (!input.checkValidity()) {
                    isValid = false;
                }
            });
    
            // Update the submit button status
            document.getElementById('submitProposal').disabled = !isValid;
        }
    
        // Validate the form on input
        document.getElementById('proposalForm').addEventListener('input', function() {
            validateForm();
        });
    
        // Update the file input label when a file is selected
        document.getElementById('dokumen_proposal').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'Pilih file PDF...';
            // You can add visual feedback here if needed
        });
    
        // Function to add a new member row
        function addAnggotaRow() {
            const table = document.getElementById('anggotaTable').getElementsByTagName('tbody')[0];
            const row = table.insertRow();
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
                    <input 
                        type="text" 
                        name="anggota_telepon[]" 
                        class="modern-form-input" 
                        placeholder="No. Telepon"
                        inputmode="numeric" 
                        pattern="[0-9]*" 
                        oninput="this.value = this.value.replace(/[^0-9]/g, '');" 
                        required>
                </td>
                <td><button type="button" class="modern-btn modern-btn-danger modern-btn-sm removeAnggota">
                    <i class="fa fa-trash me-1"></i> Hapus
                </button></td>`;
    
            // Attach input event listeners for validation
            const anggotaInputs = row.querySelectorAll('input, select');
            anggotaInputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    validateForm();
                });
            });
    
            // Attach click event listener to the remove button
            row.querySelector('.removeAnggota').addEventListener('click', function() {
                row.remove();
                validateForm(); // Validate form after row is removed
            });
    
            validateForm(); // Validate form after row is added
        }
    
        // Add event listener for adding new member
        document.getElementById('addAnggota').addEventListener('click', addAnggotaRow);
    
        // Initial validation when the page loads
        window.onload = function() {
            validateForm();
        };
        // Countdown Timer for Upload Period
        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countdownDate - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("countdown").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown").innerHTML = "EXPIRED";
            }
        }, 1000);
    </script>
    
</x-dosen-layout>
