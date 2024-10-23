<x-admin-layout>
    <x-slot name="header">
        {{ __('Agenda/Buat Baru') }}
    </x-slot>

    <x-admin.heading name="Agenda/Buat Baru">
        <a href="{{ route('agenda.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-list fa-sm text-white-50"></i> <span class="text-white">Daftar Agenda</span></a>
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <form class="form-horizontal" method="POST" action="{{ route('agenda.store') }}"  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="mb-3">
                            <x-admin.input-text lable_input="judul">
                            </x-admin.input-text>
                        </div>

                        <div class="mb-3">
                            <x-admin.input-text lable_input="lokasi">
                            </x-admin.input-text>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="jadwal" class="col-form-label">Jadwal</label>
                                <input type="datetime-local" class="form-control" id="jadwal" name="jadwal" min="{{ date('Y-m-d',time()) }}T09:00" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="jadwal_akhir" class="col-form-label">Jadwal Akhir</label>
                                <input type="datetime-local" class="form-control" id="jadwal_akhir" name="jadwal_akhir" min="{{ date('Y-m-d',time()) }}T09:00">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="tautan" class="col-form-label">Tautan</label>
                                <input type="url" class="form-control" id="tautan" name="tautan" placeholder="masukkan url">
                            </div>
                        </div>

                        <div class="mb-3">
                            <x-admin.input-text lable_input="tag" required="0">
                            </x-admin.input-text>
                        </div>
                        
                        <div class="mb-3">
                            <label for="cover" class="col-form-label">Pilih Cover Agenda</label>
                            <input class="form-control" type="file" id="cover" name="cover" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Agenda</label>
                            <textarea id="deskripsi" class="form-control" name="deskripsi" rows="20"></textarea>
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
            window.konten = document.getElementById("deskripsi");
            CKEDITOR.replace(konten,{
                language:'id',
                height: '400',
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token() ]) }}",
                filebrowserUploadMethod: 'form'
            });
        </script>
    </x-slot>
</x-admin-layout>