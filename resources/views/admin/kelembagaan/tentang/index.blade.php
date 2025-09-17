<x-admin-layout>
    <x-slot name="title">
        {{ __('Tentang Satker LPPM-PM') }}
    </x-slot>
    <x-slot name="header">
        {{ __('Tentang Satker LPPM-PM') }}
    </x-slot>

    <x-admin.heading name="Tentang Satker LPPM-PM">
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-12">
            <form class="form-horizontal" method="POST" action="{{ route('tentang-satker.store') }}">
                {{ csrf_field() }}
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-header">
                        <h5 class="mb-0">
                            <i class="fa fa-info-circle me-2"></i>Tentang Satker LPPM-PM
                        </h5>
                    </div>
                    <div class="modern-card-body">
                        <div class="modern-form-group">
                            <label for="about_org" class="modern-form-label">
                                <i class="fa fa-edit me-2"></i>Konten Tentang Organisasi
                            </label>
                            <textarea id="about_org" class="modern-form-textarea" name="about_org" rows="20">{!! htmlspecialchars($text_about) !!}</textarea>
                        </div>
                    </div>
                    <div class="modern-card-footer">
                        <button type="submit" class="modern-btn modern-btn-primary w-100">
                            <i class="fa fa-save me-1"></i> Simpan Tentang Organisasi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <x-slot name="scripts">
        <script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
        <!-- https://codepolitan.com/blog/mengintegrasikan-ckeditor-di-laravel-5a1d04ac1f749 -->

        <script>
            window.konten = document.getElementById("about_org");
            
            CKEDITOR.replace(konten, {
                height: '400',
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token() ]) }}",
                filebrowserUploadMethod: 'form'
            });
        </script>
    </x-slot>
</x-admin-layout>
