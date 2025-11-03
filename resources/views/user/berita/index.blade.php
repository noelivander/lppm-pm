<x-user-layout>
    <x-slot name="title">
        {{ __('Berita Terkini') }}
    </x-slot>

    <!-- Hero Section -->
    <section class="position-relative overflow-hidden py-5" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #3730a3 100%);">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center text-white">
                    <h1 class="display-4 fw-bold mb-3 animate-float">Berita Terkini</h1>
                    <p class="lead mb-4">Informasi terbaru seputar kegiatan dan prestasi LPPM-PM ITH</p>

                    <!-- Sort Options -->
                    <div class="d-flex justify-content-center flex-wrap gap-3 mb-4">
                        <a href="{{ route('layanan-berita.index', ['sort' => 'latest']) }}" class="sort-btn {{ $sort == 'latest' ? 'active' : '' }}">
                            <i class="fas fa-clock me-2"></i>Terbaru
                        </a>
                        <a href="{{ route('layanan-berita.index', ['sort' => 'popular']) }}" class="sort-btn {{ $sort == 'popular' ? 'active' : '' }}">
                            <i class="fas fa-fire me-2"></i>Populer
                        </a>
                        <a href="{{ route('layanan-berita.index', ['sort' => 'oldest']) }}" class="sort-btn {{ $sort == 'oldest' ? 'active' : '' }}">
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

    <!-- Berita Section -->
    <section class="py-5">
        <div class="container">
            <!-- Loading State -->
            <div id="loadingState" class="text-center py-5" style="display: none;">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 text-muted">Memuat berita...</p>
            </div>

            <div class="row g-4" id="beritaGrid">
                @forelse($berita as $key => $value)
                <div class="col-lg-3 col-md-4 col-sm-6 berita-item fade-in-up" data-date="{{ $value->created_at->timestamp }}" data-views="{{ $value->views ?? 0 }}">
                    <article class="card border-0 shadow-sm h-100 hover-lift" style="border-radius: 15px; overflow: hidden; transition: all 0.3s ease;">
                        <div class="position-relative" style="overflow: hidden; height: 200px;">
                            @if($value->cover)
                                <img src="{{ asset('storage/'.$value->cover) }}" class="card-img-top" alt="{{ $value->judul }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100" style="background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);">
                                    <i class="fa fa-newspaper fa-4x text-primary" style="opacity: 0.3;"></i>
                                </div>
                            @endif
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge" style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); padding: 0.5rem 1rem; border-radius: 50px;">
                                    <i class="far fa-newspaper me-1"></i> Berita
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3 text-muted small">
                                <i class="far fa-calendar-alt me-2 text-primary"></i>
                                <span>{{ $value->created_at->format('d M Y') }}</span>
                                <span class="mx-2">•</span>
                                <i class="far fa-eye me-2 text-primary"></i>
                                <span>{{ $value->views ?? 0 }} views</span>
                            </div>
                            <h5 class="card-title mb-3" style="color: #1e1b4b; font-weight: 600; line-height: 1.4; min-height: 3rem;">
                                {{ maxStr($value->judul, 65) }}
                            </h5>
                            <p class="card-text text-muted mb-4" style="font-size: 0.9rem; line-height: 1.6;">
                                {{ maxStr(strip_tags($value->isi), 100) }}
                            </p>
                            <a href="{{ route('layanan-berita.show',['slug'=>$value->slug]) }}" class="btn btn-sm px-4 py-2" style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); color: white; border-radius: 50px; font-weight: 500; transition: all 0.3s ease;">
                                Baca Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </article>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-newspaper fa-4x text-muted" style="opacity: 0.3;"></i>
                        </div>
                        <h5 class="text-muted">Belum ada berita tersedia</h5>
                        <p class="text-muted">Silakan kunjungi kembali nanti untuk informasi terbaru</p>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if(method_exists($berita, 'links'))
            <div class="d-flex justify-content-center mt-5">
                {{ $berita->links() }}
            </div>
            @endif
        </div>
    </section>

    @push('styles')
    <style>
        .sort-btn {
            padding: 0.5rem 1rem;
            border: 2px solid #e2e8f0;
            background: white;
            color: #64748b;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .sort-btn:hover {
            border-color: #7c3aed;
            color: #7c3aed;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.2);
        }

        .sort-btn.active {
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
            color: white;
            border-color: #7c3aed;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
        }

        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
        }
        .hover-lift:hover img {
            transform: scale(1.05);
        }
        .card:hover .btn {
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.4);
        }

        .berita-item {
            transition: all 0.3s ease;
        }

        .berita-item.hidden {
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
    </style>
    @endpush
</x-user-layout>