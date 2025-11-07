<x-user-layout>
	<x-slot name="title">
		{{ __($agenda->judul) }}
	</x-slot>

	<section class="position-relative overflow-hidden" style="background: linear-gradient(135deg, #3730a3 0%, #4f46e5 50%, #7c3aed 100%); padding-top: 100px; padding-bottom: 60px; margin-top: 0;">
		<div class="container">
			<nav aria-label="breadcrumb" class="mb-4">
				<ol class="breadcrumb bg-transparent mb-0 text-white" style="--bs-breadcrumb-divider: '›';">
					<li class="breadcrumb-item"><a class="text-white-50 text-decoration-none" href="{{ route('home') }}">Beranda</a></li>
					<li class="breadcrumb-item"><a class="text-white-50 text-decoration-none" href="{{ route('layanan-agenda.index') }}">Agenda</a></li>
					<li class="breadcrumb-item active text-white" aria-current="page">{{ \Illuminate\Support\Str::limit($agenda->judul, 50) }}</li>
				</ol>
			</nav>
			<h1 class="text-white fw-bold mb-3" style="max-width:900px; font-size: 2.5rem;">{{ $agenda->judul }}</h1>
			<p class="text-white-50 mb-0" style="font-size: 1rem;">
				<i class="far fa-calendar-alt me-2"></i>{{ $jadwal }}
				@if($agenda->lokasi)
					· <i class="fas fa-map-marker-alt ms-2 me-1"></i>{{ $agenda->lokasi }}
				@endif
			</p>
		</div>
	</section>

	<div class="container py-5">
		<div class="row justify-content-center g-5">
			<div class="col-lg-10">
				<div class="bg-white rounded-3 shadow-sm overflow-hidden">
					@if($agenda->cover)
						<img src="{{ asset('storage/'.$agenda->cover) }}" alt="{{ $agenda->judul }}" class="w-100" style="max-height: 420px; object-fit: cover;">
					@endif
					<div class="p-3 p-md-4 border-bottom d-flex justify-content-between align-items-center">
						<a href="{{ url()->previous() }}" class="btn btn-light border"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
						<div class="d-flex gap-2">
							@if($agenda->tautan)
								<a href="{{ $agenda->tautan }}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-external-link-alt me-1"></i> Tautan</a>
							@endif
						</div>
					</div>
					<div class="p-3 p-md-4">
						<div class="row g-3 mb-4">
							@if($agenda->tag)
							<div class="col-md-6">
								<div class="d-flex align-items-center">
									<i class="fas fa-tag text-primary me-2"></i>
									<div>
										<small class="text-muted d-block">Kategori</small>
										<span class="badge bg-primary">{{ $agenda->tag }}</span>
									</div>
								</div>
							</div>
							@endif
							<div class="col-md-6">
								<div class="d-flex align-items-center">
									<i class="far fa-calendar-alt text-primary me-2"></i>
									<div>
										<small class="text-muted d-block">Jadwal</small>
										<span>{{ $jadwal }}</span>
									</div>
								</div>
							</div>
							@if($agenda->lokasi)
							<div class="col-md-6">
								<div class="d-flex align-items-center">
									<i class="fas fa-map-marker-alt text-primary me-2"></i>
									<div>
										<small class="text-muted d-block">Lokasi</small>
										<span>{{ $agenda->lokasi }}</span>
									</div>
								</div>
							</div>
							@endif
						</div>
						<article class="prose">
							{!! $deskripsi ?? '<p class="text-muted">Tidak ada deskripsi tersedia.</p>' !!}
						</article>
					</div>
				</div>
			</div>
		</div>
	</div>

	@push('styles')
	<style>
		.prose p { font-size: 1.05rem; line-height: 1.85; color: #334155; }
		.prose h2, .prose h3 { margin-top: 1.5rem; }
		.prose img { max-width: 100%; height: auto; border-radius: .5rem; }
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
