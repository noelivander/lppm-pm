@extends('layouts.user-v2.app')

@section('title', $pengumuman->judul)

@push('styles')
<style>
    .banner-section {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        padding: 5rem 0 7rem;
        position: relative;
        overflow: hidden;
        color: white;
    }
    .banner-shape {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        line-height: 0;
    }
    .banner-shape svg {
        position: relative;
        display: block;
        width: calc(100% + 1.3px);
        height: 100px;
    }
    .banner-content {
        position: relative;
        z-index: 1;
    }
    .breadcrumb {
        justify-content: center;
        background: transparent;
        padding: 0.5rem 0;
    }
    .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: all 0.3s;
    }
    .breadcrumb-item a:hover {
        color: white;
        text-decoration: underline;
    }
    .breadcrumb-item.active {
        color: white;
        font-weight: 500;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.6);
    }
    .pengumuman-image {
        width: 100%;
        max-height: 500px;
        object-fit: cover;
        border-radius: 12px 12px 0 0;
    }
    .pengumuman-tag {
        position: absolute;
        top: 20px;
        left: 20px;
        background: white;
        color: #4f46e5;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .pengumuman-date {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(79, 70, 229, 0.9);
        color: white;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .share-buttons .btn {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 3px;
        transition: all 0.3s;
    }
    .share-buttons .btn:hover {
        transform: translateY(-3px);
    }
    .nav-links a {
        color: #4f46e5;
        text-decoration: none;
        transition: all 0.3s;
    }
    .nav-links a:hover {
        color: #4338ca;
        text-decoration: underline;
    }
    .content-wrapper {
        line-height: 1.8;
    }
    .content-wrapper img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5rem 0;
    }
    .content-wrapper h2, 
    .content-wrapper h3, 
    .content-wrapper h4 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #1f2937;
    }
    .content-wrapper p {
        margin-bottom: 1.2rem;
    }
    @media (max-width: 768px) {
        .banner-section {
            padding: 4rem 0 6rem;
        }
        .banner-shape svg {
            height: 60px;
        }
    }
</style>
@endpush

@section('content')
<!-- Banner Section -->
<section class="banner-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-5 fw-bold mb-3">{{ $pengumuman->judul }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('layanan-pengumuman.index') }}">Pengumuman</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="banner-shape">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100">
            <path fill="#ffffff" fill-opacity="1" d="M0,64L48,80C96,96,192,128,288,138.7C384,149,480,139,576,128C672,117,768,107,864,117.3C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

<!-- Pengumuman Detail -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-5">
                    @if($pengumuman->cover)
                    <div class="position-relative">
                        <img src="{{ asset('storage/'.$pengumuman->cover) }}" 
                             class="pengumuman-image" 
                             alt="{{ $pengumuman->judul }}">
                        @if($pengumuman->tag)
                            <span class="pengumuman-tag">
                                <i class="fas fa-tag me-1"></i> {{ $pengumuman->tag }}
                            </span>
                        @endif
                        <span class="pengumuman-date">
                            <i class="far fa-calendar-alt me-1"></i> {{ $pengumuman->created_at->format('d M Y') }}
                        </span>
                    </div>
                    @endif
                    
                    <div class="card-body p-4 p-md-5">
                        <!-- Author and Date -->
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 pb-3 border-bottom">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-light rounded-circle p-2 me-3">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <p class="mb-0 small text-muted">Oleh</p>
                                    <p class="mb-0 fw-medium">{{ $pengumuman->user->name ?? 'Admin' }}</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-light rounded-circle p-2 me-3">
                                    <i class="far fa-calendar-alt text-primary"></i>
                                </div>
                                <div>
                                    <p class="mb-0 small text-muted">Tanggal</p>
                                    <p class="mb-0 fw-medium">{{ $pengumuman->created_at->translatedFormat('d F Y') }}</p>
                                </div>
                            </div>
                            @if($pengumuman->dokumen)
                            <div class="d-flex align-items-center mb-2">
                                <a href="{{ asset('storage/'.$pengumuman->dokumen) }}" class="btn btn-outline-primary btn-sm" download>
                                    <i class="fas fa-download me-1"></i> Unduh Dokumen
                                </a>
                            </div>
                            @endif
                        </div>

                        <!-- Share Buttons -->
                        <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                            <h6 class="mb-0">Bagikan:</h6>
                            <div class="share-buttons">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                                   target="_blank" 
                                   class="btn btn-light text-primary"
                                   title="Share on Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($pengumuman->judul) }}" 
                                   target="_blank" 
                                   class="btn btn-light text-info"
                                   title="Share on Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($pengumuman->judul . ' ' . url()->current()) }}" 
                                   target="_blank" 
                                   class="btn btn-light text-success"
                                   title="Share on WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <button class="btn btn-light text-secondary" 
                                        onclick="navigator.clipboard.writeText('{{ url()->current() }}').then(() => alert('Link berhasil disalin!'))"
                                        title="Salin link">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="content-wrapper">
                            {!! $pengumuman->isi !!}
                        </div>

                        @if($pengumuman->dokumen)
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="mb-3">Lampiran Dokumen:</h6>
                            <a href="{{ asset('storage/'.$pengumuman->dokumen) }}" class="btn btn-outline-primary" download>
                                <i class="fas fa-file-pdf me-2"></i> Unduh Dokumen
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Navigation -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center py-4 border-top">
                    @php
                        $prev = \App\Models\Pengumuman::where('id', '<', $pengumuman->id)
                            ->orderBy('id', 'desc')
                            ->first();
                        $next = \App\Models\Pengumuman::where('id', '>', $pengumuman->id)
                            ->orderBy('id', 'asc')
                            ->first();
                    @endphp
                    
                    @if($prev)
                        <a href="{{ route('layanan-pengumuman.show', $prev->slug) }}" class="btn btn-outline-primary mb-3 mb-md-0">
                            <i class="fas fa-arrow-left me-2"></i> Pengumuman Sebelumnya
                            <div class="small text-muted mt-1">{{ Str::limit($prev->judul, 30) }}</div>
                        </a>
                    @else
                        <div></div>
                    @endif
                    
                    <a href="{{ route('layanan-pengumuman.index') }}" class="btn btn-outline-secondary mb-3 mb-md-0">
                        <i class="fas fa-list me-2"></i> Semua Pengumuman
                    </a>
                    
                    @if($next)
                        <a href="{{ route('layanan-pengumuman.show', $next->slug) }}" class="btn btn-outline-primary text-end">
                            Pengumuman Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
                            <div class="small text-muted mt-1">{{ Str::limit($next->judul, 30) }}</div>
                        </a>
                    @else
                        <div></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    /* Page Banner */
    .page-banner {
        position: relative;
        overflow: hidden;
        padding: 100px 0 80px;
        color: #fff;
    }
    
    .banner-shape {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        line-height: 0;
    }
    
    .banner-shape svg {
        position: relative;
        display: block;
        width: 100%;
        height: 100px;
    }
    
    /* Pengumuman Content */
    .pengumuman-content {
        line-height: 1.8;
        color: #4a5568;
    }
    
    .pengumuman-content h2,
    .pengumuman-content h3,
    .pengumuman-content h4 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #1e1b4b;
        font-weight: 600;
    }
    
    .pengumuman-content p {
        margin-bottom: 1.5rem;
    }
    
    .pengumuman-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5rem 0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .pengumuman-content a {
        color: #4f46e5;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .pengumuman-content a:hover {
        color: #4338ca;
        text-decoration: underline;
    }
    
    .pengumuman-content ul,
    .pengumuman-content ol {
        margin-bottom: 1.5rem;
        padding-left: 1.5rem;
    }
    
    .pengumuman-content li {
        margin-bottom: 0.5rem;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .page-banner {
            padding: 80px 0 60px;
        }
        
        .banner-shape svg {
            height: 60px;
        }
        
        .card-body {
            padding: 1.5rem !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Copy to clipboard function
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Show tooltip or alert
            const tooltip = document.createElement('div');
            tooltip.className = 'position-fixed bg-dark text-white px-3 py-2 rounded';
            tooltip.style.top = '20px';
            tooltip.style.right = '20px';
            tooltip.style.zIndex = '9999';
            tooltip.textContent = 'Tautan berhasil disalin!';
            document.body.appendChild(tooltip);
            
            // Remove tooltip after 3 seconds
            setTimeout(function() {
                tooltip.remove();
            }, 3000);
        }).catch(function(err) {
            console.error('Gagal menyalin teks: ', err);
        });
    }
    
    // Add lightbox to images
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.pengumuman-content img');
        
        images.forEach(img => {
            // Add cursor pointer to indicate clickable
            img.style.cursor = 'zoom-in';
            
            // Add click event to open in new tab
            img.addEventListener('click', function() {
                window.open(this.src, '_blank');
            });
        });
    });
</script>
@endpush
@endsection