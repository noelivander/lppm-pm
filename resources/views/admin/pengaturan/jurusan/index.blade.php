<x-admin-layout>
    <x-slot name="header">
        {{ __('Pengaturan/Jurusan') }}
    </x-slot>

    <x-admin.heading name="Pengaturan/Jurusan">
        
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-8">
            <div class="modern-table-container mb-4 fade-in-up">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Tahun Berdiri</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jurusan as $key => $value)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>
                                <span class="badge bg-primary">{{ strtoupper($value->kode) }}</span>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $value->nama }}</div>
                            </td>
                            <td>{{ $value->tahun }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('jurusan.edit', ['jurusan'=>$value->id]) }}" 
                                       class="modern-btn modern-btn-warning modern-btn-sm">
                                        <i class="fa fa-edit me-1"></i> Ubah
                                    </a>
                                    
                                    <form method="POST" action="{{ route('jurusan.destroy', $value->id) }}" class="d-inline">
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
                        <i class="fa fa-plus-circle me-2"></i>Tambahkan Jurusan
                    </h5>
                </div>
                <form class="form-horizontal" method="POST" action="{{ route('jurusan.store') }}">
                    {{ csrf_field() }}
                    <div class="modern-card-body">
                        <div class="modern-form-group">
                            <label for="kode" class="modern-form-label"><i class="fa fa-key me-2"></i>Kode</label>
                            <input id="kode" type="text" class="modern-form-input" name="kode" placeholder="masukkan kode ..." required>
                            @if ($errors->has('kode'))
                                <div class="text-danger small">{{ $errors->first('kode') }}</div>
                            @endif
                        </div>
                        <div class="modern-form-group">
                            <label for="nama" class="modern-form-label"><i class="fa fa-font me-2"></i>Nama</label>
                            <input id="nama" type="text" class="modern-form-input" name="nama" placeholder="masukkan nama ..." required>
                            @if ($errors->has('nama'))
                                <div class="text-danger small">{{ $errors->first('nama') }}</div>
                            @endif
                        </div>
                        <div class="modern-form-group">
                            <label for="tahun" class="modern-form-label"><i class="fa fa-calendar me-2"></i>Tahun Berdiri</label>
                            <input id="tahun" type="number" class="modern-form-input" name="tahun" placeholder="mis. 2015" required>
                            @if ($errors->has('tahun'))
                                <div class="text-danger small">{{ $errors->first('tahun') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="modern-card-footer">
                        <button type="submit" class="modern-btn modern-btn-primary w-100">
                            <i class="fa fa-save me-1"></i> Simpan Jurusan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-slot name="scripts">

    </x-slot>
</x-admin-layout>