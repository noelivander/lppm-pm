<x-admin-layout>
    <x-slot name="header">
        {{ __('Pengaturan/Pegawai') }}
    </x-slot>

    <x-admin.heading name="Pengaturan/Pegawai">
        <a href="{{ route('pegawai.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> <span class="text-white">Buat Baru</span></a>
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>NIP</th>
                        <th>Program Studi</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pegawai as $key => $value)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            <b>{{ strtoupper($value->nama) }}</b><br>
                            @if($value->pangkat_golongan_ruang_id)
                                <span>{{ $value->pangkat_golongan_ruang->golongan }}/{{ $value->pangkat_golongan_ruang->ruang }}</span>
                            @endif
                        </td>
                        <td>{{ $value->email }}</td>
                        <td>{{ $value->nip }}</td>
                        <td>
                            @if($value->program_studi_id)
                                <span>{{ $value->program_studi->nama }}</span><br>
                                <small>{{ $value->program_studi->jurusan->nama }}</small>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('pegawai.edit', ['pegawai'=>$value->id]) }}" role="button" class="btn btn-warning btn-sm text-white">Ubah</a>
                                <form method="POST" action="{{ route('pegawai.destroy', $value->id) }}">
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
    </div>
    <x-slot name="scripts">

    </x-slot>
</x-admin-layout>