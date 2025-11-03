<x-user-layout>
    <x-slot name="title">
        {{ __('Dokumen Penting') }}
    </x-slot>

    <!-- Hero Section -->
    <section class="position-relative overflow-hidden py-5" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #3730a3 100%);">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-10 mx-auto text-center text-white">
                    <div class="mb-3">
                        <i class="fas fa-file-alt" style="font-size: 3rem; opacity: 0.9;"></i>
                    </div>
                    <h1 class="display-4 fw-bold mb-3" style="animation: float 3s ease-in-out infinite;">Dokumen Penting</h1>
                    <p class="lead mb-4">Kumpulan dokumen penting LPPM-PM ITH yang dapat diunduh dengan mudah</p>
                    
                    <!-- Statistics Cards -->
                    <div class="row g-3 mb-4 justify-content-center">
                        <div class="col-6 col-md-3">
                            <div class="stat-card" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 15px; padding: 1.5rem; border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease;">
                                <div class="stat-icon mb-2">
                                    <i class="fas fa-flask" style="font-size: 1.5rem;"></i>
                                </div>
                                <h3 class="mb-0" style="font-size: 1.75rem; font-weight: 700;">{{ $dokumen_ppm->count() }}</h3>
                                <p class="mb-0 small" style="opacity: 0.9;">PPM</p>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 15px; padding: 1.5rem; border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease;">
                                <div class="stat-icon mb-2">
                                    <i class="fas fa-award" style="font-size: 1.5rem;"></i>
                                </div>
                                <h3 class="mb-0" style="font-size: 1.75rem; font-weight: 700;">{{ $dokumen_pm->count() }}</h3>
                                <p class="mb-0 small" style="opacity: 0.9;">PM</p>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 15px; padding: 1.5rem; border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease;">
                                <div class="stat-icon mb-2">
                                    <i class="fas fa-file-alt" style="font-size: 1.5rem;"></i>
                                </div>
                                <h3 class="mb-0" style="font-size: 1.75rem; font-weight: 700;">{{ $dokumen_umum->count() }}</h3>
                                <p class="mb-0 small" style="opacity: 0.9;">Umum</p>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 15px; padding: 1.5rem; border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease;">
                                <div class="stat-icon mb-2">
                                    <i class="fas fa-folder" style="font-size: 1.5rem;"></i>
                                </div>
                                <h3 class="mb-0" style="font-size: 1.75rem; font-weight: 700;">{{ $dokumen_lain->count() }}</h3>
                                <p class="mb-0 small" style="opacity: 0.9;">Lainnya</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Search Bar -->
                    <div class="search-box mx-auto" style="max-width: 600px;">
                        <div class="position-relative">
                            <i class="fas fa-search position-absolute" style="left: 1.5rem; top: 50%; transform: translateY(-50%); color: #94a3b8; z-index: 10;"></i>
                            <input type="text" id="searchDokumen" class="form-control border-0 shadow-lg" placeholder="Cari dokumen berdasarkan judul..." style="border-radius: 50px; padding: 1rem 1.5rem 1rem 3.5rem; font-size: 1rem;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Floating Background Elements -->
        <div class="position-absolute" style="top: 10%; left: 5%; width: 100px; height: 100px; background: rgba(255,255,255,0.05); border-radius: 50%; animation: float 6s ease-in-out infinite;"></div>
        <div class="position-absolute" style="top: 60%; right: 10%; width: 150px; height: 150px; background: rgba(255,255,255,0.03); border-radius: 50%; animation: float-delayed 8s ease-in-out infinite;"></div>
        <div class="position-absolute" style="bottom: 20%; left: 15%; width: 80px; height: 80px; background: rgba(255,255,255,0.04); border-radius: 50%; animation: float 7s ease-in-out infinite;"></div>
    </section>

    <div class="container py-5">
        <!-- Filter and Controls -->
        <div class="mb-5">
            <div class="row align-items-center mb-4">
                <div class="col-md-8">
                    <div class="d-flex flex-wrap gap-3">
                        <button class="filter-btn active" data-filter="all">
                            <i class="fas fa-th-large me-2"></i>Semua <span class="badge bg-white text-primary ms-1">{{ $dokumen_ppm->count() + $dokumen_pm->count() + $dokumen_umum->count() + $dokumen_lain->count() }}</span>
                        </button>
                        @if($dokumen_ppm->count()>0)
                        <button class="filter-btn" data-filter="ppm">
                            <i class="fas fa-flask me-2"></i>PPM <span class="badge bg-white text-purple ms-1">{{ $dokumen_ppm->count() }}</span>
                        </button>
                        @endif
                        @if($dokumen_pm->count()>0)
                        <button class="filter-btn" data-filter="pm">
                            <i class="fas fa-award me-2"></i>PM <span class="badge bg-white text-success ms-1">{{ $dokumen_pm->count() }}</span>
                        </button>
                        @endif
                        @if($dokumen_umum->count()>0)
                        <button class="filter-btn" data-filter="umum">
                            <i class="fas fa-file-alt me-2"></i>Umum <span class="badge bg-white text-info ms-1">{{ $dokumen_umum->count() }}</span>
                        </button>
                        @endif
                        @if($dokumen_lain->count()>0)
                        <button class="filter-btn" data-filter="lain">
                            <i class="fas fa-folder me-2"></i>Lainnya <span class="badge bg-white text-warning ms-1">{{ $dokumen_lain->count() }}</span>
                        </button>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex justify-content-md-end align-items-center gap-3 mt-3 mt-md-0">
                        <span class="text-muted small d-none d-md-inline">Tampilan:</span>
                        <div class="btn-group" role="group">
                            <button type="button" class="view-toggle-btn active" data-view="grid" title="Grid View">
                                <i class="fas fa-th"></i>
                            </button>
                            <button type="button" class="view-toggle-btn" data-view="list" title="List View">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                        <select id="sortDokumen" class="form-select form-select-sm" style="width: auto; border-radius: 10px;">
                            <option value="newest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                            <option value="name-asc">Nama A-Z</option>
                            <option value="name-desc">Nama Z-A</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents Grid -->
        <div class="row g-4" id="documentsGrid">
            @php
                $all_documents = collect([
                    ['docs' => $dokumen_ppm, 'category' => 'ppm', 'badge_color' => 'linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%)', 'icon' => 'flask', 'label' => 'PPM'],
                    ['docs' => $dokumen_pm, 'category' => 'pm', 'badge_color' => 'linear-gradient(135deg, #10b981 0%, #059669 100%)', 'icon' => 'award', 'label' => 'PM'],
                    ['docs' => $dokumen_umum, 'category' => 'umum', 'badge_color' => 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)', 'icon' => 'file-alt', 'label' => 'Umum'],
                    ['docs' => $dokumen_lain, 'category' => 'lain', 'badge_color' => 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)', 'icon' => 'folder', 'label' => 'Lainnya'],
                ]);
            @endphp

            @foreach($all_documents as $doc_group)
                @if($doc_group['docs']->count() > 0)
                    @foreach($doc_group['docs'] as $value)
                        <div class="col-lg-3 col-md-4 col-sm-6 dokumen-item fade-in-up" data-category="{{ $doc_group['category'] }}" data-title="{{ strtolower($value->judul) }}" data-date="{{ $value->created_at->timestamp }}">
                            <article class="document-card border-0 shadow-sm h-100" style="border-radius: 15px; overflow: hidden; transition: all 0.3s ease; background: white;">
                                <div class="position-relative" style="height: 180px; overflow: hidden; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);">
                                    @if($value->cover)
                                        <img src="{{ asset('storage/'.$value->cover) }}" class="card-img-top" alt="{{ $value->judul }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <i class="fas fa-file-pdf" style="font-size: 4rem; color: #7c3aed; opacity: 0.3;"></i>
                                        </div>
                                    @endif
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge" style="background: {{ $doc_group['badge_color'] }}; padding: 0.5rem 1rem; border-radius: 50px; box-shadow: 0 2px 8px rgba(124, 58, 237, 0.3);">
                                            <i class="fas fa-{{ $doc_group['icon'] }} me-1"></i> {{ $doc_group['label'] }}
                                        </span>
                                    </div>
                                    @if($value->is_lock)
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <span class="badge bg-danger" style="padding: 0.5rem 1rem; border-radius: 50px; box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);">
                                            <i class="fa fa-lock me-1"></i> Terkunci
                                        </span>
                                    </div>
                                    @endif
                                    <div class="position-absolute bottom-0 start-0 end-0 p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);">
                                        <small class="text-white d-flex align-items-center">
                                            <i class="far fa-calendar-alt me-2"></i>
                                            {{ $value->created_at->format('d M Y') }}
                                        </small>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <h6 class="card-title mb-3" style="color: #1e1b4b; font-weight: 600; line-height: 1.5; min-height: 3rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $value->judul }}
                                    </h6>
                                    <div class="d-flex gap-2">
                                        @if($value->is_lock)
                                            <button class="btn btn-sm w-100" disabled style="background: #e2e8f0; color: #64748b; border: none; border-radius: 50px; padding: 0.65rem 1.5rem; font-weight: 500;">
                                                <i class="fa fa-lock me-2"></i>Terkunci
                                            </button>
                                        @else
                                            <a href="{{ route('dokumen.show',['slug'=>$value->slug]) }}" class="btn btn-sm flex-grow-1" style="background: {{ $doc_group['badge_color'] }}; color: white; border: none; border-radius: 50px; font-weight: 500; padding: 0.65rem 1rem; transition: all 0.3s ease;">
                                                <i class="fas fa-eye me-2"></i>Lihat
                                            </a>
                                            <a href="{{ route('dokumen.show',['slug'=>$value->slug]) }}" class="btn btn-sm" style="background: rgba(124, 58, 237, 0.1); color: #7c3aed; border: none; border-radius: 50px; padding: 0.65rem 1rem; transition: all 0.3s ease;">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                @endif
            @endforeach
        </div>
        
        <!-- No Results Message -->
        <div id="noResults" class="text-center py-5" style="display: none;">
            <div class="mb-4">
                <i class="fas fa-search fa-4x text-muted" style="opacity: 0.3;"></i>
            </div>
            <h5 class="text-muted">Tidak ada dokumen yang ditemukan</h5>
            <p class="text-muted">Coba gunakan kata kunci lain atau pilih kategori berbeda</p>
        </div>
    </div>

    @push('styles')
    <style>
        :root {
            --primary-color: #7c3aed;
            --primary-dark: #6d28d9;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(255,255,255,0.2);
        }

        .filter-btn {
            padding: 0.75rem 1.5rem;
            border: 2px solid #e2e8f0;
            background: white;
            color: #64748b;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .filter-btn:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.2);
        }
        
        .filter-btn.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border-color: var(--primary-color);
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
        }

        .filter-btn .badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        .view-toggle-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #e2e8f0;
            background: white;
            color: #64748b;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .view-toggle-btn:first-child {
            border-radius: 10px 0 0 10px;
        }

        .view-toggle-btn:last-child {
            border-radius: 0 10px 10px 0;
        }

        .view-toggle-btn:hover {
            background: #f8fafc;
            color: var(--primary-color);
        }

        .view-toggle-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .document-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
        }
        
        .document-card:hover img {
            transform: scale(1.05);
        }
        
        .document-card:hover .btn {
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.4);
        }
        
        .dokumen-item {
            transition: all 0.3s ease;
        }

        .dokumen-item.hidden {
            display: none;
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

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes float-delayed {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }

        /* List View Styles */
        .list-view .dokumen-item {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .list-view .document-card {
            display: flex;
            flex-direction: row;
        }

        .list-view .document-card > div:first-child {
            width: 200px;
            height: auto;
            flex-shrink: 0;
        }

        .list-view .card-body {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }

        .list-view .card-title {
            min-height: auto !important;
            margin-bottom: 0 !important;
        }

        @media (max-width: 768px) {
            .list-view .document-card {
                flex-direction: column;
            }

            .list-view .document-card > div:first-child {
                width: 100%;
                height: 180px;
            }

            .list-view .card-body {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterBtns = document.querySelectorAll('.filter-btn');
            const dokumenItems = document.querySelectorAll('.dokumen-item');
            const searchInput = document.getElementById('searchDokumen');
            const sortSelect = document.getElementById('sortDokumen');
            const noResults = document.getElementById('noResults');
            const viewToggleBtns = document.querySelectorAll('.view-toggle-btn');
            const documentsGrid = document.getElementById('documentsGrid');
            
            let currentFilter = 'all';
            
            // Filter functionality
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    currentFilter = this.dataset.filter;
                    filterDocuments();
                });
            });
            
            // Search functionality
            searchInput.addEventListener('input', function() {
                filterDocuments();
            });

            // Sort functionality
            sortSelect.addEventListener('change', function() {
                sortDocuments(this.value);
            });

            // View toggle functionality
            viewToggleBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    viewToggleBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    if (this.dataset.view === 'list') {
                        documentsGrid.classList.add('list-view');
                    } else {
                        documentsGrid.classList.remove('list-view');
                    }
                });
            });
            
            function filterDocuments() {
                const searchTerm = searchInput.value.toLowerCase();
                let visibleCount = 0;
                
                dokumenItems.forEach(item => {
                    const category = item.dataset.category;
                    const title = item.dataset.title;
                    
                    const matchesFilter = currentFilter === 'all' || category === currentFilter;
                    const matchesSearch = title.includes(searchTerm);
                    
                    if (matchesFilter && matchesSearch) {
                        item.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        item.classList.add('hidden');
                    }
                });
                
                // Show/hide no results message
                if (visibleCount === 0) {
                    noResults.style.display = 'block';
                } else {
                    noResults.style.display = 'none';
                }
            }

            function sortDocuments(sortBy) {
                const itemsArray = Array.from(dokumenItems);
                
                itemsArray.sort((a, b) => {
                    switch(sortBy) {
                        case 'newest':
                            return parseInt(b.dataset.date) - parseInt(a.dataset.date);
                        case 'oldest':
                            return parseInt(a.dataset.date) - parseInt(b.dataset.date);
                        case 'name-asc':
                            return a.dataset.title.localeCompare(b.dataset.title);
                        case 'name-desc':
                            return b.dataset.title.localeCompare(a.dataset.title);
                        default:
                            return 0;
                    }
                });
                
                // Reorder DOM elements
                itemsArray.forEach(item => {
                    documentsGrid.appendChild(item);
                });
            }

            // Add staggered animation
            dokumenItems.forEach((item, index) => {
                item.style.animationDelay = `${index * 0.05}s`;
            });
        });
    </script>
    @endpush
</x-user-layout>
