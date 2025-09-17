<x-admin-layout>
    <x-slot name="header">
        {{ __('Berita/Buat Baru') }}
    </x-slot>

    <x-admin.heading name="Berita/Buat Baru">
        <a href="{{ route('berita.index') }}" class="modern-btn modern-btn-primary">
            <i class="fa fa-list me-1"></i> Daftar Berita
        </a>
    </x-admin.heading>

    <div class="row">
        <div class="col-xl-8">
            <div class="modern-card mb-4 fade-in-up">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="fa fa-plus-circle me-2"></i>
                        Form Buat Berita Baru
                    </h5>
                </div>
                <form class="form-horizontal" method="POST" action="{{ route('berita.store') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modern-card-body">
                        <div class="modern-form-group">
                            <label for="judul" class="modern-form-label">
                                <i class="fa fa-heading me-2"></i>Judul Berita
                            </label>
                            <input type="text" id="judul" name="judul" class="modern-form-input" required>
                        </div>
                        
                        <div class="modern-form-group">
                            <label for="cover" class="modern-form-label">
                                <i class="fa fa-image me-2"></i>Pilih Cover Berita
                            </label>
                            <input class="modern-form-input" type="file" id="cover" name="cover" accept="image/*">
                        </div>

                        <div class="modern-form-group">
                            <label for="isi" class="modern-form-label">
                                <i class="fa fa-edit me-2"></i>Deskripsi Berita
                            </label>
                            <textarea id="isi" class="modern-form-textarea" name="isi" rows="20" placeholder="Tuliskan isi berita di sini..."></textarea>
                        </div>
                        
                    </div>
                    <div class="modern-card-footer">
                        <div class="d-flex gap-2">
                            <a href="{{ route('berita.index') }}" class="modern-btn modern-btn-secondary">
                                <i class="fa fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="modern-btn modern-btn-primary">
                                <i class="fa fa-save me-1"></i> Simpan Berita
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