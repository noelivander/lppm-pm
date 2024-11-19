<x-dosen-layout>
    <x-slot name="header">
        {{ __('Penelitian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h3>Proposal Penelitian</h3>
                        @if ($penelitian->isEmpty())
                            <p>Belum ada proposal penelitian.</p>
                        @else
                        <table class="table table-hover table-responsive mb-4">
                            <style>
                                .table {
                                    width: 100%; /* Gunakan lebar penuh */
                                    table-layout: fixed; /* Tabel fleksibel, bukan tetap */
                                }
                                .table th.judul, .table td.judul {
                                    width: 30%;
                                    text-align: left;
                                }
                                .table colgroup col.judul {
                                    width: 35%;
                                }
                            </style>
                            
                            <colgroup>
                                <col class="judul"> 
                            </colgroup>
                            
                            <thead class="thead-light bg-primary text-white">
                                <tr>
                                    <th>Judul</th>
                                    <th>Skema</th>
                                    <th>Tahun</th>
                                    <th>Status</th>
                                    <th>Dokumen Proposal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penelitian as $item)
                                    <tr>
                                        <td class="judul">{{ $item->judul }}</td>
                                        <td class="skema">{{ $item->skema }}</td>
                                        <td>{{ $item->created_at->year }}</td>
                                        <td>
                                            <span class="badge 
                                                @if ($item->status === 'Diterima') bg-success
                                                @elseif ($item->status === 'Ditolak') bg-danger
                                                @else bg-warning @endif">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($item->dokumen_proposal)
                                                <a href="{{ Storage::url($item->dokumen_proposal) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                                    <i class="fas fa-file-download"></i> Download PDF
                                                </a>
                                            @else
                                                <span class="text-muted">Tidak ada file</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @endif

                        <button class="btn btn-primary mt-3" id="addNewProposal">+ Tambah Usulan Baru</button>

                        <form id="proposalForm" method="POST" action="{{ route('penelitian-dos.store') }}" enctype="multipart/form-data" style="display: none;">
                            @csrf
                            <br><br><h3>Form Usulan Penelitian</h3>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="judul">Judul</label>
                                        <input type="text" name="judul" id="judul" class="form-control" required>
                                    </div>
                                    
                                    <div class="form-group mt-3">
                                        <label for="lama_penelitian">Lama Penelitian</label>
                                        <input type="text" name="lama_penelitian" id="lama_penelitian" class="form-control" required>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="biaya_diusulkan">Biaya yang Diusulkan (Rp.)</label>
                                        <div class="input-group">
                                            <input type="text" name="biaya_diusulkan" id="biaya_diusulkan" class="form-control" inputmode="numeric" pattern="[0-9]*" required>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById('biaya_diusulkan').addEventListener('input', function (e) {
                                            this.value = this.value.replace(/[^0-9]/g, '');
                                            });
                                    </script>
                                    <div class="form-group mt-3">
                                        <label for="ringkasan_proposal">Ringkasan Proposal</label>
                                        <textarea name="ringkasan_proposal" id="ringkasan_proposal" class="form-control" required></textarea>
                                        <div id="wordCount" class="text-muted small">0/500 words</div> <!-- Elemen ini akan diisi otomatis -->
                                    </div>                            
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <label for="skema">Skema</label>
                                        <div class="dropdown-wrapper">
                                            <select name="skema" id="skema" class="form-control" required>
                                                <option value="" disabled selected>...</option>
                                                <option value="penelitian dasar">Penelitian Dasar</option>
                                                <option value="penelitian lanjutan">Penelitian Lanjutan</option>
                                            </select>
                                            <i class="fas fa-caret-down dropdown-icon"></i>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3 position-relative">
                                        <label for="luaran_wajib">Luaran Wajib</label>
                                        <div class="dropdown-wrapper">
                                            <select name="luaran_wajib" id="luaran_wajib" class="form-control" required>
                                                <option value="" disabled selected>...</option>
                                                <option value="jurnal nasional terindeks sinta">Jurnal Nasional Terindeks Sinta</option>
                                                <option value="jurnal internasional terindeks">Jurnal Internasional Terindeks</option>
                                                <option value="jurnal internasional">Jurnal Internasional</option>
                                                <option value="prosiding konferensi nasional">Prosiding Konferensi Nasional</option>
                                                <option value="produk model prototype">Produk/Model/Prototype</option>
                                            </select>
                                            <i class="fas fa-caret-down dropdown-icon"></i>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3 position-relative">
                                        <label for="luaran_tambahan">Luaran Tambahan</label>
                                        <div class="dropdown-wrapper">
                                            <select name="luaran_tambahan" id="luaran_tambahan" class="form-control">
                                                <option value="" disabled selected>...</option>
                                                <option value="bahan ajar">Bahan Ajar</option>
                                                <option value="buku monografi">Buku Monografi</option>
                                                <option value="haki">HAKI</option>
                                                <option value="teknologi tepat guna">Teknologi Tepat Guna</option>
                                            </select>
                                            <i class="fas fa-caret-down dropdown-icon"></i>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="dokumen_proposal">Dokumen Proposal (PDF)</label>
                                        <div class="custom-file">
                                            <input type="file" name="dokumen_proposal" id="dokumen_proposal" class="custom-file-input" accept="application/pdf" required>
                                        </div>
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
                                <div class="position-relative">
                                <h4 class="mt-4">Tim Peneliti</h4>
                                <button type="button" class="btn mt-3" id="addAnggota">+ Tambah Anggota</button>
                                <table class="table table-responsive table-borderless mb-4" id="anggotaTable">
                                    <thead class="thead-light bg-primary text-white">
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
                            <br><button type="submit" class="btn btn-success mt-3" id="submitProposal">Submit Proposal</button>
                        </form>
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
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            const fileName = e.target.files[0].name;
            const nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    
        // Function to add a new member row
        function addAnggotaRow() {
            const table = document.getElementById('anggotaTable').getElementsByTagName('tbody')[0];
            const row = table.insertRow();
            row.innerHTML = `
                <td><input type="text" name="anggota_nama[]" class="form-control" required></td>
                <td>
                    <select name="anggota_peran[]" class="form-control" required>
                        <option value="" disabled selected>...</option>
                        <option value="Ketua">Ketua</option>
                        <option value="Anggota">Anggota</option>
                    </select>
                </td>
                <td>
                    <select name="anggota_jabatan[]" class="form-control" required>
                        <option value="" disabled selected>...</option>
                        <option value="Dosen">Dosen</option>
                        <option value="Mahasiswa">Mahasiswa</option>
                    </select>
                </td>
                <td><input type="text" name="anggota_nidn[]" class="form-control" required></td>
                <td><input type="email" name="anggota_email[]" class="form-control" required></td>
                <td>
                    <input 
                        type="text" 
                        name="anggota_telepon[]" 
                        class="form-control" 
                        inputmode="numeric" 
                        pattern="[0-9]*" 
                        oninput="this.value = this.value.replace(/[^0-9]/g, '');" 
                        required>
                </td>

                <td><button type="button" class="btn btn-danger mt-3 removeAnggota">Hapus</button></td>`;
    
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
    </script>
    
</x-dosen-layout>
