<x-dosen-layout>
    <x-slot name="title">
        {{ __('Dosen Dashboard') }}
    </x-slot>

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-8">
                <x-dosen.heading name="Dashboard"></x-dosen.heading>
            </div>
            <div class="col-4 text-end">
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-download fa-sm text-white-50"></i>
                    <span class="text-white">Generate Report</span>
                </a>
            </div>
        </div>

        <div class="row mb-3 text-center">
            <div class="col-md-6">
                <a href="{{ url('/dosen/ppm/penelitian-dos') }}" class="dashboard-btn teal d-flex align-items-center justify-content-center w-100">
                    <span class="dashboard-icon"><i class="fas fa-microscope"></i></span>
                    <span class="dashboard-text">Usulan Penelitian</span>
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ url('/dosen/ppm/pengabdian-dos') }}" class="dashboard-btn yellow d-flex align-items-center justify-content-center w-100">
                    <span class="dashboard-icon"><i class="fas fa-lightbulb"></i></span>
                    <span class="dashboard-text">Usulan Pengabdian</span>
                </a>
            </div>
        </div>
        

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

</x-dosen-layout>
