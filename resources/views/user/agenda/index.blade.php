<x-user-layout>
	<x-slot name="title">
		{{ __('Agenda') }}
	</x-slot>

	<section class="position-relative overflow-hidden" style="background: linear-gradient(135deg, #3730a3 0%, #4f46e5 50%, #7c3aed 100%); padding-top: 100px; padding-bottom: 60px; margin-top: 0;">
		<div class="container">
			<div class="row align-items-center g-4">
				<div class="col-lg-7 text-white">
					<nav aria-label="breadcrumb" class="mb-4">
						<ol class="breadcrumb bg-transparent mb-0" style="--bs-breadcrumb-divider: '›';">
							<li class="breadcrumb-item"><a class="text-white-50 text-decoration-none" href="{{ route('home') }}">Beranda</a></li>
							<li class="breadcrumb-item active text-white" aria-current="page">Agenda</li>
						</ol>
					</nav>
					<h1 class="display-5 fw-bold mb-3 text-white">Agenda Kegiatan</h1>
					<p class="mb-0 text-white" style="font-size: 1.1rem; opacity: 0.95;">Jadwal dan informasi kegiatan terbaru dari LPPM-PM ITH.</p>
				</div>
				<div class="col-lg-5">
					<form method="get" class="bg-white rounded-3 shadow-sm p-2 p-md-3">
						<div class="row g-2 align-items-center">
							<div class="col-12 col-md">
								<div class="position-relative">
									<i class="fas fa-search position-absolute" style="left: .9rem; top: 50%; transform: translateY(-50%); color: #64748b;"></i>
									<input name="q" value="{{ $q ?? '' }}" class="form-control ps-5" placeholder="Cari agenda..." aria-label="Cari agenda">
								</div>
							</div>
							<div class="col-6 col-md-auto">
								<select name="sort" class="form-select">
									<option value="upcoming" {{ ($sort ?? '')==='upcoming'?'selected':'' }}>Mendatang</option>
									<option value="latest" {{ ($sort ?? '')==='latest'?'selected':'' }}>Terbaru</option>
									<option value="oldest" {{ ($sort ?? '')==='oldest'?'selected':'' }}>Terlama</option>
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
		<!-- Filter Pills -->
		@if($availableMonths->count() > 0 || $availableCategories->count() > 0)
		<div class="mb-4">
			<div class="d-flex flex-wrap gap-2 align-items-center">
				<span class="text-muted small me-2">Filter:</span>
				@if($availableCategories->count() > 0)
					@foreach($availableCategories as $category)
						<a href="{{ route('layanan-agenda.index', ['category' => $category, 'q' => $q, 'sort' => $sort, 'per_page' => $perPage ?? 9]) }}" 
						   class="filter-btn {{ request('category') == $category ? 'active' : '' }}" 
						   style="text-decoration: none;">
							<i class="fas fa-tag me-2"></i>{{ $category }}
						</a>
					@endforeach
				@endif
			</div>
		</div>
		@endif

		@if($agenda->count()===0)
			<div class="text-center text-muted py-5">
				<i class="far fa-calendar-alt fa-3x mb-3"></i>
				<p>Tidak ada agenda ditemukan.</p>
			</div>
		@else
			<div class="row g-4">
				@foreach($agenda as $item)
				<div class="col-xl-4 col-md-6">
					<article class="card h-100 border-0 shadow-sm" style="border-radius: 16px; overflow:hidden;">
						<div class="position-relative" style="height: 200px; background: #f3f4f6;">
							@if($item->cover)
								<img src="{{ asset('storage/'.$item->cover) }}" alt="{{ $item->judul }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
							@else
								<div class="d-flex align-items-center justify-content-center w-100 h-100"><i class="far fa-calendar-alt text-muted" style="font-size: 3rem;"></i></div>
							@endif
							@if($item->tag)
							<div class="position-absolute top-0 start-0 m-3">
								<span class="badge bg-primary" style="padding: 0.5rem 0.75rem; border-radius: 50px;">
									<i class="fas fa-tag me-1"></i> {{ $item->tag }}
								</span>
							</div>
							@endif
							<div class="position-absolute bottom-0 start-0 end-0 p-3" style="background: linear-gradient(to top, rgba(0,0,0,.55), transparent)">
								<small class="text-white"><i class="far fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($item->jadwal)->format('d M Y') }}</small>
							</div>
						</div>
						<div class="card-body">
							<h6 class="mb-2" style="line-height:1.5; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; color: #1e1b4b; font-weight: 600;">{{ $item->judul }}</h6>
							@if($item->deskripsi_singkat)
							<p class="text-muted small mb-3" style="display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{!! \Illuminate\Support\Str::limit(strip_tags($item->deskripsi_singkat), 140) !!}</p>
							@endif
							@if($item->lokasi)
							<p class="text-muted small mb-3"><i class="fas fa-map-marker-alt me-1"></i>{{ $item->lokasi }}</p>
							@endif
							<div class="d-flex justify-content-between align-items-center">
								<a href="{{ route('layanan-agenda.show', ['slug'=>$item->slug]) }}" class="btn btn-sm btn-primary"><i class="fas fa-book-open me-2"></i>Detail</a>
								<small class="text-muted"><i class="far fa-clock me-1"></i>{{ \Carbon\Carbon::parse($item->jadwal)->format('H:i') }}</small>
							</div>
						</div>
					</article>
				</div>
				@endforeach
			</div>
			<div class="d-flex justify-content-center mt-4">
				{{ $agenda->links() }}
			</div>
		@endif
	</div>

	@push('styles')
	<style>
		.card:hover { transform: translateY(-4px); box-shadow: 0 16px 32px rgba(0,0,0,.08) !important; transition: .25s; }
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
