<x-user-layout>
    <!-- Hero Section -->
    <section class="position-relative overflow-hidden hero-section"
        style="background: linear-gradient(135deg, #312e81 0%, #4c1d95 50%, #1e1b4b 100%);">
        <!-- Animated Background Elements -->
        <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden" style="z-index: 0;">
            <div class="position-absolute top-0 start-50 translate-middle rounded-circle opacity-20 animate-pulse"
                style="width: 800px; height: 800px; background: radial-gradient(circle, #818cf8 0%, transparent 70%); filter: blur(80px);">
            </div>
            <div class="position-absolute bottom-0 end-0 translate-middle-x rounded-circle opacity-20 animate-float"
                style="width: 600px; height: 600px; background: radial-gradient(circle, #c084fc 0%, transparent 70%); filter: blur(60px);">
            </div>
            <!-- Grid Pattern -->
            <div class="position-absolute top-0 start-0 w-100 h-100"
                style="background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 30px 30px; opacity: 0.1;">
            </div>
        </div>

        <div class="container position-relative" style="z-index: 2;">
            <div class="row min-vh-100 align-items-center py-5">
                <!-- Text Content Column -->
                <div class="col-lg-7 text-white wow fadeInLeft" data-wow-duration="1.2s">
                    <div class="position-relative d-inline-block mb-4">
                    </div>

                    <h1 class="display-3 fw-bold mb-4 leading-tight text-white">
                        {{ $landingPage['title_prefix'] ?? 'Lembaga Penelitian &' }} <br>
                        <span class="text-transparent bg-clip-text"
                            style="background-image: linear-gradient(to right, #a5b4fc, #e879f9);">{{ $landingPage['title_suffix'] ?? 'Pengabdian Kepada Masyarakat' }}</span>
                    </h1>

                    <p class="lead mb-5 text-indigo-100 col-lg-10 lh-lg opacity-90">
                        {{ $landingPage['hero_description'] ?? 'Mengembangkan potensi akademik melalui penelitian bermutu dan pengabdian yang berdampak nyata bagi masyarakat luas.' }}
                    </p>

                    <div class="d-flex flex-wrap gap-3">
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

                    <div class="row mt-5 pt-4 border-top border-white-10 g-4">
                        <div class="col-auto">
                            <div class="d-flex align-items-center gap-3">
                                <div class="display-6 fw-bold text-white">{{ $landingPage['stat_1_value'] ?? '150' }}
                                </div>
                                <div class="text-indigo-200 small lh-sm">
                                    {{ $landingPage['stat_1_label'] ?? 'Penelitian' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-auto border-start border-white-10 ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="display-6 fw-bold text-white">{{ $landingPage['stat_2_value'] ?? '85' }}
                                </div>
                                <div class="text-indigo-200 small lh-sm">
                                    {{ $landingPage['stat_2_label'] ?? 'Pengabdian' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-auto border-start border-white-10 ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="display-6 fw-bold text-white">{{ $landingPage['stat_3_value'] ?? '50' }}
                                </div>
                                <div class="text-indigo-200 small lh-sm">
                                    {{ $landingPage['stat_3_label'] ?? 'Dosen Aktif' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carousel Column -->
                <div class="col-lg-5 position-relative wow fadeInRight" data-wow-duration="1.2s" data-wow-delay="0.2s">
                    <div x-data="{
                            activeSlide: 0,
                            slides: [
                                '{{ ($landingPage['hero_image'] ?? null) ?: 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=800&q=80' }}',
                                '{{ ($landingPage['hero_image_2'] ?? null) ?: 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=800&q=80' }}',
                                '{{ ($landingPage['hero_image_3'] ?? null) ?: 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=80' }}'
                            ],
                            init() {
                                setInterval(() => {
                                    this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                                }, 5000);
                            }
                        }"
                        class="position-relative">
                        
                        <!-- Carousel Container -->
                        <div class="relative w-full h-[400px] rounded-2xl overflow-hidden shadow-2xl border-4 border-white/10 backdrop-blur-sm">
                            <template x-for="(slide, index) in slides" :key="index">
                                <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                                    x-show="activeSlide === index"
                                    x-transition:enter="transition ease-out duration-1000"
                                    x-transition:enter-start="opacity-0 transform scale-105"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    x-transition:leave="transition ease-in duration-1000"
                                    x-transition:leave-start="opacity-100 transform scale-100"
                                    x-transition:leave-end="opacity-0 transform scale-95">
                                    <img :src="slide" class="w-full h-full object-cover" alt="Hero Image">
                                </div>
                            </template>

                            <!-- Indicators -->
                            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2 z-20">
                                <template x-for="(slide, index) in slides" :key="index">
                                    <button @click="activeSlide = index"
                                        class="w-2 h-2 rounded-full transition-all duration-300"
                                        :class="activeSlide === index ? 'bg-white w-6' : 'bg-white/50 hover:bg-white/80'"></button>
                                </template>
                            </div>
                        </div>

                        <!-- Decorative Elements -->
                        <div class="position-absolute -top-6 -right-6 w-24 h-24 bg-indigo-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                        <div class="position-absolute -bottom-6 -left-6 w-24 h-24 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                    </div>
                    <!-- Decorative Glow -->
                    <div class="position-absolute top-50 start-50 translate-middle rounded-circle bg-purple-500 opacity-20"
                        style="width: 300px; height: 300px; filter: blur(60px); z-index: -1;"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light position-relative">
        <div class="container py-5 position-relative z-2">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center wow fadeInUp">
                    <span
                        class="text-primary fw-bold text-uppercase small tracking-wider">{{ $landingPage['features_subtitle'] ?? 'Keunggulan Kami' }}</span>
                    <h2 class="display-6 fw-bold mt-2 text-dark">
                        {{ $landingPage['features_title'] ?? 'Mengapa Memilih LPPM?' }}
                    </h2>
                    <p class="text-muted mt-3">
                        {{ $landingPage['features_description'] ?? 'Kami menyediakan infrastruktur dan dukungan komprehensif untuk memajukan kualitas penelitian.' }}
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Feature 1 -->
                <div class="col-md-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div
                        class="card h-100 border-0 shadow-hover transition-all bg-white rounded-4 overflow-hidden group">
                        <div class="card-body p-4 text-center">
                            <div
                                class="d-inline-flex align-items-center justify-content-center w-16 h-16 rounded-circle bg-blue-50 text-primary mb-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-microscope fa-2x"></i>
                            </div>
                            <h4 class="fw-bold mb-3">
                                {{ $landingPage['feature_1_title'] ?? 'Riset Berkualitas' }}
                            </h4>
                            <p class="text-muted mb-0">
                                {{ $landingPage['feature_1_desc'] ?? 'Mendukung penelitian inovatif yang relevan dengan kebutuhan industri dan masyarakat.' }}
                            </p>
                        </div>
                        <div class="h-1 w-0 bg-primary group-hover:w-100 transition-all duration-300"></div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
                    <div
                        class="card h-100 border-0 shadow-hover transition-all bg-white rounded-4 overflow-hidden group">
                        <div class="card-body p-4 text-center">
                            <div
                                class="d-inline-flex align-items-center justify-content-center w-16 h-16 rounded-circle bg-indigo-50 text-indigo-600 mb-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                            <h4 class="fw-bold mb-3">
                                {{ $landingPage['feature_2_title'] ?? 'Pengabdian Masyarakat' }}
                            </h4>
                            <p class="text-muted mb-0">
                                {{ $landingPage['feature_2_desc'] ?? 'Memberikan solusi nyata bagi permasalahan sosial melalui program pengabdian terukur.' }}
                            </p>
                        </div>
                        <div class="h-1 w-0 bg-indigo-600 group-hover:w-100 transition-all duration-300">
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="col-md-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div
                        class="card h-100 border-0 shadow-hover transition-all bg-white rounded-4 overflow-hidden group">
                        <div class="card-body p-4 text-center">
                            <div
                                class="d-inline-flex align-items-center justify-content-center w-16 h-16 rounded-circle bg-sky-50 text-sky-500 mb-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-globe fa-2x"></i>
                            </div>
                            <h4 class="fw-bold mb-3">
                                {{ $landingPage['feature_3_title'] ?? 'Publikasi Global' }}
                            </h4>
                            <p class="text-muted mb-0">
                                {{ $landingPage['feature_3_desc'] ?? 'Mendorong diseminasi hasil penelitian di tingkat nasional maupun internasional.' }}
                            </p>
                        </div>
                        <div class="h-1 w-0 bg-sky-500 group-hover:w-100 transition-all duration-300"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5 bg-white overflow-hidden">
        <div class="container py-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 wow fadeInLeft">
                    <div class="position-relative">
                        <div class="position-absolute top-0 start-0 translate-middle bg-warning rounded-circle opacity-25"
                            style="width: 200px; height: 200px; filter: blur(40px);"></div>
                        <div class="position-absolute bottom-0 end-0 translate-middle bg-primary rounded-circle opacity-25"
                            style="width: 200px; height: 200px; filter: blur(40px);"></div>
                        <img src="{{ $landingPage['about_image'] ?? 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1470&q=80' }}"
                            class="img-fluid rounded-5 shadow-lg position-relative" alt="Tentang LPPM">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight">
                    <span
                        class="text-primary fw-bold text-uppercase small tracking-wider">{{ $landingPage['about_subtitle'] ?? 'Tentang Kami' }}</span>
                    <h2 class="display-5 fw-bold mb-4 text-dark">
                        {{ $landingPage['about_title'] ?? 'Mewujudkan Visi Melalui Riset Unggulan' }}
                    </h2>
                    <p class="lead text-muted mb-4">
                        {{ $landingPage['about_description'] ?? 'LPPM berkomitmen untuk menjadi pusat unggulan dalam pengelolaan penelitian dan pengabdian kepada masyarakat yang adaptif terhadap perkembangan zaman.' }}
                    </p>

                    <div class="d-flex flex-column gap-3 mb-5">
                        <div class="d-flex align-items-center gap-3">
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-circle bg-green-100 text-green-600 d-flex align-items-center justify-content-center">
                                <i class="fas fa-check"></i>
                            </div>
                            <span
                                class="fw-medium text-dark">{{ $landingPage['about_point_1'] ?? 'Manajemen Riset Terintegrasi' }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-circle bg-green-100 text-green-600 d-flex align-items-center justify-content-center">
                                <i class="fas fa-check"></i>
                            </div>
                            <span
                                class="fw-medium text-dark">{{ $landingPage['about_point_2'] ?? 'Kolaborasi Multi-Disiplin' }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-circle bg-green-100 text-green-600 d-flex align-items-center justify-content-center">
                                <i class="fas fa-check"></i>
                            </div>
                            <span
                                class="fw-medium text-dark">{{ $landingPage['about_point_3'] ?? 'Hilirisasi Hasil Inovasi' }}</span>
                        </div>
                    </div>

                    <a href="{{ route('tentang-satker.index') }}"
                        class="btn btn-primary rounded-pill px-4 py-2 shadow-sm hover-transform">
                        Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5 wow fadeInUp">
                <h2 class="display-6 fw-bold text-dark">
                    {{ $landingPage['services_title'] ?? 'Layanan Akademik' }}
                </h2>
                <p class="text-muted">
                    {{ $landingPage['services_subtitle'] ?? 'Akses berbagai layanan pendukung kegiatan akademik Anda' }}
                </p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-hover transition-all wow fadeInUp">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <i class="fas fa-calendar-alt fa-3x text-primary"></i>
                            </div>
                            <h4 class="fw-bold mb-3">{{ $landingPage['service_1_title'] ?? 'Agenda Kegiatan' }}</h4>
                            <p class="text-muted mb-4">{{ $landingPage['service_1_desc'] ?? 'Jadwal lengkap seminar, workshop, dan kegiatan ilmiah lainnya.' }}
                            </p>
                            <a href="{{ route('layanan-agenda.index') }}"
                                class="text-primary fw-semibold text-decoration-none stretched-link">
                                Lihat Agenda <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-hover transition-all wow fadeInUp" data-wow-delay="0.1s">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <i class="fas fa-bullhorn fa-3x text-success"></i>
                            </div>
                            <h4 class="fw-bold mb-3">{{ $landingPage['service_2_title'] ?? 'Pengumuman' }}</h4>
                            <p class="text-muted mb-4">{{ $landingPage['service_2_desc'] ?? 'Informasi terbaru seputar hibah, beasiswa, dan kebijakan.' }}</p>
                            <a href="{{ route('layanan-pengumuman.index') }}"
                                class="text-success fw-semibold text-decoration-none stretched-link">
                                Cek Pengumuman <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-hover transition-all wow fadeInUp" data-wow-delay="0.2s">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <i class="fas fa-file-alt fa-3x text-info"></i>
                            </div>
                            <h4 class="fw-bold mb-3">{{ $landingPage['service_3_title'] ?? 'Dokumen' }}</h4>
                            <p class="text-muted mb-4">{{ $landingPage['service_3_desc'] ?? 'Unduh panduan, template, dan dokumen resmi lainnya.' }}
                            </p>
                            <a href="{{ route('dokumen.index') }}"
                                class="text-info fw-semibold text-decoration-none stretched-link">
                                Unduh File <i class="fas fa-arrow-right ms-1"></i>
                            </a>
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

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-delayed {
            animation: float 6s ease-in-out 3s infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .shadow-hover:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        /* Responsive Slider Height */
        .hero-slider-height {
            height: 300px;
        }

        @media (min-width: 768px) {
            .hero-slider-height {
                height: 400px;
            }
        }

        @media (min-width: 992px) {
            .hero-slider-height {
                height: 550px;
            }
        }
    </style>
</x-user-layout>