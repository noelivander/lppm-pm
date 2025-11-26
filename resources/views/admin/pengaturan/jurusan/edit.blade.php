<x-admin-layout>
    <x-slot name="header">
        {{ __('Pengaturan/Jurusan') }}
    </x-slot>

    <x-admin.heading name="Edit Jurusan">
        <a href="{{ route('jurusan.index') }}" class="modern-btn modern-btn-secondary">
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
                        <i class="fa fa-edit me-2"></i>Form Edit Jurusan
                    </h5>
                </div>
                <form method="POST" action="{{ route('jurusan.update', $jurusan->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modern-card-body">
                        <div class="modern-form-group">
                            <label for="kode" class="modern-form-label"><i class="fa fa-key me-2"></i>Kode <span class="text-danger">*</span></label>
                            <input id="kode" type="text" class="modern-form-input" name="kode" value="{{ old('kode', $jurusan->kode) }}" placeholder="masukkan kode ..." required>
                            @if ($errors->has('kode'))
                                <div class="text-danger small">{{ $errors->first('kode') }}</div>
                            @endif
                        </div>
                        <div class="modern-form-group">
                            <label for="nama" class="modern-form-label"><i class="fa fa-font me-2"></i>Nama <span class="text-danger">*</span></label>
                            <input id="nama" type="text" class="modern-form-input" name="nama" value="{{ old('nama', $jurusan->nama) }}" placeholder="masukkan nama ..." required>
                            @if ($errors->has('nama'))
                                <div class="text-danger small">{{ $errors->first('nama') }}</div>
                            @endif
                        </div>
                        <div class="modern-form-group">
                            <label for="tahun" class="modern-form-label"><i class="fa fa-calendar me-2"></i>Tahun Berdiri <span class="text-danger">*</span></label>
                            <input id="tahun" type="number" class="modern-form-input" name="tahun" value="{{ old('tahun', $jurusan->tahun) }}" placeholder="mis. 2015" required>
                            @if ($errors->has('tahun'))
                                <div class="text-danger small">{{ $errors->first('tahun') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="modern-card-footer">
                        <div class="d-flex gap-2">
                            <a href="{{ route('jurusan.index') }}" class="modern-btn modern-btn-secondary">
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

