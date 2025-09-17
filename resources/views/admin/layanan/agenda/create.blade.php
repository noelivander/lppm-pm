<x-admin-layout>
    <x-slot name="header">
        {{ __('Agenda/Buat Baru') }}
    </x-slot>

    <x-admin.heading name="Agenda/Buat Baru">
        <a href="{{ route('agenda.index') }}" class="modern-btn modern-btn-primary">
            <i class="fa fa-list me-1"></i> Daftar Agenda
        </a>
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-8">
            <div class="modern-card mb-4 fade-in-up">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="fa fa-plus-circle me-2"></i>Form Buat Agenda Baru
                    </h5>
                </div>
                <form class="form-horizontal" method="POST" action="{{ route('agenda.store') }}"  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modern-card-body">
                        <div class="modern-form-group">
                            <label for="judul" class="modern-form-label">
                                <i class="fa fa-heading me-2"></i>Judul Agenda
                            </label>
                            <input type="text" id="judul" name="judul" class="modern-form-input" placeholder="Masukkan judul agenda" required>
                        </div>

                        <div class="modern-form-group">
                            <label for="lokasi" class="modern-form-label">
                                <i class="fa fa-map-marker-alt me-2"></i>Lokasi
                            </label>
                            <input type="text" id="lokasi" name="lokasi" class="modern-form-input" placeholder="Masukkan lokasi agenda" required>
                        </div>

                        <div class="modern-form-group">
                            <label for="jadwal" class="modern-form-label">
                                <i class="fa fa-calendar me-2"></i>Jadwal
                            </label>
                            <input type="datetime-local" class="modern-form-input" id="jadwal" name="jadwal" min="{{ date('Y-m-d',time()) }}T09:00" required>
                        </div>

                        <div class="modern-form-group">
                            <label for="jadwal_akhir" class="modern-form-label">
                                <i class="fa fa-calendar-times me-2"></i>Jadwal Akhir
                            </label>
                            <input type="datetime-local" class="modern-form-input" id="jadwal_akhir" name="jadwal_akhir" min="{{ date('Y-m-d',time()) }}T09:00">
                        </div>

                        <div class="modern-form-group">
                            <label for="tautan" class="modern-form-label">
                                <i class="fa fa-link me-2"></i>Tautan
                            </label>
                            <input type="url" class="modern-form-input" id="tautan" name="tautan" placeholder="masukkan url">
                        </div>

                        <div class="modern-form-group">
                            <label for="tag" class="modern-form-label">
                                <i class="fa fa-tag me-2"></i>Tag
                            </label>
                            <input type="text" id="tag" name="tag" class="modern-form-input" placeholder="Opsional: tag/kategori">
                        </div>
                        
                        <div class="modern-form-group">
                            <label for="cover" class="modern-form-label">
                                <i class="fa fa-image me-2"></i>Pilih Cover Agenda
                            </label>
                            <input class="modern-form-input" type="file" id="cover" name="cover" accept="image/*">
                        </div>

                        <div class="modern-form-group">
                            <label for="deskripsi" class="modern-form-label">
                                <i class="fa fa-edit me-2"></i>Deskripsi Agenda
                            </label>
                            <textarea id="deskripsi" class="modern-form-textarea" name="deskripsi" rows="20"></textarea>
                        </div>
                        
                    </div>
                    <div class="modern-card-footer">
                        <div class="d-flex gap-2">
                            <a href="{{ route('agenda.index') }}" class="modern-btn modern-btn-secondary">
                                <i class="fa fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="modern-btn modern-btn-primary">
                                <i class="fa fa-save me-1"></i> Simpan Agenda
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
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