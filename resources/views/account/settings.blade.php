<x-role-layout :hideFooter="true">

    <x-admin.heading name="Pengaturan Akun"></x-admin.heading>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('account.password.update') }}">
                        @csrf
                        <div class="mb-3">
                            <x-admin.input-text lable_input="current_password" type="password"></x-admin.input-text>
                            @error('current_password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <x-admin.input-text lable_input="password" type="password"></x-admin.input-text>
                            @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <x-admin.input-text lable_input="password_confirmation" type="password"></x-admin.input-text>
                        </div>
                        <button type="submit" class="btn btn-outline-primary">Ubah Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-role-layout>


