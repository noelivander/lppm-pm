<x-admin-layout>
    <x-slot name="header">
        {{ __('Berita/Buat Baru') }}
    </x-slot>

    <x-admin.heading name="Berita/Buat Baru">
        <a href="{{ route('berita.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-list fa-sm text-white-50"></i> <span class="text-white">Daftar Berita</span></a>
    </x-admin.heading>

    <div class="row">
        <div class="col-xl-8">
            <div class="card shadow mb-4">
                <form class="form-horizontal" method="POST" action="{{ route('berita.store') }}"  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="mb-3">
                            <x-admin.input-text lable_input="judul">
                            </x-admin.input-text>
                        </div>
                        
                        <div class="mb-3">
                            <label for="cover" class="col-form-label">Pilih cover berita</label>
                            <input class="form-control" type="file" id="cover" name="cover" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="isi" class="col-form-label">Deskripsi Berita</label>
                            <textarea id="isi" class="form-control" name="isi" rows="20"></textarea>
                        </div>
                        
                    </div>
                    <div class="card-footer">
                        <div class="">
                            <button type="submit" class="btn btn-outline-primary btn-block">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script type="text/javascript" src="{{ url('storage/ckeditor/ckeditor.js') }}"></script>
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