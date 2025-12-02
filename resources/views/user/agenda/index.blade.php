<x-user-layout>
	<x-slot name="title">
		{{ __('Agenda Kegiatan') }}
	</x-slot>

	<!-- Hero Section -->
	<section class="position-relative overflow-hidden"
		style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #3730a3 100%); min-height: 60vh;">
		<!-- Decorative Background Elements -->
		<div class="position-absolute"
			style="top: -10%; right: -5%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(124, 58, 237, 0.15) 0%, transparent 70%); border-radius: 50%;">
		</div>
		<div class="position-absolute"
			style="bottom: -15%; left: -8%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(59, 130, 246, 0.12) 0%, transparent 70%); border-radius: 50%;">
		</div>

		<div class="container position-relative" style="padding-top: 6rem; padding-bottom: 4rem;">
			<div class="row align-items-center justify-content-center text-center">
				<div class="col-lg-8" data-aos="fade-up">
					<div class="mb-4">
						<span class="badge px-4 py-2"
							style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius: 50px; color: white; font-weight: 500; font-size: 0.9rem;">
							<i class="far fa-calendar-alt me-2"></i>Jadwal Kegiatan
						</span>
					</div>

					<h1 class="display-4 fw-bold text-white mb-4" style="line-height: 1.2;">
						Agenda & Kegiatan<br>
						<span
							style="background: linear-gradient(135deg, #a78bfa 0%, #ec4899 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">LPPM-PM
							ITH</span>
					</h1>

					<p class="lead text-white mb-5" style="opacity: 0.9; line-height: 1.8; font-size: 1.1rem;">
						Informasi lengkap mengenai jadwal kegiatan, seminar, workshop, dan agenda penting lainnya di
						lingkungan LPPM-PM ITH.
					</p>
				</div>
			</div>

			<!-- Search & Filter Card -->
			<div class="row justify-content-center" data-aos="fade-up" data-aos-delay="100">
				<div class="col-lg-10">
					<div class="card border-0 shadow-lg"
						style="background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); border-radius: 30px;">
						<div class="card-body p-4">
							<form method="get">
								<div class="row g-3">
									<div class="col-lg-7">
										<div class="position-relative">
											<i class="fas fa-search position-absolute text-muted"
												style="left: 1.2rem; top: 50%; transform: translateY(-50%);"></i>
											<input type="text" name="q" value="{{ $q ?? '' }}"
												class="form-control form-control-lg ps-5 border-0 bg-light"
												style="border-radius: 15px;" placeholder="Cari agenda...">
										</div>
									</div>
									<div class="col-md-6 col-lg-4">
										<select name="sort" class="form-select form-select-lg border-0 bg-light"
											style="border-radius: 15px;">
											<option value="upcoming" {{ ($sort ?? '') === 'upcoming' ? 'selected' : '' }}>
												Mendatang</option>
											<option value="latest" {{ ($sort ?? '') === 'latest' ? 'selected' : '' }}>Terbaru
												Ditambahkan</option>
											<option value="oldest" {{ ($sort ?? '') === 'oldest' ? 'selected' : '' }}>Terlama
												Ditambahkan</option>
										</select>
									</div>
									
									<div class="col-lg-1 d-none d-lg-block">
										<button type="submit" class="btn btn-primary btn-lg w-100 h-100"
											style="border-radius: 15px; background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%); border: none;">
											<i class="fas fa-arrow-right"></i>
										</button>
									</div>
									<!-- Mobile Submit Button -->
									<div class="col-12 d-lg-none">
										<button type="submit" class="btn btn-primary w-100 py-3"
											style="border-radius: 15px; background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%); border: none;">
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
			<!-- Category Filter Pills -->
			@if($availableMonths->count() > 0 || $availableCategories->count() > 0)
				<div class="d-flex justify-content-center mb-5 overflow-auto pb-2">
					<div class="btn-group bg-white rounded-pill p-1 shadow-sm" role="group">
						<a href="{{ route('layanan-agenda.index', ['q' => $q, 'sort' => $sort, 'per_page' => $perPage ?? 9]) }}"
							class="filter-btn btn btn-link text-decoration-none rounded-pill px-4 py-2 {{ !request('category') ? 'active fw-bold' : 'text-muted' }}"
							style="{{ !request('category') ? 'color: #1e1b4b;' : '' }}">
							Semua
						</a>
						@if($availableCategories->count() > 0)
							@foreach($availableCategories as $category)
								<a href="{{ route('layanan-agenda.index', ['category' => $category, 'q' => $q, 'sort' => $sort, 'per_page' => $perPage ?? 9]) }}"
									class="filter-btn btn btn-link text-decoration-none rounded-pill px-4 py-2 {{ request('category') == $category ? 'active fw-bold' : 'text-muted' }}"
									style="{{ request('category') == $category ? 'color: #1e1b4b;' : '' }}">
									{{ $category }}
								</a>
							@endforeach
						@endif
					</div>
				</div>
			@endif

			@if($agenda->count() === 0)
				<div class="text-center py-5">
					<div class="mb-4">
						<div class="d-inline-flex align-items-center justify-content-center"
							style="width: 100px; height: 100px; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); border-radius: 50%;">
							<i class="far fa-calendar-times fa-3x" style="color: #4f46e5;"></i>
						</div>
					</div>
					<h4 class="fw-bold mb-2" style="color: #1e1b4b;">Belum ada agenda</h4>
					<p class="text-muted mb-4">Tidak ada kegiatan yang ditemukan untuk kriteria pencarian ini.</p>
					<a href="{{ route('layanan-agenda.index') }}" class="btn btn-outline-primary rounded-pill px-4 py-2"
						style="border-color: #4f46e5; color: #4f46e5;">
						Reset Pencarian
					</a>
				</div>
			@else
				<div class="row g-4">
					@foreach($agenda as $index => $item)
						<div class="col-xl-4 col-md-6 fade-in-up" style="animation-delay: {{ $index * 0.1 }}s">
							<article class="card h-100 border-0 shadow-sm hover-lift"
								style="border-radius: 20px; overflow:hidden; transition: all 0.3s ease;">
								<div class="position-relative overflow-hidden" style="height: 220px;">
									@if($item->cover)
										<img src="{{ asset('storage/' . $item->cover) }}" alt="{{ $item->judul }}"
											class="w-100 h-100 object-fit-cover transition-transform">
									@else
										<div class="d-flex align-items-center justify-content-center w-100 h-100 bg-light">
											<i class="far fa-calendar-alt text-muted opacity-25" style="font-size: 4rem;"></i>
										</div>
									@endif

									<!-- Date Badge (Large) -->
									<div class="position-absolute top-0 start-0 m-3">
										<div class="bg-white rounded-4 shadow-sm text-center overflow-hidden"
											style="width: 60px;">
											<div class="bg-primary text-white small py-1 fw-bold text-uppercase"
												style="background: #4f46e5 !important;">
												{{ \Carbon\Carbon::parse($item->jadwal)->format('M') }}
											</div>
											<div class="h4 mb-0 fw-bold py-2" style="color: #1e1b4b;">
												{{ \Carbon\Carbon::parse($item->jadwal)->format('d') }}
											</div>
										</div>
									</div>

									<!-- Tag Badge -->
									@if($item->tag)
										<div class="position-absolute top-0 end-0 m-3">
											<span class="badge shadow-sm rounded-pill px-3 py-2"
												style="background: rgba(255,255,255,0.95); color: #4f46e5; backdrop-filter: blur(5px);">
												<i class="fas fa-tag me-1"></i> {{ $item->tag }}
											</span>
										</div>
									@endif
								</div>

								<div class="card-body p-4 d-flex flex-column">
									<h5 class="card-title fw-bold mb-3 line-clamp-2" style="color: #1e1b4b; line-height: 1.4;">
										<a href="{{ route('layanan-agenda.show', ['slug' => $item->slug]) }}"
											class="text-decoration-none text-reset stretched-link">
											{{ $item->judul }}
										</a>
									</h5>

									<div class="mb-3">
										<div class="d-flex align-items-center text-muted small mb-2">
											<i class="far fa-clock me-2 text-primary" style="width: 16px;"></i>
											{{ \Carbon\Carbon::parse($item->jadwal)->format('H:i') }} WITA
										</div>
										@if($item->lokasi)
											<div class="d-flex align-items-center text-muted small">
												<i class="fas fa-map-marker-alt me-2 text-primary" style="width: 16px;"></i>
												<span class="line-clamp-1">{{ $item->lokasi }}</span>
											</div>
										@endif
									</div>

									@if($item->deskripsi_singkat)
										<p class="text-muted small mb-4 line-clamp-2" style="line-height: 1.6;">
											{!! \Illuminate\Support\Str::limit(strip_tags($item->deskripsi_singkat), 100) !!}
										</p>
									@endif

									<div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
										<span class="btn btn-sm btn-outline-primary rounded-pill px-3"
											style="border-color: #4f46e5; color: #4f46e5;">
											Lihat Detail
										</span>
										<div class="d-flex align-items-center text-muted small">
											<i class="far fa-eye me-1"></i> {{ number_format($item->views ?? 0) }}
										</div>
									</div>
								</div>
							</article>
						</div>
					@endforeach
				</div>

				<div class="d-flex justify-content-center mt-5">
					{{ $agenda->links() }}
				</div>
			@endif
		</div>
	</section>

	@push('styles')
		<style>
			.hover-lift:hover {
				transform: translateY(-5px);
				box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
			}

			.hover-lift:hover img.transition-transform {
				transform: scale(1.05);
			}

			.transition-transform {
				transition: transform 0.5s ease;
			}

			.line-clamp-1 {
				display: -webkit-box;
				-webkit-line-clamp: 1;
				-webkit-box-orient: vertical;
				overflow: hidden;
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
				from {
					opacity: 0;
					transform: translateY(20px);
				}

				to {
					opacity: 1;
					transform: translateY(0);
				}
			}

			.form-control:focus,
			.form-select:focus {
				box-shadow: none;
				border-color: #4f46e5;
				background-color: white;
			}

			/* Pagination Customization */
			.pagination {
				--bs-pagination-active-bg: #4f46e5;
				--bs-pagination-active-border-color: #4f46e5;
				--bs-pagination-color: #1e1b4b;
				--bs-pagination-hover-color: #4f46e5;
				--bs-pagination-focus-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.25);
			}

			.page-link {
				border-radius: 50%;
				margin: 0 3px;
				width: 40px;
				height: 40px;
				display: flex;
				align-items: center;
				justify-content: center;
				border: none;
				font-weight: 600;
			}

			.page-item.active .page-link {
				box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
			}
		</style>
	@endpush

	@push('scripts')
		<script>
			document.addEventListener('DOMContentLoaded', function () {
				// Hide global spinner
				const spinner = document.getElementById('spinner');
				if (spinner) spinner.classList.remove('show');
			});
		</script>
	@endpush
</x-user-layout>