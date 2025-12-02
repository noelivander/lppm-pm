<x-user-layout>
    <x-slot name="title">
        {{ __('Struktur Organisasi') }}
    </x-slot>

    <!-- Hero Section -->
    <section class="position-relative overflow-hidden" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #3730a3 100%); min-height: 70vh;">
        <!-- Decorative Background Elements -->
        <div class="position-absolute" style="top: -10%; right: -5%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(124, 58, 237, 0.15) 0%, transparent 70%); border-radius: 50%;"></div>
        <div class="position-absolute" style="bottom: -15%; left: -8%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(59, 130, 246, 0.12) 0%, transparent 70%); border-radius: 50%;"></div>
        
        <div class="container position-relative" style="padding-top: 6rem; padding-bottom: 4rem;">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb" style="background: transparent;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: rgba(255,255,255,0.7); text-decoration: none;"><i class="fas fa-home me-1"></i>Beranda</a></li>
                    <li class="breadcrumb-item"><span style="color: rgba(255,255,255,0.5);">Kelembagaan</span></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: white;">Struktur Organisasi</li>
                </ol>
            </nav>
            
            <div class="row align-items-center g-5">
                <!-- Left Content -->
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="mb-4">
                        <span class="badge px-4 py-2" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius: 50px; color: white; font-weight: 500; font-size: 0.9rem;">
                            <i class="fas fa-sitemap me-2"></i>{{ $data['hero_badge'] ?? 'Tata Kelola & Kepemimpinan' }}
                        </span>
                    </div>
                    
                    <h1 class="display-3 fw-bold text-white mb-4" style="line-height: 1.2;">
                        {{ $data['hero_title'] ?? 'Struktur Organisasi' }}<br>
                        <span style="background: linear-gradient(135deg, #a78bfa 0%, #ec4899 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">LPPM-PM ITH</span>
                    </h1>
                    
                    <p class="lead text-white mb-4" style="opacity: 0.9; line-height: 1.8; font-size: 1.1rem;">
                        {{ $data['hero_description'] ?? 'Susunan hierarki dan alur koordinasi yang sinergis untuk mendukung visi dan misi lembaga dalam pengembangan riset dan pengabdian.' }}
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="d-flex flex-wrap gap-3 mt-5">
                        <a href="#chart" class="btn btn-lg px-4 py-3" style="background: white; color: #1e1b4b; border-radius: 50px; font-weight: 600; box-shadow: 0 10px 30px rgba(0,0,0,0.2); transition: all 0.3s ease;">
                            <i class="fas fa-arrow-down me-2"></i>Lihat Bagan
                        </a>
                        <a href="{{ route('kelembagaan_visi_misi') }}" class="btn btn-lg btn-outline-light px-4 py-3" style="border-radius: 50px; font-weight: 600; border: 2px solid rgba(255,255,255,0.3); backdrop-filter: blur(10px); transition: all 0.3s ease;">
                            <i class="fas fa-bullseye me-2"></i>Visi & Misi
                        </a>
                    </div>
                </div>
                
                <!-- Right Illustration -->
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="position-relative">
                        <!-- Main Illustration Card -->
                        <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); border-radius: 30px; overflow: hidden; transform: rotate(-2deg);">
                            <div class="card-body p-5">
                                <div class="text-center mb-4">
                                    <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 120px; height: 120px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 30px; box-shadow: 0 20px 40px rgba(59, 130, 246, 0.3);">
                                        <i class="fas fa-network-wired fa-3x text-white"></i>
                                    </div>
                                    <h4 class="fw-bold mb-2" style="color: #1e1b4b;">Hierarki & Koordinasi</h4>
                                    <p class="text-muted mb-0">Fondasi tata kelola yang kuat</p>
                                </div>
                                
                                <!-- Value List -->
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="d-flex align-items-center p-3" style="background: #f8fafc; border-radius: 15px;">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); border-radius: 12px;">
                                                    <i class="fas fa-search text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold" style="color: #1e1b4b;">Transparansi</h6>
                                                <small class="text-muted">Keterbukaan informasi publik</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex align-items-center p-3" style="background: #f8fafc; border-radius: 15px;">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 12px;">
                                                    <i class="fas fa-check-circle text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold" style="color: #1e1b4b;">Akuntabilitas</h6>
                                                <small class="text-muted">Tanggung jawab terukur</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex align-items-center p-3" style="background: #f8fafc; border-radius: 15px;">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 12px;">
                                                    <i class="fas fa-handshake text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold" style="color: #1e1b4b;">Sinergitas</h6>
                                                <small class="text-muted">Kerjasama lintas sektor</small>
                                            </div>
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

    <!-- Content Section -->
    <section class="py-5" id="chart">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <!-- Organization Chart Visualization -->
                    <div class="card border-0 shadow-sm mb-5" style="border-radius: 20px; overflow: hidden;">
                        <div class="card-body p-5">
                            <!-- Decorative Element -->
                            <div class="mb-4 text-center">
                                <div class="d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); border-radius: 20px;">
                                    <i class="fas fa-sitemap fa-2x" style="color: #4f46e5;"></i>
                                </div>
                                <h3 class="mt-4 mb-2" style="color: #1e1b4b; font-weight: 700;">Bagan Organisasi</h3>
                                <p class="text-muted">Struktur hierarki kepemimpinan LPPM-PM ITH</p>
                            </div>
                            
                            @if(!empty($data['chart_image']))
                            <div class="text-center">
                                <img src="{{ asset($data['chart_image']) }}" alt="Bagan Organisasi" class="img-fluid rounded shadow-sm">
                            </div>
                            @else
                            <div class="alert alert-info text-center">
                                Belum ada bagan organisasi yang diunggah.
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Text Content -->
                    <div class="card border-0 shadow-sm mb-5" style="border-radius: 20px; overflow: hidden;">
                        <div class="card-body p-5">
                            <div class="mb-4 text-center">
                                <div class="d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); border-radius: 20px;">
                                    <i class="fas fa-info-circle fa-2x" style="color: #4f46e5;"></i>
                                </div>
                                <h3 class="mt-4 mb-2" style="color: #1e1b4b; font-weight: 700;">Informasi Struktur</h3>
                            </div>
                            
                            <!-- Content -->
                            <div class="prose" style="max-width: 100%; line-height: 1.8; color: #374151;">
                                {!! $data['main_content'] ?? '' !!}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Organization Info Cards -->
                    <div class="row g-4">
                        @if(isset($data['info_cards']) && is_array($data['info_cards']))
                            @foreach($data['info_cards'] as $card)
                            <div class="col-lg-3 col-md-6">
                                <div class="card border-0 shadow-sm h-100 text-center hover-lift" style="border-radius: 15px; transition: all 0.3s ease;">
                                    <div class="card-body p-4">
                                        <div class="mb-3">
                                            <div class="d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); border-radius: 15px;">
                                                <i class="{{ $card['icon'] }} fa-2x" style="color: #4f46e5;"></i>
                                            </div>
                                        </div>
                                        <h5 style="color: #1e1b4b; font-weight: 600; margin-bottom: 0.5rem;">{{ $card['title'] }}</h5>
                                        <p class="text-muted mb-0">{{ $card['desc'] }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('styles')
    <style>
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        }
        .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
            color: #1e1b4b;
            font-weight: 600;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }
        .prose p {
            margin-bottom: 1rem;
        }
        .prose ul, .prose ol {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
        }
        .prose img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin: 1.5rem 0;
        }
    </style>
    @endpush
</x-user-layout>