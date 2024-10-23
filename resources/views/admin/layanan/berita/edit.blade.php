<x-admin-layout>
    <x-slot name="header">
        {{ __('Berita/Edit') }}
    </x-slot>

    <x-admin.heading name="Berita/Edit">
        <a href="{{ route('berita.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-list fa-sm text-white-50"></i> <span class="text-white">Daftar Berita</span></a>
    </x-admin.heading>

    <div class="row">
        <div class="col-xl-8">
            <div class="card shadow mb-4">
                <form class="form-horizontal" method="POST" action="{{ route('berita.update', ['beritum' => $berita->id]) }}"  enctype="multipart/form-data">
                    @method('PUT')
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="mb-3">
                            <x-admin.input-text lable_input="judul" value="{{$berita->judul}}">
                            </x-admin.input-text>
                        </div>

                        <div class="mb-3">
                            <x-admin.input-text lable_input="tag" value="{{$berita->tag}}" required="0">
                            </x-admin.input-text>
                        </div>

                        @if ($berita->cover)
                        <div class="mb-3">
                            <img src="{{ asset('storage/'.$berita->cover) }}" class="img-fluid" alt="Cover Berita">
                        </div>
                        @endif

                        <div class="mb-3">
                            <label for="cover" class="form-label">Ganti Cover Berita</label>
                            <input class="col-form-control" type="file" id="cover" name="cover" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="isi" class="form-label">Deskripsi Berita</label>
                            <textarea id="isi" class="form-control" name="isi" rows="20">{!! htmlspecialchars($berita->isi) !!}</textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="created_at" class="col-form-label">Jadwal Publish</label>
                                <input type="datetime-local" class="form-control" id="created_at" name="created_at" max="{{ date('Y-m-d',time()) }}T09:00" value="{{$berita->created_at}}" required>
                            </div>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox"  id="is_shown" name="is_shown"
                                @if($berita->is_shown==1)
                                    checked
                                @endif
                            >
                            <label class="form-check-label" for="is_shown">tampilkan berita</label>
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