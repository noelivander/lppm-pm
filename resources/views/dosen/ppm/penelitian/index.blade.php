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
                                    <th>Dokumen Review</th>
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
                                                @if ($item->status === 'Pending') bg-warning
                                                @elseif ($item->status === 'Diproses') bg-info
                                                @elseif ($item->status === 'Selesai') bg-success
                                                @endif">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        
                                        <td>
                                            @if ($item->dokumen_proposal)
                                                <a href="{{ route('penelitian.downloadProposal', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-file-download"></i> Download PDF
                                                </a>
                                            @else
                                                <span class="text-muted">Tidak ada file</span>
                                            @endif
                                        </td>
                                        
                                        <td>
                                            <a class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $item->id }}">
                                                <i class="fas fa-search"></i> Hasil Review
                                            </a>
                                        </td>

                                        <div class="modal fade" id="reviewModal{{ $item->id }}" tabindex="-1" aria-labelledby="reviewModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="reviewModalLabel{{ $item->id }}">Pilih Review</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @php
                                                            $reviews = \App\Models\Review::where('penelitian_id', $item->id)->get();
                                                        @endphp

                                                        @if ($reviews->count() > 0)
                                                            @foreach ($reviews as $index => $review)
                                                                <a href="{{ route('penelitian-dos.view-reviews', ['penelitian_id' => $item->id, 'review_number' => $index + 1]) }}" class="btn btn-link">
                                                                    Lihat Review {{ $index + 1 }}
                                                                </a><br>
                                                            @endforeach
                                                        @else
                                                            <p>Review belum tersedia.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
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
                                    <div class="form-group mt-3 d-flex align-items-start gap-3">
                                        <!-- Dropdown Luaran Wajib -->
                                        <div style="flex: 1;" class="dropdown-wrapper">
                                            <label for="luaran_wajib">Luaran Wajib</label>
                                            <div class="dropdown-container">
                                                <select name="luaran_wajib" id="luaran_wajib" class="form-control custom-dropdown" required>
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
                                    
                                        <!-- Dropdown Sinta Level -->
                                        <div id="sintaOptions" style="flex: 1; display: none;" class="dropdown-wrapper">
                                            <label for="sinta_index">Sinta Level</label>
                                            <div class="dropdown-container">
                                                <select name="sinta_index" id="sinta_index" class="form-control custom-dropdown">
                                                    <option value="" disabled selected>...</option>
                                                    <option value="Sinta 1">Sinta 1</option>
                                                    <option value="Sinta 2">Sinta 2</option>
                                                    <option value="Sinta 3">Sinta 3</option>
                                                    <option value="Sinta 4">Sinta 4</option>
                                                    <option value="Sinta 5">Sinta 5</option>
                                                    <option value="Sinta 6">Sinta 6</option>
                                                </select>
                                                <i class="fas fa-caret-down dropdown-icon"></i>
                                            </div>
                                        </div>
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
