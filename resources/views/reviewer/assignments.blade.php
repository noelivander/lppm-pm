<x-reviewer-layout>
    <x-slot name="title">
        {{ __('Daftar Tugas Review') }}
    </x-slot>

    <div class="container-fluid py-4">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h4 class="mb-1 text-primary fw-bold">Daftar Tugas Review</h4>
                <p class="mb-0 text-muted">Kelola tugas review proposal Anda.</p>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('reviewer.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fa fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>

        {{-- Filter Tabs --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden;">
            <div class="card-body p-2 bg-white">
                <ul class="nav nav-pills nav-fill gap-2">
                    <li class="nav-item">
                        <a class="nav-link {{ $status == 'pending' ? 'active shadow-sm fw-bold bg-danger' : 'text-danger' }}"
                            href="{{ route('reviewer.assignments', ['status' => 'pending']) }}">
                            <i class="fa fa-clock me-2"></i>Perlu Direview
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $status == 'completed' ? 'active shadow-sm fw-bold bg-success' : 'text-success' }}"
                            href="{{ route('reviewer.assignments', ['status' => 'completed']) }}">
                            <i class="fa fa-check-circle me-2"></i>Selesai Direview
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Content List --}}
        @if($allAssignments->count() > 0)
            <div class="row">
                @foreach($allAssignments as $proposal)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm hover-shadow transition-all" style="border-radius: 12px;">
                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    @if($proposal->type == 'Penelitian')
                                        <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                                            <i class="fa fa-flask me-1"></i> Penelitian
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">
                                            <i class="fa fa-hand-holding-heart me-1"></i> Pengabdian
                                        </span>
                                    @endif
                                    <small class="text-muted">
                                        <i class="fa fa-calendar-alt me-1"></i> {{ $proposal->created_at->format('d M Y') }}
                                    </small>
                                </div>

                                <h5 class="fw-bold text-dark mb-3 line-clamp-2" style="min-height: 3rem;">
                                    {{ $proposal->judul }}
                                </h5>

                                {{-- Additional Info if available in model (Author, Scheme etc) could go here --}}

                                <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                    @if(request('status') === 'completed')
                                        <span class="text-success small fw-bold">
                                            <i class="fa fa-check-double me-1"></i> Selesai
                                        </span>
                                    @else
                                        <span class="text-danger small fw-bold">
                                            <i class="fa fa-hourglass-half me-1"></i> Menunggu
                                        </span>
                                    @endif

                                    @if($proposal->type == 'Penelitian')
                                        <a href="{{ route('penelitian-rev.review', $proposal->id) }}"
                                            class="btn btn-sm btn-primary rounded-pill px-4 shadow-sm">
                                            {{ request('status') === 'completed' ? 'Lihat Review' : 'Mulai Review' }} <i
                                                class="fa fa-arrow-right ms-1"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('pengabdian-rev.review', $proposal->id) }}"
                                            class="btn btn-sm btn-primary rounded-pill px-4 shadow-sm">
                                            {{ request('status') === 'completed' ? 'Lihat Review' : 'Mulai Review' }} <i
                                                class="fa fa-arrow-right ms-1"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination (if implemented later) or Count Info --}}
            <div class="text-center text-muted small mt-2">
                Menampilkan {{ $allAssignments->count() }} proposal
            </div>

        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    @if($status == 'pending')
                        <div class="bg-success-subtle rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <i class="fa fa-check fa-3x text-success"></i>
                        </div>
                        <h4 class="mt-4 fw-bold text-dark">Luar Biasa!</h4>
                        <p class="text-muted">Anda tidak memiliki tugas review yang pending.</p>
                    @elseif($status == 'completed')
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <i class="fa fa-clipboard fa-3x text-muted"></i>
                        </div>
                        <h4 class="mt-4 fw-bold text-dark">Belum Ada History</h4>
                        <p class="text-muted">Anda belum menyelesaikan review apapun.</p>
                    @else
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <i class="fa fa-folder-open fa-3x text-muted"></i>
                        </div>
                        <h4 class="mt-4 fw-bold text-dark">Tidak Ada Data</h4>
                        <p class="text-muted">Tidak ada proposal yang ditemukan.</p>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <style>
        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-reviewer-layout>