<x-role-layout :hideFooter="true">

    <x-admin.heading name="Profil Saya">
        @php($role = Auth::user()->role)
        @if($role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm">Kembali ke Dashboard</a>
        @elseif($role === 'dosen')
            <a href="{{ route('dosen.dashboard') }}" class="btn btn-primary btn-sm">Kembali ke Dashboard</a>
        @elseif($role === 'reviewer')
            <a href="{{ route('reviewer.dashboard') }}" class="btn btn-primary btn-sm">Kembali ke Dashboard</a>
        @elseif($role === 'auditor')
            <a href="{{ route('auditor.dashboard') }}" class="btn btn-primary btn-sm">Kembali ke Dashboard</a>
        @elseif($role === 'kaprodi')
            <a href="{{ route('kaprodi.dashboard') }}" class="btn btn-primary btn-sm">Kembali ke Dashboard</a>
        @else
            <a href="{{ route('home') }}" class="btn btn-primary btn-sm">Kembali ke Dashboard</a>
        @endif
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    @if (session('profile_status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('profile_status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('account.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label d-block">Avatar</label>
                            <div class="d-flex align-items-center">
                                <img src="{{ Auth::user()->avatar_path ? Storage::url(Auth::user()->avatar_path) : url('img/undraw_profile.svg') }}" class="rounded-circle" style="width:64px;height:64px;object-fit:cover;">
                                <input type="file" name="avatar" accept="image/*" class="form-control ms-3">
                            </div>
                            @error('avatar')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <x-admin.input-text lable_input="name" value="{{ old('name', $user->name) }}" />
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <x-admin.input-text lable_input="email" value="{{ old('email', $user->email) }}" />
                            @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <br>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-outline-primary">Simpan</button>
                            <a href="{{ url()->previous() }}" rel="prev" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    @if (session('password_status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('password_status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('account.password.update') }}">
                        @csrf
                        <div class="mb-3">
                            <x-admin.input-text lable_input="current_password" input_type="password" />
                        </div>
                        <div class="mb-3">
                            <x-admin.input-text lable_input="password" input_type="password" />
                        </div>
                        <div class="mb-3">
                            <x-admin.input-text lable_input="password_confirmation" input_type="password" />
                        </div>
                        <br>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-outline-primary">Ubah Password</button>
                            <a href="{{ url()->previous() }}" rel="prev" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-role-layout>


