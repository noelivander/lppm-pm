<x-user-layout>
    <!-- Hero Section -->
    <section
        class="position-relative overflow-hidden hero-section min-vh-100 d-flex align-items-center justify-content-center"
        x-data="{
            activeSlide: 0,
            slides: [
                '{{ asset('img/ITH Kampus 1.jpg') }}',
                '{{ asset('img/ITH Kampus 2.jpg') }}'
            ],
            init() {
                setInterval(() => {
                    this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                }, 5000);
            }
        }">

        <!-- Background Carousel -->
        <div class="position-absolute top-0 start-0 w-100 h-100 z-0">
            <template x-for="(slide, index) in slides" :key="index">
                <div class="position-absolute top-0 start-0 w-100 h-100 transition-opacity duration-1000 ease-in-out"
                    x-show="activeSlide === index" x-transition:enter="transition ease-out duration-1000"
                    x-transition:enter-start="opacity-0 transform scale-105"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-1000"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95">
                    <img :src="slide" class="w-100 h-100 object-fit-cover" alt="Hero Background">
                </div>
            </template>
        </div>

        <!-- Overlay Gradient (Indigo/Purple Theme) -->
        <div class="position-absolute top-0 start-0 w-100 h-100 z-1"
            style="background: linear-gradient(135deg, rgba(30, 27, 75, 0.85) 0%, rgba(49, 46, 129, 0.8) 50%, rgba(76, 29, 149, 0.85) 100%); backdrop-filter: blur(2px);">
        </div>

        <!-- Content -->
        <div class="container position-relative z-2 text-center text-white">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9 wow fadeInUp" data-wow-duration="1.2s">
                    <!-- Badge -->
                    <div class="d-inline-block mb-22">
                        <span class="badge px-4 py-12 rounded-pill border border-white border-opacity-25"
                            style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); font-size: 0.9rem; letter-spacing: 5px;">
                            <i class="fas fa-university me-2"></i>INSTITUT TEKNOLOGI BACHARUDDIN JUSUF HABIBIE
                        </span>
                    </div>

                    <!-- Title -->

                    <h1 class="display-3 fw-bold mb-24 leading-tight text-white text-shadow-lg">
                        {{ $landingPage['title_prefix'] ?? 'Lembaga Penelitian &' }} <br>
                        <span class="text-transparent bg-clip-text"
                            style="background-image: linear-gradient(to right, #a5b4fc, #e879f9);">
                            {{ $landingPage['title_suffix'] ?? 'Pengabdian Kepada Masyarakat' }}
                        </span>
                    </h1>

                    <!-- Description -->
                    <p class="lead mb-24 text-indigo-100 mx-auto col-lg-10 lh-lg opacity-90 fs-5">
                        {{ $landingPage['hero_description'] ?? 'Mengembangkan potensi akademik melalui penelitian bermutu dan pengabdian yang berdampak nyata bagi masyarakat luas.' }}
                    </p>

                    <!-- Buttons -->
                    <div class="d-flex flex-wrap justify-content-center gap-3 mb-5">
                        <a href="{{ $landingPage['button_url'] ?? '#layanan' }}"
                            class="btn btn-primary btn-lg rounded-pill px-5 py-3 shadow-lg hover-transform fw-bold position-relative overflow-hidden group border-0"
                            style="background: linear-gradient(to right, #6366f1, #8b5cf6);">
                            <span
                                class="position-relative z-1">{{ $landingPage['button_text'] ?? 'Jelajahi Layanan' }}</span>
                            <div
                                class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-to-r from-indigo-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-all duration-300">
                            </div>
                        </a>
                        <a href="{{ $landingPage['secondary_button_url'] ?? '#tentang' }}"
                            class="btn btn-outline-light btn-lg rounded-pill px-5 py-3 hover-transform fw-bold backdrop-blur-sm border-2">
                            {{ $landingPage['secondary_button_text'] ?? 'Pelajari Lebih Lanjut' }}
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="row justify-content-center g-4 mt-4 border-top border-white border-opacity-10 pt-4 mx-auto"
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
        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4 z-2 d-flex gap-2">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" class="rounded-pill transition-all duration-300 border-0"
                    :class="activeSlide === index ? 'bg-white w-8 h-1' : 'bg-white/50 w-2 h-1 hover:bg-white/80'"
                    style="height: 4px;"></button>
            </template>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 position-relative features-v2-section overflow-hidden">
        <div class="features-v2-glow features-v2-glow-1"></div>
        <div class="features-v2-glow features-v2-glow-2"></div>
        <div class="container py-5 position-relative">
            <div class="row align-items-center g-5">
                <div class="col-lg-5 text-white wow fadeInLeft" data-wow-duration="1.1s">
                    <span class="badge rounded-pill px-4 py-2 text-uppercase fw-semibold letter-space-4 text-indigo-100 bg-white bg-opacity-10 border border-white border-opacity-25 mb-3">
                        {{ $landingPage['features_subtitle'] ?? 'Keunggulan Kami' }}
                    </span>
                    <h2 class="display-5 fw-bold mb-3">
                        {{ $landingPage['features_title'] ?? 'Ekosistem Riset Futuristik' }}
                    </h2>
                    <p class="lead text-indigo-100 mb-4">
                        {{ $landingPage['features_description'] ?? 'Menyatukan pengetahuan, teknologi, dan kolaborasi lintas disiplin untuk menghasilkan inovasi berdampak besar.' }}
                    </p>
                    <ul class="feature-v2-list">
                        <li>
                            <span class="feature-v2-dot"></span>
                            <span>{{ $landingPage['feature_point_1'] ?? 'Pendampingan personal dari tim riset untuk menjaga mutu proposal dan luaran.' }}</span>
                        </li>
                        <li>
                            <span class="feature-v2-dot"></span>
                            <span>{{ $landingPage['feature_point_2'] ?? 'Integrasi platform digital untuk monitoring progres dan kolaborasi lintas unit.' }}</span>
                        </li>
                        <li>
                            <span class="feature-v2-dot"></span>
                            <span>{{ $landingPage['feature_point_3'] ?? 'Jejaring mitra nasional & global guna mempercepat hilirisasi inovasi.' }}</span>
                        </li>
                    </ul>
                    <div class="d-flex flex-wrap gap-4 mt-4">
                        <div class="feature-stat">
                            <strong>{{ $landingPage['stat_1_value'] ?? '150' }}+</strong>
                            <small>{{ $landingPage['stat_1_label'] ?? 'Penelitian' }}</small>
                        </div>
                        <div class="feature-stat">
                            <strong>{{ $landingPage['stat_2_value'] ?? '85' }}+</strong>
                            <small>{{ $landingPage['stat_2_label'] ?? 'Pengabdian' }}</small>
                        </div>
                        <div class="feature-stat">
                            <strong>{{ $landingPage['stat_3_value'] ?? '50' }}+</strong>
                            <small>{{ $landingPage['stat_3_label'] ?? 'Dosen Aktif' }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="feature-card-grid">
                        <article class="feature-card-v2 wow fadeInUp" data-wow-delay="0.05s">
                            <div class="feature-card-icon bg-gradient-primary">
                                <i class="fas fa-microscope"></i>
                            </div>
                            <div>
                                <h4>{{ $landingPage['feature_1_title'] ?? 'Riset Berkualitas' }}</h4>
                                <p>{{ $landingPage['feature_1_desc'] ?? 'Kurasi roadmap, akses laboratorium, dan coaching intensif untuk menjaga standar riset.' }}</p>
                            </div>
                            <div class="feature-card-meta">
                                <span>TR Level 5-7</span>
                                <span>92% Proposal Lolos</span>
                            </div>
                        </article>

                        <article class="feature-card-v2 wow fadeInUp" data-wow-delay="0.15s">
                            <div class="feature-card-icon bg-gradient-secondary">
                                <i class="fas fa-hands-helping"></i>
                            </div>
                            <div>
                                <h4>{{ $landingPage['feature_2_title'] ?? 'Pengabdian Kolaboratif' }}</h4>
                                <p>{{ $landingPage['feature_2_desc'] ?? 'Sinkronisasi isu prioritas, kurasi mitra, dan dashboard impact untuk program pengabdian.' }}</p>
                            </div>
                            <div class="feature-card-meta">
                                <span>20+ Mitra Aktif</span>
                                <span>Monitoring Real-time</span>
                            </div>
                        </article>

                        <article class="feature-card-v2 wow fadeInUp" data-wow-delay="0.25s">
                            <div class="feature-card-icon bg-gradient-tertiary">
                                <i class="fas fa-globe-asia"></i>
                            </div>
                            <div>
                                <h4>{{ $landingPage['feature_3_title'] ?? 'Publikasi Global' }}</h4>
                                <p>{{ $landingPage['feature_3_desc'] ?? 'Dukungan klinik penulisan, proofreading, dan cost sharing untuk penetrasi jurnal bereputasi.' }}</p>
                            </div>
                            <div class="feature-card-meta">
                                <span>Index Scopus</span>
                                <span>H-Index 27</span>
                            </div>
                        </article>

                        <article class="feature-card-v2 wow fadeInUp" data-wow-delay="0.35s">
                            <div class="feature-card-icon bg-gradient-info">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div>
                                <h4>{{ $landingPage['feature_4_title'] ?? 'Insight & Analytics' }}</h4>
                                <p>{{ $landingPage['feature_4_desc'] ?? 'Panel data adaptif yang menampilkan timeline, progres review, serta rekomendasi aksi.' }}</p>
                            </div>
                            <div class="feature-card-meta">
                                <span>Dashboard Interaktif</span>
                                <span>Update Harian</span>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5 bg-white">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeInLeft">
                    <div class="about-visual">
                        <img src="{{ $landingPage['about_image'] ?? 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1470&q=80' }}"
                            class="img-fluid rounded-5 shadow-lg" alt="Tentang LPPM">
                        <div class="data-pill primary">
                            <span class="label">Peneliti Aktif</span>
                            <strong>150+</strong>
                        </div>
                        <div class="data-pill secondary">
                            <span class="label">Kemitraan</span>
                            <strong>35 Kampus</strong>
                        </div>
                        <div class="about-timeline">
                            <div class="timeline-dot"></div>
                            <div class="timeline-dot"></div>
                            <div class="timeline-dot"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight">
                    <span class="section-eyebrow text-uppercase fw-semibold text-indigo-600 letter-space-4">
                        {{ $landingPage['about_subtitle'] ?? 'Tentang Kami' }}
                    </span>
                    <h2 class="display-5 fw-bold mb-4">
                        {{ $landingPage['about_title'] ?? 'Mewujudkan Visi Melalui Riset Unggulan' }}
                    </h2>
                    <p class="lead text-muted mb-4">
                        {{ $landingPage['about_description'] ?? 'LPPM hadir sebagai katalis inovasi institusional dengan tata kelola adaptif, data-driven decision, dan dukungan talenta lintas bidang.' }}
                    </p>

                    <div class="about-pillars">
                        <div class="pillar-card">
                            <span class="pillar-icon bg-soft-primary">
                                <i class="fas fa-project-diagram"></i>
                            </span>
                            <div>
                                <h5>{{ $landingPage['about_point_1'] ?? 'Manajemen Riset Terintegrasi' }}</h5>
                                <p>Satu portal untuk proposal, review, hingga LPJ dengan pelacakan status realtime.</p>
                            </div>
                        </div>
                        <div class="pillar-card">
                            <span class="pillar-icon bg-soft-secondary">
                                <i class="fas fa-handshake"></i>
                            </span>
                            <div>
                                <h5>{{ $landingPage['about_point_2'] ?? 'Kolaborasi Multi-Disiplin' }}</h5>
                                <p>Memadukan dosen, mahasiswa, dan mitra eksternal dalam cluster fokus unggulan.</p>
                            </div>
                        </div>
                        <div class="pillar-card">
                            <span class="pillar-icon bg-soft-tertiary">
                                <i class="fas fa-seedling"></i>
                            </span>
                            <div>
                                <h5>{{ $landingPage['about_point_3'] ?? 'Hilirisasi Hasil Inovasi' }}</h5>
                                <p>Skema inkubasi dan coaching untuk membawa temuan menuju tingkat kesiapterapan tinggi.</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="{{ route('tentang-satker.index') }}" class="btn btn-gradient-primary px-4 py-3 rounded-pill">
                            Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <a href="#timeline" class="btn btn-outline-indigo px-4 py-3 rounded-pill">
                            Lihat Timeline <i class="fas fa-clock ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-5 bg-gradient-lilac">
        <div class="container py-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-5 wow fadeInUp">
                    <span class="section-eyebrow text-uppercase fw-semibold text-indigo-100 letter-space-4">
                        {{ $landingPage['services_subtitle'] ?? 'Layanan Akademik' }}
                    </span>
                    <h2 class="display-5 fw-bold text-white mt-3">
                        {{ $landingPage['services_title'] ?? 'Pendampingan Menyeluruh, Dari Ide Hingga Dampak' }}
                    </h2>
                    <p class="text-indigo-50 mt-3">
                        Tiga kanal layanan digital yang siap memfasilitasi kolaborasi, publikasi, dan akses informasi strategis bagi sivitas akademika.
                    </p>

                    <div class="service-pill d-inline-flex align-items-center gap-3 mt-4">
                        <span class="pill-icon"><i class="fas fa-shield-alt"></i></span>
                        <div>
                            <p class="mb-0 text-white fw-semibold">Response time rata-rata <strong>6 jam kerja</strong></p>
                            <small class="text-indigo-100">Dengan SLA & notifikasi multi-channel</small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-flow">
                        <div class="service-step">
                            <div class="step-number">01</div>
                            <div>
                                <h4>{{ $landingPage['service_1_title'] ?? 'Agenda Kegiatan' }}</h4>
                                <p>{{ $landingPage['service_1_desc'] ?? 'Kurasi event ilmiah, integrasi kalender pribadi, dan fitur reminder otomatis.' }}</p>
                                <a href="{{ route('layanan-agenda.index') }}" class="link-arrow text-white">Lihat Agenda</a>
                            </div>
                            <span class="step-icon bg-step-one">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                        </div>

                        <div class="service-step">
                            <div class="step-number">02</div>
                            <div>
                                <h4>{{ $landingPage['service_2_title'] ?? 'Pengumuman' }}</h4>
                                <p>{{ $landingPage['service_2_desc'] ?? 'Dashboard notifikasi adaptif untuk hibah, ketentuan baru, dan jadwal penting.' }}</p>
                                <a href="{{ route('layanan-pengumuman.index') }}" class="link-arrow text-white">Cek Pengumuman</a>
                            </div>
                            <span class="step-icon bg-step-two">
                                <i class="fas fa-bullhorn"></i>
                            </span>
                        </div>

                        <div class="service-step mb-0">
                            <div class="step-number">03</div>
                            <div>
                                <h4>{{ $landingPage['service_3_title'] ?? 'Dokumen' }}</h4>
                                <p>{{ $landingPage['service_3_desc'] ?? 'Repositori format resmi, template, dan panduan terbaru dengan versi terkontrol.' }}</p>
                                <a href="{{ route('dokumen.index') }}" class="link-arrow text-white">Unduh Dokumen</a>
                            </div>
                            <span class="step-icon bg-step-three">
                                <i class="fas fa-file-alt"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="py-5 bg-white">
        <div class="container py-5">
            <div class="d-flex justify-content-between align-items-end mb-5 wow fadeInUp">
                <div>
                    <span class="text-primary fw-bold text-uppercase small tracking-wider">Berita
                        Terkini</span>
                    <h2 class="display-6 fw-bold mt-2 text-dark">Kabar LPPM-PM</h2>
                </div>
                <a href="{{ route('layanan-berita.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                    Lihat Semua
                </a>
            </div>

            <div class="row g-4">
                @forelse($berita as $key => $value)
                    @if($key < 3)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 border-0 shadow-sm hover-lift transition-all wow fadeInUp"
                                style="animation-delay: {{ $key * 0.1 }}s;">
                                <div class="position-relative overflow-hidden rounded-top-4">
                                    @if($value->cover)
                                        <img src="{{ asset('storage/' . $value->cover) }}" class="card-img-top"
                                            style="height: 240px; object-fit: cover;" alt="{{ $value->judul }}">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                            style="height: 240px;">
                                            <i class="fas fa-image fa-3x text-muted opacity-25"></i>
                                        </div>
                                    @endif
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <span class="badge bg-white text-primary shadow-sm py-2 px-3 rounded-pill">
                                            {{ convertDatetileLocToDateShort($value->created_at) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <h5 class="card-title fw-bold mb-3">
                                        <a href="{{ route('layanan-berita.show', ['slug' => $value->slug]) }}"
                                            class="text-dark text-decoration-none stretched-link">
                                            {{ maxStr($value->judul, 60) }}
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted small mb-0">
                                        {{ maxStr(strip_tags($value->isi), 100) }}
                                    </p>
                                </div>
                                <div class="card-footer bg-transparent border-0 p-4 pt-0">
                                    <div class="d-flex align-items-center text-primary fw-semibold small">
                                        Baca Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-newspaper fa-3x text-muted opacity-25"></i>
                        </div>
                        <p class="text-muted">Belum ada berita terbaru.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <style>
        /* Feature Section */
        .features-v2-section {
            background: radial-gradient(circle at top, rgba(111, 76, 255, 0.35), transparent 55%),
                linear-gradient(135deg, #1f134b, #312e81 35%, #5b21b6 70%, #7c3aed);
        }

        .features-v2-glow {
            position: absolute;
            width: 380px;
            height: 380px;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.4;
            z-index: 0;
        }

        .features-v2-glow-1 {
            top: -80px;
            left: -120px;
            background: #7c3aed;
        }

        .features-v2-glow-2 {
            bottom: -120px;
            right: -60px;
            background: #38bdf8;
        }

        .feature-v2-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .feature-v2-list li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 14px;
            font-size: 0.95rem;
        }

        .feature-v2-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-top: 6px;
            background: linear-gradient(135deg, #a5b4fc, #f472b6);
            box-shadow: 0 0 20px rgba(164, 154, 255, 0.9);
            flex-shrink: 0;
        }

        .feature-stat {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
            padding: 1rem 1.25rem;
            min-width: 120px;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .feature-stat strong {
            display: block;
            font-size: 1.8rem;
            line-height: 1;
        }

        .feature-stat small {
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .feature-card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
        }

        .feature-card-v2 {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 1.75rem;
            padding: 1.75rem;
            color: #fff;
            min-height: 240px;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            box-shadow: 0 20px 45px rgba(25, 6, 58, 0.35);
            transition: transform 0.35s ease, box-shadow 0.35s ease;
            backdrop-filter: blur(10px);
        }

        .feature-card-v2:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 60px rgba(23, 9, 51, 0.6);
        }

        .feature-card-v2 h4 {
            font-weight: 600;
        }

        .feature-card-v2 p {
            color: rgba(255, 255, 255, 0.75);
            margin-bottom: 0;
        }

        .feature-card-icon {
            width: 58px;
            height: 58px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.25rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .feature-card-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.85);
        }

        .feature-card-meta span {
            padding: 0.35rem 0.8rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
        }

        .bg-gradient-secondary {
            background: linear-gradient(135deg, #ec4899, #f472b6);
        }

        .bg-gradient-tertiary {
            background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #34d399, #10b981);
        }

        @media (max-width: 991.98px) {
            .feature-card-grid {
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            }

            .feature-v2-section {
                border-radius: 0;
            }
        }

        @media (max-width: 575.98px) {
            .feature-stat {
                width: 100%;
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
    </style>
</x-user-layout>