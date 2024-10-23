<x-admin-layout>
    <x-slot name="header">
        {{ __('Agenda') }}
    </x-slot>

    <x-admin.heading name="Agenda">
        <a href="{{ route('agenda.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-plus fa-sm text-white-50"></i> <span class="text-white">Buat Baru</span></a>
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Judul</th>
                        <th>Jadwal</th>
                        <th>Jadwal Akhir</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agenda as $key => $value)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $value->judul }}<br>
                            <small><i class="fa fa-user text-warning"></i> {{ $value->user->name }}&ensp;&ensp;
                                @if($value->tag)
                                    <i class="fa fa-tag text-warning"></i> <span>{{$value->tag}}</span>
                                @endif
                            </small>
                        </td>
                        <td>
                            {{ convertDatetileLocToDate($value->jadwal) }} {{ convertDatetileLocToTime($value->jadwal)}}
                        </td>
                        <td>
                            @if($value->jadwal_akhir)
                                {{ convertDatetileLocToDate($value->jadwal_akhir) }} {{convertDatetileLocToTime($value->jadwal_akhir)}}
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td>
                            @if($value->is_shown)
                                <span class=""><i class="fa fa-eye"></i></span>
                            @else
                                <span class="text-danger"><i class="fa fa-eye-slash"></i></span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex">
                                @if($value->is_shown)
                                <a href="{{ route('layanan-agenda.show', ['slug'=>$value->slug]) }}" role="button" class="btn btn-success btn-sm ms-1 text-white" target="_blank">Lihat</a>
                                @endif
                                <a href="{{ route('agenda.edit', ['agenda'=>$value->id]) }}" role="button" class="btn btn-warning btn-sm ms-1 text-white">Ubah</a>
                                
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger btn-sm ms-1 text-white show_confirm" data-bs-toggle="modal" data-bs-target="#deleteAgenda" data-id-agenda="{{ $value->id }}" data-judul-agenda="{{ $value->judul }}">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <x-slot name="modals">
        <div class="modal fade" id="deleteAgenda" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Hapus Agenda</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="#">
                        @method('DELETE')
                        @csrf
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus agenda yang berjudul<span class="text-primary"></span>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm ms-1 text-white" data-bs-dismiss="modal">Batalkan</button>
                            <button type="submi" class="btn btn-danger btn-sm ms-1 text-white">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
    
    <x-slot name="scripts">
        <script type="text/javascript">
            var exampleModal = document.getElementById('deleteAgenda')
            exampleModal.addEventListener('show.bs.modal', function (event) {
                // Button that triggered the modal
                var button = event.relatedTarget
                // Extract info from data-bs-* attributes
                var id = button.getAttribute('data-id-agenda')
                var judul = button.getAttribute('data-judul-agenda')

                var modalBodyInput = exampleModal.querySelector('.modal-body span')
                var modalForm = exampleModal.querySelector('form')

                modalBodyInput.textContent = ' '+ judul
                modalForm.action = "{{ route('agenda.index') }}"+'/'+id
            })
        </script>
    </x-slot>
</x-admin-layout>