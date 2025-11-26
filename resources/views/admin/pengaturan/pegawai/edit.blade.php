<x-admin-layout>
    <x-slot name="header">
        {{ __('Pengaturan/Pegawai') }}
    </x-slot>

    <x-admin.heading name="Edit Pegawai">
        <a href="{{ route('pegawai.index') }}" class="modern-btn modern-btn-secondary">
            <i class="fa fa-arrow-left me-1"></i> Kembali
        </a>
    </x-admin.heading>

    @if (session('success'))
        <div class="modern-alert modern-alert-success mb-3 fade-in-up">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="modern-card mb-4 fade-in-up">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="fa fa-edit me-2"></i>Form Edit Pegawai
                    </h5>
                </div>
                <form method="POST" action="{{ route('pegawai.update', $pegawai->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modern-card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <label for="nama" class="modern-form-label"><i class="fa fa-user me-2"></i>Nama <span class="text-danger">*</span></label>
                                    <input id="nama" type="text" class="modern-form-input" name="nama" value="{{ old('nama', $pegawai->nama) }}" placeholder="masukkan nama ..." required>
                                    @if ($errors->has('nama'))
                                        <div class="text-danger small">{{ $errors->first('nama') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <label for="nip" class="modern-form-label"><i class="fa fa-id-card me-2"></i>NIP <span class="text-danger">*</span></label>
                                    <input id="nip" type="text" class="modern-form-input" name="nip" value="{{ old('nip', $pegawai->nip) }}" placeholder="masukkan NIP ..." required>
                                    @if ($errors->has('nip'))
                                        <div class="text-danger small">{{ $errors->first('nip') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modern-form-group">
                            <label for="email" class="modern-form-label"><i class="fa fa-envelope me-2"></i>Email <span class="text-danger">*</span></label>
                            <input id="email" type="email" class="modern-form-input" name="email" value="{{ old('email', $pegawai->email) }}" placeholder="masukkan email ..." required>
                            @if ($errors->has('email'))
                                <div class="text-danger small">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <label for="program_studi_id" class="modern-form-label"><i class="fa fa-graduation-cap me-2"></i>Program Studi</label>
                                    <select class="modern-form-select" id="program_studi_id" name="program_studi_id">
                                        <option value="">Pilih Program Studi</option>
                                        @foreach ($program_studi as $prodi)
                                            <option value="{{ $prodi->id }}" {{ old('program_studi_id', $pegawai->program_studi_id) == $prodi->id ? 'selected' : '' }}>
                                                {{ $prodi->nama }} 
                                                @if($prodi->jurusan)
                                                    - {{ $prodi->jurusan->nama }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('program_studi_id'))
                                        <div class="text-danger small">{{ $errors->first('program_studi_id') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <label for="jabatan_id" class="modern-form-label"><i class="fa fa-briefcase me-2"></i>Jabatan</label>
                                    <select class="modern-form-select" id="jabatan_id" name="jabatan_id">
                                        <option value="">Pilih Jabatan</option>
                                        @foreach ($jabatan as $jab)
                                            <option value="{{ $jab->id }}" {{ old('jabatan_id', $pegawai->jabatan_id) == $jab->id ? 'selected' : '' }}>{{ $jab->nama }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('jabatan_id'))
                                        <div class="text-danger small">{{ $errors->first('jabatan_id') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modern-form-group">
                            <label for="pangkat_golongan_ruang_id" class="modern-form-label"><i class="fa fa-star me-2"></i>Pangkat/Golongan/Ruang</label>
                            <select class="modern-form-select" id="pangkat_golongan_ruang_id" name="pangkat_golongan_ruang_id">
                                <option value="">Pilih Pangkat/Golongan/Ruang</option>
                                @foreach ($pangkat_golongan_ruang as $pgr)
                                    <option value="{{ $pgr->id }}" {{ old('pangkat_golongan_ruang_id', $pegawai->pangkat_golongan_ruang_id) == $pgr->id ? 'selected' : '' }}>
                                        {{ $pgr->pangkat }} - {{ $pgr->golongan }}/{{ $pgr->ruang }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('pangkat_golongan_ruang_id'))
                                <div class="text-danger small">{{ $errors->first('pangkat_golongan_ruang_id') }}</div>
                            @endif
                        </div>
                        <div class="modern-form-group">
                            <label for="foto" class="modern-form-label"><i class="fa fa-image me-2"></i>Foto</label>
                            @if($pegawai->foto)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $pegawai->foto) }}" alt="Foto Pegawai" class="img-thumbnail" style="max-width: 150px;">
                                </div>
                            @endif
                            <input id="foto" type="file" class="modern-form-input" name="foto" accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                            @if ($errors->has('foto'))
                                <div class="text-danger small">{{ $errors->first('foto') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="modern-card-footer">
                        <div class="d-flex gap-2">
                            <a href="{{ route('pegawai.index') }}" class="modern-btn modern-btn-secondary">
                                <i class="fa fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="modern-btn modern-btn-primary">
                                <i class="fa fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>

