<x-user-layout>
    <x-slot name="title">
        {{ __($dokumen->judul) }}
    </x-slot>

    <section class="position-relative overflow-hidden" style="background: linear-gradient(135deg, #3730a3 0%, #4f46e5 50%, #7c3aed 100%); padding-top: 100px; padding-bottom: 60px; margin-top: 0;">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent mb-0 text-white" style="--bs-breadcrumb-divider: '›';">
                    <li class="breadcrumb-item"><a class="text-white-50 text-decoration-none" href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a class="text-white-50 text-decoration-none" href="{{ route('dokumen.index') }}">Dokumen</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">{{ \Illuminate\Support\Str::limit($dokumen->judul, 50) }}</li>
                </ol>
            </nav>
            <h1 class="text-white fw-bold mb-3" style="max-width:900px; font-size: 2.5rem;">{{ $dokumen->judul }}</h1>
            <p class="text-white-50 mb-0" style="font-size: 1rem;"><i class="far fa-calendar-alt me-2"></i>{{ $dokumen->created_at->format('d M Y') }}</p>
        </div>
    </section>

    <div class="container py-5">
        <div class="row justify-content-md-center g-5">
            <div class="col-lg-9 ">
                <div class="modern-card wow animated zoomIn fade-in-up" data-wow-delay="0.2s">
                    <div class="d-flex justify-content-between align-items-center px-3 px-md-4 py-3 border-bottom" style="gap: .75rem;">
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ url()->previous() }}" class="btn btn-light btn-sm border" style="border-radius: 10px;">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                            <h6 class="mb-0 text-truncate" style="max-width: 420px;">{{ $dokumen->judul }}</h6>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            @php
                                $fileUrl = !empty($dokumen->file) ? asset('storage/'.$dokumen->file) : null;
                                $ext = pathinfo($dokumen->file ?? '', PATHINFO_EXTENSION);
                            @endphp
                            @if($fileUrl)
                            <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="Buka di tab baru" style="border-radius: 10px;"><i class="fas fa-external-link-alt"></i></a>
                            <a href="{{ $fileUrl }}" download class="btn btn-sm btn-primary" title="Unduh" style="border-radius: 10px;"><i class="fas fa-download me-1"></i> Unduh</a>
                            <button id="printPdf" class="btn btn-sm btn-outline-secondary d-none d-md-inline-flex" title="Cetak" style="border-radius: 10px;"><i class="fas fa-print"></i></button>
                            @endif
                        </div>
                    </div>
                    <div class="modern-card-body p-0">
                        @if(!empty($dokumen->file))
                        <embed id="pdfViewer" src="{{ asset('storage/'.$dokumen->file) }}" type="application/pdf" width="100%" height="720px" class="pt-1">
                        @else
                        <div class="p-5 text-center text-muted">File tidak tersedia.</div>
                        @endif
                    </div>
                    <div class="px-3 px-md-4 py-3 border-top d-flex flex-wrap gap-3 align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-light text-dark border">Tipe: <span class="text-uppercase ms-1">{{ $ext ?: '—' }}</span></span>
                            <span class="badge bg-light text-dark border">Tanggal: {{ $dokumen->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="text-muted small">Pastikan Anda telah masuk untuk mengakses dokumen yang terkunci.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
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
            const btn = document.getElementById('printPdf');
            const viewer = document.getElementById('pdfViewer');
            if (btn && viewer) {
                btn.addEventListener('click', function() {
                    // Fallback print: open in new tab to invoke native print
                    const url = viewer.getAttribute('src');
                    const w = window.open(url, '_blank');
                    if (w) {
                        w.addEventListener('load', function() { w.focus(); w.print(); }, { once: true });
                    }
                });
            }

            // Hide spinner when page loaded
            const spinner = document.getElementById('spinner');
            if (spinner) {
                spinner.classList.remove('show');
            }
        });
    </script>
    @endpush
</x-user-layout>