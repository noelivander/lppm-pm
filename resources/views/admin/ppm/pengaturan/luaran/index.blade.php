<x-admin-layout>
    <x-slot name="header">
        {{ __('Penelitian & Pengabdian/Pengaturan/Luaran') }}
    </x-slot>

    <x-admin.heading name="Penelitian & Pengabdian/Pengaturan/Luaran">
        
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
                    @foreach($luaran as $key => $value)
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
                                <a href="{{ route('luaran.edit', ['luaran'=>$value->id]) }}" 
                                   class="modern-btn modern-btn-warning modern-btn-sm">
                                    <i class="fa fa-edit me-1"></i> Ubah
                                </a>
                                <form method="POST" action="{{ route('luaran.destroy', $value->id) }}" class="d-inline">
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
            <div class="modern-card mb-4 fade-in-up">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="fa fa-plus-circle me-2"></i>Tambahkan Luaran
                    </h5>
                </div>
                <form class="form-horizontal" method="POST" action="{{ route('luaran.store') }}">
                    {{ csrf_field() }}
                    <div class="modern-card-body">
                        <div class="modern-form-group">
                            <x-admin.input-text lable_input="kode">
                            </x-admin.input-text>
                        </div>
                        <div class="modern-form-group">
                            <x-admin.input-text lable_input="nama">
                            </x-admin.input-text>
                        </div>
                        <div class="modern-form-group">
                            <x-admin.input-text lable_input="perihal">
                            </x-admin.input-text>
                        </div>
                    </div>
                    <div class="modern-card-footer">
                        <button type="submit" class="modern-btn modern-btn-primary w-100">
                            <i class="fa fa-save me-1"></i> Simpan Luaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-slot name="scripts">

    </x-slot>
</x-admin-layout>