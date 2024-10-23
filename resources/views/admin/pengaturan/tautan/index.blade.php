<x-admin-layout>
    <x-slot name="header">
        {{ __('Pengaturan/Tautan') }}
    </x-slot>

    <x-admin.heading name="Pengaturan/Tautan">
        
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-8">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>URL</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($related_link as $key => $value)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $value->nama }}</td>
                        <td>{{ $value->url }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('related_link.edit', ['related_link'=>$value->id]) }}" role="button" class="btn btn-warning btn-sm text-white">Ubah</a>
                                <form method="POST" action="{{ route('related_link.destroy', $value->id) }}">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm ms-1 text-white show_confirm" data-toggle="tooltip" title='Delete'>Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <form class="form-horizontal" method="POST" action="{{ route('related_link.store') }}">
                    {{ csrf_field() }}
                    <h5 class="card-header py-3">Tambahkan Tautan</h5>
                    <div class="card-body">
                        <div class="mb-3">
                            <x-admin.input-text lable_input="nama">
                            </x-admin.input-text>
                            <x-admin.input-text lable_input="url">
                            </x-admin.input-text>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="">
                            <button type="submit" class="btn btn-outline-primary btn-block">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-slot name="scripts">

    </x-slot>
</x-admin-layout>