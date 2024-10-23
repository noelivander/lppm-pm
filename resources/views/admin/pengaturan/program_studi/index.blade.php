<x-admin-layout>
    <x-slot name="header">
        {{ __('Pengaturan/Program Studi') }}
    </x-slot>

    <x-admin.heading name="Pengaturan/Program Studi">
        
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-8">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Jurusan</th>
                        <th>Singkatan</th>
                        <th>Nama</th>
                        <th>Tahun Berdiri</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($program_studi as $key => $value)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $value->jurusan->nama }}</td>
                        <td>{{ strtoupper($value->kode) }}</td>
                        <td>{{ $value->nama }}</td>
                        <td>{{ $value->tahun }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('program_studi.edit', ['program_studi'=>$value->id]) }}" role="button" class="btn btn-warning btn-sm text-white">Ubah</a>
                                <form method="POST" action="{{ route('program_studi.destroy', $value->id) }}">
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
                <form class="form-horizontal" method="POST" action="{{ route('program_studi.store') }}">
                    {{ csrf_field() }}
                    <h5 class="card-header py-3">Tambahkan Program Studi</h5>
                    <div class="card-body">
                        <div class="mb-3">
                            <x-admin.input-text lable_input="singkatan">
                            </x-admin.input-text>
                            <x-admin.input-text lable_input="jurusan" input_type="selection" :categories="$jurusan">
                            </x-admin.input-text>
                            <x-admin.input-text lable_input="nama">
                            </x-admin.input-text>
                            <x-admin.input-text lable_input="tahun">
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