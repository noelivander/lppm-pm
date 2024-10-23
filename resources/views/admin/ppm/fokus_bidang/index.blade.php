<x-admin-layout>
    <x-slot name="header">
        {{ __('Penelitian & Pengabdian/Pengaturan/Bidang Fokus') }}
    </x-slot>

    <x-admin.heading name="Penelitian & Pengabdian/Pengaturan/Bidang Fokus">
        <a href="{{ route('fokus-bidang.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> <span class="text-white">Buat Baru</span></a>
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-8">
            <table class="table">
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
                        <td>{{ $value->nama }}
                            @if($value->perihal)
                                {{ __(" - ".$value->perihal) }}
                            @endif
                        </td>
                        <td>
                            <div class="d-flex">
                                @if($value->is_shown)
                                <a href="{{ route('bidang-fokus.show', ['slug'=>$value->slug]) }}" role="button" class="btn btn-success btn-sm ms-1 text-white" target="_blank">Lihat</a>
                                @endif
                                <a href="{{ route('fokus-bidang.edit', ['fokus_bidang'=>$value->id]) }}" role="button" class="btn btn-warning btn-sm ms-1 text-white">Ubah</a>
                                <form method="POST" action="{{ route('fokus-bidang.destroy', $value->id) }}">
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