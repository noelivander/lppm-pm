<x-reviewer-layout>
    <x-slot name="title">
        {{ __('Reviewer Dashboard') }}
    </x-slot>

    <div class="container-fluid dashboard-page">
        {{-- Header Section --}}
        <div class="row mb-3 align-items-center">
            <div class="col-md-8">
                <x-reviewer.heading name="Dashboard"></x-reviewer.heading>
                <p class="text-muted small mb-0">Kelola tugas review dan pantau progres penilaian Anda.</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="d-inline-flex align-items-center bg-white rounded-pill px-3 py-2 shadow-sm border">
                    <i class="fa fa-calendar-alt text-primary me-2"></i>
                    <span class="small fw-bold">{{ now()->format('d F Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <a href="{{ route('reviewer.assignments', ['status' => 'pending']) }}" class="text-decoration-none">
                    <div class="modern-card stat-card bg-danger-subtle border-0 h-100 animate-hover-up">
                        <div class="modern-card-body d-flex align-items-center">
                            <div class="stat-icon bg-white text-danger rounded-circle shadow-sm d-flex align-items-center justify-content-center me-3"
                                style="width: 60px; height: 60px;">
                                <i class="fas fa-clipboard-list fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted text-uppercase small fw-bold mb-1">Perlu Direview</h6>
                                <h2 class="mb-0 fw-bold text-danger">{{ $pendingReviewCount }}</h2>
                                <small class="text-danger">Proposal belum dinilai <i
                                        class="fa fa-arrow-right ms-1"></i></small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 mb-3">
                <a href="{{ route('reviewer.assignments', ['status' => 'completed']) }}" class="text-decoration-none">
                    <div class="modern-card stat-card bg-success-subtle border-0 h-100 animate-hover-up">
                        <div class="modern-card-body d-flex align-items-center">
                            <div class="stat-icon bg-white text-success rounded-circle shadow-sm d-flex align-items-center justify-content-center me-3"
                                style="width: 60px; height: 60px;">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted text-uppercase small fw-bold mb-1">Selesai Direview</h6>
                                <h2 class="mb-0 fw-bold text-success">{{ $completedReviewCount }}</h2>
                                <small class="text-success">Total proposal dinilai <i
                                        class="fa fa-arrow-right ms-1"></i></small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        {{-- Main Content Row: Tasks & Scire Dist --}}
        <div class="row">
            {{-- Priority Tasks List --}}
            <div class="col-lg-8 mb-4">
                <div class="modern-card shadow-sm h-100">
                    <div class="modern-card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold mb-0">
                            <i class="fa fa-thumbtack me-2 text-primary"></i>Tugas Prioritas (Terbaru)
                        </h5>
                    </div>
                    <div class="modern-card-body p-0">
                        @if($recentAssignments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light text-muted small text-uppercase">
                                        <tr>
                                            <th class="ps-4">Judul Proposal</th>
                                            <th>Tipe</th>
                                            <th>Tanggal Masuk</th>
                                            <th class="text-end pe-4">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-top-0">
                                        @foreach($recentAssignments as $proposal)
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="fw-bold text-dark text-truncate" style="max-width: 300px;">
                                                        {{ $proposal->judul }}
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($proposal->type == 'Penelitian')
                                                        <span
                                                            class="badge bg-info-subtle text-info rounded-pill px-3">Penelitian</span>
                                                    @else
                                                        <span
                                                            class="badge bg-warning-subtle text-warning rounded-pill px-3">Pengabdian</span>
                                                    @endif
                                                </td>
                                                <td class="small text-muted">
                                                    <i class="fa fa-clock me-1"></i>
                                                    {{ $proposal->created_at->diffForHumans() }}
                                                </td>
                                                <td class="text-end pe-4">
                                                    @if($proposal->type == 'Penelitian')
                                                        <a href="{{ route('penelitian-rev.review', $proposal->id) }}"
                                                            class="btn btn-sm btn-primary rounded-pill px-3">
                                                            Review
                                                        </a>
                                                    @else
                                                        <a href="{{ route('pengabdian-rev.review', $proposal->id) }}"
                                                            class="btn btn-sm btn-primary rounded-pill px-3">
                                                            Review
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3 text-success opacity-50">
                                    <i class="fa fa-clipboard-check fa-4x"></i>
                                </div>
                                <h6 class="fw-bold text-dark">Kerja Bagus!</h6>
                                <p class="text-muted mb-0">Tidak ada tugas review yang pending saat ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Score Distribution Chart --}}
            <div class="col-lg-4 mb-4">
                <div class="modern-card shadow-sm h-100">
                    <div class="modern-card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold mb-0">
                            <i class="fa fa-chart-pie me-2 text-primary"></i>Distribusi Nilai
                        </h5>
                    </div>
                    <div class="modern-card-body p-4 d-flex align-items-center justify-content-center">
                        <div style="width: 100%; max-width: 280px;">
                            <canvas id="scoreChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Reviews Activity Chart (Replaces Calendar) --}}
        <div class="modern-card mb-4 fade-in-up shadow-sm">
            <div class="modern-card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                <h5 class="mb-0 fw-bold">
                    <i class="fa fa-chart-line me-2 text-primary"></i>Aktivitas Review Bulanan
                </h5>
            </div>
            <div class="modern-card-body p-4">
                <div style="height: 300px;">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"
    integrity="sha384-jb8JQMbMoBUzgWatfe6COACi2ljcDdZQ2OxczGA3bGNeWe+6DChMTBJemed7ZnvJ"
    crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- 1. Score Chart ---
            const scoreCtx = document.getElementById('scoreChart').getContext('2d');
            new Chart(scoreCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode(array_keys($scoreDistribution)) !!},
                    datasets: [{
                        data: {!! json_encode(array_values($scoreDistribution)) !!},
                        backgroundColor: [
                            '#fbbf24', // Warning (Low)
                            '#3b82f6', // Info (Mid)
                            '#10b981'  // Success (High)
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
                    },
                    cutout: '70%'
                }
            });

            // --- 2. Activity Chart ---
            const activityCtx = document.getElementById('activityChart').getContext('2d');
            new Chart(activityCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Proposal Direview',
                        data: {!! json_encode($monthlyReviews ?? []) !!},
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#6366f1',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            intersect: false,
                            mode: 'index',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [2, 2] },
                            ticks: { precision: 0 }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>

    <style>
        .dashboard-page .mb-2 {
            margin-bottom: -1rem !important;
        }

        .dashboard-page .mb-3 {
            margin-bottom: 1rem !important;
        }
    </style>
</x-reviewer-layout>