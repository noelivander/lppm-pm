<x-admin-layout>
    <x-slot name="header">
        {{ __('Dokumen/Edit') }}
    </x-slot>

    <x-admin.heading name="Dokumen/Edit">
        <a href="{{ route('dokumen_penting.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> <span class="text-white">Daftar Dokumen</span></a>
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <form class="form-horizontal" method="POST" action="{{ route('dokumen_penting.update', ['dokumen_penting' => $dokumen_penting->id]) }}"  enctype="multipart/form-data">
                    @method('PUT')
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="mb-3">
                            <x-admin.input-text lable_input="judul" value="{{$dokumen_penting->judul}}">
                            </x-admin.input-text>
                        </div>
                        <div class="mb-3">
                            <x-admin.input-text lable_input="label" input_type="selection-val" :categories="$label_dokumen" value="{{$dokumen_penting->label}}" >
                            </x-admin.input-text>
                        </div>
                        <div class="mb-3">
                            <x-admin.input-text lable_input="urutan" input_type="number" value="{{$dokumen_penting->urutan}}" help="semakin kecil angkanya maka semakin prioritas di urutan awal">
                            </x-admin.input-text>
                        </div>

                        @if ($dokumen_penting->cover)
                        <div class="mb-3 row">
                            <div class="col-lg-4">
                                <img src="{{ asset('storage/'.$dokumen_penting->cover) }}" class="img-fluid" alt="Cover Berita">
                            </div>
                            <div class="col">
                                <label for="cover" class="form-label">Ganti Cover Dokumen</label>
                                <input class="form-control" type="file" id="cover" name="cover" accept="image/*">
                            </div>
                        </div>
                        @endif
                        
                        <div class="mb-3">
                            <label for="file" class="form-label">File Dokumen</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="File Dokumen" value="{{ $file_dokumen }}" aria-describedby="button-addon2" disabled>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label">Ganti File Dokumen</label>
                            <input class="form-control" type="file" id="file" name="file" accept="application/pdf">
                        </div>
                        
                        <div class="mb-3">
                            <label class="col-form-label">Pengaturan</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"  id="is_shown" name="is_shown"
                                @if($dokumen_penting->is_shown==1)
                                    checked
                                @endif
                                >
                                <label class="form-check-label" for="is_shown">tampilkan dokumen</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"  id="is_lock" name="is_lock"
                                @if($dokumen_penting->is_lock==0)
                                    checked
                                @endif
                                >
                                <label class="form-check-label" for="is_lock">tampilkan file</label>
                            </div>
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
            @if($dokumen_penting->file)
                <embed src="{{ asset('storage/'.$dokumen_penting->file) }}" type="application/pdf" width="100%" height="640px" class="pt-1">
            @else
                <h2 class="text-center">Belum ada file</h2>
            @endif
        </div>
    </div>
    <x-slot name="scripts">
        <script type="text/javascript" src="{{ asset('storage/ckeditor/ckeditor.js') }}"></script>
        <!-- https://codepolitan.com/blog/mengintegrasikan-ckeditor-di-laravel-5a1d04ac1f749 -->

        <script>
            var konten = document.getElementById("isi");
                CKEDITOR.replace(konten,{
                language:'id'
            });

            CKEDITOR.config.allowedContent = true;
        </script>
    </x-slot>
</x-admin-layout>