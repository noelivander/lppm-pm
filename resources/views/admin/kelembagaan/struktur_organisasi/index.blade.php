<x-admin-layout>
    <x-slot name="header">
        {{ __('Struktur Organisasi') }}
    </x-slot>

    <x-admin.heading name="Struktur Organisasi">
        
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form class="form-horizontal" method="POST" action="{{ route('struktur-organisasi.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="orgTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="hero-tab" data-bs-toggle="tab" data-bs-target="#tab-hero" type="button" role="tab">
                                    <i class="fas fa-image me-2"></i>Hero Section
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="chart-tab" data-bs-toggle="tab" data-bs-target="#tab-chart" type="button" role="tab">
                                    <i class="fas fa-sitemap me-2"></i>Bagan Organisasi
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="info-tab" data-bs-toggle="tab" data-bs-target="#tab-info" type="button" role="tab">
                                    <i class="fas fa-info-circle me-2"></i>Info Cards
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="content-tab" data-bs-toggle="tab" data-bs-target="#tab-main-content" type="button" role="tab">
                                    <i class="fas fa-file-alt me-2"></i>Konten Utama
                                </button>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="modern-card-body">
                        <div class="tab-content" id="orgTabsContent">
                            <!-- Hero Tab -->
                            <div class="tab-pane fade show active" id="tab-hero" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Badge Hero</label>
                                        <input type="text" class="form-control" name="hero_badge" value="{{ $data['hero_badge'] ?? '' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Judul Hero</label>
                                        <input type="text" class="form-control" name="hero_title" value="{{ $data['hero_title'] ?? '' }}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Deskripsi Hero</label>
                                        <textarea class="form-control" name="hero_description" rows="3">{{ $data['hero_description'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Chart Tab -->
                            <div class="tab-pane fade" id="tab-chart" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Upload Gambar Bagan Organisasi</label>
                                        <input type="file" class="form-control" name="chart_image_file" accept="image/*">
                                        <small class="text-muted">Format: JPG, PNG, JPEG. Max: 2MB.</small>
                                    </div>
                                    @if(!empty($data['chart_image']))
                                    <div class="col-md-12 mt-3">
                                        <label class="form-label">Gambar Saat Ini:</label>
                                        <div class="p-3 border rounded bg-light text-center">
                                            <img src="{{ asset($data['chart_image']) }}" alt="Bagan Organisasi" class="img-fluid" style="max-height: 300px;">
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Info Cards Tab -->
                            <div class="tab-pane fade" id="tab-info" role="tabpanel">
                                <h5 class="mb-3 text-primary">Kartu Informasi (4 Item)</h5>
                                <div class="row">
                                    @for($i = 0; $i < 4; $i++)
                                    <div class="col-md-6 mb-3">
                                        <div class="card bg-light border-0 p-3">
                                            <h6 class="fw-bold">Kartu #{{ $i + 1 }}</h6>
                                            <div class="mb-2">
                                                <label class="form-label small">Judul</label>
                                                <input type="text" class="form-control form-control-sm" name="info_cards[{{ $i }}][title]" value="{{ $data['info_cards'][$i]['title'] ?? '' }}">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small">Deskripsi</label>
                                                <textarea class="form-control form-control-sm" name="info_cards[{{ $i }}][desc]" rows="2">{{ $data['info_cards'][$i]['desc'] ?? '' }}</textarea>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small">Icon (FontAwesome)</label>
                                                <input type="text" class="form-control form-control-sm" name="info_cards[{{ $i }}][icon]" value="{{ $data['info_cards'][$i]['icon'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    @endfor
                                </div>
                            </div>

                            <!-- Content Tab -->
                            <div class="tab-pane fade" id="tab-main-content" role="tabpanel">
                                <div class="modern-form-group">
                                    <label for="main_content" class="modern-form-label">
                                        <i class="fa fa-edit me-2"></i>Konten Utama (Rich Editor)
                                    </label>
                                    <textarea id="main_content" class="modern-form-textarea" name="main_content" rows="20">{!! htmlspecialchars($data['main_content'] ?? '') !!}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modern-card-footer">
                        <button type="submit" class="modern-btn modern-btn-primary w-100">
                            <i class="fa fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <x-slot name="scripts">
        <script src="https://cdn.ckeditor.com/4.20.1/full/ckeditor.js"></script>
        <!-- https://codepolitan.com/blog/mengintegrasikan-ckeditor-di-laravel-5a1d04ac1f749 -->

        <script>
            // Wait for DOM to be ready
            document.addEventListener('DOMContentLoaded', function() {
                // Wait for CKEditor to load
                CKEDITOR.on('instanceReady', function(ev) {
                    console.log('CKEditor is ready');
                });

                var konten = document.getElementById("main_content");
                
                if (konten) {
                    CKEDITOR.replace(konten, {
                        height: '500',
                        language: 'id',
                        toolbar: 'Full',
                        filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token() ]) }}",
                        filebrowserUploadMethod: 'form',
                        allowedContent: true,
                        extraPlugins: 'justify,font,colorbutton,iframe',
                        removeDialogTabs: 'image:advanced;link:advanced',
                        versionCheck: false
                    });
                } else {
                    console.error("Textarea #main_content not found!");
                }

                // Refresh CKEditor when tab is shown
                var tabEl = document.querySelector('button[data-bs-target="#tab-main-content"]');
                if (tabEl) {
                    tabEl.addEventListener('shown.bs.tab', function (event) {
                        // Optional: Force resize if needed
                    });
                }
            });
        </script>
    </x-slot>
</x-admin-layout>