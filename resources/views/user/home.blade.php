<x-user-layout>
    @php
        // Kumpulkan slide dari database
        $heroSlides = [];
        foreach (range(1, 5) as $i) {
            $key = 'hero_slide_' . $i;
            if (!empty($landingPage[$key] ?? null)) {
                $heroSlides[] = asset('storage/' . $landingPage[$key]);
            }
        }

        // Fallback jika belum ada data di admin
        if (count($heroSlides) === 0) {
            $heroSlides = [
                asset('img/ITH Kampus 1.jpg'),
                asset('img/ITH Kampus 2.jpg'),
            ];
        }
    @endphp

    <!-- Hero Section -->
    <section
        class="position-relative overflow-hidden hero-section min-vh-100 d-flex align-items-center justify-content-center">

        <!-- Background Carousel (tanpa Alpine, murni JS/CSS) -->
        <div class="position-absolute top-0 start-0 w-100 h-100 z-0 hero-slides-wrapper">
            @foreach ($heroSlides as $index => $url)
                <div class="hero-slide position-absolute top-0 start-0 w-100 h-100 {{ $index === 0 ? 'is-active' : '' }}"
                    data-hero-index="{{ $index }}">
                    <img src="{{ $url }}" class="w-100 h-100 object-fit-cover" alt="Hero Background {{ $index + 1 }}">
                </div>
            @endforeach
        </div>

        <!-- Overlay Gradient (Indigo/Purple Theme) -->
        <div class="position-absolute top-0 start-0 w-100 h-100 z-1"
            style="background: linear-gradient(135deg, rgba(30, 27, 75, 0.85) 0%, rgba(49, 46, 129, 0.8) 50%, rgba(76, 29, 149, 0.85) 100%); backdrop-filter: blur(2px);">
        </div>

        <!-- Content -->
        <div class="container position-relative z-2 text-center text-white">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9 wow fadeInUp" data-wow-duration="1.2s">

                    <h1 class="display-3 fw-bold mb-4 leading-tight text-white text-shadow-lg">
                        {{ $landingPage['title_prefix'] ?? 'Lembaga Penelitian &' }} <br>
                        <span class="text-transparent bg-clip-text"
                            style="background-image: linear-gradient(to right, #a5b4fc, #e879f9);">
                            {{ $landingPage['title_suffix'] ?? 'Pengabdian Kepada Masyarakat' }}
                        </span>
                    </h1>

                    <p class="lead mb-5 text-indigo-100 mx-auto col-lg-10 lh-lg opacity-90 fs-5">
                        {{ $landingPage['hero_description'] ?? 'Mengembangkan potensi akademik melalui penelitian bermutu dan pengabdian yang berdampak nyata bagi masyarakat luas.' }}
                    </p>

                    <div class="d-flex flex-wrap justify-content-center gap-3 mb-5">
                        <a href="{{ $landingPage['button_url'] ?? '#layanan' }}"
                            class="btn btn-primary btn-lg rounded-pill px-5 py-3 shadow-lg hover-transform fw-bold position-relative overflow-hidden group border-0"
                            style="background: linear-gradient(to right, #6366f1, #8b5cf6);">
                            <span class="position-relative z-1">{{ $landingPage['button_text'] ?? 'Jelajahi Layanan' }}</span>
                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-to-r from-indigo-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-all duration-300">
                            </div>
                        </a>
                        <a href="{{ $landingPage['secondary_button_url'] ?? '#tentang' }}"
                            class="btn btn-outline-light btn-lg rounded-pill px-5 py-3 hover-transform fw-bold backdrop-blur-sm border-2">
                            {{ $landingPage['secondary_button_text'] ?? 'Pelajari Lebih Lanjut' }}
                        </a>
                    </div>

                    <div class="row justify-content-center g-4 mt-5 border-top border-white border-opacity-10 pt-4 mx-auto"
                        style="max-width: 800px;">
                        <div class="col-4 col-md-auto px-4 border-end border-white border-opacity-10">
                            <div class="display-6 fw-bold text-white mb-1">{{ $landingPage['stat_1_value'] ?? '150' }}
                            </div>
                            <div class="text-indigo-200 small text-uppercase tracking-wider">
                                {{ $landingPage['stat_1_label'] ?? 'Penelitian' }}
                            </div>
                        </div>
                        <div class="col-4 col-md-auto px-4 border-end border-white border-opacity-10">
                            <div class="display-6 fw-bold text-white mb-1">{{ $landingPage['stat_2_value'] ?? '85' }}
                            </div>
                            <div class="text-indigo-200 small text-uppercase tracking-wider">
                                {{ $landingPage['stat_2_label'] ?? 'Pengabdian' }}
                            </div>
                        </div>
                        <div class="col-4 col-md-auto px-4">
                            <div class="display-6 fw-bold text-white mb-1">{{ $landingPage['stat_3_value'] ?? '50' }}
                            </div>
                            <div class="text-indigo-200 small text-uppercase tracking-wider">
                                {{ $landingPage['stat_3_label'] ?? 'Dosen Aktif' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carousel Indicators -->
        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4 z-2 d-flex gap-2 hero-indicators">
            @foreach ($heroSlides as $index => $url)
                <button
                    class="rounded-pill transition-all duration-300 border-0 hero-indicator {{ $index === 0 ? 'is-active' : '' }}"
                    data-hero-index="{{ $index }}"
                    style="height: 4px;"></button>
            @endforeach
        </div>
    </section>
            
    <!-- News Section -->
    <section class="py-5 bg-white position-relative overflow-hidden news-modern-section">
        <div class="container py-5">
            <div class="d-flex justify-content-between align-items-end mb-5 wow fadeInUp">
                <div>
                    <span class="badge bg-indigo-50 text-indigo-600 rounded-pill px-3 py-2 text-uppercase fw-bold letter-space-2 mb-3 border border-indigo-100">
                        Berita Terkini
                    </span>
                    <h2 class="display-5 fw-bold mt-2 text-slate-900 leading-tight">Kabar LPPM-PM</h2>
                </div>
                <a href="{{ route('layanan-berita.index') }}" class="btn btn-outline-slate rounded-pill px-4 py-2 fw-bold border-2 text-slate-600 hover-transform">
                    Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>

            <div class="row g-4">
                @forelse($berita as $key => $value)
                    @if($key < 3)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ $key * 0.1 }}s">
                            <div class="news-card-modern h-100 bg-white rounded-4 border border-slate-100 position-relative overflow-hidden group d-flex flex-column">
                                <div class="news-image-wrapper position-relative overflow-hidden">
                                    @if($value->cover)
                                        <img src="{{ asset('storage/' . $value->cover) }}" class="img-fluid w-100 h-100 object-fit-cover scale-on-hover" alt="{{ $value->judul }}">
                                    @else
                                        <div class="bg-slate-50 d-flex align-items-center justify-content-center w-100 h-100">
                                            <i class="fas fa-image fa-3x text-slate-300"></i>
                                        </div>
                                    @endif
                                    <div class="image-overlay-gradient"></div>
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge bg-white text-indigo-600 shadow-sm py-2 px-3 rounded-pill fw-bold">
                                            {{ convertDatetileLocToDateShort($value->created_at) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-4 d-flex flex-column flex-grow-1">
                                    <h5 class="fw-bold mb-3 leading-tight">
                                        <a href="{{ route('layanan-berita.show', ['slug' => $value->slug]) }}"
                                            class="text-slate-900 text-decoration-none stretched-link group-hover-text-indigo-600 transition-colors">
                                            {{ maxStr($value->judul, 60) }}
                                        </a>
                                    </h5>
                                    <p class="text-slate-600 small mb-4 flex-grow-1">
                                        {{ maxStr(strip_tags($value->isi), 100) }}
                                    </p>
                                    <div class="d-flex align-items-center text-indigo-600 fw-bold small mt-auto">
                                        Baca Selengkapnya <i class="fas fa-arrow-right ms-2 transition-transform group-hover-translate-x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-newspaper fa-3x text-slate-200"></i>
                        </div>
                        <p class="text-slate-500">Belum ada berita terbaru.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 position-relative features-bento-section overflow-hidden">
        <!-- Background Elements -->
        <div class="bento-glow bento-glow-1"></div>
        <div class="bento-glow bento-glow-2"></div>
        <div class="bento-grid-pattern"></div>

        <div class="container py-5 position-relative z-2">
            <div class="row g-5">
                <!-- Left Column: Sticky Content -->
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <div class="sticky-lg-top" style="top: 120px; z-index: 10;">
                        <!-- Badge -->
                        <div class="wow fadeInUp">
                            <span
                                class="badge rounded-pill px-3 py-2 text-uppercase fw-bold letter-space-2 text-indigo-600 bg-indigo-50 border border-indigo-100 mb-4 shadow-sm backdrop-blur-sm">
                                <i class="fas fa-bolt me-2 text-warning"></i>
                                {{ $landingPage['features_subtitle'] ?? 'Keunggulan Kami' }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h2 class="display-4 fw-bold text-slate-900 mb-4 leading-tight wow fadeInUp" data-wow-delay="0.1s">
                            {{ $landingPage['features_title'] ?? 'Ekosistem Riset Futuristik' }}
                        </h2>

                        <!-- Description -->
                        <p class="lead text-slate-600 mb-5 wow fadeInUp" data-wow-delay="0.2s"
                            style="line-height: 1.8;">
                            {{ $landingPage['features_description'] ?? 'Menyatukan pengetahuan, teknologi, dan kolaborasi lintas disiplin untuk menghasilkan inovasi berdampak besar.' }}
                        </p>

                        <!-- Feature List (Checkmarks) -->
                        <ul class="bento-list mb-5 wow fadeInUp" data-wow-delay="0.3s">
                            <li class="d-flex align-items-start gap-3 mb-3">
                                <div class="bento-check"><i class="fas fa-check"></i></div>
                                <span
                                    class="text-slate-700">{{ $landingPage['feature_point_1'] ?? 'Pendampingan personal dari tim riset.' }}</span>
                            </li>
                            <li class="d-flex align-items-start gap-3 mb-3">
                                <div class="bento-check"><i class="fas fa-check"></i></div>
                                <span
                                    class="text-slate-700">{{ $landingPage['feature_point_2'] ?? 'Integrasi platform digital monitoring.' }}</span>
                            </li>
                            <li class="d-flex align-items-start gap-3">
                                <div class="bento-check"><i class="fas fa-check"></i></div>
                                <span
                                    class="text-slate-700">{{ $landingPage['feature_point_3'] ?? 'Jejaring mitra nasional & global.' }}</span>
                            </li>
                        </ul>

                        <!-- Stats Row -->
                        <div class="d-flex gap-4 wow fadeInUp" data-wow-delay="0.4s">
                            <div class="text-center px-3 py-2 rounded-3 bg-white border border-gray-200 shadow-sm">
                                <h3 class="fw-bold text-slate-900 mb-0">{{ $landingPage['stat_1_value'] ?? '150' }}+</h3>
                                <small
                                    class="text-slate-500 text-uppercase text-xs tracking-wider">{{ $landingPage['stat_1_label'] ?? 'Penelitian' }}</small>
                            </div>
                            <div class="vr bg-dark opacity-10 my-2"></div>
                            <div class="text-center px-3 py-2 rounded-3 bg-white border border-gray-200 shadow-sm">
                                <h3 class="fw-bold text-slate-900 mb-0">{{ $landingPage['stat_2_value'] ?? '85' }}+</h3>
                                <small
                                    class="text-slate-500 text-uppercase text-xs tracking-wider">{{ $landingPage['stat_2_label'] ?? 'Pengabdian' }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Bento Grid -->
                <div class="col-lg-7">
                    <div class="bento-grid">
                        <!-- Card 1: Large -->
                        <div class="bento-card bento-large wow fadeInUp" data-wow-delay="0.2s">
                            <div class="bento-content">
                                <div class="d-flex justify-content-between align-items-start mb-4">
                                    <div class="bento-icon bg-gradient-1 text-white shadow-lg">
                                        <i class="fas fa-microscope"></i>
                                    </div>
                                    <span class="badge bg-indigo-50 text-indigo-600 border border-indigo-100 rounded-pill">Unggulan</span>
                                </div>
                                <h4 class="text-slate-900 mb-2">{{ $landingPage['feature_1_title'] ?? 'Riset Berkualitas' }}
                                </h4>
                                <p class="text-slate-600 text-sm mb-0">
                                    {{ $landingPage['feature_1_desc'] ?? 'Kurasi roadmap, akses laboratorium, dan coaching intensif.' }}
                                </p>
                            </div>
                            <div class="bento-bg-icon text-slate-100"><i class="fas fa-microscope"></i></div>
                        </div>

                        <!-- Card 2: Medium -->
                        <div class="bento-card wow fadeInUp" data-wow-delay="0.3s">
                            <div class="bento-content">
                                <div class="bento-icon bg-gradient-2 mb-3 text-white shadow-lg">
                                    <i class="fas fa-hands-helping"></i>
                                </div>
                                <h4 class="text-slate-900 mb-2 fs-5">
                                    {{ $landingPage['feature_2_title'] ?? 'Pengabdian' }}</h4>
                                <p class="text-slate-600 text-sm mb-0">
                                    {{ $landingPage['feature_2_desc'] ?? 'Sinkronisasi isu prioritas & dashboard impact.' }}
                                </p>
                            </div>
                        </div>

                        <!-- Card 3: Medium -->
                        <div class="bento-card wow fadeInUp" data-wow-delay="0.4s">
                            <div class="bento-content">
                                <div class="bento-icon bg-gradient-3 mb-3 text-white shadow-lg">
                                    <i class="fas fa-globe-asia"></i>
                                </div>
                                <h4 class="text-slate-900 mb-2 fs-5">
                                    {{ $landingPage['feature_3_title'] ?? 'Publikasi' }}</h4>
                                <p class="text-slate-600 text-sm mb-0">
                                    {{ $landingPage['feature_3_desc'] ?? 'Klinik penulisan & cost sharing jurnal.' }}
                                </p>
                            </div>
                        </div>

                        <!-- Card 4: Wide -->
                        <div class="bento-card bento-wide wow fadeInUp" data-wow-delay="0.5s">
                            <div class="bento-content d-flex align-items-center gap-4">
                                <div class="bento-icon bg-gradient-4 flex-shrink-0 text-white shadow-lg">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div>
                                    <h4 class="text-slate-900 mb-1">
                                        {{ $landingPage['feature_4_title'] ?? 'Insight & Analytics' }}</h4>
                                    <p class="text-slate-600 text-sm mb-0">
                                        {{ $landingPage['feature_4_desc'] ?? 'Panel data adaptif timeline & progres review.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <!-- About Section (Redesigned - White Theme) -->
    <section id="about" class="py-5 bg-white position-relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="blob-decoration blob-1"></div>
        <div class="blob-decoration blob-2"></div>

        <div class="container py-5 position-relative z-2">
            <div class="row g-5 align-items-center">
                <!-- Visual Side (Left) -->
                <div class="col-lg-6 wow fadeInLeft">
                    <div class="about-visual-modern position-relative">
                        <div class="main-image-wrapper rounded-5 overflow-hidden shadow-lg position-relative">
                            @php
                                $aboutImage = $landingPage['about_image'] ?? null;
                                $aboutImageSrc = $aboutImage ? asset('storage/' . $aboutImage) : 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1470&q=80';
                            @endphp
                            <img src="{{ $aboutImageSrc }}"
                                class="img-fluid object-fit-cover w-100 h-100 scale-on-hover" alt="Tentang LPPM">
                            <div class="image-overlay-gradient"></div>
                        </div>

                        <!-- Floating Stat Cards -->
                        <div class="floating-stat-card stat-1 glass-card p-3 rounded-4 shadow-sm">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon bg-indigo-100 text-indigo-600 rounded-circle p-2">
                                    <i class="fas fa-user-graduate fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold text-slate-900">150+</h5>
                                    <small class="text-slate-500">Peneliti Aktif</small>
                                </div>
                            </div>
                        </div>

                        <div class="floating-stat-card stat-2 glass-card p-3 rounded-4 shadow-sm">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon bg-pink-100 text-pink-600 rounded-circle p-2">
                                    <i class="fas fa-handshake fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold text-slate-900">35+</h5>
                                    <small class="text-slate-500">Mitra Kampus</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Side (Right) -->
                <div class="col-lg-6 wow fadeInRight">
                    <span
                        class="badge bg-indigo-50 text-indigo-600 rounded-pill px-3 py-2 text-uppercase fw-bold letter-space-2 mb-3 border border-indigo-100">
                        {{ $landingPage['about_subtitle'] ?? 'Tentang Kami' }}
                    </span>
                    <h2 class="display-5 fw-bold mb-4 text-slate-900 leading-tight">
                        {{ $landingPage['about_title'] ?? 'Mewujudkan Visi Melalui Riset Unggulan' }}
                    </h2>
                    <p class="lead text-slate-600 mb-5" style="line-height: 1.8;">
                        {{ $landingPage['about_description'] ?? 'LPPM hadir sebagai katalis inovasi institusional dengan tata kelola adaptif, data-driven decision, dan dukungan talenta lintas bidang.' }}
                    </p>

                    <!-- Interactive Pillars -->
                    <div class="about-pillars-modern d-flex flex-column gap-3">
                        <div class="pillar-card-modern p-3 rounded-4 border border-slate-100 bg-slate-50 hover-lift transition-all cursor-pointer">
                            <div class="d-flex gap-3 align-items-start">
                                <div class="pillar-icon-modern bg-white text-indigo-600 shadow-sm rounded-3 p-2 flex-shrink-0">
                                    <i class="fas fa-project-diagram"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-slate-800 mb-1">{{ $landingPage['about_point_1'] ?? 'Manajemen Riset Terintegrasi' }}</h5>
                                    <p class="text-slate-500 text-sm mb-0">Satu portal untuk proposal, review, hingga LPJ dengan pelacakan status realtime.</p>
                                </div>
                            </div>
                        </div>

                        <div class="pillar-card-modern p-3 rounded-4 border border-slate-100 bg-slate-50 hover-lift transition-all cursor-pointer">
                            <div class="d-flex gap-3 align-items-start">
                                <div class="pillar-icon-modern bg-white text-pink-600 shadow-sm rounded-3 p-2 flex-shrink-0">
                                    <i class="fas fa-handshake"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-slate-800 mb-1">{{ $landingPage['about_point_2'] ?? 'Kolaborasi Multi-Disiplin' }}</h5>
                                    <p class="text-slate-500 text-sm mb-0">Memadukan dosen, mahasiswa, dan mitra eksternal dalam cluster fokus unggulan.</p>
                                </div>
                            </div>
                        </div>

                        <div class="pillar-card-modern p-3 rounded-4 border border-slate-100 bg-slate-50 hover-lift transition-all cursor-pointer">
                            <div class="d-flex gap-3 align-items-start">
                                <div class="pillar-icon-modern bg-white text-teal-600 shadow-sm rounded-3 p-2 flex-shrink-0">
                                    <i class="fas fa-seedling"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-slate-800 mb-1">{{ $landingPage['about_point_3'] ?? 'Hilirisasi Hasil Inovasi' }}</h5>
                                    <p class="text-slate-500 text-sm mb-0">Skema inkubasi dan coaching untuk membawa temuan menuju tingkat kesiapterapan tinggi.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-3 mt-5">
                        <a href="{{ route('tentang-satker.index') }}"
                            class="btn btn-primary rounded-pill px-4 py-3 shadow-lg hover-transform fw-bold border-0"
                            style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
                            Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <!-- Services Section (Redesigned - White Theme) -->
    <section class="py-5 bg-slate-50 position-relative overflow-hidden services-modern-section">
        <!-- Background Pattern -->
        <div class="services-pattern"></div>
        
        <div class="container py-5 position-relative z-2">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8 wow fadeInUp">
                    <span class="badge bg-indigo-50 text-indigo-600 rounded-pill px-3 py-2 text-uppercase fw-bold letter-space-2 mb-3 border border-indigo-100">
                        {{ $landingPage['services_subtitle'] ?? 'Layanan Akademik' }}
                    </span>
                    <h2 class="display-5 fw-bold text-slate-900 mb-3">
                        {{ $landingPage['services_title'] ?? 'Pendampingan Menyeluruh' }}
                    </h2>
                    <p class="lead text-slate-600">
                        Tiga kanal layanan digital yang siap memfasilitasi kolaborasi, publikasi, dan akses informasi strategis.
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Service 1: Agenda -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-card-modern h-100 bg-white p-4 rounded-4 shadow-sm border border-slate-100 position-relative overflow-hidden group">
                        <div class="icon-box-modern bg-indigo-50 text-indigo-600 rounded-circle mb-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                        <h4 class="fw-bold text-slate-900 mb-3">{{ $landingPage['service_1_title'] ?? 'Agenda Kegiatan' }}</h4>
                        <p class="text-slate-600 mb-4">{{ $landingPage['service_1_desc'] ?? 'Kurasi event ilmiah, integrasi kalender pribadi, dan fitur reminder otomatis.' }}</p>
                        <a href="{{ route('layanan-agenda.index') }}" class="stretched-link text-decoration-none fw-bold text-indigo-600 group-hover-text-indigo-700 d-flex align-items-center">
                            Lihat Agenda <i class="fas fa-arrow-right ms-2 transition-transform group-hover-translate-x"></i>
                        </a>
                        <div class="hover-glow bg-indigo-500 opacity-0 group-hover-opacity-5"></div>
                    </div>
                </div>

                <!-- Service 2: Pengumuman -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="service-card-modern h-100 bg-white p-4 rounded-4 shadow-sm border border-slate-100 position-relative overflow-hidden group">
                        <div class="icon-box-modern bg-pink-50 text-pink-600 rounded-circle mb-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-bullhorn fa-2x"></i>
                        </div>
                        <h4 class="fw-bold text-slate-900 mb-3">{{ $landingPage['service_2_title'] ?? 'Pengumuman' }}</h4>
                        <p class="text-slate-600 mb-4">{{ $landingPage['service_2_desc'] ?? 'Dashboard notifikasi adaptif untuk hibah, ketentuan baru, dan jadwal penting.' }}</p>
                        <a href="{{ route('layanan-pengumuman.index') }}" class="stretched-link text-decoration-none fw-bold text-pink-600 group-hover-text-pink-700 d-flex align-items-center">
                            Cek Pengumuman <i class="fas fa-arrow-right ms-2 transition-transform group-hover-translate-x"></i>
                        </a>
                    </div>
                </div>

                <!-- Service 3: Dokumen -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-card-modern h-100 bg-white p-4 rounded-4 shadow-sm border border-slate-100 position-relative overflow-hidden group">
                        <div class="icon-box-modern bg-teal-50 text-teal-600 rounded-circle mb-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-file-alt fa-2x"></i>
                        </div>
                        <h4 class="fw-bold text-slate-900 mb-3">{{ $landingPage['service_3_title'] ?? 'Dokumen' }}</h4>
                        <p class="text-slate-600 mb-4">{{ $landingPage['service_3_desc'] ?? 'Repositori format resmi, template, dan panduan terbaru dengan versi terkontrol.' }}</p>
                        <a href="{{ route('dokumen.index') }}" class="stretched-link text-decoration-none fw-bold text-teal-600 group-hover-text-teal-700 d-flex align-items-center">
                            Unduh Dokumen <i class="fas fa-arrow-right ms-2 transition-transform group-hover-translate-x"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Bento Grid Features Section */
        .features-bento-section {
            background: #ffffff;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            color: #1e293b;
        }

        .bento-grid-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(rgba(99, 102, 241, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99, 102, 241, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
            opacity: 1;
            z-index: 1;
        }

        .bento-glow {
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.15;
            z-index: 0;
            animation: pulseGlow 10s infinite alternate;
        }

        .bento-glow-1 {
            top: -200px;
            left: -200px;
            background: #6366f1;
        }

        .bento-glow-2 {
            bottom: -200px;
            right: -200px;
            background: #ec4899;
            animation-delay: 5s;
        }

        @keyframes pulseGlow {
            0% {
                transform: scale(1);
                opacity: 0.1;
            }

            100% {
                transform: scale(1.2);
                opacity: 0.2;
            }
        }

        /* Bento Grid Layout */
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            position: relative;
            z-index: 2;
        }

        .bento-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.5rem;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .bento-large {
            grid-row: span 2;
        }

        .bento-wide {
            grid-column: span 2;
        }

        .bento-card:hover {
            transform: translateY(-8px) scale(1.01);
            border-color: #cbd5e1;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .bento-content {
            position: relative;
            z-index: 2;
        }

        /* Responsive Bento Grid */
        @media (max-width: 768px) {
            .bento-grid {
                grid-template-columns: 1fr;
            }

            .bento-large,
            .bento-wide {
                grid-column: span 1;
                grid-row: auto;
            }

            .display-3 {
                font-size: 2.5rem;
            }

            .display-4 {
                font-size: 2rem;
            }
            
            .display-5 {
                font-size: 1.75rem;
            }
        }

        .bento-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            transition: transform 0.3s ease;
        }

        .bento-card:hover .bento-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .bento-bg-icon {
            position: absolute;
            bottom: -20px;
            right: -20px;
            font-size: 10rem;
            color: #f1f5f9;
            transform: rotate(-15deg);
            z-index: 1;
            transition: all 0.5s ease;
        }

        .bento-card:hover .bento-bg-icon {
            transform: rotate(0deg) scale(1.1);
            color: #e2e8f0;
        }

        /* Gradients */
        .bg-gradient-1 {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
        }

        .bg-gradient-2 {
            background: linear-gradient(135deg, #ec4899, #f472b6);
        }

        .bg-gradient-3 {
            background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        }

        .bg-gradient-4 {
            background: linear-gradient(135deg, #10b981, #34d399);
        }

        /* List & Typography */
        .bento-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .bento-check {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        .letter-space-2 {
            letter-spacing: 2px;
        }

        .text-xs {
            font-size: 0.75rem;
        }

        /* Text Utilities for White Theme */
        .text-slate-900 { color: #0f172a; }
        .text-slate-700 { color: #334155; }
        .text-slate-600 { color: #475569; }
        .text-slate-500 { color: #64748b; }
        .text-slate-100 { color: #f1f5f9; }

        /* Responsive */
        @media (max-width: 991.98px) {
            .bento-grid {
                grid-template-columns: 1fr;
            }

            .bento-large,
            .bento-wide {
                grid-row: auto;
                grid-column: auto;
            }

            .sticky-lg-top {
                position: relative;
                top: 0 !important;
                margin-bottom: 2rem;
            }
        }

        /* Custom Utilities */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
        }

        .hover-transform:hover {
            transform: translateY(-2px);
        }

        .text-transparent {
            color: transparent;
        }

        .bg-clip-text {
            -webkit-background-clip: text;
            background-clip: text;
        }

        .backdrop-blur-sm {
            backdrop-filter: blur(4px);
        }

        .backdrop-blur-md {
            backdrop-filter: blur(12px);
        }

        .text-shadow-lg {
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .shadow-hover:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .object-fit-cover {
            object-fit: cover;
        }
        /* About Section Modern */
        .about-modern-section {
            background: #ffffff;
            /* Subtle pattern */
            background-image: radial-gradient(#6366f1 0.5px, transparent 0.5px), radial-gradient(#6366f1 0.5px, #ffffff 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            background-color: #ffffff;
            /* Fade out pattern */
            mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 0%, rgba(0,0,0,0.05) 100%);
            -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 0%, rgba(0,0,0,0.05) 100%);
        }
        
        /* Fix for mask-image affecting content - apply pattern to pseudo-element instead */
        .about-modern-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 24px 24px;
            opacity: 0.6;
            z-index: 0;
            pointer-events: none;
        }

        .blob-decoration {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            z-index: 0;
        }

        .blob-1 {
            width: 400px;
            height: 400px;
            background: #e0e7ff; /* Indigo-100 */
            top: -100px;
            left: -100px;
            animation: floatBlob 8s infinite ease-in-out;
        }

        .blob-2 {
            width: 300px;
            height: 300px;
            background: #fce7f3; /* Pink-100 */
            bottom: -50px;
            right: -50px;
            animation: floatBlob 10s infinite ease-in-out reverse;
        }

        @keyframes floatBlob {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, 20px); }
        }

        .about-visual-modern {
            position: relative;
            z-index: 1;
            padding: 2rem;
        }

        .main-image-wrapper {
            transform: rotate(-2deg);
            transition: transform 0.5s ease;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .about-visual-modern:hover .main-image-wrapper {
            transform: rotate(0deg) scale(1.02);
        }

        .scale-on-hover {
            transition: transform 0.7s ease;
        }

        .main-image-wrapper:hover .scale-on-hover {
            transform: scale(1.05);
        }

        .floating-stat-card {
            position: absolute;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            z-index: 2;
        }

        .stat-1 {
            top: 10%;
            right: 0;
            transform: translateX(20%);
        }

        .stat-2 {
            bottom: 15%;
            left: 0;
            transform: translateX(-10%);
        }

        .about-visual-modern:hover .floating-stat-card {
            transform: translateX(0) scale(1.05);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        .pillar-card-modern {
            transition: all 0.3s ease;
        }

        .pillar-card-modern:hover {
            background: #ffffff;
            border-color: #6366f1;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.1);
        }

        .pillar-card-modern:hover .pillar-icon-modern {
            background: #6366f1 !important;
            color: #ffffff !important;
            transform: scale(1.1) rotate(5deg);
        }

        .pillar-icon-modern {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            transition: all 0.3s ease;
        }

        /* Color Utilities */
        .bg-indigo-50 { background-color: #eef2ff; }
        .bg-indigo-100 { background-color: #e0e7ff; }
        .text-indigo-600 { color: #4f46e5; }
        .border-indigo-100 { border-color: #e0e7ff; }
        
        .bg-pink-100 { background-color: #fce7f3; }
        .text-pink-600 { color: #db2777; }
        
        .bg-teal-600 { background-color: #0d9488; }
        .text-teal-600 { color: #0d9488; }

        .bg-slate-50 { background-color: #f8fafc; }
        .text-slate-800 { color: #1e293b; }
        .border-slate-100 { border-color: #f1f5f9; }
        
        .btn-outline-slate {
            border-color: #cbd5e1;
            color: #475569;
        }
        
        .btn-outline-slate:hover {
            background-color: #f1f5f9;
            border-color: #94a3b8;
            color: #0f172a;
        }

        .cursor-pointer { cursor: pointer; }

        /* Services Section Modern */
        .services-modern-section {
            background-color: #f8fafc; /* Slate-50 */
        }

        .services-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.3;
            pointer-events: none;
        }

        .service-card-modern {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .service-card-modern:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
            border-color: transparent;
        }

        .icon-box-modern {
            width: 80px;
            height: 80px;
            transition: transform 0.3s ease;
        }

        .service-card-modern:hover .icon-box-modern {
            transform: scale(1.1) rotate(5deg);
        }

        .group-hover-translate-x {
            transition: transform 0.3s ease;
        }

        .group:hover .group-hover-translate-x {
            transform: translateX(5px);
        }

        .hover-glow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .group:hover .group-hover-opacity-5 {
            opacity: 0.05;
        }

        .bg-pink-50 { background-color: #fdf2f8; }
        .text-pink-600 { color: #db2777; }
        .bg-pink-500 { background-color: #ec4899; }
        
        .bg-teal-50 { background-color: #f0fdfa; }
        .text-teal-600 { color: #0d9488; }
        .bg-teal-500 { background-color: #14b8a6; }

        /* News Section Modern */
        .news-card-modern {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        .news-card-modern:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: #cbd5e1;
        }

        .news-image-wrapper {
            height: 240px;
        }

        .image-overlay-gradient {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.05) 100%);
            pointer-events: none;
        }

        .group-hover-text-indigo-600 {
            transition: color 0.3s ease;
        }

        .group:hover .group-hover-text-indigo-600 {
            color: #4f46e5 !important;
        }

        .text-slate-200 { color: #e2e8f0; }
        .text-slate-300 { color: #cbd5e1; }
    </style>
</x-user-layout>
