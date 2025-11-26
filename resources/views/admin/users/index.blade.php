<x-admin-layout>
    <x-slot name="header">
        {{ __('Kelola User') }}
    </x-slot>

    <x-admin.heading name="Kelola User">
        <a href="{{ route('users.create') }}" class="modern-btn modern-btn-primary">
            <i class="fa fa-plus me-1"></i> Tambah User
        </a>
    </x-admin.heading>

    @if (session('success'))
        <div class="modern-alert modern-alert-success mb-3 fade-in-up">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="modern-alert modern-alert-danger mb-3 fade-in-up">
            <i class="fa fa-exclamation-triangle me-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="mb-3 fade-in-up">
                <form method="GET" action="{{ route('users.index') }}" class="modern-card modern-card-body mb-3">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="modern-form-label" for="q"><i class="fa fa-search me-2"></i>Cari</label>
                            <input type="text" name="q" id="q" value="{{ $q ?? '' }}" class="modern-form-input" placeholder="Nama, email, atau NIP...">
                        </div>
                        <div class="col-md-3">
                            <label class="modern-form-label" for="role"><i class="fa fa-filter me-2"></i>Filter Role</label>
                            <select name="role" id="role" class="modern-form-select">
                                <option value="">Semua Role</option>
                                @foreach ($roles as $r)
                                    <option value="{{ $r }}" @if(($role ?? '')===$r) selected @endif>{{ ucfirst($r) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5 ms-md-auto d-flex gap-2 justify-content-md-end">
                            <button type="submit" class="modern-btn modern-btn-primary"><i class="fa fa-search me-1"></i>Terapkan</button>
                            <a href="{{ route('users.index') }}" class="modern-btn modern-btn-secondary"><i class="fa fa-undo me-1"></i>Reset</a>
                        </div>
                    </div>
                </form>

                <div class="modern-table-container">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Akun (Email)</th>
                                <th>NIP</th>
                                <th>Role</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold">{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->nip ?? '-' }}</td>
                                    <td>
                                        <span class="status-badge {{ $user->role }}">{{ ucfirst($user->role) }}</span>
                                    </td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('users.edit', $user) }}" class="modern-btn modern-btn-warning modern-btn-sm">
                                                <i class="fa fa-edit me-1"></i>Edit
                                            </a>
                                            <button type="button" class="modern-btn modern-btn-danger modern-btn-sm show_confirm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteUser" 
                                                    data-id-user="{{ $user->id }}" 
                                                    data-nama-user="{{ $user->name }}"
                                                    data-url-user="{{ route('users.destroy', $user) }}">
                                                <i class="fa fa-trash me-1"></i>Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="modern-alert modern-alert-info mb-0">
                                            <i class="fa fa-info-circle me-2"></i>Belum ada user.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
    
    <x-slot name="modals">
        <div class="modal fade modern-modal" id="deleteUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">
                            <i class="fa fa-exclamation-triangle text-warning me-2"></i>
                            Hapus User
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="#">
                        @method('DELETE')
                        @csrf
                        <div class="modal-body">
                            <div class="modern-alert modern-alert-warning">
                                <i class="fa fa-warning me-2"></i>
                                Apakah Anda yakin ingin menghapus user <strong class="text-primary"></strong>? Tindakan ini tidak dapat dibatalkan.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="modern-btn modern-btn-secondary modern-btn-sm" data-bs-dismiss="modal">
                                <i class="fa fa-times me-1"></i> Batalkan
                            </button>
                            <button type="submit" class="modern-btn modern-btn-danger modern-btn-sm">
                                <i class="fa fa-trash me-1"></i> Hapus
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
    
    <x-slot name="scripts">
        <script type="text/javascript">
            var deleteUserModal = document.getElementById('deleteUser')
            if (deleteUserModal) {
                deleteUserModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget
                    var id = button.getAttribute('data-id-user')
                    var nama = button.getAttribute('data-nama-user')
                    var url = button.getAttribute('data-url-user')

                    var modalBodyInput = deleteUserModal.querySelector('.modal-body strong')
                    var modalForm = deleteUserModal.querySelector('form')

                    if (modalBodyInput) {
                        modalBodyInput.textContent = nama
                    }
                    if (modalForm && url) {
                        modalForm.action = url
                    }
                })
            }
        </script>
    </x-slot>
</x-admin-layout>


