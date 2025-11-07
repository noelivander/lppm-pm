<x-user-layout>
	<x-slot name="title">
		{{ __($berita->judul) }}
	</x-slot>

	<section class="position-relative overflow-hidden" style="background: linear-gradient(135deg, #3730a3 0%, #4f46e5 50%, #7c3aed 100%); padding-top: 100px; padding-bottom: 60px; margin-top: 0;">
		<div class="container">
			<nav aria-label="breadcrumb" class="mb-4">
				<ol class="breadcrumb bg-transparent mb-0 text-white" style="--bs-breadcrumb-divider: '›';">
					<li class="breadcrumb-item"><a class="text-white-50 text-decoration-none" href="{{ route('home') }}">Beranda</a></li>
					<li class="breadcrumb-item"><a class="text-white-50 text-decoration-none" href="{{ route('layanan-berita.index') }}">Berita</a></li>
					<li class="breadcrumb-item active text-white" aria-current="page">{{ \Illuminate\Support\Str::limit($berita->judul, 50) }}</li>
				</ol>
			</nav>
			<h1 class="text-white fw-bold mb-3" style="max-width:900px; font-size: 2.5rem;">{{ $berita->judul }}</h1>
			<p class="text-white-50 mb-0" style="font-size: 1rem;"><i class="far fa-calendar-alt me-2"></i>{{ $berita->created_at->format('d M Y') }} · <i class="far fa-eye ms-2 me-1"></i>{{ number_format($berita->views ?? 0) }} views</p>
		</div>
	</section>

	<div class="container py-5">
		<div class="row justify-content-center g-5">
			<div class="col-lg-10">
				<div class="bg-white rounded-3 shadow-sm overflow-hidden">
					@if($berita->cover)
						<img src="{{ asset('storage/'.$berita->cover) }}" alt="{{ $berita->judul }}" class="w-100" style="max-height: 420px; object-fit: cover;">
					@endif
					<div class="p-3 p-md-4 border-bottom d-flex justify-content-between align-items-center">
						<a href="{{ url()->previous() }}" class="btn btn-light border"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
						<div class="d-flex gap-2">
						</div>
					</div>
					<div class="p-3 p-md-4">
						<article class="prose">
							{!! $berita->isi !!}
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