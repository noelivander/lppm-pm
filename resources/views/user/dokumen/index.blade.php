<x-user-layout>
    <x-slot name="title">
        {{ __('Dokumen Penting') }}
    </x-slot>

    <!-- Hero Section -->
    <section class="position-relative overflow-hidden" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #3730a3 100%); min-height: 60vh;">
        <!-- Decorative Background Elements -->
        <div class="position-absolute" style="top: -10%; right: -5%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(124, 58, 237, 0.15) 0%, transparent 70%); border-radius: 50%;"></div>
        <div class="position-absolute" style="bottom: -15%; left: -8%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(59, 130, 246, 0.12) 0%, transparent 70%); border-radius: 50%;"></div>
        
        <div class="container position-relative" style="padding-top: 6rem; padding-bottom: 4rem;">
            <div class="row align-items-center justify-content-center text-center">
                <div class="col-lg-8" data-aos="fade-up">
                    <div class="mb-4">
                        <span class="badge px-4 py-2" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius: 50px; color: white; font-weight: 500; font-size: 0.9rem;">
                            <i class="fas fa-archive me-2"></i>Arsip Digital
                        </span>
                    </div>
                    
                    <h1 class="display-4 fw-bold text-white mb-4" style="line-height: 1.2;">
                        Dokumen & Arsip<br>
                        <span style="background: linear-gradient(135deg, #a78bfa 0%, #ec4899 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">LPPM-PM ITH</span>
                    </h1>
                    
                    <p class="lead text-white mb-5" style="opacity: 0.9; line-height: 1.8; font-size: 1.1rem;">
                        Pusat unduhan resmi LPPM-PM ITH. Temukan panduan, formulir, SK, dan dokumen penting lainnya untuk menunjang kegiatan akademik dan penelitian.
                    </p>
                </div>
            </div>

            <!-- Search & Filter Card -->
            <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="100">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); border-radius: 30px;">
                        <div class="card-body p-4">
                            <form method="get" action="{{ route('dokumen.index') }}" id="searchForm">
                                <div class="row g-3">
                                    <div class="col-lg-5">
                                        <div class="position-relative">
                                            <i class="fas fa-search position-absolute text-muted" style="left: 1.2rem; top: 50%; transform: translateY(-50%);"></i>
                                            <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-lg ps-5 border-0 bg-light" style="border-radius: 15px;" placeholder="Cari dokumen (judul, nomor SK, dll)...">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <select name="type" id="typeFilter" class="form-select form-select-lg border-0 bg-light" style="border-radius: 15px;">
                                            <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>Semua Tipe File</option>
                                            <option value="pdf" {{ request('type') == 'pdf' ? 'selected' : '' }}>PDF Document</option>
                                            <option value="doc" {{ request('type') == 'doc' ? 'selected' : '' }}>Word Document</option>
                                            <option value="xls" {{ request('type') == 'xls' ? 'selected' : '' }}>Excel Spreadsheet</option>
                                            <option value="zip" {{ request('type') == 'zip' ? 'selected' : '' }}>Archive (ZIP/RAR)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <select name="sort" class="form-select form-select-lg border-0 bg-light" style="border-radius: 15px;" onchange="this.form.submit()">
                                            <option value="urutan" {{ request('sort') == 'urutan' ? 'selected' : '' }}>Default</option>
                                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru Diunggah</option>
                                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama Diunggah</option>
                                            <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                                            <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-1 d-none d-lg-block">
                                        <button type="submit" class="btn btn-primary btn-lg w-100 h-100" style="border-radius: 15px; background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%); border: none;">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                    <!-- Mobile Submit Button -->
                                    <div class="col-12 d-lg-none">
                                        <button type="submit" class="btn btn-primary w-100 py-3" style="border-radius: 15px; background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%); border: none;">
                                            Terapkan Filter
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5" style="background-color: #f8fafc;">
        <div class="container">
            <!-- Category Tabs -->
            <div class="d-flex justify-content-center mb-5 overflow-auto pb-2">
                <div class="btn-group bg-white rounded-pill p-1 shadow-sm" role="group">
                    <button class="filter-btn btn btn-link text-decoration-none rounded-pill px-4 py-2 active fw-bold" style="color: #1e1b4b;" data-filter="all">
                        Semua
                    </button>
                    @if($dokumen_ppm->count()>0)
                    <button class="filter-btn btn btn-link text-decoration-none rounded-pill px-4 py-2 text-muted" data-filter="ppm">
                        PPM
                    </button>
                    @endif
                    @if($dokumen_pm->count()>0)
                    <button class="filter-btn btn btn-link text-decoration-none rounded-pill px-4 py-2 text-muted" data-filter="pm">
                        PM
                    </button>
                    @endif
                    @if($dokumen_umum->count()>0)
                    <button class="filter-btn btn btn-link text-decoration-none rounded-pill px-4 py-2 text-muted" data-filter="umum">
                        Umum
                    </button>
                    @endif
                    @if($dokumen_lain->count()>0)
                    <button class="filter-btn btn btn-link text-decoration-none rounded-pill px-4 py-2 text-muted" data-filter="lain">
                        Lainnya
                    </button>
                    @endif
                </div>
            </div>

            <!-- Documents Grid -->
            <div class="row g-4" id="documentsGrid">
                @php
                    $all_documents = collect([
                        ['docs' => $dokumen_ppm, 'category' => 'ppm', 'color' => 'primary', 'icon' => 'flask', 'label' => 'Penelitian'],
                        ['docs' => $dokumen_pm, 'category' => 'pm', 'color' => 'success', 'icon' => 'hand-holding-heart', 'label' => 'Pengabdian'],
                        ['docs' => $dokumen_umum, 'category' => 'umum', 'color' => 'info', 'icon' => 'globe', 'label' => 'Umum'],
                        ['docs' => $dokumen_lain, 'category' => 'lain', 'color' => 'warning', 'icon' => 'folder-open', 'label' => 'Lainnya'],
                    ]);
                @endphp

                @foreach($all_documents as $doc_group)
                    @if($doc_group['docs']->count() > 0)
                        @foreach($doc_group['docs'] as $value)
                            @php 
                                $extItem = pathinfo($value->file ?? '', PATHINFO_EXTENSION);
                                $iconClass = match(strtolower($extItem)) {
                                    'pdf' => 'fa-file-pdf text-danger',
                                    'doc', 'docx' => 'fa-file-word text-primary',
                                    'xls', 'xlsx' => 'fa-file-excel text-success',
                                    'zip', 'rar' => 'fa-file-archive text-warning',
                                    default => 'fa-file-alt text-secondary'
                                };
                            @endphp
                            <div class="col-xl-3 col-lg-4 col-md-6 dokumen-item fade-in-up" 
                                 data-category="{{ $doc_group['category'] }}" 
                                 data-ext="{{ strtolower($extItem) }}">
                                
                                <div class="card border-0 shadow-sm h-100 hover-lift" style="border-radius: 20px; transition: all 0.3s ease; overflow: hidden;">
                                    <!-- Card Header / Preview -->
                                    <div class="position-relative bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                        @if($value->cover)
                                            <img src="{{ asset('storage/'.$value->cover) }}" alt="{{ $value->judul }}" class="w-100 h-100 object-fit-cover">
                                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-10"></div>
                                        @else
                                            <div class="d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); border-radius: 20px;">
                                                <i class="fas {{ $iconClass }} fa-3x"></i>
                                            </div>
                                        @endif
                                        
                                        <!-- Category Badge -->
                                        <div class="position-absolute top-0 end-0 m-3">
                                            <span class="badge shadow-sm rounded-pill px-3 py-2" style="background: rgba(255,255,255,0.9); color: #1e1b4b; backdrop-filter: blur(5px);">
                                                <i class="fas fa-{{ $doc_group['icon'] }} me-1"></i> {{ $doc_group['label'] }}
                                            </span>
                                        </div>

                                        <!-- Lock Badge -->
                                        @if($value->is_lock)
                                        <div class="position-absolute top-0 start-0 m-3">
                                            <span class="badge bg-danger shadow-sm rounded-circle p-2" data-bs-toggle="tooltip" title="Dokumen Terkunci">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Card Body -->
                                    <div class="card-body p-4 d-flex flex-column">
                                        <div class="mb-3 d-flex align-items-center text-muted small">
                                            <i class="far fa-calendar-alt me-2"></i>
                                            {{ $value->created_at->format('d M Y') }}
                                            <span class="mx-2">•</span>
                                            <span class="text-uppercase fw-bold" style="color: #4f46e5;">{{ $extItem ?: 'FILE' }}</span>
                                        </div>
                                        
                                        <h6 class="card-title fw-bold mb-3 line-clamp-2" style="color: #1e1b4b; min-height: 2.5rem; line-height: 1.5;">
                                            {{ $value->judul }}
                                        </h6>

                                        <div class="mt-auto d-flex gap-2">
                                            @if($value->is_lock)
                                                <button class="btn w-100 rounded-pill text-muted" style="background: #f1f5f9;" disabled>
                                                    <i class="fas fa-lock me-2"></i>Akses Terbatas
                                                </button>
                                            @else
                                                <a href="{{ route('dokumen.show',['slug'=>$value->slug]) }}" class="btn btn-outline-primary flex-grow-1 rounded-pill" style="border-color: #4f46e5; color: #4f46e5;">
                                                    <i class="fas fa-eye me-1"></i> Detail
                                                </a>
                                                @if(!empty($value->file))
                                                <a href="{{ asset('storage/'.$value->file) }}" download class="btn btn-primary rounded-pill px-3" style="background: #4f46e5; border-color: #4f46e5;" data-bs-toggle="tooltip" title="Unduh File">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            </div>

            <!-- Empty State -->
            <div id="noResults" class="text-center py-5 d-none">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); border-radius: 50%;">
                        <i class="fas fa-search fa-3x" style="color: #4f46e5;"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-2" style="color: #1e1b4b;">Dokumen tidak ditemukan</h4>
                <p class="text-muted mb-4">Coba ubah kata kunci pencarian atau filter kategori Anda.</p>
                <a href="{{ route('dokumen.index') }}" class="btn btn-primary rounded-pill px-4 py-2" style="background: #4f46e5; border-color: #4f46e5;">
                    Reset Filter
                </a>
            </div>
        </div>
    </section>

    @push('styles')
    <style>
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .filter-btn {
            transition: all 0.3s ease;
        }
        .filter-btn:hover:not(.active) {
            background-color: rgba(79, 70, 229, 0.05);
            color: #4f46e5 !important;
        }
        .filter-btn.active {
            background-color: #4f46e5 !important;
            color: white !important;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .fade-in-up {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-control:focus, .form-select:focus {
            box-shadow: none;
            border-color: #4f46e5;
            background-color: white;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })

            const filterBtns = document.querySelectorAll('.filter-btn');
            const dokumenItems = document.querySelectorAll('.dokumen-item');
            const typeFilter = document.getElementById('typeFilter');
            const noResults = document.getElementById('noResults');
            
            // Get URL params
            const urlParams = new URLSearchParams(window.location.search);
            let currentFilter = urlParams.get('category') || 'all';
            
            // Set initial active filter
            filterBtns.forEach(btn => {
                if(btn.dataset.filter === currentFilter) {
                    setActiveFilter(btn);
                }
                
                btn.addEventListener('click', function() {
                    setActiveFilter(this);
                    currentFilter = this.dataset.filter;
                    
                    // Update URL without reload
                    const url = new URL(window.location);
                    url.searchParams.set('category', currentFilter);
                    window.history.pushState({}, '', url);
                    
                    filterDocuments();
                });
            });

            function setActiveFilter(btn) {
                filterBtns.forEach(b => {
                    b.classList.remove('active', 'fw-bold');
                    b.classList.add('text-muted');
                });
                btn.classList.remove('text-muted');
                btn.classList.add('active', 'fw-bold');
            }
            
            // Type Filter Logic (Client Side)
            typeFilter.addEventListener('change', () => {
                // Update URL for type filter too
                const url = new URL(window.location);
                url.searchParams.set('type', typeFilter.value);
                window.history.pushState({}, '', url);
                
                filterDocuments();
            });
            
            function filterDocuments() {
                const selectedType = typeFilter.value;
                let visibleCount = 0;
                
                dokumenItems.forEach(item => {
                    const category = item.dataset.category;
                    const ext = item.dataset.ext;
                    
                    const matchesFilter = currentFilter === 'all' || category === currentFilter;
                    const matchesType = selectedType === 'all' ||
                        (selectedType === 'pdf' && ext === 'pdf') ||
                        (selectedType === 'doc' && (ext === 'doc' || ext === 'docx')) ||
                        (selectedType === 'xls' && (ext === 'xls' || ext === 'xlsx')) ||
                        (selectedType === 'zip' && (ext === 'zip' || ext === 'rar'));
                    
                    if (matchesFilter && matchesType) {
                        item.classList.remove('d-none');
                        item.style.animation = 'none';
                        item.offsetHeight; /* trigger reflow */
                        item.style.animation = 'fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards';
                        visibleCount++;
                    } else {
                        item.classList.add('d-none');
                    }
                });
                
                noResults.classList.toggle('d-none', visibleCount > 0);
            }

            // Initial Staggered Animation
            dokumenItems.forEach((item, index) => {
                item.style.animationDelay = `${index * 0.05}s`;
            });
            
            // Initial Filter Run
            filterDocuments();
            
            // Hide global spinner
            const spinner = document.getElementById('spinner');
            if (spinner) spinner.classList.remove('show');
        });
    </script>
    @endpush
</x-user-layout>
