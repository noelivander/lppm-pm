<x-admin-layout>
    <x-slot name="header">
        {{ __('Pengaturan/Tautan') }}
    </x-slot>

    <x-admin.heading name="Pengaturan/Tautan">
        
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
        <div class="col-lg-8">
            <div class="modern-table-container mb-4 fade-in-up">
                <table class="modern-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>URL</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($related_link as $key => $value)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <div class="fw-bold">{{ $value->nama }}</div>
                                </td>
                                <td>
                                    <a href="{{ $value->url }}" target="_blank" class="text-primary">
                                        <i class="fa fa-external-link me-1"></i>{{ $value->url }}
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('related_link.edit', ['related_link'=>$value->id]) }}" 
                                           class="modern-btn modern-btn-warning modern-btn-sm">
                                            <i class="fa fa-edit me-1"></i> Ubah
                                        </a>
                                        <button type="button" class="modern-btn modern-btn-danger modern-btn-sm show_confirm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteRelatedLink" 
                                                data-id-link="{{ $value->id }}" 
                                                data-nama-link="{{ $value->nama }}"
                                                data-url-link="{{ route('related_link.destroy', $value->id) }}">
                                            <i class="fa fa-trash me-1"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="modern-card mb-4 fade-in-up">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="fa fa-plus-circle me-2"></i>Tambahkan Tautan
                    </h5>
                </div>
                <form class="form-horizontal" method="POST" action="{{ route('related_link.store') }}">
                    {{ csrf_field() }}
                    <div class="modern-card-body">
                        <div class="modern-form-group">
                            <label for="nama" class="modern-form-label"><i class="fa fa-font me-2"></i>Nama</label>
                            <input id="nama" type="text" class="modern-form-input" name="nama" placeholder="Masukkan nama tautan..." required>
                            @if ($errors->has('nama'))
                                <div class="text-danger small mt-1">{{ $errors->first('nama') }}</div>
                            @endif
                        </div>
                        <div class="modern-form-group">
                            <label for="url" class="modern-form-label"><i class="fa fa-link me-2"></i>URL</label>
                            <input id="url" type="url" class="modern-form-input" name="url" placeholder="https://example.com" required>
                            @if ($errors->has('url'))
                                <div class="text-danger small mt-1">{{ $errors->first('url') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="modern-card-footer">
                        <button type="submit" class="modern-btn modern-btn-primary w-100">
                            <i class="fa fa-save me-1"></i> Simpan Tautan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-slot name="modals">
        <div class="modal fade modern-modal" id="deleteRelatedLink" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">
                            <i class="fa fa-exclamation-triangle text-warning me-2"></i>
                            Hapus Tautan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="#">
                        @method('DELETE')
                        @csrf
                        <div class="modal-body">
                            <div class="modern-alert modern-alert-warning">
                                <i class="fa fa-warning me-2"></i>
                                Apakah Anda yakin ingin menghapus tautan <strong class="text-primary"></strong>? Tindakan ini tidak dapat dibatalkan.
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
            var deleteRelatedLinkModal = document.getElementById('deleteRelatedLink')
            if (deleteRelatedLinkModal) {
                deleteRelatedLinkModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget
                    var id = button.getAttribute('data-id-link')
                    var nama = button.getAttribute('data-nama-link')
                    var url = button.getAttribute('data-url-link')

                    var modalBodyInput = deleteRelatedLinkModal.querySelector('.modal-body strong')
                    var modalForm = deleteRelatedLinkModal.querySelector('form')

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