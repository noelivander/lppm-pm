<x-admin-layout>
    <x-slot name="header">
        {{ __('Pengumuman/Buat Baru') }}
    </x-slot>

    <x-admin.heading name="Pengumuman/Buat Baru">
        <a href="{{ route('pengumuman.index') }}" class="modern-btn modern-btn-primary">
            <i class="fa fa-list me-1"></i> Daftar Pengumuman
        </a>
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-8">
            <div class="modern-card mb-4 fade-in-up">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="fa fa-plus-circle me-2"></i>Form Buat Pengumuman Baru
                    </h5>
                </div>
                <form class="form-horizontal" method="POST" action="{{ route('pengumuman.store') }}"  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modern-card-body">
                        <div class="modern-form-group">
                            <label for="judul" class="modern-form-label">
                                <i class="fa fa-heading me-2"></i>Judul Pengumuman
                            </label>
                            <input type="text" id="judul" name="judul" class="modern-form-input" placeholder="Masukkan Judul" required>
                        </div>

                        <div class="modern-form-group">
                            <label for="tag" class="modern-form-label">
                                <i class="fa fa-tag me-2"></i>Tag
                            </label>
                            <input type="text" id="tag" name="tag" class="modern-form-input" placeholder="Opsional">
                        </div>
                        
                        <div class="modern-form-group">
                            <label for="cover" class="modern-form-label">
                                <i class="fa fa-image me-2"></i>Pilih cover pengumuman
                            </label>
                            <input class="modern-form-input" type="file" id="cover" name="cover" accept="image/*">
                        </div>
                        
                        <div class="modern-form-group">
                            <label for="dokumen" class="modern-form-label">
                                <i class="fa fa-file-pdf me-2"></i>Pilih dokumen pengumuman
                            </label>
                            <input class="modern-form-input" type="file" id="dokumen" name="dokumen" accept="application/pdf">
                        </div>

                        <div class="modern-form-group">
                            <label for="isi" class="modern-form-label">
                                <i class="fa fa-edit me-2"></i>Deskripsi Pengumuman
                            </label>
                            <textarea id="isi" class="modern-form-textarea" name="isi" rows="20"></textarea>
                        </div>
                        
                    </div>
                    <div class="modern-card-footer">
                        <div class="d-flex gap-2">
                            <a href="{{ route('pengumuman.index') }}" class="modern-btn modern-btn-secondary">
                                <i class="fa fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="modern-btn modern-btn-primary">
                                <i class="fa fa-save me-1"></i> Simpan Pengumuman
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