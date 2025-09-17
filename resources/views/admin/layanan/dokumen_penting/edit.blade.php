<x-admin-layout>
    <x-slot name="header">
        {{ __('Dokumen/Edit') }}
    </x-slot>

    <x-admin.heading name="Dokumen/Edit">
        <a href="{{ route('dokumen_penting.index') }}" class="modern-btn modern-btn-primary">
            <i class="fa fa-list me-1"></i> Daftar Dokumen
        </a>
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-6">
            <div class="modern-card mb-4 fade-in-up">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="fa fa-edit me-2"></i>Edit Dokumen
                    </h5>
                </div>
                <form class="form-horizontal" method="POST" action="{{ route('dokumen_penting.update', ['dokumen_penting' => $dokumen_penting->id]) }}"  enctype="multipart/form-data">
                    @method('PUT')
                    {{ csrf_field() }}
                    <div class="modern-card-body">
                        <div class="modern-form-group">
                            <label for="judul" class="modern-form-label"><i class="fa fa-heading me-2"></i>Judul Dokumen</label>
                            <input id="judul" type="text" class="modern-form-input" name="judul" value="{{$dokumen_penting->judul}}" required>
                            @if ($errors->has('judul'))
                                <div class="text-danger small">{{ $errors->first('judul') }}</div>
                            @endif
                        </div>
                        <div class="modern-form-group">
                            <label for="label" class="modern-form-label"><i class="fa fa-tags me-2"></i>Label</label>
                            <select class="modern-form-select" id="label" name="label" required>
                                <option value="">pilih label</option>
                                @foreach ($label_dokumen as $key => $val)
                                    <option value="{{ $key }}" @if($key==$dokumen_penting->label) selected @endif>{{ $val }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('label'))
                                <div class="text-danger small">{{ $errors->first('label') }}</div>
                            @endif
                        </div>
                        <div class="modern-form-group">
                            <label for="urutan" class="modern-form-label"><i class="fa fa-list-ol me-2"></i>Urutan</label>
                            <input id="urutan" type="number" class="modern-form-input" name="urutan" value="{{$dokumen_penting->urutan}}" required>
                            <span id="urutanHelpInline" class="form-text">semakin kecil angkanya maka semakin prioritas di urutan awal</span>
                            @if ($errors->has('urutan'))
                                <div class="text-danger small">{{ $errors->first('urutan') }}</div>
                            @endif
                        </div>

                        @if ($dokumen_penting->cover)
                        <div class="modern-form-group row">
                            <div class="col-lg-4">
                                <img src="{{ asset('storage/'.$dokumen_penting->cover) }}" class="img-fluid" alt="Cover Berita">
                            </div>
                            <div class="col">
                                <label for="cover" class="modern-form-label">
                                    <i class="fa fa-image me-2"></i>Ganti Cover Dokumen
                                </label>
                                <input class="modern-form-input" type="file" id="cover" name="cover" accept="image/*">
                            </div>
                        </div>
                        @endif
                        
                        <div class="modern-form-group">
                            <label for="file" class="modern-form-label">
                                <i class="fa fa-file me-2"></i>File Dokumen
                            </label>
                            <div class="input-group mb-3">
                                <input type="text" class="modern-form-input" placeholder="File Dokumen" value="{{ $file_dokumen }}" aria-describedby="button-addon2" disabled>
                            </div>
                        </div>

                        <div class="modern-form-group">
                            <label for="file" class="modern-form-label">
                                <i class="fa fa-upload me-2"></i>Ganti File Dokumen
                            </label>
                            <input class="modern-form-input" type="file" id="file" name="file" accept="application/pdf">
                        </div>
                        
                        <div class="modern-form-group">
                            <label class="modern-form-label">
                                <i class="fa fa-cog me-2"></i>Pengaturan
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"  id="is_shown" name="is_shown"
                                @if($dokumen_penting->is_shown==1)
                                    checked
                                @endif
                                >
                                <label class="form-check-label" for="is_shown">
                                    <i class="fa fa-eye me-1"></i>Tampilkan dokumen
                                </label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"  id="is_lock" name="is_lock"
                                @if($dokumen_penting->is_lock==0)
                                    checked
                                @endif
                                >
                                <label class="form-check-label" for="is_lock">
                                    <i class="fa fa-unlock me-1"></i>Tampilkan file
                                </label>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modern-card-footer">
                        <div class="d-flex gap-2">
                            <a href="{{ route('dokumen_penting.index') }}" class="modern-btn modern-btn-secondary">
                                <i class="fa fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="modern-btn modern-btn-primary">
                                <i class="fa fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-6">
            @if($dokumen_penting->file)
                <embed src="{{ asset('storage/'.$dokumen_penting->file) }}" type="application/pdf" width="100%" height="640px" class="pt-1">
            @else
                <h2 class="text-center">Belum ada file</h2>
            @endif
        </div>
    </div>
    <x-slot name="scripts">
        <script type="text/javascript" src="{{ asset('storage/ckeditor/ckeditor.js') }}"></script>
        <!-- https://codepolitan.com/blog/mengintegrasikan-ckeditor-di-laravel-5a1d04ac1f749 -->

        <script>
            var konten = document.getElementById("isi");
                CKEDITOR.replace(konten,{
                language:'id'
            });

            CKEDITOR.config.allowedContent = true;
        </script>
    </x-slot>
</x-admin-layout>