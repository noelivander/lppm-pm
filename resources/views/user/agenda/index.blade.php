@extends('layouts.user-v2.app')

@section('title', 'Agenda')

@push('styles')
<style>
    .agenda-card {
        transition: all 0.3s ease;
        height: 100%;
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    .agenda-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .agenda-date {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(79, 70, 229, 0.9);
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .agenda-category {
        position: absolute;
        top: 15px;
        left: 15px;
        background: white;
        color: #4f46e5;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .agenda-image {
        height: 200px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .agenda-card:hover .agenda-image {
        transform: scale(1.05);
    }
    .filter-section {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    .btn-filter {
        border-radius: 8px;
        padding: 0.6rem 1.25rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    .btn-primary {
        background-color: #4f46e5;
        border: none;
    }
    .btn-primary:hover {
        background-color: #4338ca;
        transform: translateY(-2px);
    }
    .btn-outline-secondary {
        border-color: #e2e8f0;
        color: #64748b;
    }
    .btn-outline-secondary:hover {
        background-color: #f1f5f9;
        border-color: #cbd5e1;
        color: #475569;
    }
    .form-select, .form-control {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
    }
    .form-select:focus, .form-control:focus {
        border-color: #a5b4fc;
        box-shadow: 0 0 0 3px rgba(165, 180, 252, 0.3);
    }
    .empty-state {
        background: #f8fafc;
        border-radius: 12px;
        padding: 3rem 2rem;
        text-align: center;
    }
    .empty-state i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 1.5rem;
    }
</style>
@endpush

@section('content')
<!-- Page Header Start -->
<div class="container-fluid bg-primary py-5 mb-5">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="display-4 text-white fw-bold mb-4">Agenda Kegiatan</h1>
                <p class="text-white-50 mb-4">Jadwal dan informasi kegiatan terbaru dari LPPM Universitas Teknokrat Indonesia</p>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Beranda</a></li>
                        <li class="breadcrumb-item text-white-50 active" aria-current="page">Agenda</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Filter Section Start -->
<section class="filter-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="bg-white p-4 rounded-3 shadow-sm">
                    <h5 class="mb-4 text-dark"><i class="fas fa-filter me-2 text-primary"></i>Filter Agenda</h5>
                    <form id="filterForm" class="row g-3">
                        <div class="col-md-5">
                            <label for="monthFilter" class="form-label fw-medium text-muted">Bulan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="far fa-calendar text-muted"></i></span>
                                <select id="monthFilter" class="form-select border-start-0 ps-2">
                                    <option value="">Semua Bulan</option>
                                    @foreach($availableMonths as $month)
                                        <option value="{{ $month['value'] }}" {{ request('month') == $month['value'] ? 'selected' : '' }}>
                                            {{ $month['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label for="categoryFilter" class="form-label fw-medium text-muted">Kategori</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-tag text-muted"></i></span>
                                <select id="categoryFilter" class="form-select border-start-0 ps-2">
                                    <option value="">Semua Kategori</option>
                                    @foreach($availableCategories as $category)
                                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" id="resetFilter" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-redo-alt me-2"></i>Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Filter Section End -->
</div>

<!-- Loading State -->
<div id="loadingState" class="d-none position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center" style="z-index: 1050;">
    <div class="bg-white p-4 rounded-3 shadow-lg">
        <div class="d-flex align-items-center">
            <div class="spinner-border text-primary me-3" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <span class="text-dark fw-medium">Memuat data agenda...</span>
        </div>
    </div>
</div>

<!-- Agenda List -->
<section class="py-5">
    <div class="container">
        @if($agenda->count() > 0)
            <div id="agendaGrid" class="row g-4">
                @foreach($agenda as $item)
                    <div class="col-lg-4 col-md-6" data-month="{{ \Carbon\Carbon::parse($item->jadwal)->format('n') }}" data-category="{{ $item->tag ?? '' }}">
                        <div class="card h-100 border-0 shadow-sm agenda-card">
                            @if($item->cover)
                                <div class="position-relative overflow-hidden" style="height: 200px;">
                                    <img src="{{ asset('storage/' . $item->cover) }}" class="card-img-top img-fluid h-100 w-100 agenda-image" alt="{{ $item->judul }}" style="object-fit: cover;">
                                    <div class="agenda-category">
                                        <i class="fas fa-tag me-1"></i> {{ $item->tag ?? 'Umum' }}
                                    </div>
                                    <div class="agenda-date">
                                        <i class="far fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($item->jadwal)->translatedFormat('d M') }}
                                    </div>
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="far fa-clock text-muted me-2"></i>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }} WIB
                                    </small>
                                </div>
                                <h5 class="card-title fw-bold mb-3">{{ $item->judul }}</h5>
                                @if($item->deskripsi_singkat)
                                    <p class="card-text text-muted mb-4">
                                        {{ Str::limit(strip_tags($item->deskripsi_singkat), 120) }}
                                    </p>
                                @endif
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('layanan-agenda.show', $item->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                    @if($item->lokasi)
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $item->lokasi }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($agenda->hasPages())
                <div class="mt-5">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            {{-- Previous Page Link --}}
                            @if($agenda->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $agenda->previousPageUrl() }}" rel="prev">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach($agenda->getUrlRange(1, $agenda->lastPage()) as $page => $url)
                                @if($page == $agenda->currentPage())
                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if($agenda->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $agenda->nextPageUrl() }}" rel="next">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            @endif
        @else
            <div class="empty-state">
                <i class="far fa-calendar-alt"></i>
                <h4 class="mb-2">Tidak Ada Agenda Tersedia</h4>
                <p class="text-muted mb-4">Saat ini tidak ada agenda yang tersedia. Silakan coba lagi nanti.</p>
                <a href="{{ route('layanan-agenda.index') }}" class="btn btn-primary">
                    <i class="fas fa-redo me-2"></i>Muat Ulang
                </a>
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi elemen DOM
        const monthFilter = document.getElementById('monthFilter');
        const categoryFilter = document.getElementById('categoryFilter');
        const resetFilter = document.getElementById('resetFilter');
        const loadingState = document.getElementById('loadingState');
        const filterForm = document.getElementById('filterForm');
        
        // Fungsi untuk menampilkan loading state
        function showLoading() {
            loadingState.classList.remove('d-none');
            loadingState.classList.add('d-flex');
        }
        
        // Fungsi untuk menyembunyikan loading state
        function hideLoading() {
            loadingState.classList.remove('d-flex');
            loadingState.classList.add('d-none');
        }
        
        // Fungsi untuk memperbarui URL tanpa me-refresh halaman
        function updateUrl() {
            const params = new URLSearchParams();
            
            if (monthFilter.value) params.set('month', monthFilter.value);
            if (categoryFilter.value) params.set('category', categoryFilter.value);
            
            const queryString = params.toString();
            const newUrl = `${window.location.pathname}${queryString ? '?' + queryString : ''}`;
            
            // Update URL tanpa me-refresh halaman
            window.history.pushState({}, '', newUrl);
        }
        
        // Fungsi untuk memfilter agenda dengan AJAX
        function filterAgenda() {
            const selectedMonth = monthFilter.value;
            const selectedCategory = categoryFilter.value;
            
            // Tampilkan loading state
            showLoading();
            
            // Update URL
            updateUrl();
            
            // Kirim permintaan AJAX
            fetch(`{{ route('layanan-agenda.index') }}?month=${selectedMonth}&category=${selectedCategory}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html, application/xhtml+xml'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Buat elemen sementara untuk menampung konten baru
                const temp = document.createElement('div');
                temp.innerHTML = html;
                
                // Perbarui konten
                const newAgendaGrid = temp.querySelector('#agendaGrid');
                if (newAgendaGrid) {
                    document.getElementById('agendaGrid').innerHTML = newAgendaGrid.innerHTML;
                }
                
                // Perbarui URL tanpa me-refresh halaman
                window.history.pushState({}, '', window.location.href);
            })
            .catch(error => {
                console.error('Error:', error);
                // Fallback ke reload halaman jika terjadi error
                window.location.href = window.location.href;
            })
            .finally(() => {
                // Sembunyikan loading state
                hideLoading();
            });
        }
        
        // Event listener untuk filter bulan
        monthFilter.addEventListener('change', function() {
            filterAgenda();
        });
        
        // Event listener untuk filter kategori
        categoryFilter.addEventListener('change', function() {
            filterAgenda();
        });
        
        // Event listener untuk tombol reset
        resetFilter.addEventListener('click', function(e) {
            e.preventDefault();
            monthFilter.value = '';
            categoryFilter.value = '';
            filterAgenda();
        });
        
        // Inisialisasi filter dari URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('month')) {
            monthFilter.value = urlParams.get('month');
        }
        if (urlParams.has('category')) {
            categoryFilter.value = urlParams.get('category');
        }
        
        // Apply filters on page load if any filter is set
        if (urlParams.has('month') || urlParams.has('category')) {
            filterAgenda();
        }
    });
</script>
@endpush

@endsection
