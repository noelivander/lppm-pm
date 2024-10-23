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
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <textarea id="about_org" class="form-control" name="about_org" rows="20">
                                {!! htmlspecialchars($text_about) !!}
                            </textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="">
                            <button type="submit" class="btn btn-outline-primary btn-block">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <x-slot name="scripts">
        <script type="text/javascript" src="{{ url('storage/ckeditor/ckeditor.js') }}"></script>
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
