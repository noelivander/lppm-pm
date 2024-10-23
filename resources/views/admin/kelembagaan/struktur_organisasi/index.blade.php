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
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="mb-3">
                            <textarea id="struktur_org" class="form-control" name="struktur_org" rows="20">
                                {!! htmlspecialchars($text_stucture) !!}
                            </textarea>
                        </form>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="">
                        <button type="submit" class="btn btn-outline-primary btn-block">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script type="text/javascript" src="{{ url('storage/ckeditor/ckeditor.js') }}"></script>
        <!-- https://codepolitan.com/blog/mengintegrasikan-ckeditor-di-laravel-5a1d04ac1f749 -->

        <script>
            window.konten = document.getElementById("struktur_org");
            CKEDITOR.replace(konten,{
                language:'id',
                height: '400',
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token() ]) }}",
                filebrowserUploadMethod: 'form'
            });
        </script>
    </x-slot>
</x-admin-layout>