<x-admin-layout>
    <x-slot name="header">
        {{ __('Visi Misi') }}
    </x-slot>

    <x-admin.heading name="Visi Misi">

    </x-admin.heading>

    <div class="row">
        <div class="col-lg-12">
            <!-- Edit Form -->
            <form class="form-horizontal" method="POST" action="{{ route('visi-misi.store') }}">
                {{ csrf_field() }}
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-header">
                        <h5 class="mb-0">
                            <i class="fa fa-eye me-2"></i>Visi Misi Organisasi
                        </h5>
                    </div>
                    <div class="modern-card-body">
                        <div class="modern-form-group">
                            <label for="visi_misi_org" class="modern-form-label">
                                <i class="fa fa-edit me-2"></i>Konten Visi Misi
                            </label>
                            <textarea id="visi_misi_org" class="modern-form-textarea" name="visi_misi_org" rows="20">{!! htmlspecialchars($text_visi_misi) !!}</textarea>
                        </div>
                    </div>
                    <div class="modern-card-footer">
                        <button type="submit" class="modern-btn modern-btn-primary w-100">
                            <i class="fa fa-save me-1"></i> Simpan Visi Misi
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-6">

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

                window.konten = document.getElementById("visi_misi_org");
                
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
