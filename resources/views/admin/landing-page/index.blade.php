<x-admin-layout>
    <x-slot name="header">
        {{ __('Kelola Landing Page') }}
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show modern-card" role="alert" style="margin-bottom: 1.5rem; border-left: 4px solid #10b981;">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="modern-card fade-in-up">
                <div class="modern-card-header d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><i class="fa fa-globe me-2"></i>Konfigurasi Landing Page</h4>
                </div>
                <form id="landingPageForm" action="{{ route('admin.landing-page.update', 1) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modern-card-body">
                            <!-- Modern Tabs -->
                            <ul class="nav nav-tabs modern-nav-tabs mb-4" id="landingPageTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="hero-tab" data-bs-toggle="tab" data-bs-target="#hero" type="button" role="tab" aria-controls="hero" aria-selected="true">
                                        <i class="fa fa-image me-2"></i>Hero Section
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="features-tab" data-bs-toggle="tab" data-bs-target="#features" type="button" role="tab" aria-controls="features" aria-selected="false">
                                        <i class="fa fa-star me-2"></i>Features
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button" role="tab" aria-controls="about" aria-selected="false">
                                        <i class="fa fa-info-circle me-2"></i>About
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="services-tab" data-bs-toggle="tab" data-bs-target="#services" type="button" role="tab" aria-controls="services" aria-selected="false">
                                        <i class="fa fa-cogs me-2"></i>Services
                                    </button>
                                </li>
                            </ul>
                            
                            <div class="tab-content" id="landingPageTabContent">
                                <!-- Hero Section -->
                                <div class="tab-pane fade show active" id="hero" role="tabpanel" aria-labelledby="hero-tab">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label"><i class="fa fa-heading me-2"></i>Title Prefix</label>
                                        <input type="text" class="modern-form-input" name="title_prefix" value="{{ $contents['title_prefix'] ?? 'Lembaga Penelitian &' }}">
                                    </div>
                                    <div class="modern-form-group">
                                        <label class="modern-form-label"><i class="fa fa-heading me-2"></i>Title Suffix</label>
                                        <input type="text" class="modern-form-input" name="title_suffix" value="{{ $contents['title_suffix'] ?? 'Pengabdian Kepada Masyarakat' }}">
                                    </div>
                                    <div class="modern-form-group">
                                        <label class="modern-form-label"><i class="fa fa-align-left me-2"></i>Description</label>
                                        <textarea class="modern-form-textarea" name="hero_description" rows="3">{{ $contents['hero_description'] ?? 'Mengembangkan potensi akademik melalui penelitian bermutu dan pengabdian yang berdampak nyata bagi masyarakat luas.' }}</textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="modern-form-group">
                                                <label class="modern-form-label"><i class="fa fa-mouse-pointer me-2"></i>Button Text</label>
                                                <input type="text" class="modern-form-input" name="button_text" value="{{ $contents['button_text'] ?? 'Jelajahi Layanan' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="modern-form-group">
                                                <label class="modern-form-label"><i class="fa fa-link me-2"></i>Button URL</label>
                                                <input type="text" class="modern-form-input" name="button_url" value="{{ $contents['button_url'] ?? '#layanan' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="modern-form-group">
                                                <label class="modern-form-label"><i class="fa fa-mouse-pointer me-2"></i>Secondary Button Text</label>
                                                <input type="text" class="modern-form-input" name="secondary_button_text" value="{{ $contents['secondary_button_text'] ?? 'Pelajari Lebih Lanjut' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="modern-form-group">
                                                <label class="modern-form-label"><i class="fa fa-link me-2"></i>Secondary Button URL</label>
                                                <input type="text" class="modern-form-input" name="secondary_button_url" value="{{ $contents['secondary_button_url'] ?? '#tentang' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <h5 class="mb-3 text-primary"><i class="fa fa-images me-2"></i>Background Slides (Max 5)</h5>
                                    <div class="row">
                                        @for($i = 1; $i <= 5; $i++)
                                            <div class="col-md-4">
                                                <div class="modern-form-group">
                                                    <label class="modern-form-label">Slide {{ $i }}</label>
                                                    <input type="file" class="modern-form-input mb-2" name="hero_slide_{{ $i }}" accept="image/*">
                                                    @if(isset($contents["hero_slide_$i"]))
                                                        <div class="mb-2">
                                                            <img src="{{ asset('storage/' . $contents["hero_slide_$i"]) }}" class="img-thumbnail" style="height: 80px; border-radius: 8px; border: 2px solid var(--border-color);">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                    <hr class="my-4">
                                    <h5 class="mb-3 text-primary"><i class="fa fa-chart-bar me-2"></i>Stats</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="modern-form-group">
                                                <label class="modern-form-label">Stat 1 Value</label>
                                                <input type="text" class="modern-form-input" name="stat_1_value" value="{{ $contents['stat_1_value'] ?? '150' }}">
                                                <label class="modern-form-label mt-3">Stat 1 Label</label>
                                                <input type="text" class="modern-form-input" name="stat_1_label" value="{{ $contents['stat_1_label'] ?? 'Penelitian' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="modern-form-group">
                                                <label class="modern-form-label">Stat 2 Value</label>
                                                <input type="text" class="modern-form-input" name="stat_2_value" value="{{ $contents['stat_2_value'] ?? '85' }}">
                                                <label class="modern-form-label mt-3">Stat 2 Label</label>
                                                <input type="text" class="modern-form-input" name="stat_2_label" value="{{ $contents['stat_2_label'] ?? 'Pengabdian' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="modern-form-group">
                                                <label class="modern-form-label">Stat 3 Value</label>
                                                <input type="text" class="modern-form-input" name="stat_3_value" value="{{ $contents['stat_3_value'] ?? '50' }}">
                                                <label class="modern-form-label mt-3">Stat 3 Label</label>
                                                <input type="text" class="modern-form-input" name="stat_3_label" value="{{ $contents['stat_3_label'] ?? 'Dosen Aktif' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Features Section -->
                                <div class="tab-pane fade" id="features" role="tabpanel" aria-labelledby="features-tab">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label"><i class="fa fa-tag me-2"></i>Subtitle</label>
                                        <input type="text" class="modern-form-input" name="features_subtitle" value="{{ $contents['features_subtitle'] ?? 'Keunggulan Kami' }}">
                                    </div>
                                    <div class="modern-form-group">
                                        <label class="modern-form-label"><i class="fa fa-heading me-2"></i>Title</label>
                                        <input type="text" class="modern-form-input" name="features_title" value="{{ $contents['features_title'] ?? 'Ekosistem Riset Futuristik' }}">
                                    </div>
                                    <div class="modern-form-group">
                                        <label class="modern-form-label"><i class="fa fa-align-left me-2"></i>Description</label>
                                        <textarea class="modern-form-textarea" name="features_description" rows="3">{{ $contents['features_description'] ?? 'Menyatukan pengetahuan, teknologi, dan kolaborasi lintas disiplin untuk menghasilkan inovasi berdampak besar.' }}</textarea>
                                    </div>
                                    <hr class="my-4">
                                    <h5 class="mb-3 text-primary"><i class="fa fa-list me-2"></i>Feature Points (Left Column)</h5>
                                    <div class="modern-form-group">
                                        <input type="text" class="modern-form-input mb-2" name="feature_point_1" value="{{ $contents['feature_point_1'] ?? 'Pendampingan personal dari tim riset.' }}" placeholder="Feature point 1">
                                        <input type="text" class="modern-form-input mb-2" name="feature_point_2" value="{{ $contents['feature_point_2'] ?? 'Integrasi platform digital monitoring.' }}" placeholder="Feature point 2">
                                        <input type="text" class="modern-form-input mb-2" name="feature_point_3" value="{{ $contents['feature_point_3'] ?? 'Jejaring mitra nasional & global.' }}" placeholder="Feature point 3">
                                    </div>
                                    <hr class="my-4">
                                    <h5 class="mb-3 text-primary"><i class="fa fa-th me-2"></i>Bento Grid Cards</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="modern-card mb-3" style="border: 2px dashed var(--border-color);">
                                                <div class="modern-card-body">
                                                    <h6 class="text-primary mb-3"><i class="fa fa-square me-2"></i>Card 1 (Large)</h6>
                                                    <div class="modern-form-group">
                                                        <label class="modern-form-label">Title</label>
                                                        <input type="text" class="modern-form-input mb-2" name="feature_1_title" value="{{ $contents['feature_1_title'] ?? 'Riset Berkualitas' }}">
                                                        <label class="modern-form-label">Description</label>
                                                        <input type="text" class="modern-form-input" name="feature_1_desc" value="{{ $contents['feature_1_desc'] ?? 'Kurasi roadmap, akses laboratorium, dan coaching intensif.' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="modern-card mb-3" style="border: 2px dashed var(--border-color);">
                                                <div class="modern-card-body">
                                                    <h6 class="text-primary mb-3"><i class="fa fa-square me-2"></i>Card 2</h6>
                                                    <div class="modern-form-group">
                                                        <label class="modern-form-label">Title</label>
                                                        <input type="text" class="modern-form-input mb-2" name="feature_2_title" value="{{ $contents['feature_2_title'] ?? 'Pengabdian' }}">
                                                        <label class="modern-form-label">Description</label>
                                                        <input type="text" class="modern-form-input" name="feature_2_desc" value="{{ $contents['feature_2_desc'] ?? 'Sinkronisasi isu prioritas & dashboard impact.' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="modern-card mb-3" style="border: 2px dashed var(--border-color);">
                                                <div class="modern-card-body">
                                                    <h6 class="text-primary mb-3"><i class="fa fa-square me-2"></i>Card 3</h6>
                                                    <div class="modern-form-group">
                                                        <label class="modern-form-label">Title</label>
                                                        <input type="text" class="modern-form-input mb-2" name="feature_3_title" value="{{ $contents['feature_3_title'] ?? 'Publikasi' }}">
                                                        <label class="modern-form-label">Description</label>
                                                        <input type="text" class="modern-form-input" name="feature_3_desc" value="{{ $contents['feature_3_desc'] ?? 'Klinik penulisan & cost sharing jurnal.' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="modern-card mb-3" style="border: 2px dashed var(--border-color);">
                                                <div class="modern-card-body">
                                                    <h6 class="text-primary mb-3"><i class="fa fa-square me-2"></i>Card 4 (Wide)</h6>
                                                    <div class="modern-form-group">
                                                        <label class="modern-form-label">Title</label>
                                                        <input type="text" class="modern-form-input mb-2" name="feature_4_title" value="{{ $contents['feature_4_title'] ?? 'Insight & Analytics' }}">
                                                        <label class="modern-form-label">Description</label>
                                                        <input type="text" class="modern-form-input" name="feature_4_desc" value="{{ $contents['feature_4_desc'] ?? 'Panel data adaptif timeline & progres review.' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- About Section -->
                                <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label"><i class="fa fa-tag me-2"></i>Subtitle</label>
                                        <input type="text" class="modern-form-input" name="about_subtitle" value="{{ $contents['about_subtitle'] ?? 'Tentang Kami' }}">
                                    </div>
                                    <div class="modern-form-group">
                                        <label class="modern-form-label"><i class="fa fa-heading me-2"></i>Title</label>
                                        <input type="text" class="modern-form-input" name="about_title" value="{{ $contents['about_title'] ?? 'Mewujudkan Visi Melalui Riset Unggulan' }}">
                                    </div>
                                    <div class="modern-form-group">
                                        <label class="modern-form-label"><i class="fa fa-align-left me-2"></i>Description</label>
                                        <textarea class="modern-form-textarea" name="about_description" rows="3">{{ $contents['about_description'] ?? 'LPPM hadir sebagai katalis inovasi institusional dengan tata kelola adaptif, data-driven decision, dan dukungan talenta lintas bidang.' }}</textarea>
                                    </div>
                                    <div class="modern-form-group">
                                        <label class="modern-form-label"><i class="fa fa-image me-2"></i>About Image</label>
                                        <input type="file" class="modern-form-input mb-2" name="about_image" accept="image/*">
                                        @if(isset($contents['about_image']))
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $contents['about_image']) }}" class="img-thumbnail" style="height: 150px; border-radius: 8px; border: 2px solid var(--border-color);">
                                            </div>
                                        @endif
                                    </div>
                                    <hr class="my-4">
                                    <h5 class="mb-3 text-primary"><i class="fa fa-columns me-2"></i>Pillars</h5>
                                    <div class="modern-form-group">
                                        <label class="modern-form-label">Point 1 Title</label>
                                        <input type="text" class="modern-form-input mb-2" name="about_point_1" value="{{ $contents['about_point_1'] ?? 'Manajemen Riset Terintegrasi' }}">
                                        <label class="modern-form-label">Point 2 Title</label>
                                        <input type="text" class="modern-form-input mb-2" name="about_point_2" value="{{ $contents['about_point_2'] ?? 'Kolaborasi Multi-Disiplin' }}">
                                        <label class="modern-form-label">Point 3 Title</label>
                                        <input type="text" class="modern-form-input mb-2" name="about_point_3" value="{{ $contents['about_point_3'] ?? 'Hilirisasi Hasil Inovasi' }}">
                                    </div>
                                </div>

                                <!-- Services Section -->
                                <div class="tab-pane fade" id="services" role="tabpanel" aria-labelledby="services-tab">
                                    <div class="modern-form-group">
                                        <label class="modern-form-label"><i class="fa fa-tag me-2"></i>Subtitle</label>
                                        <input type="text" class="modern-form-input" name="services_subtitle" value="{{ $contents['services_subtitle'] ?? 'Layanan Akademik' }}">
                                    </div>
                                    <div class="modern-form-group">
                                        <label class="modern-form-label"><i class="fa fa-heading me-2"></i>Title</label>
                                        <input type="text" class="modern-form-input" name="services_title" value="{{ $contents['services_title'] ?? 'Pendampingan Menyeluruh' }}">
                                    </div>
                                    <hr class="my-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="modern-card mb-3" style="border: 2px dashed var(--border-color);">
                                                <div class="modern-card-body">
                                                    <h6 class="text-primary mb-3"><i class="fa fa-cog me-2"></i>Service 1</h6>
                                                    <div class="modern-form-group">
                                                        <label class="modern-form-label">Title</label>
                                                        <input type="text" class="modern-form-input mb-2" name="service_1_title" value="{{ $contents['service_1_title'] ?? 'Agenda Kegiatan' }}">
                                                        <label class="modern-form-label">Description</label>
                                                        <textarea class="modern-form-textarea" name="service_1_desc" rows="2">{{ $contents['service_1_desc'] ?? 'Kurasi event ilmiah, integrasi kalender pribadi, dan fitur reminder otomatis.' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="modern-card mb-3" style="border: 2px dashed var(--border-color);">
                                                <div class="modern-card-body">
                                                    <h6 class="text-primary mb-3"><i class="fa fa-cog me-2"></i>Service 2</h6>
                                                    <div class="modern-form-group">
                                                        <label class="modern-form-label">Title</label>
                                                        <input type="text" class="modern-form-input mb-2" name="service_2_title" value="{{ $contents['service_2_title'] ?? 'Pengumuman' }}">
                                                        <label class="modern-form-label">Description</label>
                                                        <textarea class="modern-form-textarea" name="service_2_desc" rows="2">{{ $contents['service_2_desc'] ?? 'Dashboard notifikasi adaptif untuk hibah, ketentuan baru, dan jadwal penting.' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="modern-card mb-3" style="border: 2px dashed var(--border-color);">
                                                <div class="modern-card-body">
                                                    <h6 class="text-primary mb-3"><i class="fa fa-cog me-2"></i>Service 3</h6>
                                                    <div class="modern-form-group">
                                                        <label class="modern-form-label">Title</label>
                                                        <input type="text" class="modern-form-input mb-2" name="service_3_title" value="{{ $contents['service_3_title'] ?? 'Dokumen' }}">
                                                        <label class="modern-form-label">Description</label>
                                                        <textarea class="modern-form-textarea" name="service_3_desc" rows="2">{{ $contents['service_3_desc'] ?? 'Repositori format resmi, template, dan panduan terbaru dengan versi terkontrol.' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

        /* Image thumbnail styling */
        .img-thumbnail {
            transition: transform 0.2s ease;
        }

        .img-thumbnail:hover {
            transform: scale(1.05);
        }

        /* Remove bottom margin/padding from card-body to make footer flush */
        #landingPageForm .modern-card-body {
            padding-bottom: 0;
            margin-bottom: 0;
        }

        #landingPageForm .tab-content {
            margin-bottom: 0;
            padding-bottom: 0;
        }
    </style>
</x-admin-layout>
