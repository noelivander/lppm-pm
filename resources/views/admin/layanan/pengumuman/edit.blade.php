<x-admin-layout>
    <x-slot name="header">
        {{ __('Pengumuman/Edit') }}
    </x-slot>

    <x-admin.heading name="Pengumuman/Edit">
        <a href="{{ route('pengumuman.index') }}" class="modern-btn modern-btn-primary">
            <i class="fa fa-list me-1"></i> Daftar Pengumuman
        </a>
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-6">
            <div class="modern-card mb-4 fade-in-up">
                <form class="form-horizontal" method="POST" action="{{ route('pengumuman.update', ['pengumuman' => $pengumuman->id]) }}"  enctype="multipart/form-data">
                    @method('PUT')
                    {{ csrf_field() }}
                    <div class="modern-card-body">
                        <div class="modern-form-group">
                            <label for="judul" class="modern-form-label"><i class="fa fa-heading me-2"></i>Judul Pengumuman</label>
                            <input type="text" id="judul" name="judul" class="modern-form-input" value="{{$pengumuman->judul}}" required>
                        </div>

                        <div class="modern-form-group">
                            <label for="tag" class="modern-form-label"><i class="fa fa-tag me-2"></i>Tag</label>
                            <input type="text" id="tag" name="tag" class="modern-form-input" value="{{$pengumuman->tag}}" placeholder="Opsional">
                        </div>

                        @if ($pengumuman->cover)
                        <div class="mb-3">
                            <img src="{{ asset('storage/'.$pengumuman->cover) }}" class="img-fluid" alt="Cover Pengumuman">
                        </div>
                        @endif

                        <div class="modern-form-group">
                            <label for="cover" class="modern-form-label"><i class="fa fa-image me-2"></i>Ganti Cover Pengumuman</label>
                            <input class="modern-form-input" type="file" id="cover" name="cover" accept="image/*">
                        </div>
                        
                        <div class="modern-form-group">
                            <label for="file" class="modern-form-label"><i class="fa fa-file me-2"></i>Dokumen Pengumuman</label>
                            <div class="input-group mb-3">
                                <input type="text" class="modern-form-input" placeholder="File Dokumen" value="{{ $file_dokumen }}" aria-describedby="button-addon2" disabled>
                            </div>
                        </div>

                        <div class="modern-form-group">
                            <label for="dokumen" class="modern-form-label"><i class="fa fa-upload me-2"></i>Ganti Dokumen Pengumuman</label>
                            <input class="modern-form-input" type="file" id="dokumen" name="dokumen" accept="application/pdf">
                        </div>

                        <div class="modern-form-group">
                            <label for="isi" class="modern-form-label"><i class="fa fa-edit me-2"></i>Deskripsi Pengumuman</label>
                            <textarea id="isi" class="modern-form-textarea" name="isi" rows="20">{!! htmlspecialchars($pengumuman->isi) !!}</textarea>
                        </div>
                        
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox"  id="is_shown" name="is_shown"
                                @if($pengumuman->is_shown==1)
                                    checked
                                @endif
                            >
                            <label class="form-check-label" for="is_shown"><i class="fa fa-eye me-1"></i>tampilkan pengumuman</label>
                        </div>
                    </div>
                    <div class="modern-card-footer">
                        <div class="d-flex gap-2">
                            <a href="{{ route('pengumuman.index') }}" class="modern-btn modern-btn-secondary"><i class="fa fa-arrow-left me-1"></i> Kembali</a>
                            <button type="submit" class="modern-btn modern-btn-primary"><i class="fa fa-save me-1"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-6">
            <embed src="{{ asset('storage/'.$pengumuman->dokumen) }}" type="application/pdf" width="100%" height="640px" class="pt-1">
        </div>
    </div>
    <x-slot name="scripts">
        <script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
        <!-- https://codepolitan.com/blog/mengintegrasikan-ckeditor-di-laravel-5a1d04ac1f749 -->

        <script>
            window.konten = document.getElementById("isi");
            CKEDITOR.replace(konten,{
                language:'id',
                height: '400',
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token() ]) }}",
                filebrowserUploadMethod: 'form'
            });
        </script>
    </x-slot>
</x-admin-layout>