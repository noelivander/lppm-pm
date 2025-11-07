<x-user-layout>
    <x-slot name="title">
        {{ __('Dokumen Penting') }}
    </x-slot>

    <section class="position-relative overflow-hidden" style="background: linear-gradient(135deg, #3730a3 0%, #4f46e5 50%, #7c3aed 100%); padding-top: 100px; padding-bottom: 60px; margin-top: 0;">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-7 text-white">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb bg-transparent mb-0" style="--bs-breadcrumb-divider: '›';">
                            <li class="breadcrumb-item"><a class="text-white-50 text-decoration-none" href="{{ route('home') }}">Beranda</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Dokumen</li>
                        </ol>
                    </nav>
                    <h1 class="display-5 fw-bold mb-3 text-white">Dokumen Penting</h1>
                    <p class="mb-0 text-white" style="font-size: 1.1rem; opacity: 0.95;">Telusuri, pratinjau, dan unduh dokumen LPPM-PM ITH dengan mudah.</p>
                </div>
                <div class="col-lg-5">
                    <form method="get" class="bg-white rounded-3 shadow-sm p-2 p-md-3">
                        <div class="row g-2 align-items-center">
                            <div class="col-12 col-md">
                                <div class="position-relative">
                                    <i class="fas fa-search position-absolute" style="left: .9rem; top: 50%; transform: translateY(-50%); color: #64748b;"></i>
                                    <input type="text" id="searchDokumen" class="form-control ps-5" placeholder="Cari dokumen..." aria-label="Cari dokumen">
                                </div>
                            </div>
                            <div class="col-6 col-md-auto">
                                <select id="sortDokumen" class="form-select">
                                    <option value="newest">Terbaru</option>
                                    <option value="oldest">Terlama</option>
                                    <option value="name-asc">Nama A-Z</option>
                                    <option value="name-desc">Nama Z-A</option>
                                </select>
                            </div>
                            <div class="col-6 col-md-auto">
                                <select id="typeFilter" class="form-select">
                                    <option value="all">Semua tipe</option>
                                    <option value="pdf">PDF</option>
                                    <option value="doc">DOC/DOCX</option>
                                    <option value="xls">XLS/XLSX</option>
                                    <option value="zip">ZIP</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <div class="container py-5">
        <!-- Filter Pills -->
        <div class="mb-4">
            <div class="d-flex flex-wrap gap-2">
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

        <!-- Documents Grid -->
        <div class="row g-4" id="documentsGrid">
            @php
                $all_documents = collect([
                    ['docs' => $dokumen_ppm, 'category' => 'ppm', 'badge_color' => '#7c3aed', 'icon' => 'flask', 'label' => 'PPM'],
                    ['docs' => $dokumen_pm, 'category' => 'pm', 'badge_color' => '#10b981', 'icon' => 'award', 'label' => 'PM'],
                    ['docs' => $dokumen_umum, 'category' => 'umum', 'badge_color' => '#3b82f6', 'icon' => 'file-alt', 'label' => 'Umum'],
                    ['docs' => $dokumen_lain, 'category' => 'lain', 'badge_color' => '#f59e0b', 'icon' => 'folder', 'label' => 'Lainnya'],
                ]);
            @endphp

            @foreach($all_documents as $doc_group)
                @if($doc_group['docs']->count() > 0)
                    @foreach($doc_group['docs'] as $value)
                        @php $extItem = pathinfo($value->file ?? '', PATHINFO_EXTENSION); @endphp
                        <div class="col-xl-4 col-md-6 dokumen-item fade-in-up" data-category="{{ $doc_group['category'] }}" data-title="{{ strtolower($value->judul) }}" data-date="{{ $value->created_at->timestamp }}" data-ext="{{ strtolower($extItem) }}">
                            <article class="card h-100 border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
                                <div class="position-relative" style="height: 200px; background: #f3f4f6;">
                                    @if($value->cover)
                                        <img src="{{ asset('storage/'.$value->cover) }}" alt="{{ $value->judul }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center w-100 h-100">
                                            <i class="fas fa-file-pdf" style="font-size: 3rem; color: {{ $doc_group['badge_color'] }}; opacity: 0.3;"></i>
                                        </div>
                                    @endif
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge" style="background: {{ $doc_group['badge_color'] }}; padding: 0.5rem 0.75rem; border-radius: 50px;">
                                            <i class="fas fa-{{ $doc_group['icon'] }} me-1"></i> {{ $doc_group['label'] }}
                                        </span>
                                    </div>
                                    @if($value->is_lock)
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <span class="badge bg-danger" style="padding: 0.5rem 0.75rem; border-radius: 50px;">
                                            <i class="fa fa-lock me-1"></i> Terkunci
                                        </span>
                                    </div>
                                    @endif
                                    <div class="position-absolute bottom-0 start-0 end-0 p-3" style="background: linear-gradient(to top, rgba(0,0,0,.55), transparent)">
                                        <div class="d-flex justify-content-between align-items-end">
                                            <small class="text-white"><i class="far fa-calendar-alt me-1"></i>{{ $value->created_at->format('d M Y') }}</small>
                                            @if(!empty($extItem))
                                            <span class="badge bg-dark bg-opacity-50 text-white text-uppercase">{{ $extItem }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h6 class="mb-2" style="line-height:1.5; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; color: #1e1b4b; font-weight: 600;">{{ $value->judul }}</h6>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        @if($value->is_lock)
                                            <button class="btn btn-sm w-100" disabled style="background: #e2e8f0; color: #64748b; border: none; border-radius: 50px;">
                                                <i class="fa fa-lock me-2"></i>Terkunci
                                            </button>
                                        @else
                                            <a href="{{ route('dokumen.show',['slug'=>$value->slug]) }}" class="btn btn-sm btn-primary flex-grow-1" style="border-radius: 50px;">
                                                <i class="fas fa-eye me-2"></i>Lihat
                                            </a>
                                            @if(!empty($value->file))
                                            <a href="{{ asset('storage/'.$value->file) }}" download class="btn btn-sm btn-outline-primary ms-2" style="border-radius: 50px;" aria-label="Unduh dokumen {{ $value->judul }}">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            @endif
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
                <i class="fas fa-file-alt fa-3x text-muted" style="opacity: 0.3;"></i>
            </div>
            <h5 class="text-muted">Tidak ada dokumen yang ditemukan</h5>
            <p class="text-muted">Coba gunakan kata kunci lain atau pilih kategori berbeda</p>
        </div>
    </div>

    @push('styles')
    <style>
        .card:hover { 
            transform: translateY(-4px); 
            box-shadow: 0 16px 32px rgba(0,0,0,.08) !important; 
            transition: .25s; 
        }

        .filter-btn {
            padding: 0.5rem 1rem;
            border: 2px solid #e2e8f0;
            background: white;
            color: #64748b;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 0.9rem;
        }
        
        .filter-btn:hover {
            border-color: #7c3aed;
            color: #7c3aed;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.2);
        }
        
        .filter-btn.active {
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
            color: white;
            border-color: #7c3aed;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
        }

        .filter-btn .badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
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

        @media (max-width: 768px) {
            section[style*="padding-top: 100px"] {
                padding-top: 80px !important;
                padding-bottom: 40px !important;
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
            const typeFilter = document.getElementById('typeFilter');
            const noResults = document.getElementById('noResults');
            
            let currentFilter = localStorage.getItem('dokumenFilter') || 'all';
            
            // Filter functionality
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    currentFilter = this.dataset.filter;
                    localStorage.setItem('dokumenFilter', currentFilter);
                    filterDocuments();
                });
                if (btn.dataset.filter === currentFilter) btn.classList.add('active');
            });
            
            // Search functionality
            const debounce = (fn, delay=250) => { 
                let t; 
                return (...args) => { 
                    clearTimeout(t); 
                    t = setTimeout(() => fn.apply(this, args), delay); 
                } 
            };
            
            searchInput.addEventListener('input', debounce(function() {
                filterDocuments();
            }));

            // Keyboard shortcut to focus search
            document.addEventListener('keydown', (e) => {
                if ((e.ctrlKey || e.metaKey) && e.key === '/') {
                    e.preventDefault();
                    searchInput.focus();
                }
            });

            // Sort functionality
            sortSelect.addEventListener('change', function() {
                sortDocuments(this.value);
            });

            // Type filter
            if (typeFilter) {
                typeFilter.addEventListener('change', function() {
                    filterDocuments();
                });
            }
            
            function filterDocuments() {
                const searchTerm = searchInput.value.toLowerCase();
                let visibleCount = 0;
                
                dokumenItems.forEach(item => {
                    const category = item.dataset.category;
                    const title = item.dataset.title;
                    const ext = (item.dataset.ext || '').toLowerCase();
                    
                    const matchesFilter = currentFilter === 'all' || category === currentFilter;
                    const matchesSearch = title.includes(searchTerm);
                    const selectedType = typeFilter ? typeFilter.value : 'all';
                    const matchesType = selectedType === 'all' ||
                        (selectedType === 'pdf' && ext === 'pdf') ||
                        (selectedType === 'doc' && (ext === 'doc' || ext === 'docx')) ||
                        (selectedType === 'xls' && (ext === 'xls' || ext === 'xlsx')) ||
                        (selectedType === 'zip' && (ext === 'zip' || ext === 'rar'));
                    
                    if (matchesFilter && matchesSearch && matchesType) {
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
                const grid = document.getElementById('documentsGrid');
                itemsArray.forEach(item => {
                    grid.appendChild(item);
                });
                
                filterDocuments();
            }

            // Add staggered animation
            dokumenItems.forEach((item, index) => {
                item.style.animationDelay = `${index * 0.05}s`;
            });

            // Initial render
            filterDocuments();
        });

        // Hide spinner when page loaded
        document.addEventListener('DOMContentLoaded', function() {
            const spinner = document.getElementById('spinner');
            if (spinner) {
                spinner.classList.remove('show');
            }
        });
    </script>
    @endpush
</x-user-layout>
