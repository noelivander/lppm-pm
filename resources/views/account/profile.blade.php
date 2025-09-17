<x-role-layout :hideFooter="true">

    <x-admin.heading name="Profil Saya">
        @php($role = Auth::user()->role)
        @if($role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="modern-btn modern-btn-primary">Kembali ke Dashboard</a>
        @elseif($role === 'dosen')
            <a href="{{ route('dosen.dashboard') }}" class="modern-btn modern-btn-primary">Kembali ke Dashboard</a>
        @elseif($role === 'reviewer')
            <a href="{{ route('reviewer.dashboard') }}" class="modern-btn modern-btn-primary">Kembali ke Dashboard</a>
        @elseif($role === 'auditor')
            <a href="{{ route('auditor.dashboard') }}" class="modern-btn modern-btn-primary">Kembali ke Dashboard</a>
        @elseif($role === 'kaprodi')
            <a href="{{ route('kaprodi.dashboard') }}" class="modern-btn modern-btn-primary">Kembali ke Dashboard</a>
        @else
            <a href="{{ route('home') }}" class="modern-btn modern-btn-primary">Kembali ke Dashboard</a>
        @endif
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-6">
            <div class="modern-card mb-4 fade-in-up">
                <div class="modern-card-body">
                    @if (session('profile_status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('profile_status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('account.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modern-form-group">
                            <label class="modern-form-label d-block"><i class="fa fa-image me-2"></i>Avatar</label>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ Auth::user()->avatar_path ? Storage::url(Auth::user()->avatar_path) : url('img/undraw_profile.svg') }}" class="rounded-circle" style="width:64px;height:64px;object-fit:cover;">
                                <input type="file" name="avatar" accept="image/*" class="modern-form-input">
                            </div>
                            @error('avatar')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modern-form-group">
                            <label for="name" class="modern-form-label"><i class="fa fa-user me-2"></i>Nama</label>
                            <input type="text" id="name" name="name" class="modern-form-input" value="{{ old('name', $user->name) }}" placeholder="Nama lengkap" required>
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modern-form-group">
                            <label for="email" class="modern-form-label"><i class="fa fa-envelope me-2"></i>Email</label>
                            <input type="email" id="email" name="email" class="modern-form-input" value="{{ old('email', $user->email) }}" placeholder="nama@domain.com" required>
                            @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <br>
                        <div class="d-flex gap-2">
                            <button type="submit" class="modern-btn modern-btn-primary">Simpan</button>
                            <a href="{{ url()->previous() }}" rel="prev" class="modern-btn modern-btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="modern-card mb-4 fade-in-up">
                <div class="modern-card-body">
                    @if (session('password_status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('password_status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('account.password.update') }}">
                        @csrf
                        <div class="modern-form-group">
                            <label for="current_password" class="modern-form-label"><i class="fa fa-lock me-2"></i>Password Saat Ini</label>
                            <input type="password" id="current_password" name="current_password" class="modern-form-input" placeholder="Masukkan password saat ini" required>
                            @error('current_password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modern-form-group">
                            <label for="password" class="modern-form-label"><i class="fa fa-key me-2"></i>Password Baru</label>
                            <input type="password" id="password" name="password" class="modern-form-input" placeholder="Minimal 8 karakter" required>
                            @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modern-form-group">
                            <label for="password_confirmation" class="modern-form-label"><i class="fa fa-check me-2"></i>Konfirmasi Password Baru</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="modern-form-input" placeholder="Ulangi password baru" required>
                            @error('password_confirmation')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <br>
                        <div class="d-flex gap-2">
                            <button type="submit" class="modern-btn modern-btn-primary">Ubah Password</button>
                            <a href="{{ url()->previous() }}" rel="prev" class="modern-btn modern-btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-role-layout>


