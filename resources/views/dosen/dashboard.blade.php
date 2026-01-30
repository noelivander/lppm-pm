<x-dosen-layout>
    <x-slot name="title">
        {{ __('Dosen Dashboard') }}
    </x-slot>

    <div class="container-fluid dashboard-page">
        {{-- Header Section --}}
        <div class="row mb-3 align-items-center">
            <div class="col-md-8">
                <x-dosen.heading name="Dashboard"></x-dosen.heading>
                <p class="text-muted small mb-0">Selamat datang kembali, pantau aktivitas penelitian dan pengabdian
                    Anda.</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="d-inline-flex align-items-center bg-white rounded-pill px-3 py-2 shadow-sm border">
                    <i class="fa fa-calendar-alt text-primary me-2"></i>
                    <span class="small fw-bold">{{ now()->format('d F Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Action Items (Alerts) --}}
        @if($usulanPerluRevisi > 0 || $laporanPending > 0)
            <div class="row mb-4">
                @if($usulanPerluRevisi > 0)
                    <div class="col-md-6 mb-2">
                        <div class="modern-alert modern-alert-danger d-flex align-items-center shadow-sm border-0">
                            <div class="alert-icon-box bg-danger-subtle text-danger me-3 rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 48px; height: 48px;">
                                <i class="fa fa-exclamation-triangle fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Perhatian Diperlukan</h6>
                                <p class="mb-0 small">Anda memiliki <strong>{{ $usulanPerluRevisi }}</strong> proposal yang
                                    perlu direvisi.</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($laporanPending > 0)
                    <div class="col-md-6 mb-2">
                        <div class="modern-alert modern-alert-warning d-flex align-items-center shadow-sm border-0">
                            <div class="alert-icon-box bg-warning-subtle text-warning me-3 rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 48px; height: 48px;">
                                <i class="fa fa-file-invoice fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Laporan Belum Diunggah</h6>
                                <p class="mb-0 small">Ada <strong>{{ $laporanPending }}</strong> kegiatan aktif yang belum
                                    melengkapi laporan (Monev/Akhir).</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        {{-- Stats Cards --}}
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <a href="{{ url('/dosen/ppm/penelitian-dos') }}" class="text-decoration-none w-100">
                    <div class="modern-card stat-card bg-info-subtle border-0 h-100">
                        <div class="modern-card-body d-flex align-items-center">
                            <div class="stat-icon bg-white text-info rounded-circle shadow-sm d-flex align-items-center justify-content-center me-3"
                                style="width: 60px; height: 60px;">
                                <i class="fas fa-microscope fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted text-uppercase small fw-bold mb-1">Penelitian</h6>
                                <h2 class="mb-0 fw-bold text-info">{{ $jumlahPenelitian }}</h2>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4 mb-3">
                <a href="{{ url('/dosen/ppm/pengabdian-dos') }}" class="text-decoration-none w-100">
                    <div class="modern-card stat-card bg-warning-subtle border-0 h-100">
                        <div class="modern-card-body d-flex align-items-center">
                            <div class="stat-icon bg-white text-warning rounded-circle shadow-sm d-flex align-items-center justify-content-center me-3"
                                style="width: 60px; height: 60px;">
                                <i class="fas fa-lightbulb fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted text-uppercase small fw-bold mb-1">Pengabdian</h6>
                                <h2 class="mb-0 fw-bold text-warning">{{ $jumlahPengabdian }}</h2>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Card 3: Total Dana Disetujui (Linked) --}}
            <div class="col-md-4 mb-4">
                <a href="{{ route('dosen.riwayat-pendanaan') }}" class="text-decoration-none">
                    <div class="modern-card shadow-sm h-100 animate-hover-up">
                        <div class="modern-card-body d-flex align-items-center p-4">
                            <div class="icon-circle bg-success-subtle text-success me-4">
                                <i class="fa fa-coins fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted text-uppercase fw-bold small mb-1">Total Dana Disetujui</h6>
                                <h3 class="mb-0 fw-bold text-dark counter-currency">
                                    Rp {{ number_format($fundingHistory['total'] ?? 0, 0, ',', '.') }}
                                </h3>
                                <small class="text-success"><i class="fa fa-arrow-right me-1"></i>Lihat Detil</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row">
             {{-- Funding History Chart --}}
             <div class="col-lg-7 mb-4">
                <div class="modern-card shadow-sm h-100">
                     <div class="modern-card-header bg-white border-0 pt-4 px-4 pb-0">
                         <h5 class="mb-0 fw-bold text-dark">
                             <i class="fa fa-chart-bar me-2 text-primary"></i>Riwayat Pendanaan
                         </h5>
                     </div>
                     <div class="modern-card-body p-4">
                         <div style="height: 300px;">
                             <canvas id="fundingChart"></canvas>
                         </div>
                     </div>
                </div>
            </div>

            {{-- Linear Timeline Stepper --}}
            <div class="col-lg-5 mb-4">
                <div class="modern-card shadow-sm h-100">
                    <div class="modern-card-header bg-gradient-primary text-white border-0 pt-3 px-3 pb-3"> 
                        <h5 class="mb-0 text-white"> 
                            <i class="fa fa-calendar-check me-2"></i>Timeline Kegiatan
                        </h5>
                    </div>
                    <div class="modern-card-body p-3">
                        @if($timelineActive)
                             <div class="d-flex justify-content-between align-items-center mb-4">
                                 <div class="small">
                                     <strong>Periode:</strong> {{ $timelineActive->title }} ({{ $timelineActive->period }})
                                 </div>
                                 <span class="badge bg-{{ $currentStageColor }}">{{ $currentStage }}</span>
                             </div>
                             
                             {{-- Stepper UI --}}
                             <div class="timeline-stepper">
                                 @php
                                     $now = now();
                                     $phases = [
                                         [
                                             'label' => 'Upload Proposal', 
                                             'start' => $timelineActive->upload_start_date, 
                                             'end' => $timelineActive->upload_end_date
                                         ],
                                         [
                                             'label' => 'Review Proposal', 
                                             'start' => $timelineActive->review_start_date, 
                                             'end' => $timelineActive->review_end_date
                                         ],
                                         [
                                             'label' => 'Penyetujuan Admin', 
                                             'start' => $timelineActive->admin_decision_start_date, 
                                             'end' => $timelineActive->admin_decision_end_date
                                         ],
                                         [
                                             'label' => 'Revisi Proposal', 
                                             'start' => $timelineActive->revision_start_date, 
                                             'end' => $timelineActive->revision_end_date
                                         ],
                                         [
                                             'label' => 'Laporan Kemajuan', 
                                             'start' => $timelineActive->progress_submission_start_date, 
                                             'end' => $timelineActive->progress_submission_end_date
                                         ],
                                         [
                                             'label' => 'Laporan Akhir', 
                                             'start' => $timelineActive->final_submission_start_date, 
                                             'end' => $timelineActive->final_submission_end_date
                                         ],
                                     ];
                                 @endphp

                                 @foreach($phases as $index => $phase)
                                     @php
                                         $isActive = $phase['start'] && $phase['end'] && $now->between($phase['start'], $phase['end']);
                                         $isPast = $phase['end'] && $now->gt($phase['end']);
                                         $statusClass = $isActive ? 'active' : ($isPast ? 'completed' : 'pending');
                                         $icon = $isActive ? 'fa-spinner fa-spin' : ($isPast ? 'fa-check' : 'fa-circle');
                                         $textClass = $isActive ? 'text-primary fw-bold' : ($isPast ? 'text-success' : 'text-muted');
                                     @endphp
                                     
                                     <div class="stepper-item d-flex mb-3 position-relative {{ $loop->last ? '' : 'stepper-line' }}">
                                         <div class="stepper-marker me-3">
                                             <div class="marker-circle bg-state-{{ $statusClass }} shadow-sm d-flex align-items-center justify-content-center">
                                                 <i class="fa {{ $icon }} text-white" style="font-size: 0.7rem;"></i>
                                             </div>
                                         </div>
                                         <div class="stepper-content pb-2">
                                             <div class="{{ $textClass }} mb-0 small">{{ $phase['label'] }}</div>
                                             @if($phase['start'] && $phase['end'])
                                                <div class="text-secondary x-small">
                                                    {{ $phase['start']->format('d M') }} - {{ $phase['end']->format('d M Y') }}
                                                </div>
                                             @else
                                                <div class="text-muted x-small fst-italic">Belum dijadwalkan</div>
                                             @endif
                                         </div>
                                     </div>
                                 @endforeach
                             </div>
                             
                             <style>
                                 .stepper-line::before {
                                     content: '';
                                     position: absolute;
                                     top: 24px;
                                     left: 11px;
                                     bottom: -16px;
                                     width: 2px;
                                     background-color: #e9ecef;
                                     z-index: 0;
                                 }
                                 .marker-circle {
                                     width: 24px;
                                     height: 24px;
                                     border-radius: 50%;
                                     position: relative;
                                     z-index: 1;
                                 }
                                 .bg-state-active { background-color: #3b82f6; }
                                 .bg-state-completed { background-color: #10b981; }
                                 .bg-state-pending { background-color: #cbd5e1; }
                                 .x-small { font-size: 0.75rem; }
                             </style>

                        @else
                             <div class="text-center py-5">
                                 <img src="{{ asset('img/no-data.svg') }}" alt="No Data" style="height: 100px; opacity: 0.5;">
                                 <p class="text-muted mt-3">Tidak ada periode kegiatan yang aktif saat ini.</p>
                             </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"
    integrity="sha384-jb8JQMbMoBUzgWatfe6COACi2ljcDdZQ2OxczGA3bGNeWe+6DChMTBJemed7ZnvJ"
    crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- 1. Funding Chart ---
            const ctx = document.getElementById('fundingChart').getContext('2d');
            const fundingChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($fundingHistory['years'] ?? []) !!},
                    datasets: [{
                        label: 'Dana Disetujui (Rp)',
                        data: {!! json_encode($fundingHistory['data'] ?? []) !!},
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        borderRadius: 6,
                        barThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [2, 2] }
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
        .bg-gradient-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
    </style>
</x-dosen-layout>