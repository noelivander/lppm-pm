<x-role-layout :hideFooter="true">

    <x-admin.heading name="Pengaturan Akun"></x-admin.heading>

    <div class="row">
        <div class="col-lg-6">
            <div class="modern-card mb-4 fade-in-up">
                <div class="modern-card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
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
                        <button type="submit" class="modern-btn modern-btn-primary">Ubah Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-role-layout>


