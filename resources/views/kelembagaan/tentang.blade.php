<x-user-layout>
    <x-slot name="title">
        {{ __('Tentang Organisasi') }}
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
                    <li class="breadcrumb-item active" aria-current="page" style="color: white;">Tentang</li>
                </ol>
            </nav>
            
            <div class="row align-items-center g-5">
                <!-- Left Content -->
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="mb-4">
                        <span class="badge px-4 py-2" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius: 50px; color: white; font-weight: 500; font-size: 0.9rem;">
                            <i class="fas fa-bullseye me-2"></i>{{ $data['hero_badge'] ?? 'Tentang' }}
                        </span>
                    </div>
                    
                    <h1 class="display-3 fw-bold text-white mb-4" style="line-height: 1.2;">
                        {{ $data['hero_title'] ?? 'Visi & Misi' }}<br>
                        <span style="background: linear-gradient(135deg, #a78bfa 0%, #ec4899 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">LPPM-PM ITH</span>
                    </h1>
                    
                     <p class="lead text-white mb-4" style="opacity: 0.9; line-height: 1.8; font-size: 1.1rem;">
                        {{ $data['hero_description'] ?? 'Arah dan tujuan LPPM-PM ITH dalam pengembangan ilmu pengetahuan, teknologi, dan penjaminan mutu pendidikan tinggi' }}
                    </p>
                    
                    <!-- Stats Row -->
                    <div class="row g-4 mt-4">
                        @if(isset($data['stats']) && is_array($data['stats']))
                            @foreach($data['stats'] as $stat)
                            <div class="col-6 col-md-4">
                                <div class="text-center p-3" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 15px; border: 1px solid rgba(255,255,255,0.1);">
                                    <div class="display-6 fw-bold text-white mb-1">
                                        <i class="{{ $stat['icon'] }}" style="font-size: 1.5rem; color: {{ $stat['color'] }};"></i>
                                    </div>
                                    <div class="small text-white" style="opacity: 0.8;">{{ $stat['value'] }}</div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    
                    <!-- CTA Buttons -->
                    <div class="d-flex flex-wrap gap-3 mt-5">
                        <a href="#content" class="btn btn-lg px-4 py-3" style="background: white; color: #1e1b4b; border-radius: 50px; font-weight: 600; box-shadow: 0 10px 30px rgba(0,0,0,0.2); transition: all 0.3s ease;">
                            <i class="fas fa-arrow-down me-2"></i>Pelajari Lebih Lanjut
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
                                    <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 120px; height: 120px; background: linear-gradient(135deg, #7c3aed 0%, #ec4899 100%); border-radius: 30px; box-shadow: 0 20px 40px rgba(124, 58, 237, 0.3);">
                                        <i class="fas fa-university fa-3x text-white"></i>
                                    </div>
                                    <h4 class="fw-bold mb-2" style="color: #1e1b4b;">Institut Teknologi Habibie</h4>
                                    <p class="text-muted mb-0">Lembaga Penelitian, Pengabdian Masyarakat & Penjaminan Mutu</p>
                                </div>
                                
                                <!-- Feature List -->
                                <div class="row g-3">
                                    @if(isset($data['features']) && is_array($data['features']))
                                        @foreach($data['features'] as $feature)
                                        <div class="col-12">
                                            <div class="d-flex align-items-center p-3" style="background: #f8fafc; border-radius: 15px;">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); border-radius: 12px;">
                                                        <i class="{{ $feature['icon'] }} text-white"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold" style="color: #1e1b4b;">{{ $feature['title'] }}</h6>
                                                    <small class="text-muted">{{ $feature['desc'] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating Badge -->
                        <div class="position-absolute" style="top: -20px; right: -20px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); padding: 1rem 1.5rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(245, 158, 11, 0.4); transform: rotate(5deg);">
                            <div class="text-center text-white">
                                <div class="fw-bold" style="font-size: 1.5rem;">{{ $data['founded_year'] }}</div>
                                <div class="small">Berdiri</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </section>

    <!-- Content Section -->
    <section class="py-5" id="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <!-- Section Header -->
                    <div class="text-center mb-5" data-aos="fade-up">
                        <span class="badge px-4 py-2 mb-3" style="background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); color: #4f46e5; border-radius: 50px; font-weight: 600;">
                            <i class="fas fa-info-circle me-2"></i>Profil Lengkap
                        </span>
                        <h2 class="fw-bold mb-3" style="color: #1e1b4b; font-size: 2.5rem;">Profil LPPM-PM ITH</h2>
                        <p class="text-muted" style="font-size: 1.1rem;">Informasi lengkap tentang lembaga kami</p>
                    </div>
                    
                    <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;" data-aos="fade-up" data-aos-delay="100">
                        <div class="card-body p-4 p-md-5">
                            <!-- Decorative Element -->
                            <div class="mb-4 text-center">
                                <div class="d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); border-radius: 20px;">
                                    <i class="fas fa-building fa-2x" style="color: #4f46e5;"></i>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="prose" style="max-width: 100%; line-height: 1.8; color: #374151;">
                                {!! $data['main_content'] !!}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Info Cards -->
                    <div class="row g-4 mt-5">
                        @if(isset($data['stats']) && is_array($data['stats']))
                            @foreach($data['stats'] as $index => $stat)
                            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ 200 + ($index * 100) }}">
                                <div class="card border-0 shadow-sm h-100 hover-lift" style="border-radius: 20px; transition: all 0.3s ease; background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);">
                                    <div class="card-body p-4 text-center">
                                        <div class="mb-3">
                                            <div class="d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: linear-gradient(135deg, {{ $stat['color'] }} 0%, {{ $stat['color'] }}dd 100%); border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0, 0.1);">
                                                <i class="{{ $stat['icon'] }} fa-lg text-white"></i>
                                            </div>
                                        </div>
                                        <h5 style="color: #1e1b4b; font-weight: 700; margin-bottom: 0.75rem;">{{ $stat['value'] }}</h5>
                                        <p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.6;">
                                            @if($index == 0) Mendorong penelitian berkualitas dan inovatif yang berdampak
                                            @elseif($index == 1) Berkontribusi nyata untuk kemajuan masyarakat
                                            @else Menjaga standar kualitas pendidikan tinggi
                                            @endif
                                        </p>
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
        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
        
        /* Hover Effects */
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
        }
        
        /* Button Hover */
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.25) !important;
        }
        
        /* Prose Styling */
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
        
        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(45deg); }
            50% { transform: translateY(-20px) rotate(45deg); }
        }
        
        @keyframes float-delayed {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-25px); }
        }
        
        /* Breadcrumb Hover */
        .breadcrumb-item a:hover {
            color: white !important;
            text-decoration: underline !important;
        }
        
        /* Gradient Text Animation */
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Responsive Adjustments */
        @media (max-width: 991px) {
            .display-3 {
                font-size: 2.5rem !important;
            }
            
            section[style*="min-height: 70vh"] {
                min-height: auto !important;
                padding-top: 4rem !important;
                padding-bottom: 3rem !important;
            }
            
            .card[style*="transform: rotate(-2deg)"] {
                transform: rotate(0deg) !important;
            }
        }
        
        @media (max-width: 768px) {
            .display-3 {
                font-size: 2rem !important;
            }
            
            .lead {
                font-size: 1rem !important;
            }
            
            .btn-lg {
                padding: 0.75rem 1.5rem !important;
                font-size: 0.95rem !important;
            }
            
            .position-absolute[style*="top: -20px"] {
                top: 10px !important;
                right: 10px !important;
                transform: rotate(0deg) !important;
            }
        }
        
        @media (max-width: 576px) {
            .container[style*="padding-top: 6rem"] {
                padding-top: 3rem !important;
                padding-bottom: 2rem !important;
            }
            
            .col-6.col-md-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>
    @endpush
    
    @push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                offset: 100
            });
            
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
    @endpush
</x-user-layout>