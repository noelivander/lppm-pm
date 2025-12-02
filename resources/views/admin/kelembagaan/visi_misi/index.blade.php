<x-admin-layout>
    <x-slot name="header">
        {{ __('Visi Misi') }}
    </x-slot>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show modern-card" role="alert" style="margin-bottom: 1.5rem; border-left: 4px solid #10b981;">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <!-- Edit Form -->
            <form class="form-horizontal" method="POST" action="{{ route('visi-misi.store') }}">
                {{ csrf_field() }}
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-header d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="fa fa-bullseye me-2"></i>Visi Misi</h4>
                    </div>
                    <div class="modern-card-body">
                            <!-- Modern Tabs -->
                            <ul class="nav nav-tabs modern-nav-tabs mb-4" id="visiMisiTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="hero-tab" data-bs-toggle="tab" data-bs-target="#tab-hero" type="button" role="tab">
                                        <i class="fas fa-image me-2"></i>Hero Section
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="hero-cards-tab" data-bs-toggle="tab" data-bs-target="#tab-hero-cards" type="button" role="tab">
                                        <i class="fas fa-th-large me-2"></i>Hero Cards
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="values-tab" data-bs-toggle="tab" data-bs-target="#tab-values" type="button" role="tab">
                                        <i class="fas fa-star me-2"></i>Value Cards
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="content-tab" data-bs-toggle="tab" data-bs-target="#tab-main-content" type="button" role="tab">
                                        <i class="fas fa-file-alt me-2"></i>Konten Utama
                                    </button>
                                </li>
                            </ul>
                            
                            <div class="tab-content" id="visiMisiTabsContent">
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
                                    </div>
                                </div>

                                <!-- Hero Cards Tab -->
                                <div class="tab-pane fade" id="tab-hero-cards" role="tabpanel">
                                    <h5 class="mb-3 text-primary"><i class="fa fa-th-large me-2"></i>Kartu Hero (3 Item)</h5>
                                    <div class="row">
                                        @for($i = 0; $i < 3; $i++)
                                        <div class="col-md-4">
                                            <div class="modern-card mb-3" style="border: 2px dashed var(--border-color);">
                                                <div class="modern-card-body">
                                                    <h6 class="text-primary mb-3"><i class="fa fa-square me-2"></i>Kartu #{{ $i + 1 }}</h6>
                                                    <div class="modern-form-group">
                                                        <label class="modern-form-label">Judul</label>
                                                        <input type="text" class="modern-form-input mb-2" name="hero_cards[{{ $i }}][title]" value="{{ $data['hero_cards'][$i]['title'] ?? '' }}" placeholder="Judul kartu">
                                                    </div>
                                                    <div class="modern-form-group">
                                                        <label class="modern-form-label">Sub-judul</label>
                                                        <input type="text" class="modern-form-input mb-2" name="hero_cards[{{ $i }}][subtitle]" value="{{ $data['hero_cards'][$i]['subtitle'] ?? '' }}" placeholder="Sub-judul kartu">
                                                    </div>
                                                    <div class="modern-form-group">
                                                        <label class="modern-form-label">Icon (FontAwesome)</label>
                                                        <input type="text" class="modern-form-input" name="hero_cards[{{ $i }}][icon]" value="{{ $data['hero_cards'][$i]['icon'] ?? '' }}" placeholder="fa fa-icon">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endfor
                                    </div>
                                </div>

                                <!-- Value Cards Tab -->
                                <div class="tab-pane fade" id="tab-values" role="tabpanel">
                                    <h5 class="mb-3 text-primary"><i class="fa fa-star me-2"></i>Kartu Nilai (4 Item)</h5>
                                    <div class="row">
                                        @for($i = 0; $i < 4; $i++)
                                        <div class="col-md-6">
                                            <div class="modern-card mb-3" style="border: 2px dashed var(--border-color);">
                                                <div class="modern-card-body">
                                                    <h6 class="text-primary mb-3"><i class="fa fa-gem me-2"></i>Nilai #{{ $i + 1 }}</h6>
                                                    <div class="modern-form-group">
                                                        <label class="modern-form-label">Judul</label>
                                                        <input type="text" class="modern-form-input mb-2" name="value_cards[{{ $i }}][title]" value="{{ $data['value_cards'][$i]['title'] ?? '' }}" placeholder="Judul nilai">
                                                    </div>
                                                    <div class="modern-form-group">
                                                        <label class="modern-form-label">Deskripsi</label>
                                                        <textarea class="modern-form-textarea" name="value_cards[{{ $i }}][desc]" rows="2" placeholder="Deskripsi nilai">{{ $data['value_cards'][$i]['desc'] ?? '' }}</textarea>
                                                    </div>
                                                    <div class="modern-form-group">
                                                        <label class="modern-form-label">Icon (FontAwesome)</label>
                                                        <input type="text" class="modern-form-input" name="value_cards[{{ $i }}][icon]" value="{{ $data['value_cards'][$i]['icon'] ?? '' }}" placeholder="fa fa-icon">
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
        <!-- https://codepolitan.com/blog/mengintegrasikan-ckeditor-di-laravel-5a1d04ac1f749 -->

        <script>
            // Wait for DOM to be ready
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
