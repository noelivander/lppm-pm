<x-admin-layout>
    <x-slot name="header">
        {{ __('Dokumen/Buat Baru') }}
    </x-slot>

    <x-admin.heading name="Dokumen/Buat Baru">
        <a href="{{ route('dokumen_penting.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> <span class="text-white">Daftar Dokumen</span></a>
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <form class="form-horizontal" method="POST" action="{{ route('dokumen_penting.store') }}"  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="mb-3">
                            <x-admin.input-text lable_input="judul">
                            </x-admin.input-text>
                        </div>
                        <div class="mb-3">
                            <x-admin.input-text lable_input="label" input_type="selection-val" :categories="$label_dokumen">
                            </x-admin.input-text>
                        </div>

                        <div class="mb-3">
                            <x-admin.input-text lable_input="urutan" input_type="number" help="semakin kecil angkanya maka semakin prioritas di urutan awal">
                            </x-admin.input-text>
                        </div>
                        
                        <div class="mb-3">
                            <label for="cover" class="col-form-label">Pilih cover file</label>
                            <input class="form-control" type="file" id="cover" name="cover" accept="image/*">
                        </div>
                        
                        <div class="mb-3">
                            <label for="file" class="form-label">Pilih file</label>
                            <input class="form-control" type="file" id="file" name="file" accept="application/pdf, .doc, .docx">
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
    </x-slot>
</x-admin-layout>