<x-admin-layout>
    <x-slot name="title">
        {{ __('Tentang Satker LPPM-PM') }}
    </x-slot>
    <x-slot name="header">
        {{ __('Tentang Satker LPPM-PM') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-lg-12">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show modern-card" role="alert" style="margin-bottom: 1.5rem; border-left: 4px solid #10b981;">
                        <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form class="form-horizontal" method="POST" action="{{ route('tentang-satker.store') }}">
                    {{ csrf_field() }}
                    
                    <div class="modern-card mb-4 fade-in-up">
                        <div class="modern-card-header d-flex align-items-center justify-content-between">
                            <h4 class="mb-0"><i class="fa fa-info-circle me-2"></i>Tentang Satker LPPM-PM</h4>
                        </div>
                        <div class="modern-card-body">
                            <!-- Modern Tabs -->
                            <ul class="nav nav-tabs modern-nav-tabs mb-4" id="aboutTabs" role="tablist">
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
                            
                            <div class="tab-content" id="aboutTabsContent">
                                <!-- Hero Tab -->
                                <div class="tab-pane fade show active" id="tab-hero" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="modern-form-group">
                                                <label class="modern-form-label"><i class="fa fa-tag me-2"></i>Badge Hero</label>
                                                <input type="text" class="modern-form-input" name="hero_badge" value="{{ $data['hero_badge'] ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="modern-form-group">
                                                <label class="modern-form-label"><i class="fa fa-heading me-2"></i>Judul Hero</label>
                                                <input type="text" class="modern-form-input" name="hero_title" value="{{ $data['hero_title'] ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="modern-form-group">
                                                <label class="modern-form-label"><i class="fa fa-align-left me-2"></i>Deskripsi Hero</label>
                                                <textarea class="modern-form-textarea" name="hero_description" rows="3">{{ $data['hero_description'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="modern-form-group">
                                                <label class="modern-form-label"><i class="fa fa-calendar me-2"></i>Tahun Berdiri</label>
                                                <input type="text" class="modern-form-input" name="founded_year" value="{{ $data['founded_year'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stats & Features Tab -->
                                <div class="tab-pane fade" id="tab-stats" role="tabpanel">
                                    <h5 class="mb-3 text-primary"><i class="fa fa-chart-bar me-2"></i>Statistik (3 Item)</h5>
                                    <div class="row">
                                        @for($i = 0; $i < 3; $i++)
                                        <div class="col-md-4">
                                            <div class="modern-card mb-3" style="border: 2px dashed var(--border-color);">
                                                <div class="modern-card-body">
                                                    <h6 class="text-primary mb-3"><i class="fa fa-chart-line me-2"></i>Statistik #{{ $i + 1 }}</h6>
                                                    <div class="modern-form-group">
                                                        <label class="modern-form-label">Icon (FontAwesome)</label>
                                                        <input type="text" class="modern-form-input mb-2" name="stats[{{ $i }}][icon]" value="{{ $data['stats'][$i]['icon'] ?? '' }}" placeholder="fa fa-icon">
                                                    </div>
                                                    <div class="modern-form-group">
                                                        <label class="modern-form-label">Label</label>
                                                        <input type="text" class="modern-form-input mb-2" name="stats[{{ $i }}][value]" value="{{ $data['stats'][$i]['value'] ?? '' }}" placeholder="Nilai statistik">
                                                    </div>
                                                    <div class="modern-form-group">
                                                        <label class="modern-form-label">Warna Hex</label>
                                                        <input type="text" class="modern-form-input" name="stats[{{ $i }}][color]" value="{{ $data['stats'][$i]['color'] ?? '' }}" placeholder="#7c3aed">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endfor
                                    </div>

                                    <hr class="my-4">

                                    <h5 class="mb-3 text-primary"><i class="fa fa-star me-2"></i>Fitur Unggulan (3 Item)</h5>
                                    <div class="row">
                                        @for($i = 0; $i < 3; $i++)
                                        <div class="col-md-4">
                                            <div class="modern-card mb-3" style="border: 2px dashed var(--border-color);">
                                                <div class="modern-card-body">
                                                    <h6 class="text-primary mb-3"><i class="fa fa-lightbulb me-2"></i>Fitur #{{ $i + 1 }}</h6>
                                                    <div class="modern-form-group">
                                                        <label class="modern-form-label">Judul</label>
                                                        <input type="text" class="modern-form-input mb-2" name="features[{{ $i }}][title]" value="{{ $data['features'][$i]['title'] ?? '' }}" placeholder="Judul fitur">
                                                    </div>
                                                    <div class="modern-form-group">
                                                        <label class="modern-form-label">Deskripsi</label>
                                                        <textarea class="modern-form-textarea" name="features[{{ $i }}][desc]" rows="2" placeholder="Deskripsi fitur">{{ $data['features'][$i]['desc'] ?? '' }}</textarea>
                                                    </div>
                                                    <div class="modern-form-group">
                                                        <label class="modern-form-label">Icon</label>
                                                        <input type="text" class="modern-form-input" name="features[{{ $i }}][icon]" value="{{ $data['features'][$i]['icon'] ?? '' }}" placeholder="fa fa-icon">
                                                    </div>
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
                        
                        <div class="modern-card-footer d-flex gap-2 justify-content-end">
                            <button type="submit" class="modern-btn modern-btn-success">
                                <i class="fa fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        /* Modern Tabs Styling */
        .modern-nav-tabs {
            border-bottom: 2px solid var(--border-color);
            padding: 0;
        }

        .modern-nav-tabs .nav-item {
            margin-bottom: -2px;
        }

        .modern-nav-tabs .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            padding: 0.875rem 1.5rem;
            color: var(--text-secondary);
            font-weight: 500;
            transition: all 0.3s ease;
            background: transparent;
            border-radius: 0;
        }

        .modern-nav-tabs .nav-link:hover {
            color: var(--primary-color);
            background: rgba(79, 70, 229, 0.05);
            border-bottom-color: rgba(79, 70, 229, 0.3);
        }

        .modern-nav-tabs .nav-link.active {
            color: var(--primary-color);
            background: rgba(79, 70, 229, 0.08);
            border-bottom-color: var(--primary-color);
            font-weight: 600;
        }

        .modern-nav-tabs .nav-link i {
            font-size: 0.875rem;
        }

        /* Fade in animation */
        .fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

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
