<x-admin-layout>
    <x-slot name="title">
        {{ __('Dashboard') }}
    </x-slot>

    <x-admin.heading name="Dashboard">
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> <span class="text-white">Generate Report</span></a>
    </x-admin.heading>

    <div class="row">
        <x-admin.dash-content-card title="Program Studi" value="3" color="primary">
            <i class="fas fa-calendar fa-2x text-gray-300"></i>
        </x-admin.dash-content-card>
        <x-admin.dash-content-card title="Program Studi" value="3" color="success">
            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
        </x-admin.dash-content-card>
        <x-admin.dash-content-card title="Program Studi" value="3" color="info">
            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
        </x-admin.dash-content-card>
        <x-admin.dash-content-card title="Program Studi" value="3" color="warning">
            <i class="fas fa-comments fa-2x text-gray-300"></i>
        </x-admin.dash-content-card>
    </div>

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Tahunan Penelitian</h6>
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
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Hibah</h6>
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
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Kementerian
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Internal
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Lainnya
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">

        <script type="text/javascript" src="{{ asset('storage/demo/chart-area-demo.js') }}"></script>
        <script type="text/javascript" src="{{ asset('storage/demo/chart-pie-demo.js') }}"></script>
    </x-slot>
</x-admin-layout>
