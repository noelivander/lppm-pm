<x-admin-layout>
    <x-slot name="header">
        {{ __('Dokumen') }}
    </x-slot>

    <x-admin.heading name="Dokumen">
        <a href="{{ route('dokumen_penting.create') }}" class="modern-btn modern-btn-primary">
            <i class="fa fa-plus me-1"></i> Buat Baru
        </a>
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-12">
            <div class="modern-table-container mb-4 fade-in-up">
                <table class="modern-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Judul</th>
                                <th>Dokumen</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dokumen_penting as $key => $value)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <div class="fw-bold mb-1">{{ $value->judul }}</div>
                                    <div class="text-muted small">
                                        @if($value->label)
                                            <i class="fa fa-tag me-1"></i> <span>{{$value->label}}</span>
                                        @endif
                                        @if($value->created_at)
                                            <i class="fa fa-calendar ms-2 me-1"></i> <span>{{$value->created_at->format('d M Y')}}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($value->file)
                                        <a href="{{ asset('storage/'. $value->file) }}" class="modern-btn modern-btn-primary modern-btn-sm" target="_blank">
                                            <i class="fa fa-download me-1"></i> Download
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak ada file</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        @if($value->is_shown)
                                            <span class="status-badge selesai">
                                                <i class="fa fa-eye me-1"></i> Published
                                            </span>
                                        @else
                                            <span class="status-badge pending">
                                                <i class="fa fa-eye-slash me-1"></i> Draft
                                            </span>
                                        @endif
                                        @if($value->is_lock)
                                            <span class="status-badge warning">
                                                <i class="fa fa-lock me-1"></i> Locked
                                            </span>
                                        @else
                                            <span class="status-badge success">
                                                <i class="fa fa-lock-open me-1"></i> Unlocked
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if($value->file)
                                        <a href="{{ route('dokumen.show', ['slug'=>$value->slug]) }}" 
                                           class="modern-btn modern-btn-success modern-btn-sm" target="_blank">
                                            <i class="fa fa-eye me-1"></i> Lihat
                                        </a>
                                        @endif
                                        <a href="{{ route('dokumen_penting.edit', ['dokumen_penting'=>$value->id]) }}" 
                                           class="modern-btn modern-btn-warning modern-btn-sm">
                                            <i class="fa fa-edit me-1"></i> Ubah
                                        </a>
                                        <button type="button" class="modern-btn modern-btn-danger modern-btn-sm show_confirm" 
                                                data-bs-toggle="modal" data-bs-target="#deleteDokumen" 
                                                data-id-dokumen="{{ $value->id }}" data-judul-dokumen="{{ $value->judul }}">
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
        <div class="modal fade modern-modal" id="deleteDokumen" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">
                            <i class="fa fa-exclamation-triangle text-warning me-2"></i>
                            Hapus Dokumen
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="#">
                        @method('DELETE')
                        @csrf
                        <div class="modal-body">
                            <div class="modern-alert modern-alert-warning">
                                <i class="fa fa-warning me-2"></i>
                                Apakah Anda yakin ingin menghapus dokumen yang berjudul <strong class="text-primary"></strong>?
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
            var exampleModal = document.getElementById('deleteDokumen')
            exampleModal.addEventListener('show.bs.modal', function (event) {
                // Button that triggered the modal
                var button = event.relatedTarget
                // Extract info from data-bs-* attributes
                var id = button.getAttribute('data-id-dokumen')
                var judul = button.getAttribute('data-judul-dokumen')

                var modalBodyInput = exampleModal.querySelector('.modal-body span')
                var modalForm = exampleModal.querySelector('form')

                modalBodyInput.textContent = ' '+ judul
                modalForm.action = "{{ route('dokumen_penting.index') }}"+'/'+id
            })
        </script>
    </x-slot>
</x-admin-layout>