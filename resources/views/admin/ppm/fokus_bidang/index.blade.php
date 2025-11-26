<x-admin-layout>
    <x-slot name="header">
        {{ __('Penelitian & Pengabdian/Pengaturan/Bidang Fokus') }}
    </x-slot>

    <x-admin.heading name="Penelitian & Pengabdian/Pengaturan/Bidang Fokus">
        <a href="{{ route('fokus-bidang.create') }}" class="modern-btn modern-btn-primary">
            <i class="fa fa-plus me-1"></i> Buat Baru
        </a>
    </x-admin.heading>

    @if (session('success'))
        <div class="modern-alert modern-alert-success mb-3 fade-in-up">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fokus_bidang as $key => $value)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            <div class="fw-bold">{{ $value->nama }}
                                @if($value->perihal)
                                    {{ __(" - ".$value->perihal) }}
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                @if($value->is_shown)
                                <a href="{{ route('bidang-fokus.show', ['slug'=>$value->slug]) }}" 
                                   class="modern-btn modern-btn-success modern-btn-sm" target="_blank">
                                    <i class="fa fa-eye me-1"></i> Lihat
                                </a>
                                @endif
                                <a href="{{ route('fokus-bidang.edit', ['fokus_bidang'=>$value->id]) }}" 
                                   class="modern-btn modern-btn-warning modern-btn-sm">
                                    <i class="fa fa-edit me-1"></i> Ubah
                                </a>
                                <button type="button" class="modern-btn modern-btn-danger modern-btn-sm show_confirm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteFokusBidang" 
                                        data-id-fokus="{{ $value->id }}" 
                                        data-nama-fokus="{{ $value->nama }}">
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
    </div>
    <x-slot name="modals">
        <div class="modal fade modern-modal" id="deleteFokusBidang" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">
                            <i class="fa fa-exclamation-triangle text-warning me-2"></i>
                            Hapus Bidang Fokus
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="#">
                        @method('DELETE')
                        @csrf
                        <div class="modal-body">
                            <div class="modern-alert modern-alert-warning">
                                <i class="fa fa-warning me-2"></i>
                                Apakah Anda yakin ingin menghapus bidang fokus <strong class="text-primary"></strong>? Tindakan ini tidak dapat dibatalkan.
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
            var deleteFokusBidangModal = document.getElementById('deleteFokusBidang')
            if (deleteFokusBidangModal) {
                deleteFokusBidangModal.addEventListener('show.bs.modal', function (event) {
                    // Button that triggered the modal
                    var button = event.relatedTarget
                    // Extract info from data-bs-* attributes
                    var id = button.getAttribute('data-id-fokus')
                    var nama = button.getAttribute('data-nama-fokus')

                    var modalBodyInput = deleteFokusBidangModal.querySelector('.modal-body strong')
                    var modalForm = deleteFokusBidangModal.querySelector('form')

                    if (modalBodyInput) {
                        modalBodyInput.textContent = nama
                    }
                    if (modalForm) {
                        modalForm.action = "{{ route('fokus-bidang.index') }}/" + id
                    }
                })
            }
        </script>
    </x-slot>
</x-admin-layout>