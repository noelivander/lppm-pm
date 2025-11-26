<x-admin-layout>
    <x-slot name="header">
        {{ __('Pengaturan/Pegawai') }}
    </x-slot>

    <x-admin.heading name="Pengaturan/Pegawai">
        <a href="{{ route('pegawai.create') }}" class="modern-btn modern-btn-primary">
            <i class="fa fa-plus me-1"></i> Buat Baru
        </a>
    </x-admin.heading>

    @if (session('success'))
        <div class="modern-alert modern-alert-success mb-3 fade-in-up">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="modern-alert modern-alert-danger mb-3 fade-in-up">
            <i class="fa fa-exclamation-triangle me-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="modern-table-container mb-4 fade-in-up">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>NIP</th>
                            <th>Program Studi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pegawai as $key => $value)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>
                                <div class="fw-bold">{{ strtoupper($value->nama) }}</div>
                                @if($value->pangkat_golongan_ruang_id && $value->pangkat_golongan_ruang)
                                    <small class="text-muted">{{ $value->pangkat_golongan_ruang->golongan }}/{{ $value->pangkat_golongan_ruang->ruang }}</small>
                                @endif
                            </td>
                            <td>
                                <i class="fa fa-envelope me-1"></i>{{ $value->email }}
                            </td>
                            <td>
                                <span class="status-badge nip">{{ $value->nip }}</span>
                            </td>
                            <td>
                                @if($value->program_studi_id && $value->program_studi)
                                    <div class="fw-bold">{{ $value->program_studi->nama }}</div>
                                    @if($value->program_studi->jurusan)
                                        <small class="text-muted">{{ $value->program_studi->jurusan->nama }}</small>
                                    @else
                                        <small class="text-danger">Jurusan tidak ditemukan</small>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('pegawai.edit', ['pegawai'=>$value->id]) }}" 
                                       class="modern-btn modern-btn-warning modern-btn-sm">
                                        <i class="fa fa-edit me-1"></i> Ubah
                                    </a>
                                    <form method="POST" action="{{ route('pegawai.destroy', $value->id) }}" class="d-inline">
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