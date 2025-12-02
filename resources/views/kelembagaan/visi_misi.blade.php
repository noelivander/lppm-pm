<x-user-layout>
    <x-slot name="title">
        {{ __('Visi Misi Organisasi') }}
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
                    <li class="breadcrumb-item active" aria-current="page" style="color: white;">Visi & Misi</li>
                </ol>
            </nav>
            
            <div class="row align-items-center g-5">
                <!-- Left Content -->
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="mb-4">
                        <span class="badge px-4 py-2" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius: 50px; color: white; font-weight: 500; font-size: 0.9rem;">
                            <i class="fas fa-bullseye me-2"></i>{{ $data['hero_badge'] ?? 'Arah & Tujuan' }}
                        </span>
                    </div>
                    
                    <h1 class="display-3 fw-bold text-white mb-4" style="line-height: 1.2;">
                        {{ $data['hero_title'] ?? 'Visi & Misi' }}<br>
                        <span style="background: linear-gradient(135deg, #a78bfa 0%, #ec4899 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">LPPM-PM ITH</span>
                    </h1>
                    
                    <p class="lead text-white mb-4" style="opacity: 0.9; line-height: 1.8; font-size: 1.1rem;">
                        {{ $data['hero_description'] ?? 'Arah dan tujuan LPPM-PM ITH dalam pengembangan ilmu pengetahuan, teknologi, dan penjaminan mutu pendidikan tinggi' }}
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="d-flex flex-wrap gap-3 mt-5">
                        <a href="#content" class="btn btn-lg px-4 py-3" style="background: white; color: #1e1b4b; border-radius: 50px; font-weight: 600; box-shadow: 0 10px 30px rgba(0,0,0,0.2); transition: all 0.3s ease;">
                            <i class="fas fa-arrow-down me-2"></i>Lihat Detail
                        </a>
                        <a href="{{ route('kelembagaan_struktur_organisasi') }}" class="btn btn-lg btn-outline-light px-4 py-3" style="border-radius: 50px; font-weight: 600; border: 2px solid rgba(255,255,255,0.3); backdrop-filter: blur(10px); transition: all 0.3s ease;">
                            <i class="fas fa-sitemap me-2"></i>Struktur Organisasi
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
                                        <i class="fas fa-bullseye fa-3x text-white"></i>
                                    </div>
                                    <h4 class="fw-bold mb-2" style="color: #1e1b4b;">Visi & Misi Kami</h4>
                                    <p class="text-muted mb-0">Komitmen untuk keunggulan akademik</p>
                                </div>
                                
                                <!-- Value List -->
                                <div class="row g-3">
                                    @if(isset($data['hero_cards']) && is_array($data['hero_cards']))
                                        @foreach($data['hero_cards'] as $card)
                                        <div class="col-12">
                                            <div class="d-flex align-items-center p-3" style="background: #f8fafc; border-radius: 15px;">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); border-radius: 12px;">
                                                        <i class="{{ $card['icon'] }} text-white"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold" style="color: #1e1b4b;">{{ $card['title'] }}</h6>
                                                    <small class="text-muted">{{ $card['subtitle'] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
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
                    <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
                        <div class="card-body p-5">
                            <!-- Decorative Element -->
                            <div class="mb-4 text-center">
                                <div class="d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); border-radius: 20px;">
                                    <i class="fas fa-bullseye fa-2x" style="color: #4f46e5;"></i>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="prose" style="max-width: 100%; line-height: 1.8; color: #374151;">
                                {!! $data['main_content'] ?? '' !!}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Value Cards -->
                    <div class="row g-4 mt-4">
                        @if(isset($data['value_cards']) && is_array($data['value_cards']))
                            @foreach($data['value_cards'] as $card)
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100 hover-lift" style="border-radius: 15px; transition: all 0.3s ease;">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); border-radius: 12px;">
                                                    <i class="{{ $card['icon'] }}" style="color: #4f46e5;"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h5 style="color: #1e1b4b; font-weight: 600;">{{ $card['title'] }}</h5>
                                                <p class="text-muted mb-0" style="font-size: 0.9rem;">{{ $card['desc'] }}</p>
                                            </div>
                                        </div>
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
    </style>
    @endpush
</x-user-layout>