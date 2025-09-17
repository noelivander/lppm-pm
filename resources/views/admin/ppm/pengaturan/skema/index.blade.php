<x-admin-layout>
    <x-slot name="header">
        {{ __('Penelitian & Pengabdian/Pengaturan/Skema') }}
    </x-slot>

    <x-admin.heading name="Penelitian & Pengabdian/Pengaturan/Skema">
        
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-8">
            <div class="modern-table-container mb-4 fade-in-up">
                <table class="modern-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($skema as $key => $value)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            <div class="fw-bold mb-1">{{ $value->nama }}
                                @if($value->perihal)
                                    {{ __(" - ".$value->perihal) }}
                                @endif
                            </div>
                            @if($value->is_research)
                                <span class="status-badge primary">Riset</span>
                            @else
                                <span class="status-badge success">Abdimas</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ strtoupper($value->jenis_skema->kode) }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('skema.edit', ['skema'=>$value->id]) }}" 
                                   class="modern-btn modern-btn-warning modern-btn-sm">
                                    <i class="fa fa-edit me-1"></i> Ubah
                                </a>
                                <form method="POST" action="{{ route('skema.destroy', $value->id) }}" class="d-inline">
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
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <form class="form-horizontal" method="POST" action="{{ route('skema.store') }}">
                    {{ csrf_field() }}
                    <h5 class="card-header py-3">Tambahkan Luaran</h5>
                    <div class="card-body">
                        <div class="mb-3">
                            <x-admin.input-text lable_input="kode">
                            </x-admin.input-text>
                            <x-admin.input-text lable_input="nama">
                            </x-admin.input-text>
                            <x-admin.input-text lable_input="perihal">
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