<x-admin-layout>
    <x-slot name="title">
        {{ __('Dashboard') }}
    </x-slot>

    <x-admin.heading name="Dashboard">
        <a href="#" class="modern-btn modern-btn-primary">
            <i class="fa fa-download me-1"></i> Generate Report
        </a>
    </x-admin.heading>

    <div class="row">
        <x-admin.dash-content-card title="Program Studi" :value="$kpis['totalProdi']" color="primary">
            <i class="fas fa-university fa-2x text-gray-300"></i>
        </x-admin.dash-content-card>
        <x-admin.dash-content-card title="Total User" :value="$kpis['totalUsers']" color="success">
            <i class="fas fa-users fa-2x text-gray-300"></i>
        </x-admin.dash-content-card>
        <x-admin.dash-content-card title="Penelitian" :value="$kpis['totalPenelitian']" color="info">
            <i class="fas fa-flask fa-2x text-gray-300"></i>
        </x-admin.dash-content-card>
        <x-admin.dash-content-card title="Pengabdian" :value="$kpis['totalPengabdian']" color="warning">
            <i class="fas fa-hands-helping fa-2x text-gray-300"></i>
        </x-admin.dash-content-card>
    </div>

    

    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="modern-card mb-4 fade-in-up">
                <!-- Card Header - Dropdown -->
                <div class="modern-card-header d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fa fa-chart-line me-2"></i>Grafik Tahunan Penelitian
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="modern-card-body" style="min-height: 340px">
                    <div class="chart-area" style="height: 320px">
                        <canvas id="adminAreaChart" height="320"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="modern-card mb-4 fade-in-up">
                <!-- Card Header - Dropdown -->
                <div class="modern-card-header d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fa fa-chart-pie me-2"></i>Hibah per Skema
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="modern-card-body" style="min-height: 340px">
                    <div class="chart-pie pt-4 pb-2" style="height: 320px">
                        <canvas id="adminPieChart" height="320"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Skema
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Dominan
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Lainnya
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Status Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="modern-card mb-4 fade-in-up">
                <div class="modern-card-header d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fa fa-stream me-2"></i>Status Penelitian
                    </h6>
                </div>
                <div class="modern-card-body">
                    <div style="height: 320px">
                        <canvas id="statusPenelitianChart" height="320"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-6 col-lg-6">
            <div class="modern-card mb-4 fade-in-up">
                <div class="modern-card-header d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fa fa-clock me-2"></i>Pengajuan Terbaru
                    </h6>
                </div>
                <div class="modern-card-body" style="min-height: 340px">
                    <div class="table-responsive" style="max-height: 280px; overflow: auto;">
                        <table class="table modern-table mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>Jenis</th>
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latest['penelitian'] as $it)
                                <tr>
                                    <td><span class="badge bg-primary">Penelitian</span></td>
                                    <td class="text-truncate" style="max-width: 520px">{{ $it->judul }}</td>
                                    <td><span class="badge bg-info">{{ ucfirst($it->status ?? 'unknown') }}</span></td>
                                    <td>{{ $it->created_at->format('d M Y') }}</td>
                                </tr>
                                @endforeach
                                @foreach($latest['pengabdian'] as $it)
                                <tr>
                                    <td><span class="badge bg-success">Pengabdian</span></td>
                                    <td class="text-truncate" style="max-width: 520px">{{ $it->judul }}</td>
                                    <td><span class="badge bg-info">{{ ucfirst($it->status ?? 'unknown') }}</span></td>
                                    <td>{{ $it->created_at->format('d M Y') }}</td>
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
