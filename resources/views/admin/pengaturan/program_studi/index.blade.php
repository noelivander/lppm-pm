<x-admin-layout>
    <x-slot name="header">
        {{ __('Pengaturan/Program Studi') }}
    </x-slot>

    <x-admin.heading name="Pengaturan/Program Studi">
        
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
        <div class="col-lg-8">
            <div class="modern-table-container mb-4 fade-in-up">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Jurusan</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Tahun Berdiri</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($program_studi as $key => $value)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>
                                @if($value->jurusan)
                                    <span class="status-badge jurusan">{{ $value->jurusan->nama }}</span>
                                @else
                                    <span class="status-badge pending">Jurusan tidak ditemukan</span>
                                @endif
                            </td>
                            <td>
                                <span class="status-badge kode">{{ strtoupper($value->kode ?? '-') }}</span>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $value->nama }}</div>
                            </td>
                            <td>{{ $value->tahun ?? '-' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('program_studi.edit', ['program_studi'=>$value->id]) }}" 
                                       class="modern-btn modern-btn-warning modern-btn-sm">
                                        <i class="fa fa-edit me-1"></i> Ubah
                                    </a>
                                    <button type="button" class="modern-btn modern-btn-danger modern-btn-sm show_confirm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteProgramStudi" 
                                            data-id-prodi="{{ $value->id }}" 
                                            data-nama-prodi="{{ $value->nama }}">
                                        <i class="fa fa-trash me-1"></i> Hapus
                                    </button>
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
                        <i class="fa fa-plus-circle me-2"></i>Tambahkan Program Studi
                    </h5>
                </div>
                <form class="form-horizontal" method="POST" action="{{ route('program_studi.store') }}">
                    {{ csrf_field() }}
                    <div class="modern-card-body">
                        <div class="modern-form-group">
                            <label for="kode" class="modern-form-label"><i class="fa fa-compress me-2"></i>Kode</label>
                            <input id="kode" type="text" class="modern-form-input" name="kode" placeholder="mis. TI" required>
                            @if ($errors->has('kode'))
                                <div class="text-danger small">{{ $errors->first('kode') }}</div>
                            @endif
                        </div>
                        <div class="modern-form-group">
                            <label for="jurusan" class="modern-form-label"><i class="fa fa-building me-2"></i>Jurusan</label>
                            <select class="modern-form-select" id="jurusan" name="jurusan" required>
                                <option value="">pilih jurusan</option>
                                @foreach ($jurusan as $key => $val)
                                    <option value="{{ $val->id }}">{{ $val->nama }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('jurusan'))
                                <div class="text-danger small">{{ $errors->first('jurusan') }}</div>
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
                            <i class="fa fa-save me-1"></i> Simpan Program Studi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-slot name="modals">
        <div class="modal fade modern-modal" id="deleteProgramStudi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">
                            <i class="fa fa-exclamation-triangle text-warning me-2"></i>
                            Hapus Program Studi
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="#">
                        @method('DELETE')
                        @csrf
                        <div class="modal-body">
                            <div class="modern-alert modern-alert-warning">
                                <i class="fa fa-warning me-2"></i>
                                Apakah Anda yakin ingin menghapus program studi <strong class="text-primary"></strong>? Tindakan ini tidak dapat dibatalkan.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="modern-btn modern-btn-secondary modern-btn-sm" data-bs-dismiss="modal">
                                <i class="fa fa-times me-1"></i> Batalkan
                            </button>
                            <button type="submit" class="modern-btn modern-btn-danger modern-btn-sm">
                                <i class="fa fa-trash me-1"></i> Hapus
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
    
    <x-slot name="scripts">
        <script type="text/javascript">
            var deleteProgramStudiModal = document.getElementById('deleteProgramStudi')
            if (deleteProgramStudiModal) {
                deleteProgramStudiModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget
                    var id = button.getAttribute('data-id-prodi')
                    var nama = button.getAttribute('data-nama-prodi')

                    var modalBodyInput = deleteProgramStudiModal.querySelector('.modal-body strong')
                    var modalForm = deleteProgramStudiModal.querySelector('form')

                    if (modalBodyInput) {
                        modalBodyInput.textContent = nama
                    }
                    if (modalForm) {
                        modalForm.action = "{{ route('program_studi.index') }}/" + id
                    }
                })
            }
        </script>
    </x-slot>
</x-admin-layout>