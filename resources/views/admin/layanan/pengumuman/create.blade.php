<x-admin-layout>
    <x-slot name="header">
        {{ __('Pengumuman/Buat Baru') }}
    </x-slot>

    <x-admin.heading name="Pengumuman/Buat Baru">
        <a href="{{ route('pengumuman.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-list fa-sm text-white-50"></i> <span class="text-white">Daftar Pengumuman</span></a>
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <form class="form-horizontal" method="POST" action="{{ route('pengumuman.store') }}"  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="mb-3">
                            <x-admin.input-text lable_input="judul">
                            </x-admin.input-text>
                        </div>

                        <div class="mb-3">
                            <x-admin.input-text lable_input="tag" required="0">
                            </x-admin.input-text>
                        </div>
                        
                        <div class="mb-3">
                            <label for="cover" class="col-form-label">Pilih cover pengumuman</label>
                            <input class="form-control" type="file" id="cover" name="cover" accept="image/*">
                        </div>
                        
                        <div class="mb-3">
                            <label for="dokumen" class="form-label">Pilih dokumen pengumuman</label>
                            <input class="form-control" type="file" id="dokumen" name="dokumen" accept="application/pdf">
                        </div>

                        <div class="mb-3">
                            <label for="isi" class="form-label">Deskripsi Pengumuman</label>
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