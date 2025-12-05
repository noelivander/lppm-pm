<x-admin-layout>
    <x-slot name="header">
        {{ __('Edit User') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-10 col-lg-8">
                <div class="modern-card fade-in-up">
                    <div class="modern-card-header d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="fa fa-user-edit me-2"></i>Edit User</h4>
                        <a href="{{ route('users.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fa fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                    <form method="POST" action="{{ route('users.update', $user) }}">
                        @csrf
                        @method('PUT')
                        <div class="modern-card-body">
                            <div class="modern-form-group">
                                <label class="modern-form-label" for="name"><i class="fa fa-id-badge me-2"></i>Nama</label>
                                <input type="text" name="name" id="name" class="modern-form-input" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="modern-form-group">
                                <label class="modern-form-label" for="email"><i class="fa fa-envelope me-2"></i>Email</label>
                                <input type="email" name="email" id="email" class="modern-form-input" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="modern-form-group">
                                <label class="modern-form-label" for="nip"><i class="fa fa-id-card me-2"></i>NIP</label>
                                <input type="text" name="nip" id="nip" class="modern-form-input" value="{{ old('nip', $user->nip) }}" placeholder="Misal: 1987654321" required>
                                @error('nip')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="modern-form-group">
                                <label class="modern-form-label" for="role"><i class="fa fa-user-shield me-2"></i>Role</label>
                                <select name="role" id="role" class="modern-form-select" required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}" @if(old('role', $user->role)===$role) selected @endif>{{ ucfirst($role) }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jurusan and Program Studi fields (only for dosen) -->
                            <div id="dosenFields" style="display: none;">
                                <div class="modern-form-group">
                                    <label class="modern-form-label" for="jurusan_id"><i class="fa fa-building me-2"></i>Jurusan</label>
                                    <select name="jurusan_id" id="jurusan_id" class="modern-form-select">
                                        <option value="">Pilih jurusan...</option>
                                        @foreach ($jurusans as $jurusan)
                                            <option value="{{ $jurusan->id }}" @if(old('jurusan_id', $user->jurusan_id)==$jurusan->id) selected @endif>{{ $jurusan->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('jurusan_id')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="modern-form-group">
                                    <label class="modern-form-label" for="program_studi_id"><i class="fa fa-graduation-cap me-2"></i>Program Studi</label>
                                    <select name="program_studi_id" id="program_studi_id" class="modern-form-select">
                                        <option value="">Pilih program studi...</option>
                                        @foreach ($programStudis as $prodi)
                                            <option value="{{ $prodi->id }}" data-jurusan="{{ $prodi->jurusan_id }}" @if(old('program_studi_id', $user->program_studi_id)==$prodi->id) selected @endif>{{ $prodi->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('program_studi_id')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="password"><i class="fa fa-lock me-2"></i>Password (opsional)</label>
                                        <input type="password" name="password" id="password" class="modern-form-input" placeholder="Kosongkan jika tidak diubah">
                                        @error('password')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="password_confirmation"><i class="fa fa-lock me-2"></i>Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="modern-form-input" placeholder="Ulangi password baru">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modern-card-footer d-flex gap-2">
                            <button type="submit" class="modern-btn modern-btn-success"><i class="fa fa-save me-1"></i>Simpan</button>
                            <a href="{{ route('users.index') }}" class="modern-btn modern-btn-secondary"><i class="fa fa-times me-1"></i>Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const roleSelect = document.getElementById('role');
                const dosenFields = document.getElementById('dosenFields');
                const jurusanSelect = document.getElementById('jurusan_id');
                const prodiSelect = document.getElementById('program_studi_id');
                
                // Store all prodi options
                const allProdiOptions = Array.from(prodiSelect.options);
                
                // Toggle dosen fields based on role
                function toggleDosenFields() {
                    if (roleSelect.value === 'dosen') {
                        dosenFields.style.display = 'block';
                    } else {
                        dosenFields.style.display = 'none';
                        jurusanSelect.value = '';
                        prodiSelect.value = '';
                    }
                }
                
                // Filter program studi based on selected jurusan
                function filterProgramStudi() {
                    const selectedJurusanId = jurusanSelect.value;
                    const currentProdiId = prodiSelect.value;
                    
                    // Clear current options
                    prodiSelect.innerHTML = '<option value="">Pilih program studi...</option>';
                    
                    // Add filtered options
                    allProdiOptions.forEach(option => {
                        if (option.value === '') return; // Skip empty option
                        
                        if (!selectedJurusanId || option.dataset.jurusan === selectedJurusanId) {
                            const newOption = option.cloneNode(true);
                            if (option.value === currentProdiId) {
                                newOption.selected = true;
                            }
                            prodiSelect.appendChild(newOption);
                        }
                    });
                }
                
                // Event listeners
                roleSelect.addEventListener('change', toggleDosenFields);
                jurusanSelect.addEventListener('change', filterProgramStudi);
                
                // Initialize on page load
                toggleDosenFields();
                if (roleSelect.value === 'dosen') {
                    filterProgramStudi();
                }
            });
        </script>
    </x-slot>
</x-admin-layout>


