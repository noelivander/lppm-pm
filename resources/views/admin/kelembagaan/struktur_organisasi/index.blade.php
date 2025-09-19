<x-admin-layout>
    <x-slot name="header">
        {{ __('Struktur Organisasi') }}
    </x-slot>

    <x-admin.heading name="Struktur Organisasi">
        
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-12">
            <form class="form-horizontal" method="POST" action="{{ route('struktur-organisasi.store') }}">
                {{ csrf_field() }}
            <div class="modern-card mb-4 fade-in-up">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="fa fa-sitemap me-2"></i>Struktur Organisasi
                    </h5>
                </div>
                <div class="modern-card-body">
                    <div class="modern-form-group">
                        <label for="struktur_org" class="modern-form-label">
                            <i class="fa fa-edit me-2"></i>Konten Struktur Organisasi
                        </label>
                        <textarea id="struktur_org" class="modern-form-textarea" name="struktur_org" rows="20">{!! htmlspecialchars($text_stucture) !!}</textarea>
                    </div>
                </div>
                <div class="modern-card-footer">
                    <button type="submit" class="modern-btn modern-btn-primary w-100">
                        <i class="fa fa-save me-1"></i> Simpan Struktur Organisasi
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
    <x-slot name="scripts">
        <script src="https://cdn.ckeditor.com/4.20.1/full/ckeditor.js"></script>
        <!-- https://codepolitan.com/blog/mengintegrasikan-ckeditor-di-laravel-5a1d04ac1f749 -->

        <script>
            // Wait for DOM to be ready
            document.addEventListener('DOMContentLoaded', function() {
                // Wait for CKEditor to load
                CKEDITOR.on('instanceReady', function(ev) {
                    console.log('CKEditor is ready');
                });

                window.konten = document.getElementById("struktur_org");
                CKEDITOR.replace(konten, {
                    height: '500',
                    language: 'id',
                    toolbar: 'Full',
                    filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token() ]) }}",
                    filebrowserUploadMethod: 'form',
                    allowedContent: true,
                    extraPlugins: 'justify,font,colorbutton,iframe',
                    removeDialogTabs: 'image:advanced;link:advanced'
                });
            });
        </script>
    </x-slot>
</x-admin-layout>