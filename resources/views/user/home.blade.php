<x-user-layout>
    <!-- Hero Section with Image Slider -->
    <section class="position-relative overflow-hidden" style="min-height: 100vh; background: linear-gradient(135deg, #1e1b4b 0%, #312e81 30%, #4c1d95 70%, #5b21b6 100%);">
        <!-- Animated Background Elements -->
        <div class="position-absolute top-0 start-0 w-100 h-100" style="pointer-events: none; z-index: 1;">
            <div class="position-absolute rounded-circle animate-float" style="width: 300px; height: 300px; background: rgba(124,58,237,0.15); top: 5%; left: 5%; filter: blur(60px);"></div>
            <div class="position-absolute rounded-circle animate-float-delayed" style="width: 250px; height: 250px; background: rgba(79,70,229,0.1); top: 50%; right: 10%; filter: blur(50px);"></div>
            <div class="position-absolute rounded-circle animate-float" style="width: 200px; height: 200px; background: rgba(168,85,247,0.12); bottom: 10%; left: 15%; filter: blur(45px);"></div>
        </div>
        
        <div class="container py-5" style="position: relative; z-index: 2;">
            <div class="row align-items-center" style="min-height: 100vh;">
                <!-- Left Content -->
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="text-white">
                        
                        <h1 class="display-2 fw-bold mb-4 reveal" style="animation-delay: 0.1s; line-height: 1.2; text-shadow: 0 4px 20px rgba(0,0,0,0.3);">
                            <span style="background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">LPPM-PM</span>
                            <br>
                            <span style="color: #c4b5fd; font-size: 0.7em;">Institut Teknologi Habibie</span>
                        </h1>
                        
                        <p class="lead mb-4 reveal" style="animation-delay: 0.2s; color: rgba(255,255,255,0.9); font-size: 1.15rem; line-height: 1.8;">
                            Mendorong inovasi penelitian, pengabdian masyarakat, dan penjaminan mutu untuk kemajuan bangsa Indonesia melalui riset berkualitas dan pengabdian berkelanjutan.
                        </p>
                        
                        <!-- CTA Buttons -->
                        <div class="d-flex flex-wrap gap-3 mb-5 reveal" style="animation-delay: 0.3s;">
                            <a href="{{ route('kelembagaan_tentang') }}" class="btn btn-lg px-5 py-3" style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); border: none; border-radius: 50px; color: white; font-weight: 600; box-shadow: 0 10px 30px rgba(124,58,237,0.4); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 40px rgba(124,58,237,0.5)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(124,58,237,0.4)';">
                                <i class="fas fa-info-circle me-2"></i>Tentang Kami
                            </a>
                            <a href="{{ route('dokumen.index') }}" class="btn btn-lg px-5 py-3" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 2px solid rgba(255,255,255,0.3); border-radius: 50px; color: white; font-weight: 600; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255,255,255,0.2)'; this.style.borderColor='rgba(255,255,255,0.5)';" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(255,255,255,0.3)';">
                                <i class="fas fa-file-alt me-2"></i>Dokumen
                            </a>
                        </div>
                        
                        <!-- Quick Stats -->
                        <div class="row g-3 reveal" style="animation-delay: 0.4s;">
                            <div class="col-6 col-md-3">
                                <div class="text-center p-3" style="background: rgba(255,255,255,0.08); backdrop-filter: blur(10px); border-radius: 16px; border: 1px solid rgba(255,255,255,0.1);">
                                    <div class="h2 mb-1 fw-bold" style="color: #a78bfa;">{{ $totalPenelitian ?? '0' }}</div>
                                    <div class="small" style="color: rgba(255,255,255,0.7);">Penelitian</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="text-center p-3" style="background: rgba(255,255,255,0.08); backdrop-filter: blur(10px); border-radius: 16px; border: 1px solid rgba(255,255,255,0.1);">
                                    <div class="h2 mb-1 fw-bold" style="color: #c4b5fd;">{{ $totalPengabdian ?? '0' }}</div>
                                    <div class="small" style="color: rgba(255,255,255,0.7);">Pengabdian</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="text-center p-3" style="background: rgba(255,255,255,0.08); backdrop-filter: blur(10px); border-radius: 16px; border: 1px solid rgba(255,255,255,0.1);">
                                    <div class="h2 mb-1 fw-bold" style="color: #ddd6fe;">{{ $totalDosen ?? '0' }}</div>
                                    <div class="small" style="color: rgba(255,255,255,0.7);">Dosen</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="text-center p-3" style="background: rgba(255,255,255,0.08); backdrop-filter: blur(10px); border-radius: 16px; border: 1px solid rgba(255,255,255,0.1);">
                                    <div class="h2 mb-1 fw-bold" style="color: #ede9fe;">{{ $totalProdi ?? '0' }}</div>
                                    <div class="small" style="color: rgba(255,255,255,0.7);">Program Studi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Content - Image Slider -->
                <div class="col-lg-6">
                    <div class="reveal" style="animation-delay: 0.2s;">
                        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                            <!-- Indicators -->
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>
                            
                            <!-- Slides -->
                            <div class="carousel-inner" style="border-radius: 24px; overflow: hidden; box-shadow: 0 25px 60px rgba(0,0,0,0.4); border: 3px solid rgba(255,255,255,0.1);">
                                <div class="carousel-item active">
                                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1470&q=80" class="d-block w-100" alt="Kampus ITH 1" style="height: 500px; object-fit: cover;">
                                    <div class="carousel-caption d-none d-md-block" style="background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 100%); left: 0; right: 0; bottom: 0; padding: 40px 20px 20px;">
                                        <h5 class="fw-bold">Kampus Modern ITH</h5>
                                        <p>Fasilitas lengkap untuk mendukung penelitian dan pengabdian</p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1470&q=80" class="d-block w-100" alt="Kampus ITH 2" style="height: 500px; object-fit: cover;">
                                    <div class="carousel-caption d-none d-md-block" style="background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 100%); left: 0; right: 0; bottom: 0; padding: 40px 20px 20px;">
                                        <h5 class="fw-bold">Laboratorium Terkini</h5>
                                        <p>Peralatan canggih untuk riset berkualitas internasional</p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img src="https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=1470&q=80" class="d-block w-100" alt="Kampus ITH 3" style="height: 500px; object-fit: cover;">
                                    <div class="carousel-caption d-none d-md-block" style="background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 100%); left: 0; right: 0; bottom: 0; padding: 40px 20px 20px;">
                                        <h5 class="fw-bold">Ruang Kolaborasi</h5>
                                        <p>Tempat berkumpul dan berdiskusi untuk inovasi bersama</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Controls -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        
                        <!-- Floating Info Cards -->
                        <div class="position-relative mt-4">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="p-3 text-center" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                                        <i class="fas fa-award mb-2" style="font-size: 2rem; color: #7c3aed;"></i>
                                        <div class="fw-bold" style="color: #1e1b4b;">Terakreditasi</div>
                                        <div class="small text-muted">BAN-PT</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 text-center" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                                        <i class="fas fa-globe mb-2" style="font-size: 2rem; color: #6d28d9;"></i>
                                        <div class="fw-bold" style="color: #1e1b4b;">Kerjasama</div>
                                        <div class="small text-muted">Internasional</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4" style="z-index: 3;">
            <div class="text-center">
                <div class="animate-bounce" style="animation: bounce 2s infinite;">
                    <i class="fas fa-chevron-down" style="color: rgba(255,255,255,0.6); font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>
    </section>

    <section class="position-relative overflow-hidden" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #3730a3 100%);">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="pointer-events:none;">
            <div class="position-absolute rounded-circle" style="width:80px;height:80px;left:20%;top:20%;filter:blur(24px); background: radial-gradient(ellipse at center, rgba(79,70,229,.55), transparent 60%);"></div>
            <div class="position-absolute rounded-circle" style="width:120px;height:120px;right:25%;top:35%;filter:blur(28px); background: radial-gradient(ellipse at center, rgba(124,58,237,.55), transparent 60%);"></div>
            <div class="position-absolute rounded-circle" style="width:90px;height:90px;right:35%;bottom:20%;filter:blur(26px); background: radial-gradient(ellipse at center, rgba(168,85,247,.45), transparent 60%);"></div>
        </div>
        <div class="container py-5 px-lg-5">
            <div class="text-center text-white mb-4">
                <span class="badge bg-light text-dark reveal">Keunggulan Kami</span>
                <h2 class="text-white mt-3 reveal" style="animation-delay: 0.1s;">Mengapa Memilih LPPM-PM ITH?</h2>
                <p class="text-white-50 mb-0 reveal" style="animation-delay: 0.2s;">Pelayanan modern, aman, dan mudah diakses untuk mendukung penelitian dan pengabdian.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="modern-card h-100 reveal">
                        <div class="modern-card-body">
                            <div class="d-inline-flex align-items-center justify-content-center rounded" style="width:64px;height:64px;background:#e0e7ff;color:#4f46e5;">
                                <i class="fa fa-tachometer-alt fa-lg"></i>
                            </div>
                            <h5 class="mt-3 mb-2">Pelayanan Cepat</h5>
                            <p class="text-muted mb-0">Proses layanan efisien didukung tim profesional siap bantu.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="modern-card h-100 reveal" style="animation-delay: 0.1s;">
                        <div class="modern-card-body">
                            <div class="d-inline-flex align-items-center justify-content-center rounded" style="width:64px;height:64px;background:#dcfce7;color:#16a34a;">
                                <i class="fa fa-shield-alt fa-lg"></i>
                            </div>
                            <h5 class="mt-3 mb-2">Keamanan Terjamin</h5>
                            <p class="text-muted mb-0">Data terlindungi dengan pengamanan berlapis dan audit rutin.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="modern-card h-100 reveal" style="animation-delay: 0.2s;">
                        <div class="modern-card-body">
                            <div class="d-inline-flex align-items-center justify-content-center rounded" style="width:64px;height:64px;background:#f3e8ff;color:#7c3aed;">
                                <i class="fa fa-cloud-upload-alt fa-lg"></i>
                            </div>
                            <h5 class="mt-3 mb-2">Akses Dimana Saja</h5>
                            <p class="text-muted mb-0">Aplikasi berbasis web memudahkan akses kapan pun, di mana pun.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-3 mt-2">
                <div class="col-sm-6 col-lg-3">
                    <div class="modern-card text-center reveal">
                        <div class="modern-card-body">
                            <div class="h3 mb-1 text-black">{{ $totalPenelitian ?? '0' }}</div>
                            <div class="text-black-50 small">Penelitian</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="modern-card text-center reveal" style="animation-delay: 0.1s;">
                        <div class="modern-card-body">
                            <div class="h3 mb-1 text-black">{{ $totalPengabdian ?? '0' }}</div>
                            <div class="text-black-50 small">Pengabdian</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="modern-card text-center reveal" style="animation-delay: 0.2s;">
                        <div class="modern-card-body">
                            <div class="h3 mb-1 text-black">{{ $totalDosen ?? '0' }}</div>
                            <div class="text-black-50 small">Dosen Peneliti</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="modern-card text-center reveal" style="animation-delay: 0.3s;">
                        <div class="modern-card-body">
                            <div class="h3 mb-1 text-black">{{ $totalBerita ?? '0' }}</div>
                            <div class="text-black-50 small">Total Berita</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pencapaian & Statistik Section -->
    <section class="py-5" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
        <div class="container px-lg-5">
            <div class="text-center mb-5">
                <span class="badge bg-primary text-white mb-3 reveal">Pencapaian Kami</span>
                <h2 class="gradient-text reveal" style="animation-delay: 0.1s;">Statistik & Prestasi LPPM-PM ITH</h2>
                <p class="text-muted reveal" style="animation-delay: 0.2s;">Pencapaian yang membanggakan dalam penelitian, pengabdian masyarakat, dan penjaminan mutu</p>
            </div>
            
            <div class="row g-4 mb-5">
                <div class="col-lg-3 col-md-6">
                    <div class="modern-card text-center h-100 reveal">
                        <div class="modern-card-body">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:80px;height:80px;background:linear-gradient(135deg, #4f46e5, #3730a3);">
                                <i class="fas fa-flask text-white" style="font-size:2rem;"></i>
                            </div>
                            <h3 class="text-primary fw-bold mb-2 counter" data-target="50">0</h3>
                            <h6 class="text-muted mb-3">Penelitian Aktif</h6>
                            <p class="small text-muted">Proyek penelitian multidisiplin yang sedang berjalan</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="modern-card text-center h-100 reveal" style="animation-delay: 0.1s;">
                        <div class="modern-card-body">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:80px;height:80px;background:linear-gradient(135deg, #10b981, #059669);">
                                <i class="fas fa-hands-helping text-white" style="font-size:2rem;"></i>
                            </div>
                            <h3 class="text-success fw-bold mb-2 counter" data-target="30">0</h3>
                            <h6 class="text-muted mb-3">Pengabdian Masyarakat</h6>
                            <p class="small text-muted">Program pengabdian yang berdampak positif</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="modern-card text-center h-100 reveal" style="animation-delay: 0.2s;">
                        <div class="modern-card-body">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:80px;height:80px;background:linear-gradient(135deg, #7c3aed, #6d28d9);">
                                <i class="fas fa-user-tie text-white" style="font-size:2rem;"></i>
                            </div>
                            <h3 class="text-purple fw-bold mb-2 counter" data-target="100">0</h3>
                            <h6 class="text-muted mb-3">Dosen Peneliti</h6>
                            <p class="small text-muted">Tenaga pengajar yang aktif dalam penelitian</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="modern-card text-center h-100 reveal" style="animation-delay: 0.3s;">
                        <div class="modern-card-body">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:80px;height:80px;background:linear-gradient(135deg, #f59e0b, #d97706);">
                                <i class="fas fa-award text-white" style="font-size:2rem;"></i>
                            </div>
                            <h3 class="text-warning fw-bold mb-2 counter" data-target="25">0</h3>
                            <h6 class="text-muted mb-3">Publikasi Internasional</h6>
                            <p class="small text-muted">Jurnal internasional terindeks Scopus</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik Pencapaian -->
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="modern-card reveal">
                        <div class="modern-card-body">
                            <h5 class="mb-4">Tren Penelitian 5 Tahun Terakhir</h5>
                            <div class="d-flex justify-content-between align-items-end mb-3" style="height: 200px;">
                                <div class="text-center">
                                    <div class="bg-primary rounded" style="height: 60px; width: 40px; margin: 0 auto 10px;"></div>
                                    <small class="text-muted">2019</small>
                                </div>
                                <div class="text-center">
                                    <div class="bg-primary rounded" style="height: 80px; width: 40px; margin: 0 auto 10px;"></div>
                                    <small class="text-muted">2020</small>
                                </div>
                                <div class="text-center">
                                    <div class="bg-primary rounded" style="height: 100px; width: 40px; margin: 0 auto 10px;"></div>
                                    <small class="text-muted">2021</small>
                                </div>
                                <div class="text-center">
                                    <div class="bg-primary rounded" style="height: 120px; width: 40px; margin: 0 auto 10px;"></div>
                                    <small class="text-muted">2022</small>
                                </div>
                                <div class="text-center">
                                    <div class="bg-primary rounded" style="height: 140px; width: 40px; margin: 0 auto 10px;"></div>
                                    <small class="text-muted">2023</small>
                                </div>
                            </div>
                            <p class="small text-muted mb-0">Peningkatan konsisten dalam jumlah penelitian setiap tahun</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="modern-card reveal" style="animation-delay: 0.2s;">
                        <div class="modern-card-body">
                            <h5 class="mb-4">Distribusi Bidang Penelitian</h5>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded me-3" style="width:20px;height:20px;background:#3b82f6;"></div>
                                        <div>
                                            <div class="fw-semibold">Teknologi</div>
                                            <div class="small text-muted">40%</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded me-3" style="width:20px;height:20px;background:#10b981;"></div>
                                        <div>
                                            <div class="fw-semibold">Sosial</div>
                                            <div class="small text-muted">30%</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded me-3" style="width:20px;height:20px;background:#8b5cf6;"></div>
                                        <div>
                                            <div class="fw-semibold">Kesehatan</div>
                                            <div class="small text-muted">20%</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded me-3" style="width:20px;height:20px;background:#f59e0b;"></div>
                                        <div>
                                            <div class="fw-semibold">Lainnya</div>
                                            <div class="small text-muted">10%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container px-lg-5">
            <div class="text-center mb-4">
                <span class="badge bg-light text-dark reveal">Tentang Kami</span>
                <h2 class="mt-2 reveal" style="animation-delay: 0.1s;">Mengenal LPPM-PM ITH</h2>
                <p class="text-muted mb-0 reveal" style="animation-delay: 0.2s;">Unit pelaksana penelitian, pengabdian masyarakat, dan penjaminan mutu di lingkungan ITH.</p>
            </div>
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="modern-card overflow-hidden reveal">
                        <img class="img-fluid" src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1470&q=80" alt="Kampus ITH">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="modern-card reveal" style="animation-delay: 0.1s;">
                        <div class="modern-card-body">
                            <p class="mb-3">LPPM-PM ITH mendukung visi dan misi institut dalam pengembangan iptek berorientasi kebutuhan industri dan masyarakat.</p>
                            <div class="d-flex mb-3">
                                <div class="me-3 d-flex align-items-center justify-content-center rounded-circle" style="width:48px;height:48px;background:#e0e7ff;color:#4f46e5;">
                                    <i class="fa fa-bolt"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Visi</div>
                                    <div class="text-muted">Menjadi pusat unggulan penelitian dan pengabdian yang inovatif dan berkelanjutan.</div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="me-3 d-flex align-items-center justify-content-center rounded-circle" style="width:48px;height:48px;background:#dcfce7;color:#16a34a;">
                                    <i class="fa fa-list"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Misi</div>
                                    <ul class="text-muted mb-0">
                                        <li>Menyelenggarakan penelitian bermutu dan inovatif</li>
                                        <li>Melaksanakan pengabdian tepat guna dan berkelanjutan</li>
                                        <li>Membangun jejaring dengan pemangku kepentingan</li>
                                        <li>Meningkatkan mutu layanan</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('kelembagaan_tentang') }}" class="modern-btn modern-btn-primary">Hubungi Kami</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan Section -->
    <section class="py-5" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
        <div class="container px-lg-5">
            <div class="text-center mb-5">
                <span class="badge bg-primary text-white mb-3 reveal">Layanan Kami</span>
                <h2 class="gradient-text reveal" style="animation-delay: 0.1s;">Solusi Terbaik untuk Kebutuhan Anda</h2>
                <p class="text-muted reveal" style="animation-delay: 0.2s;">Berbagai layanan untuk mendukung kegiatan akademik dan penelitian.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="modern-card h-100 shadow-glow reveal">
                        <div class="modern-card-body">
                            <div class="d-flex align-items-center justify-content-center rounded mb-3" style="height:192px;background:linear-gradient(135deg, #3730a3, #4f46e5);">
                                <i class="fa fa-calendar-alt text-white" style="font-size:3rem;"></i>
                            </div>
                            <h5 class="fw-bold">Agenda Kegiatan</h5>
                            <p class="text-muted mb-3">Informasi lengkap tentang jadwal kegiatan penelitian, seminar, workshop, dan pengabdian masyarakat.</p>
                            <ul class="list-unstyled small text-muted mb-3">
                                <li><i class="fas fa-check text-primary me-2"></i>Seminar Nasional</li>
                                <li><i class="fas fa-check text-primary me-2"></i>Workshop Penelitian</li>
                                <li><i class="fas fa-check text-primary me-2"></i>Pengabdian Masyarakat</li>
                            </ul>
                            <a href="{{ route('layanan-agenda.index') }}" class="modern-btn modern-btn-primary w-100">Lihat Agenda</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="modern-card h-100 shadow-glow reveal" style="animation-delay: 0.1s;">
                        <div class="modern-card-body">
                            <div class="d-flex align-items-center justify-content-center rounded mb-3" style="height:192px;background:linear-gradient(135deg, #16a34a, #10b981);">
                                <i class="fa fa-bullhorn text-white" style="font-size:3rem;"></i>
                            </div>
                            <h5 class="fw-bold">Pengumuman</h5>
                            <p class="text-muted mb-3">Kabar terbaru seputar beasiswa, pendaftaran penelitian, dan informasi penting lainnya.</p>
                            <ul class="list-unstyled small text-muted mb-3">
                                <li><i class="fas fa-check text-success me-2"></i>Beasiswa Penelitian</li>
                                <li><i class="fas fa-check text-success me-2"></i>Pendaftaran Hibah</li>
                                <li><i class="fas fa-check text-success me-2"></i>Informasi Penting</li>
                            </ul>
                            <a href="{{ route('layanan-pengumuman.index') }}" class="modern-btn modern-btn-success w-100">Lihat Pengumuman</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="modern-card h-100 shadow-glow reveal" style="animation-delay: 0.2s;">
                        <div class="modern-card-body">
                            <div class="d-flex align-items-center justify-content-center rounded mb-3" style="height:192px;background:linear-gradient(135deg, #6d28d9, #7c3aed);">
                                <i class="fa fa-file-alt text-white" style="font-size:3rem;"></i>
                            </div>
                            <h5 class="fw-bold">Dokumen Publik</h5>
                            <p class="text-muted mb-3">Kumpulan dokumen penting yang dapat diunduh oleh masyarakat umum dan peneliti.</p>
                            <ul class="list-unstyled small text-muted mb-3">
                                <li><i class="fas fa-check text-purple me-2"></i>Template Proposal</li>
                                <li><i class="fas fa-check text-purple me-2"></i>Panduan Penelitian</li>
                                <li><i class="fas fa-check text-purple me-2"></i>Laporan Tahunan</li>
                            </ul>
                            <a href="{{ route('dokumen.index') }}" class="modern-btn modern-btn-purple w-100">Lihat Dokumen</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Berita & Pengumuman Terbaru Section -->
    <section class="py-5" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
        <div class="container px-lg-5">
            <div class="text-center mb-5">
                <span class="badge px-4 py-2 mb-3 reveal" style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); color: white; border-radius: 50px;">
                    <i class="fas fa-newspaper me-2"></i>Informasi Terkini
                </span>
                <h2 class="fw-bold reveal" style="animation-delay: 0.1s; color: #1e1b4b;">
                    Berita & Pengumuman <span class="gradient-text">Terbaru</span>
                </h2>
                <p class="text-muted reveal" style="animation-delay: 0.2s;">Update terbaru dari LPPM-PM ITH untuk Anda</p>
            </div>
            
            <div class="row g-4">
                <!-- Berita Terbaru -->
                <div class="col-lg-8">
                    <div class="modern-card reveal hover-lift" style="border: 2px solid #e0e7ff;">
                        <div class="modern-card-body">
                            <div class="d-flex align-items-center mb-4 pb-3" style="border-bottom: 2px solid #f1f5f9;">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle me-3" style="width:60px;height:60px;background:linear-gradient(135deg, #7c3aed, #6d28d9); box-shadow: 0 8px 20px rgba(124,58,237,0.3);">
                                    <i class="fas fa-newspaper text-white" style="font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1 fw-bold" style="color: #1e1b4b;">Berita Terbaru</h4>
                                    <p class="text-muted small mb-0">Informasi terkini seputar kegiatan LPPM-PM ITH</p>
                                </div>
                            </div>
                            
                            <div class="row g-4">
                                @forelse($berita as $key => $value)
                                    @if($key < 3)
                                    <div class="col-md-6">
                                        <div class="position-relative" style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(124,58,237,0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.08)';">
                                            @if($value->cover)
                                            <img src="{{ asset('storage/'.$value->cover) }}" class="w-100" style="height:180px;object-fit:cover;" alt="{{ $value->judul }}">
                                            @else
                                            <div class="w-100 d-flex align-items-center justify-content-center" style="height:180px;background:linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);">
                                                <i class="fas fa-image" style="font-size: 3rem; color: #7c3aed; opacity: 0.3;"></i>
                                            </div>
                                            @endif
                                            <div class="p-3" style="background: white;">
                                                <div class="d-flex align-items-center mb-2">
                                                    <span class="badge me-2" style="background: #e0e7ff; color: #5b21b6; font-size: 0.7rem;">{{ convertDatetileLocToDateShort($value->created_at) }}</span>
                                                </div>
                                                <h6 class="mb-2 fw-bold" style="color: #1e1b4b; line-height: 1.4;">{{ maxStr($value->judul, 60) }}</h6>
                                                <p class="small text-muted mb-3" style="line-height: 1.6;">{{ maxStr(strip_tags($value->isi), 90) }}</p>
                                                <a href="{{ route('layanan-berita.show',['slug'=>$value->slug]) }}" class="btn btn-sm px-3" style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); color: white; border-radius: 50px; font-weight: 600; transition: all 0.3s ease;" onmouseover="this.style.transform='translateX(5px)';" onmouseout="this.style.transform='translateX(0)';">
                                                    Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @empty
                                    <div class="col-12">
                                        <div class="text-center py-5">
                                            <i class="fas fa-inbox" style="font-size: 4rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
                                            <p class="text-muted">Belum ada berita tersedia</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            
                            @if(count($berita) > 0)
                            <div class="text-center mt-4 pt-3" style="border-top: 2px solid #f1f5f9;">
                                <a href="{{ route('layanan-berita.index') }}" class="btn btn-lg px-5 py-3" style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); color: white; border-radius: 50px; font-weight: 600; box-shadow: 0 8px 20px rgba(124,58,237,0.3); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 30px rgba(124,58,237,0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(124,58,237,0.3)';">
                                    <i class="fas fa-newspaper me-2"></i>Lihat Semua Berita
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Pengumuman Terbaru -->
                <div class="col-lg-4">
                    <div class="modern-card reveal" style="animation-delay: 0.1s;">
                        <div class="modern-card-body">
                            <div class="d-flex align-items-center mb-4">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle me-3" style="width:50px;height:50px;background:linear-gradient(135deg, #10b981, #059669);">
                                    <i class="fas fa-bullhorn text-white"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Pengumuman</h5>
                                    <p class="text-muted small mb-0">Informasi penting yang perlu Anda ketahui</p>
                                </div>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="d-flex align-items-start p-3 rounded" style="background:#f8fafc;">
                                    <div class="me-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:#10b981;">
                                            <i class="fas fa-calendar text-white small"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Pendaftaran Hibah Penelitian 2024</h6>
                                        <p class="small text-muted mb-2">Pendaftaran dibuka hingga 30 November 2024</p>
                                        <span class="badge bg-success small">Aktif</span>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-start p-3 rounded" style="background:#f8fafc;">
                                    <div class="me-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:#4f46e5;">
                                            <i class="fas fa-users text-white small"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Seminar Nasional Penelitian</h6>
                                        <p class="small text-muted mb-2">15 Desember 2024 di Auditorium ITH</p>
                                        <span class="badge bg-primary small">Mendatang</span>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-start p-3 rounded" style="background:#f8fafc;">
                                    <div class="me-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:#7c3aed;">
                                            <i class="fas fa-graduation-cap text-white small"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Workshop Penulisan Jurnal</h6>
                                        <p class="small text-muted mb-2">Pelatihan untuk dosen dan peneliti</p>
                                        <span class="badge bg-purple small">Berlangsung</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center mt-4">
                                <a href="{{ route('layanan-pengumuman.index') }}" class="modern-btn modern-btn-success">Lihat Semua Pengumuman</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-user-layout>