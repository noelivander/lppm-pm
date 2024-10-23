<x-dosen-layout>
    <x-slot name="header">
        {{ __('Pengabdian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-12">
                <h3>Pengabdian</h3>
                @if ($pengabdian->isEmpty())
                    <p>Belum ada proposal pengabdian.</p>
                @else
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Judul</th>
                                <th>Skema</th>
                                <th>Tahun</th>
                                <th>Status</th>
                                <th>Dokumen Proposal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengabdian as $item)
                                <tr>
                                    <td>{{ $item->judul }}</td>
                                    <td>{{ $item->skema }}</td>
                                    <td>{{ $item->created_at->year }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>
                                        @if ($item->dokumen_proposal)
                                            <a href="{{ Storage::url($item->dokumen_proposal) }}" target="_blank">Download PDF</a>
                                        @else
                                            Tidak ada file
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif      

                <button class="btn btn-primary mt-3" id="addNewProposal">+ Tambah Usulan Baru</button>

                <form id="proposalForm" method="POST" action="{{ route('pengabdian-dos.store') }}" enctype="multipart/form-data" style="display: none;">
                    @csrf
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
                                        <option value="" disabled selected>Pilih Skema</option>
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
                                        <option value="" disabled selected>Pilih Luaran Wajib</option>
                                        <option value="jurnal nasional terindeks sinta">Jurnal Nasional Terindeks Sinta</option>
                                        <option value="jurnal internasional">Jurnal Internasional</option>
                                        <option value="jurnal internasional terindeks">Jurnal Internasional Terindeks</option>
                                    </select>
                                    <i class="fas fa-caret-down dropdown-icon"></i>
                                </div>
                            </div>
                            <div class="form-group mt-3 position-relative">
                                <label for="luaran_tambahan">Luaran Tambahan</label>
                                <div class="dropdown-wrapper">
                                    <select name="luaran_tambahan" id="luaran_tambahan" class="form-control">
                                        <option value="" disabled selected>Pilih Luaran Tambahan</option>
                                        <option value="bahan ajar">Bahan Ajar</option>
                                        <option value="buku monografi">Buku Monografi</option>
                                        <option value="haki">HAKI</option>
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
                        <h4 class="mt-4">Anggota (Dosen/Mahasiswa)</h4>
                        <table class="table table-bordered" id="anggotaTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>Peran</th>
                                    <th>Email</th>
                                    <th>Telepon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Rows for members will be dynamically added here -->
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary mt-3" id="addAnggota">+ Tambah Anggota</button>
                    </div>
                        
                    </div>
                    <br><button type="submit" class="btn btn-success mt-3" id="submitProposal">Submit Proposal</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('addNewProposal').addEventListener('click', function() {
            document.getElementById('proposalForm').style.display = 'block';
        });
    
        // Validasi untuk form
        function validateForm() {
            let isValid = document.getElementById('proposalForm').checkValidity();
    
            // Periksa apakah ada minimal satu anggota yang diinput
            const anggotaRows = document.querySelectorAll('#anggotaTable tbody tr');
            if (anggotaRows.length === 0) {
                isValid = false; // Invalid jika tidak ada anggota
            }
    
            // Periksa input di tabel anggota
            const anggotaInputs = document.querySelectorAll('#anggotaTable input, #anggotaTable select');
            anggotaInputs.forEach(function(input) {
                if (!input.checkValidity()) {
                    isValid = false;
                }
            });
    
            // Update status tombol submit
            document.getElementById('submitProposal').disabled = !isValid;
        }
    
        document.getElementById('proposalForm').addEventListener('input', function() {
            validateForm();
        });
    
        // Update file input label ketika file dipilih
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = document.getElementById("dokumen_proposal").files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    
        // Fungsi untuk menambahkan baris anggota baru
        document.getElementById('addAnggota').addEventListener('click', function() {
            const table = document.getElementById('anggotaTable').getElementsByTagName('tbody')[0];
            const row = table.insertRow();
            row.innerHTML = `
                <td><input type="text" name="anggota_nama[]" class="form-control" required></td>
                <td>
                    <select name="anggota_peran[]" class="form-control" required>
                        <option value="Dosen">Dosen</option>
                        <option value="Mahasiswa">Mahasiswa</option>
                    </select>
                </td>
                <td><input type="email" name="anggota_email[]" class="form-control" required></td>
                <td><input type="text" name="anggota_telepon[]" class="form-control" required></td>
                <td><button type="button" class="btn btn-danger removeAnggota">Hapus</button></td>
            `;
    
            // Validasi ulang ketika input di tabel anggota berubah
            const anggotaInputs = row.querySelectorAll('input, select');
            anggotaInputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    validateForm();
                });
            });
    
            // Fungsi untuk menghapus baris anggota
            row.querySelector('.removeAnggota').addEventListener('click', function() {
                row.remove();
                validateForm(); // Validasi ulang setelah baris dihapus
            });
    
            validateForm(); // Validasi form setelah baris anggota ditambahkan
        });
    
        // Pastikan form divalidasi pertama kali saat halaman dimuat
        window.onload = function() {
            validateForm();
        };
    </script>
    
</x-dosen-layout>