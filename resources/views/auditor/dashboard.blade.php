<x-auditor-layout>
    <x-slot name="title">
        {{ __('Auditor Dashboard') }}
    </x-slot>

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-8">
                <x-auditor.heading name="Dashboard"></x-auditor.heading>
            </div>
            <div class="col-4 text-end">
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-download fa-sm text-white-50"></i>
                    <span class="text-white">Generate Report</span>
                </a>
            </div>
        </div>
        <br>
    
        {{-- <div class="row">
            <!-- Penelitian -->
            <div class="col-md-6 mb-3">
                <a href="{{ url('/auditor/ppm/penelitian-dos') }}" class="text-decoration-none w-100">
                    <x-auditor.dash-content-card title="Usulan Penelitian" value="{{ $jumlahPenelitian }}" color="info" class="w-100">
                        <i class="fas fa-microscope fa-2x text-gray-300"></i>
                    </x-auditor.dash-content-card>
                </a>
            </div>
        
            <!-- Pengabdian -->
            <div class="col-md-6 mb-3">
                <a href="{{ url('/auditor/ppm/pengabdian-dos') }}" class="text-decoration-none w-100">
                    <x-auditor.dash-content-card title="Usulan Pengabdian" value="{{ $jumlahPengabdian }}" color="warning" class="w-100">
                        <i class="fas fa-lightbulb fa-2x text-gray-300"></i>
                    </x-auditor.dash-content-card>
                </a>
            </div>
        </div> --}}
        
        
        <div class="card shadow mb-4">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
    
    
    <!-- FullCalendar JS and CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                initialDate: new Date(), // set to current month
                headerToolbar: {
                    start: 'prev',
                    center: 'title',
                    end: 'next'
                },
                events: [
                    {
                        title: 'Penelitian',
                        start: '2024-06-06',
                        color: '#d3c9f2'
                    },
                    {
                        title: 'Sosialisasi',
                        start: '2024-06-16',
                        color: '#f2d3d3'
                    },
                    {
                        title: 'Pengumuman',
                        start: '2024-06-24',
                        color: '#d3f2d9'
                    },
                    {
                        title: 'Upload Proposal',
                        start: '2024-06-28',
                        color: '#f2e3d3'
                    }
                ]
            });
            calendar.render();
        });

        function showAgenda(type) {
            let title = type === 'Penelitian' ? 'Agenda Penelitian' : 'Agenda Pengabdian';
            let content = type === 'Penelitian' ? 'List of Penelitian activities...' : 'List of Pengabdian activities...';

            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalContent').innerText = content;
            new bootstrap.Modal(document.getElementById('agendaModal')).show();
        }
    </script>

    <!-- Modal for Agendas -->
    <div class="modal fade" id="agendaModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Agenda Title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="modalContent">Agenda content...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .mb-2 {
            margin-bottom: -1rem !important;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }
    </style>

</x-auditor-layout>
