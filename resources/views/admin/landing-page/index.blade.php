<x-admin-layout>
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Kelola Landing Page</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Konfigurasi Landing Page</h6>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="landingPageTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="hero-tab" data-bs-toggle="tab" data-bs-target="#hero" type="button" role="tab" aria-controls="hero" aria-selected="true">Hero Section</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="features-tab" data-bs-toggle="tab" data-bs-target="#features" type="button" role="tab" aria-controls="features" aria-selected="false">Features</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button" role="tab" aria-controls="about" aria-selected="false">About</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="services-tab" data-bs-toggle="tab" data-bs-target="#services" type="button" role="tab" aria-controls="services" aria-selected="false">Services</button>
                    </li>
                </ul>
                
                <form action="{{ route('admin.landing-page.update', 1) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                    @csrf
                    @method('PUT')
                    
                    <div class="tab-content" id="landingPageTabContent">
                        <!-- Hero Section -->
                        <div class="tab-pane fade show active" id="hero" role="tabpanel" aria-labelledby="hero-tab">
                            <div class="mb-3">
                                <label class="form-label">Title Prefix</label>
                                <input type="text" class="form-control" name="title_prefix" value="{{ $contents['title_prefix'] ?? 'Lembaga Penelitian &' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Title Suffix</label>
                                <input type="text" class="form-control" name="title_suffix" value="{{ $contents['title_suffix'] ?? 'Pengabdian Kepada Masyarakat' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="hero_description" rows="3">{{ $contents['hero_description'] ?? 'Mengembangkan potensi akademik melalui penelitian bermutu dan pengabdian yang berdampak nyata bagi masyarakat luas.' }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Button Text</label>
                                    <input type="text" class="form-control" name="button_text" value="{{ $contents['button_text'] ?? 'Jelajahi Layanan' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Button URL</label>
                                    <input type="text" class="form-control" name="button_url" value="{{ $contents['button_url'] ?? '#layanan' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Secondary Button Text</label>
                                    <input type="text" class="form-control" name="secondary_button_text" value="{{ $contents['secondary_button_text'] ?? 'Pelajari Lebih Lanjut' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Secondary Button URL</label>
                                    <input type="text" class="form-control" name="secondary_button_url" value="{{ $contents['secondary_button_url'] ?? '#tentang' }}">
                                </div>
                            </div>
                            <hr>
                            <h5>Background Slides (Max 5)</h5>
                            <div class="row">
                                @for($i = 1; $i <= 5; $i++)
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Slide {{ $i }}</label>
                                        <input type="file" class="form-control mb-2" name="hero_slide_{{ $i }}">
                                        @if(isset($contents["hero_slide_$i"]))
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $contents["hero_slide_$i"]) }}" class="img-thumbnail" style="height: 80px;">
                                            </div>
                                        @endif
                                    </div>
                                @endfor
                            </div>
                            <hr>
                            <h5>Stats</h5>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Stat 1 Value</label>
                                    <input type="text" class="form-control" name="stat_1_value" value="{{ $contents['stat_1_value'] ?? '150' }}">
                                    <label class="form-label mt-2">Stat 1 Label</label>
                                    <input type="text" class="form-control" name="stat_1_label" value="{{ $contents['stat_1_label'] ?? 'Penelitian' }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Stat 2 Value</label>
                                    <input type="text" class="form-control" name="stat_2_value" value="{{ $contents['stat_2_value'] ?? '85' }}">
                                    <label class="form-label mt-2">Stat 2 Label</label>
                                    <input type="text" class="form-control" name="stat_2_label" value="{{ $contents['stat_2_label'] ?? 'Pengabdian' }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Stat 3 Value</label>
                                    <input type="text" class="form-control" name="stat_3_value" value="{{ $contents['stat_3_value'] ?? '50' }}">
                                    <label class="form-label mt-2">Stat 3 Label</label>
                                    <input type="text" class="form-control" name="stat_3_label" value="{{ $contents['stat_3_label'] ?? 'Dosen Aktif' }}">
                                </div>
                            </div>
                        </div>

                        <!-- Features Section -->
                        <div class="tab-pane fade" id="features" role="tabpanel" aria-labelledby="features-tab">
                            <div class="mb-3">
                                <label class="form-label">Subtitle</label>
                                <input type="text" class="form-control" name="features_subtitle" value="{{ $contents['features_subtitle'] ?? 'Keunggulan Kami' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="features_title" value="{{ $contents['features_title'] ?? 'Ekosistem Riset Futuristik' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="features_description" rows="3">{{ $contents['features_description'] ?? 'Menyatukan pengetahuan, teknologi, dan kolaborasi lintas disiplin untuk menghasilkan inovasi berdampak besar.' }}</textarea>
                            </div>
                            <hr>
                            <h5>Feature Points (Left Column)</h5>
                            <div class="mb-3">
                                <input type="text" class="form-control mb-2" name="feature_point_1" value="{{ $contents['feature_point_1'] ?? 'Pendampingan personal dari tim riset.' }}">
                                <input type="text" class="form-control mb-2" name="feature_point_2" value="{{ $contents['feature_point_2'] ?? 'Integrasi platform digital monitoring.' }}">
                                <input type="text" class="form-control mb-2" name="feature_point_3" value="{{ $contents['feature_point_3'] ?? 'Jejaring mitra nasional & global.' }}">
                            </div>
                            <hr>
                            <h5>Bento Grid Cards</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6>Card 1 (Large)</h6>
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control mb-2" name="feature_1_title" value="{{ $contents['feature_1_title'] ?? 'Riset Berkualitas' }}">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" name="feature_1_desc" value="{{ $contents['feature_1_desc'] ?? 'Kurasi roadmap, akses laboratorium, dan coaching intensif.' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6>Card 2</h6>
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control mb-2" name="feature_2_title" value="{{ $contents['feature_2_title'] ?? 'Pengabdian' }}">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" name="feature_2_desc" value="{{ $contents['feature_2_desc'] ?? 'Sinkronisasi isu prioritas & dashboard impact.' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6>Card 3</h6>
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control mb-2" name="feature_3_title" value="{{ $contents['feature_3_title'] ?? 'Publikasi' }}">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" name="feature_3_desc" value="{{ $contents['feature_3_desc'] ?? 'Klinik penulisan & cost sharing jurnal.' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6>Card 4 (Wide)</h6>
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control mb-2" name="feature_4_title" value="{{ $contents['feature_4_title'] ?? 'Insight & Analytics' }}">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" name="feature_4_desc" value="{{ $contents['feature_4_desc'] ?? 'Panel data adaptif timeline & progres review.' }}">
                                </div>
                            </div>
                        </div>

                        <!-- About Section -->
                        <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">
                            <div class="mb-3">
                                <label class="form-label">Subtitle</label>
                                <input type="text" class="form-control" name="about_subtitle" value="{{ $contents['about_subtitle'] ?? 'Tentang Kami' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="about_title" value="{{ $contents['about_title'] ?? 'Mewujudkan Visi Melalui Riset Unggulan' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="about_description" rows="3">{{ $contents['about_description'] ?? 'LPPM hadir sebagai katalis inovasi institusional dengan tata kelola adaptif, data-driven decision, dan dukungan talenta lintas bidang.' }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">About Image</label>
                                <input type="file" class="form-control mb-2" name="about_image">
                                @if(isset($contents['about_image']))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $contents['about_image']) }}" class="img-thumbnail" style="height: 150px;">
                                    </div>
                                @endif
                            </div>
                            <hr>
                            <h5>Pillars</h5>
                            <div class="mb-3">
                                <label class="form-label">Point 1 Title</label>
                                <input type="text" class="form-control mb-2" name="about_point_1" value="{{ $contents['about_point_1'] ?? 'Manajemen Riset Terintegrasi' }}">
                                <label class="form-label">Point 2 Title</label>
                                <input type="text" class="form-control mb-2" name="about_point_2" value="{{ $contents['about_point_2'] ?? 'Kolaborasi Multi-Disiplin' }}">
                                <label class="form-label">Point 3 Title</label>
                                <input type="text" class="form-control mb-2" name="about_point_3" value="{{ $contents['about_point_3'] ?? 'Hilirisasi Hasil Inovasi' }}">
                            </div>
                        </div>

                        <!-- Services Section -->
                        <div class="tab-pane fade" id="services" role="tabpanel" aria-labelledby="services-tab">
                            <div class="mb-3">
                                <label class="form-label">Subtitle</label>
                                <input type="text" class="form-control" name="services_subtitle" value="{{ $contents['services_subtitle'] ?? 'Layanan Akademik' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="services_title" value="{{ $contents['services_title'] ?? 'Pendampingan Menyeluruh' }}">
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <h6>Service 1</h6>
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control mb-2" name="service_1_title" value="{{ $contents['service_1_title'] ?? 'Agenda Kegiatan' }}">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="service_1_desc" rows="2">{{ $contents['service_1_desc'] ?? 'Kurasi event ilmiah, integrasi kalender pribadi, dan fitur reminder otomatis.' }}</textarea>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h6>Service 2</h6>
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control mb-2" name="service_2_title" value="{{ $contents['service_2_title'] ?? 'Pengumuman' }}">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="service_2_desc" rows="2">{{ $contents['service_2_desc'] ?? 'Dashboard notifikasi adaptif untuk hibah, ketentuan baru, dan jadwal penting.' }}</textarea>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h6>Service 3</h6>
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control mb-2" name="service_3_title" value="{{ $contents['service_3_title'] ?? 'Dokumen' }}">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="service_3_desc" rows="2">{{ $contents['service_3_desc'] ?? 'Repositori format resmi, template, dan panduan terbaru dengan versi terkontrol.' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
