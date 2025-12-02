<x-admin-layout>
    <x-slot name="title">
        {{ __('Tentang Satker LPPM-PM') }}
    </x-slot>
    <x-slot name="header">
        {{ __('Tentang Satker LPPM-PM') }}
    </x-slot>

    <x-admin.heading name="Tentang Satker LPPM-PM">
    </x-admin.heading>

    <div class="row">
        <div class="col-lg-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form class="form-horizontal" method="POST" action="{{ route('tentang-satker.store') }}">
                {{ csrf_field() }}
                
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="aboutTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="hero-tab" data-bs-toggle="tab" data-bs-target="#tab-hero" type="button" role="tab">
                                    <i class="fas fa-image me-2"></i>Hero Section
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="stats-tab" data-bs-toggle="tab" data-bs-target="#tab-stats" type="button" role="tab">
                                    <i class="fas fa-chart-bar me-2"></i>Stats & Features
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
                        <div class="tab-content" id="aboutTabsContent">
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
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tahun Berdiri</label>
                                        <input type="text" class="form-control" name="founded_year" value="{{ $data['founded_year'] ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Stats & Features Tab -->
                            <div class="tab-pane fade" id="tab-stats" role="tabpanel">
                                <h5 class="mb-3 text-primary">Statistik (3 Item)</h5>
                                <div class="row">
                                    @for($i = 0; $i < 3; $i++)
                                    <div class="col-md-4 mb-3">
                                        <div class="card bg-light border-0 p-3">
                                            <h6 class="fw-bold">Statistik #{{ $i + 1 }}</h6>
                                            <div class="mb-2">
                                                <label class="form-label small">Icon (FontAwesome)</label>
                                                <input type="text" class="form-control form-control-sm" name="stats[{{ $i }}][icon]" value="{{ $data['stats'][$i]['icon'] ?? '' }}">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small">Label</label>
                                                <input type="text" class="form-control form-control-sm" name="stats[{{ $i }}][value]" value="{{ $data['stats'][$i]['value'] ?? '' }}">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small">Warna Hex</label>
                                                <input type="text" class="form-control form-control-sm" name="stats[{{ $i }}][color]" value="{{ $data['stats'][$i]['color'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    @endfor
                                </div>

                                <hr class="my-4">

                                <h5 class="mb-3 text-primary">Fitur Unggulan (3 Item)</h5>
                                <div class="row">
                                    @for($i = 0; $i < 3; $i++)
                                    <div class="col-md-4 mb-3">
                                        <div class="card bg-light border-0 p-3">
                                            <h6 class="fw-bold">Fitur #{{ $i + 1 }}</h6>
                                            <div class="mb-2">
                                                <label class="form-label small">Judul</label>
                                                <input type="text" class="form-control form-control-sm" name="features[{{ $i }}][title]" value="{{ $data['features'][$i]['title'] ?? '' }}">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small">Deskripsi</label>
                                                <textarea class="form-control form-control-sm" name="features[{{ $i }}][desc]" rows="2">{{ $data['features'][$i]['desc'] ?? '' }}</textarea>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small">Icon</label>
                                                <input type="text" class="form-control form-control-sm" name="features[{{ $i }}][icon]" value="{{ $data['features'][$i]['icon'] ?? '' }}">
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
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
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
                
                // Refresh CKEditor when tab is shown (fixes visibility issues in tabs)
                var tabEl = document.querySelector('button[data-bs-target="#tab-main-content"]');
                if (tabEl) {
                    tabEl.addEventListener('shown.bs.tab', function (event) {
                        // Optional: Force resize if needed, though CKEditor 4 usually handles it
                    });
                }
            });
        </script>
    </x-slot>
</x-admin-layout>
