<x-admin-layout>
    <x-slot name="header">
        {{ __('Dokumen/Buat Baru') }}
    </x-slot>

    <x-admin.heading name="Dokumen/Buat Baru">
        <a href="{{ route('dokumen_penting.index') }}" class="modern-btn modern-btn-primary">
            <i class="fa fa-list me-1"></i> Daftar Dokumen
        </a>
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-8">
            <div class="modern-card mb-4 fade-in-up">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="fa fa-plus-circle me-2"></i>Form Buat Dokumen Baru
                    </h5>
                </div>
                <form class="form-horizontal" method="POST" action="{{ route('dokumen_penting.store') }}"  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modern-card-body">
                        <div class="modern-form-group">
                            <label for="judul" class="modern-form-label"><i class="fa fa-heading me-2"></i>Judul Dokumen</label>
                            <input id="judul" type="text" class="modern-form-input" name="judul" placeholder="masukkan judul ..." required>
                            @if ($errors->has('judul'))
                                <div class="text-danger small">{{ $errors->first('judul') }}</div>
                            @endif
                        </div>
                        <div class="modern-form-group">
                            <label for="label" class="modern-form-label"><i class="fa fa-tags me-2"></i>Label</label>
                            <select class="modern-form-select" id="label" name="label" required>
                                <option value="">pilih label</option>
                                @foreach ($label_dokumen as $key => $val)
                                    <option value="{{ $key }}">{{ $val }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('label'))
                                <div class="text-danger small">{{ $errors->first('label') }}</div>
                            @endif
                        </div>

                        <div class="modern-form-group">
                            <label for="urutan" class="modern-form-label"><i class="fa fa-list-ol me-2"></i>Urutan</label>
                            <input id="urutan" type="number" class="modern-form-input" name="urutan" placeholder="masukkan urutan ..." required>
                            <span id="urutanHelpInline" class="form-text">semakin kecil angkanya maka semakin prioritas di urutan awal</span>
                            @if ($errors->has('urutan'))
                                <div class="text-danger small">{{ $errors->first('urutan') }}</div>
                            @endif
                        </div>
                        
                        <div class="modern-form-group">
                            <label for="cover" class="modern-form-label">
                                <i class="fa fa-image me-2"></i>Pilih cover file
                            </label>
                            <input class="modern-form-input" type="file" id="cover" name="cover" accept="image/*">
                        </div>
                        
                        <div class="modern-form-group">
                            <label for="file" class="modern-form-label">
                                <i class="fa fa-file me-2"></i>Pilih file
                            </label>
                            <input class="modern-form-input" type="file" id="file" name="file" accept="application/pdf, .doc, .docx">
                        </div>
                    </div>
                    <div class="modern-card-footer">
                        <div class="d-flex gap-2">
                            <a href="{{ route('dokumen_penting.index') }}" class="modern-btn modern-btn-secondary">
                                <i class="fa fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="modern-btn modern-btn-primary">
                                <i class="fa fa-save me-1"></i> Simpan Dokumen
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
    </x-slot>
</x-admin-layout>