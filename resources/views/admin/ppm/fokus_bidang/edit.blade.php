<x-admin-layout>
    <x-slot name="header">
        {{ __('Bidang Fokus/Buat Baru') }}
    </x-slot>

    <x-admin.heading name="Bidang Fokus/Buat Baru">
        <a href="{{ route('fokus-bidang.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> <span class="text-white">Daftar Bidang Fokus</span></a>
    </x-admin.heading>

    <div class="row">
        <div class="col-xl-8">
            <div class="card shadow mb-4">
                <form class="form-horizontal" method="POST" action="{{ route('fokus-bidang.update', ['fokus_bidang'=>$fokus_bidang->id]) }}"  enctype="multipart/form-data">
                    @method('PUT')
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <x-admin.input-text lable_input="nama" value="{{$fokus_bidang->nama}}">
                                </x-admin.input-text>
                            </div>

                            <div class="mb-3 col-md-6">
                                <x-admin.input-text lable_input="perihal" value="{{$fokus_bidang->perihal}}">
                                </x-admin.input-text>
                            </div>

                            <div class="w-100 d-none d-md-block"></div>

                            <div class="mb-3 col-md-6">
                                <x-admin.input-text lable_input="singkatan" value="{{$fokus_bidang->singkatan}}">
                                </x-admin.input-text>
                            </div>

	                        <div class="mb-3 col-md-6">
	                            <label for="cover" class="col-form-label">Ganti Cover</label>
	                            <input class="form-control" type="file" id="cover" name="cover" accept="image/*">
	                        </div>

	                        @if ($fokus_bidang->cover)
	                        <div class="mb-3">
	                            <img src="{{ asset('storage/'.$fokus_bidang->cover) }}" class="img-fluid" alt="Cover Fokus Bidang">
	                        </div>
	                        @endif
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Bidang Fokus</label>
                            <textarea id="deskripsi" class="form-control" name="deskripsi" rows="20">{!! htmlspecialchars($deskripsi) !!}</textarea>
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
        <script type="text/javascript" src="{{ asset('storage/ckeditor/ckeditor.js') }}"></script>
        <!-- https://codepolitan.com/blog/mengintegrasikan-ckeditor-di-laravel-5a1d04ac1f749 -->

        <script>
            var konten = document.getElementById("deskripsi");
            CKEDITOR.replace(konten,{
                language:'id',
                height: '400',
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token() ]) }}",
                filebrowserUploadMethod: 'form'
            });
        </script>
    </x-slot>
</x-admin-layout>