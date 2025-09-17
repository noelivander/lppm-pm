<x-admin-layout>
    <x-slot name="header">
        {{ __('Berita/Edit') }}
    </x-slot>

    <x-admin.heading name="Berita/Edit">
        <a href="{{ route('berita.index') }}" class="modern-btn modern-btn-primary">
            <i class="fa fa-list me-1"></i> Daftar Berita
        </a>
    </x-admin.heading>

    <div class="row">
        <div class="col-xl-8">
            <div class="modern-card mb-4 fade-in-up">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="fa fa-edit me-2"></i>Edit Berita
                    </h5>
                </div>
                <form class="form-horizontal" method="POST" action="{{ route('berita.update', ['beritum' => $berita->id]) }}"  enctype="multipart/form-data">
                    @method('PUT')
                    {{ csrf_field() }}
                    <div class="modern-card-body">
                        <div class="modern-form-group">
                            <label for="judul" class="modern-form-label">
                                <i class="fa fa-heading me-2"></i>Judul Berita
                            </label>
                            <input type="text" id="judul" name="judul" class="modern-form-input" value="{{$berita->judul}}" required>
                        </div>

                        <div class="modern-form-group">
                            <label for="tag" class="modern-form-label">
                                <i class="fa fa-tag me-2"></i>Tag
                            </label>
                            <input type="text" id="tag" name="tag" class="modern-form-input" value="{{$berita->tag}}" placeholder="Opsional">
                        </div>

                        @if ($berita->cover)
                        <div class="mb-3">
                            <img src="{{ asset('storage/'.$berita->cover) }}" class="img-fluid" alt="Cover Berita">
                        </div>
                        @endif

                        <div class="modern-form-group">
                            <label for="cover" class="modern-form-label">
                                <i class="fa fa-image me-2"></i>Ganti Cover Berita
                            </label>
                            <input class="modern-form-input" type="file" id="cover" name="cover" accept="image/*">
                        </div>

                        <div class="modern-form-group">
                            <label for="isi" class="modern-form-label">
                                <i class="fa fa-edit me-2"></i>Deskripsi Berita
                            </label>
                            <textarea id="isi" class="modern-form-textarea" name="isi" rows="20">{!! htmlspecialchars($berita->isi) !!}</textarea>
                        </div>

                        <div class="modern-form-group">
                            <label for="created_at" class="modern-form-label">
                                <i class="fa fa-calendar me-2"></i>Jadwal Publish
                            </label>
                            <input type="datetime-local" class="modern-form-input" id="created_at" name="created_at" max="{{ date('Y-m-d',time()) }}T09:00" value="{{$berita->created_at}}" required>
                        </div>

                        <div class="modern-form-group">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"  id="is_shown" name="is_shown"
                                    @if($berita->is_shown==1)
                                        checked
                                    @endif
                                >
                                <label class="form-check-label" for="is_shown">
                                    <i class="fa fa-eye me-1"></i>Tampilkan berita
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modern-card-footer">
                        <div class="d-flex gap-2">
                            <a href="{{ route('berita.index') }}" class="modern-btn modern-btn-secondary">
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