<x-admin-layout>
    <x-slot name="header">
        {{ __('Penelitian & Pengabdian/Pengaturan/Bidang Fokus') }}
    </x-slot>

    <x-admin.heading name="Penelitian & Pengabdian/Pengaturan/Bidang Fokus">
        <a href="{{ route('fokus-bidang.create') }}" class="modern-btn modern-btn-primary">
            <i class="fa fa-plus me-1"></i> Buat Baru
        </a>
    </x-admin.heading>

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
                                <form method="POST" action="{{ route('fokus-bidang.destroy', $value->id) }}" class="d-inline">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="modern-btn modern-btn-danger modern-btn-sm show_confirm" 
                                            data-toggle="tooltip" title='Delete'>
                                        <i class="fa fa-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>
    <x-slot name="scripts">

    </x-slot>
</x-admin-layout>