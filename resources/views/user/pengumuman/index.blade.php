<x-user-layout>
	<x-slot name="title">
		{{ __('Pengumuman') }}
	</x-slot>

	<section class="position-relative overflow-hidden" style="background: linear-gradient(135deg, #3730a3 0%, #4f46e5 50%, #7c3aed 100%); padding-top: 100px; padding-bottom: 60px; margin-top: 0;">
		<div class="container">
			<div class="row align-items-center g-4">
				<div class="col-lg-7 text-white">
					<nav aria-label="breadcrumb" class="mb-4">
						<ol class="breadcrumb bg-transparent mb-0" style="--bs-breadcrumb-divider: '›';">
							<li class="breadcrumb-item"><a class="text-white-50 text-decoration-none" href="{{ route('home') }}">Beranda</a></li>
							<li class="breadcrumb-item active text-white" aria-current="page">Pengumuman</li>
						</ol>
					</nav>
					<h1 class="display-5 fw-bold mb-3 text-white">Pengumuman Terkini</h1>
					<p class="mb-0 text-white" style="font-size: 1.1rem; opacity: 0.95;">Informasi terbaru dan pengumuman penting dari LPPM-PM ITH.</p>
				</div>
				<div class="col-lg-5">
					<form method="get" class="bg-white rounded-3 shadow-sm p-2 p-md-3">
						<div class="row g-2 align-items-center">
							<div class="col-12 col-md">
								<div class="position-relative">
									<i class="fas fa-search position-absolute" style="left: .9rem; top: 50%; transform: translateY(-50%); color: #64748b;"></i>
									<input name="q" value="{{ $q ?? '' }}" class="form-control ps-5" placeholder="Cari pengumuman..." aria-label="Cari pengumuman">
								</div>
							</div>
							<div class="col-6 col-md-auto">
								<select name="sort" class="form-select">
									<option value="latest" {{ ($sort ?? '')==='latest'?'selected':'' }}>Terbaru</option>
									<option value="oldest" {{ ($sort ?? '')==='oldest'?'selected':'' }}>Terlama</option>
									<option value="popular" {{ ($sort ?? '')==='popular'?'selected':'' }}>Terpopuler</option>
								</select>
							</div>
							<div class="col-6 col-md-auto">
								<select name="per_page" class="form-select">
									@foreach([9,12,15,18,24] as $pp)
										<option value="{{ $pp }}" {{ (isset($perPage) && $perPage==$pp)?'selected':'' }}>{{ $pp }}/hal</option>
									@endforeach
								</select>
							</div>
							<div class="col-12 col-md-auto">
								<button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-2"></i>Terapkan</button>
							</div>
						</div>
					</form>
                </div>
            </div>
        </div>
</section>

	<div class="container py-5">
		@if($pengumuman->count()===0)
			<div class="text-center text-muted py-5">
				<i class="fas fa-bullhorn fa-3x mb-3"></i>
				<p>Tidak ada pengumuman ditemukan.</p>
            </div>
		@else
			<div class="row g-4">
				@foreach($pengumuman as $item)
				<div class="col-xl-4 col-md-6">
					<article class="card h-100 border-0 shadow-sm" style="border-radius: 16px; overflow:hidden;">
						<div class="position-relative" style="height: 200px; background: #f3f4f6;">
							@if($item->cover)
								<img src="{{ asset('storage/'.$item->cover) }}" alt="{{ $item->judul }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
                            @else
								<div class="d-flex align-items-center justify-content-center w-100 h-100"><i class="fas fa-bullhorn text-muted" style="font-size: 3rem;"></i></div>
							@endif
							<div class="position-absolute top-0 start-0 m-3">
								<span class="badge bg-primary" style="padding: 0.5rem 0.75rem; border-radius: 50px;">
									<i class="fas fa-bullhorn me-1"></i> Pengumuman
								</span>
                                </div>
							<div class="position-absolute bottom-0 start-0 end-0 p-3" style="background: linear-gradient(to top, rgba(0,0,0,.55), transparent)">
								<small class="text-white"><i class="far fa-calendar-alt me-1"></i>{{ $item->created_at->format('d M Y') }}</small>
                            </div>
                        </div>
						<div class="card-body">
							<h6 class="mb-2" style="line-height:1.5; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; color: #1e1b4b; font-weight: 600;">{{ $item->judul }}</h6>
							<p class="text-muted small mb-3" style="display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{!! \Illuminate\Support\Str::limit(strip_tags($item->isi), 140) !!}</p>
							<div class="d-flex justify-content-between align-items-center">
								<a href="{{ route('layanan-pengumuman.show', ['slug'=>$item->slug]) }}" class="btn btn-sm btn-primary"><i class="fas fa-book-open me-2"></i>Baca</a>
								<small class="text-muted"><i class="far fa-eye me-1"></i>{{ number_format($item->views ?? 0) }}</small>
                            </div>
                        </div>
                    </article>
                </div>
				@endforeach
                        </div>
			<div class="d-flex justify-content-center mt-4">
                {{ $pengumuman->links() }}
            </div>
        @endif
    </div>

	@push('styles')
	<style>
		.card:hover { transform: translateY(-4px); box-shadow: 0 16px 32px rgba(0,0,0,.08) !important; transition: .25s; }
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
