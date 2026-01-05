<x-admin-layout>
    <x-slot name="title">
        {{ __('Dashboard') }}
    </x-slot>

    <x-admin.heading name="Dashboard">
        <a href="#" class="modern-btn modern-btn-primary generate-report-btn">
            <i class="fa fa-download me-1"></i> Generate Report
        </a>
    </x-admin.heading>
    {{-- Custom CSS for 5-column grid on XL screens --}}
    <style>
        @media (min-width: 1200px) {
            .col-xl-2-4 {
                flex: 0 0 20%;
                max-width: 20%;
            }
        }
    </style>

    <div class="row mb-4">
        <div class="col-xl-2-4 col-md-6 mb-4">
            <x-admin.dash-content-card title="Program Studi" :value="$kpis['totalProdi']" color="primary" icon="fas fa-university fa-2x"/>
        </div>
        <div class="col-xl-2-4 col-md-6 mb-4">
            <x-admin.dash-content-card title="Total User" :value="$kpis['totalUsers']" color="success" icon="fas fa-users fa-2x"/>
        </div>
        <div class="col-xl-2-4 col-md-6 mb-4">
            <x-admin.dash-content-card title="Penelitian" :value="$kpis['totalPenelitian']" color="info" icon="fas fa-flask fa-2x"/>
        </div>
        <div class="col-xl-2-4 col-md-6 mb-4">
            <x-admin.dash-content-card title="Pengabdian" :value="$kpis['totalPengabdian']" color="warning" icon="fas fa-hands-helping fa-2x"/>
        </div>
        <div class="col-xl-2-4 col-md-6 mb-4">
             <x-admin.dash-content-card title="Menunggu Reviewer" :value="$kpis['pendingAssignments']" color="danger" icon="fas fa-user-clock fa-2x"/>
        </div>
    </div>

    {{-- Detailed Funding Card --}}
    <div class="row mb-4">
        <div class="col-12">
             <div class="card border-left-success shadow h-100 py-3">
                <div class="card-body">
                    <div class="row align-items-center text-center">
                         <div class="col-md-4 border-end">
                             <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Dana (Accumulated)</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($kpis['totalFunding'], 0, ',', '.') }}</div>
                         </div>
                         <div class="col-md-4 border-end">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Dana Penelitian</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($kpis['fundingPenelitian'], 0, ',', '.') }}</div>
                         </div>
                         <div class="col-md-4">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Dana Pengabdian</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($kpis['fundingPengabdian'], 0, ',', '.') }}</div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-6 col-lg-6 d-flex align-items-stretch">
            <div class="modern-card mb-4 fade-in-up w-100">
                <div class="modern-card-header d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fa fa-chart-line me-2"></i>Grafik Tahunan
                    </h6>
                </div>
                <div class="modern-card-body d-flex flex-column justify-content-center" style="min-height: 340px">
                    <div class="chart-area" style="height: 320px">
                        <canvas id="adminAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Skema Pie Chart -->
        <div class="col-xl-6 col-lg-6 d-flex align-items-stretch">
            <div class="modern-card mb-4 fade-in-up w-100">
                <div class="modern-card-header d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fa fa-chart-pie me-2"></i>Hibah per Skema
                    </h6>
                </div>
                <div class="modern-card-body" style="min-height: 340px">
                    <div class="row align-items-center h-100">
                        <div class="col-md-7">
                            <div class="chart-pie pt-4 pb-2" style="height: 300px">
                                <canvas id="adminPieChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-5">
                             <div class="mt-4 text-start small">
                                 @foreach($skema['labels'] as $index => $label)
                                    <div class="mb-3 d-flex align-items-start">
                                        <i class="fas fa-circle mt-1 me-2 flex-shrink-0" style="color: {{ ['#7c3aed', '#8b5cf6', '#10b981', '#06b6d4', '#f59e0b'][$index % 5] }}"></i> 
                                        <span class="text-wrap lh-sm" title="{{ $label }}">{{ $label }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Status Chart -->
        <div class="col-xl-6 col-lg-6 d-flex align-items-stretch">
            <div class="modern-card mb-4 fade-in-up w-100">
                <div class="modern-card-header d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fa fa-stream me-2"></i>Status Penelitian
                    </h6>
                </div>
                <div class="modern-card-body" style="min-height: 340px">
                    <div class="row align-items-center h-100">
                        <div class="col-md-7">
                            <div style="height: 300px">
                                <canvas id="statusPenelitianChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="mt-4 text-start small">
                                @foreach($status['penelitian']['labels'] as $index => $label)
                                    <div class="mb-3 d-flex align-items-center">
                                        <i class="fas fa-circle me-2"
                                            style="color: {{ ['#22c55e', '#f59e0b', '#ef4444', '#0ea5e9', '#8b5cf6'][$index % 5] }}"></i>
                                        <span class="text-capitalize">{{ $label }}</span>
                                        <span class="fw-bold ms-auto">{{ $status['penelitian']['data'][$index] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Submissions -->
        <div class="col-xl-6 col-lg-6 d-flex align-items-stretch">
            <div class="modern-card mb-4 fade-in-up w-100">
                <div class="modern-card-header d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fa fa-clock me-2"></i>Pengajuan Terbaru (Latest)
                    </h6>
                </div>
                <div class="modern-card-body p-0" style="min-height: 340px; height: 100%;">
                    <div class="table-responsive h-100">
                        <table class="table modern-table mb-0 align-middle h-100">
                            <thead>
                                <tr>
                                    <th>Jenis</th>
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latestSubmissions as $it)
                                    <tr>
                                        <td>
                                            @if($it->type == 'Penelitian')
                                                <span class="badge bg-primary rounded-pill">Penelitian</span>
                                            @else
                                                <span class="badge bg-warning rounded-pill">Pengabdian</span>
                                            @endif
                                        </td>
                                        <td class="text-truncate" style="max-width: 200px" title="{{ $it->judul }}">
                                            {{ $it->judul }}</td>
                                        <td>
                                            @php
                                                $statusColor = 'secondary';
                                                if (in_array($it->status, ['submitted', 'buka_review']))
                                                    $statusColor = 'info';
                                                if (in_array($it->status, ['disetujui', 'selesai']))
                                                    $statusColor = 'success';
                                                if (in_array($it->status, ['ditolak']))
                                                    $statusColor = 'danger';
                                                if (in_array($it->status, ['revisi']))
                                                    $statusColor = 'warning';
                                            @endphp
                                            <span
                                                class="badge bg-{{ $statusColor }} rounded-pill">{{ ucfirst($it->status ?? 'unknown') }}</span>
                                        </td>
                                        <td class="small text-muted">{{ $it->created_at->format('d/m/y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script src="{{ asset('js/chart.min.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const months = @json($months);
                const penelitian = @json($series['penelitian']);
                const pengabdian = @json($series['pengabdian']);
                const pieLabels = @json($skema['labels']);
                const pieData = @json($skema['data']);
                const statusLabels = @json($status['penelitian']['labels'] ?? []);
                const statusData = @json($status['penelitian']['data'] ?? []);

                const areaCtx = document.getElementById('adminAreaChart').getContext('2d');
                new Chart(areaCtx, {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [
                            {
                                label: 'Penelitian',
                                data: penelitian,
                                borderColor: '#7c3aed',
                                backgroundColor: 'rgba(124,58,237,0.12)',
                                tension: 0.35,
                                fill: true,
                            },
                            {
                                label: 'Pengabdian',
                                data: pengabdian,
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16,185,129,0.12)',
                                tension: 0.35,
                                fill: true,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'top' } },
                        interaction: { mode: 'index', intersect: false },
                        scales: {
                            y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.06)' } },
                            x: { grid: { display: false } }
                        }
                    }
                });

                const pieCtx = document.getElementById('adminPieChart').getContext('2d');
                new Chart(pieCtx, {
                    type: 'doughnut',
                    data: {
                        labels: pieLabels,
                        datasets: [{
                            data: pieData,
                            backgroundColor: ['#7c3aed', '#8b5cf6', '#10b981', '#06b6d4', '#f59e0b'],
                            borderWidth: 0,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '60%',
                        plugins: { legend: { position: 'bottom' } }
                    }
                });

                const statusCtx = document.getElementById('statusPenelitianChart').getContext('2d');
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: statusLabels,
                        datasets: [{
                            data: statusData,
                            backgroundColor: ['#22c55e', '#f59e0b', '#ef4444', '#0ea5e9', '#8b5cf6'],
                            borderWidth: 0,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '55%',
                        plugins: { legend: { position: 'bottom' } }
                    }
                });
            });
        </script>
    </x-slot>
</x-admin-layout>