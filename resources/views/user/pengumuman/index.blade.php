@extends('layouts.user-v2.app')

@section('title', 'Pengumuman')

@section('styles')
<style>
    :root {
        --primary-color: #4f46e5;
        --primary-dark: #3730a3;
        --primary-light: #818cf8;
        --dark-color: #1e293b;
        --light-color: #f8fafc;
        --gray-color: #94a3b8;
        --border-radius: 15px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .announcement-card {
        border: none;
        border-radius: var(--border-radius);
        overflow: hidden;
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
        background: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    }
    
    .announcement-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15) !important;
    }
    
    .announcement-card:hover .announcement-image {
        transform: scale(1.05);
    }
    
    .announcement-card:hover .read-more-btn {
        box-shadow: 0 4px 15px rgba(124, 58, 237, 0.4);
    }
    
    .announcement-image-container {
        width: 100%;
        height: 200px;
        overflow: hidden;
        position: relative;
    }
    
    .announcement-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .announcement-badge {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0.75rem;
        background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(124, 58, 237, 0.3);
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .announcement-date {
        font-size: 0.85rem;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .announcement-date i {
        color: var(--primary-color);
    }
    
    .announcement-views {
        font-size: 0.85rem;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .announcement-views i {
        color: var(--primary-color);
    }
    
    .announcement-card-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        background: white;
    }
    
    .announcement-meta {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        font-size: 0.85rem;
    }
    
    .announcement-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0 0 0.75rem 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 3rem;
        color: #1e1b4b;
    }
    
    .announcement-excerpt {
        color: #64748b;
        margin-bottom: 1rem;
        flex-grow: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 4.5em;
        font-size: 0.9rem;
        line-height: 1.6;
    }
    
    .read-more-btn {
        background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        font-size: 0.875rem;
        transition: var(--transition);
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }
    
    .read-more-btn:hover {
        color: white;
        transform: translateX(3px);
    }
    
    .sort-btn {
        padding: 0.5rem 1rem;
        border: 2px solid rgba(255, 255, 255, 0.3);
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border-radius: 50px;
        font-weight: 500;
        transition: var(--transition);
        cursor: pointer;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        backdrop-filter: blur(10px);
    }
    
    .sort-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
    }
    
    .sort-btn.active {
        background: white;
        color: #7c3aed;
        border-color: white;
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
    }
    
    .no-results {
        text-align: center;
        padding: 5rem 2rem;
        background: #f8fafc;
        border-radius: var(--border-radius);
    }
    
    .no-results i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 1.5rem;
        opacity: 0.3;
    }
    
    .no-results h5 {
        color: #64748b;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    
    .no-results p {
        color: var(--gray-color);
        margin: 0;
    }
    
    .loading-spinner {
        width: 3rem;
        height: 3rem;
        border: 0.3rem solid rgba(79, 70, 229, 0.1);
        border-top-color: var(--primary-color);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    @keyframes float-delayed {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
    }
    
    .fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
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
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="position-relative overflow-hidden py-5" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #3730a3 100%);">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center text-white">
                <h1 class="display-4 fw-bold mb-3" style="animation: float 3s ease-in-out infinite;">Pengumuman Terkini</h1>
                <p class="lead mb-4">Dapatkan informasi terbaru dan pengumuman penting dari LPPM-PM ITH</p>
                
                <!-- Sort Options -->
                <div class="d-flex justify-content-center flex-wrap gap-3 mb-4">
                    <a href="{{ route('layanan-pengumuman.index', ['sort' => 'latest']) }}" class="sort-btn {{ request('sort', 'latest') == 'latest' ? 'active' : '' }}">
                        <i class="fas fa-clock me-2"></i>Terbaru
                    </a>
                    <a href="{{ route('layanan-pengumuman.index', ['sort' => 'popular']) }}" class="sort-btn {{ request('sort') == 'popular' ? 'active' : '' }}">
                        <i class="fas fa-fire me-2"></i>Populer
                    </a>
                    <a href="{{ route('layanan-pengumuman.index', ['sort' => 'oldest']) }}" class="sort-btn {{ request('sort') == 'oldest' ? 'active' : '' }}">
                        <i class="fas fa-history me-2"></i>Terlama
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Floating Background Elements -->
    <div class="position-absolute" style="top: 10%; left: 5%; width: 100px; height: 100px; background: rgba(255,255,255,0.05); border-radius: 50%; animation: float 6s ease-in-out infinite;"></div>
    <div class="position-absolute" style="top: 60%; right: 10%; width: 150px; height: 150px; background: rgba(255,255,255,0.03); border-radius: 50%; animation: float-delayed 8s ease-in-out infinite;"></div>
</section>

<!-- Pengumuman Section -->
<section class="py-5">
    <div class="container">
        <!-- Loading State -->
        <div id="loading" class="text-center py-5 d-none">
            <div class="spinner-border text-primary loading-spinner" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 text-muted">Memuat pengumuman...</p>
        </div>

        <!-- Announcement Grid -->
        <div class="row g-4" id="announcementList">
            @forelse($pengumuman as $item)
                <div class="col-lg-3 col-md-4 col-sm-6 fade-in-up">
                    <article class="announcement-card h-100">
                        <div class="announcement-image-container">
                            @if($item->gambar)
                                <img src="{{ Storage::url($item->gambar) }}" 
                                     class="announcement-image" 
                                     alt="{{ $item->judul }}"
                                     loading="lazy">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100" style="background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);">
                                    <i class="fas fa-bullhorn fa-4x text-primary" style="opacity: 0.3;"></i>
                                </div>
                            @endif
                            <div class="announcement-badge">
                                <i class="far fa-bell me-1"></i> Pengumuman
                            </div>
                        </div>
                        <div class="announcement-card-body">
                            <div class="announcement-meta">
                                <span class="announcement-date">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ $item->created_at->format('d M Y') }}
                                </span>
                                <span class="mx-1">•</span>
                                <span class="announcement-views">
                                    <i class="far fa-eye"></i>
                                    {{ number_format($item->dilihat ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                            <h5 class="announcement-title">
                                {{ Str::limit($item->judul, 65) }}
                            </h5>
                            <p class="announcement-excerpt">
                                {{ Str::limit(strip_tags($item->isi), 100) }}
                            </p>
                            <a href="{{ route('pengumuman.show', $item->slug) }}" class="read-more-btn w-100">
                                Baca Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="no-results">
                        <div class="mb-4">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <h5>Belum ada pengumuman tersedia</h5>
                        <p>Silakan kunjungi kembali nanti untuk informasi terbaru</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(method_exists($pengumuman, 'links'))
            <div class="d-flex justify-content-center mt-5">
                {{ $pengumuman->links() }}
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scroll to top on pagination click
        document.querySelectorAll('.pagination a').forEach(link => {
            link.addEventListener('click', function(e) {
                setTimeout(() => {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }, 100);
            });
        });
        
        // Add fade-in animation to cards
        const cards = document.querySelectorAll('.fade-in-up');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>
@endpush