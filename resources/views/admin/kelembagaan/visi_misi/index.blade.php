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
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                                <textarea id="visi_misi_org" class="form-control" name="visi_misi_org" rows="20">
                                    {!! htmlspecialchars($text_visi_misi) !!}
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

        <div class="col-lg-6">

        </div>
    </div>
    <x-slot name="scripts">
        <script type="text/javascript" src="{{ url('storage/ckeditor/ckeditor.js') }}"></script>
        <!-- https://codepolitan.com/blog/mengintegrasikan-ckeditor-di-laravel-5a1d04ac1f749 -->

        <script>

            window.konten = document.getElementById("visi_misi_org");
            
            CKEDITOR.replace(konten,{
                language:'id',
                height: '400',
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token() ]) }}",
                filebrowserUploadMethod: 'form'
            });
        </script>
    </x-slot>
</x-admin-layout>
