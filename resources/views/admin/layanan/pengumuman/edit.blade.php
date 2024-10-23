<x-admin-layout>
    <x-slot name="header">
        {{ __('Pengumuman/Edit') }}
    </x-slot>

    <x-admin.heading name="Pengumuman/Edit">
        <a href="{{ route('pengumuman.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-list fa-sm text-white-50"></i> <span class="text-white">Daftar Pengumuman</span></a>
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <form class="form-horizontal" method="POST" action="{{ route('pengumuman.update', ['pengumuman' => $pengumuman->id]) }}"  enctype="multipart/form-data">
                    @method('PUT')
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="mb-3">
                            <x-admin.input-text lable_input="judul" value="{{$pengumuman->judul}}">
                            </x-admin.input-text>
                        </div>

                        <div class="mb-3">
                            <x-admin.input-text lable_input="tag" value="{{$pengumuman->tag}}" required="0">
                            </x-admin.input-text>
                        </div>

                        @if ($pengumuman->cover)
                        <div class="mb-3">
                            <img src="{{ asset('storage/'.$pengumuman->cover) }}" class="img-fluid" alt="Cover Pengumuman">
                        </div>
                        @endif

                        <div class="mb-3">
                            <label for="cover" class="form-label">Ganti Cover Pengumuman</label>
                            <input class="col-form-control" type="file" id="cover" name="cover" accept="image/*">
                        </div>
                        
                        <div class="mb-3">
                            <label for="file" class="form-label">Dokumen Pengumuman</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="File Dokumen" value="{{ $file_dokumen }}" aria-describedby="button-addon2" disabled>
                                <!-- <button class="btn btn-outline-secondary" type="button" id="button-addon2">Lihat Dokumen</button> -->
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="dokumen" class="form-label">Ganti Dokumen Pengumuman</label>
                            <input class="form-control" type="file" id="dokumen" name="dokumen" accept="application/pdf">
                        </div>

                        <div class="mb-3">
                            <label for="isi" class="form-label">Deskripsi Pengumuman</label>
                            <textarea id="isi" class="form-control" name="isi" rows="20">{!! htmlspecialchars($pengumuman->isi) !!}</textarea>
                        </div>
                        
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox"  id="is_shown" name="is_shown"
                                @if($pengumuman->is_shown==1)
                                    checked
                                @endif
                            >
                            <label class="form-check-label" for="is_shown">tampilkan pengumuman</label>
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

        <div class="col-lg-6">
            <embed src="{{ asset('storage/'.$pengumuman->dokumen) }}" type="application/pdf" width="100%" height="640px" class="pt-1">
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