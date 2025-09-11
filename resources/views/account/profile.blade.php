<x-role-layout :hideFooter="true">

    <x-admin.heading name="Profil Saya"></x-admin.heading>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
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
                            <x-admin.input-text lable_input="name">{{ old('name', $user->name) }}</x-admin.input-text>
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <x-admin.input-text lable_input="email">{{ old('email', $user->email) }}</x-admin.input-text>
                            @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-outline-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-role-layout>


