<x-admin-layout>
    <x-slot name="header">
        {{ __('Tambah User') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-10 col-lg-8">
                <div class="modern-card fade-in-up">
                    <div class="modern-card-header d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="fa fa-user-plus me-2"></i>Tambah User</h4>
                        <a href="{{ route('users.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fa fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <div class="modern-card-body">
                            <div class="modern-form-group">
                                <label class="modern-form-label" for="name"><i class="fa fa-id-badge me-2"></i>Nama</label>
                                <input type="text" name="name" id="name" class="modern-form-input" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="modern-form-group">
                                <label class="modern-form-label" for="email"><i class="fa fa-envelope me-2"></i>Email</label>
                                <input type="email" name="email" id="email" class="modern-form-input" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="modern-form-group">
                                <label class="modern-form-label" for="nip"><i class="fa fa-id-card me-2"></i>NIP</label>
                                <input type="text" name="nip" id="nip" class="modern-form-input" value="{{ old('nip') }}" placeholder="Misal: 1987654321" required>
                                @error('nip')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="modern-form-group">
                                <label class="modern-form-label" for="role"><i class="fa fa-user-shield me-2"></i>Role</label>
                                <select name="role" id="role" class="modern-form-select" required>
                                    <option value="" disabled selected>Pilih role...</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}" @if(old('role')===$role) selected @endif>{{ ucfirst($role) }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="password"><i class="fa fa-lock me-2"></i>Password</label>
                                        <input type="password" name="password" id="password" class="modern-form-input" required>
                                        @error('password')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label" for="password_confirmation"><i class="fa fa-lock me-2"></i>Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="modern-form-input" required>
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
</x-admin-layout>


