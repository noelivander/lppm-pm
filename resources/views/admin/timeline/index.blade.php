<x-admin-layout>
    <x-slot name="header">
        {{ __('Timeline Management') }}
    </x-slot>

    <x-admin.heading name="Timeline Management">
        <a href="{{ route('timeline.create') }}" class="modern-btn modern-btn-primary">
            <i class="fa fa-plus me-1"></i> Buat Baru
        </a>
    </x-admin.heading>

    @if (session('success'))
        <div class="modern-alert modern-alert-success mb-3 fade-in-up">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if($timelines->isEmpty())
        <div class="row">
            <div class="col-lg-12">
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body text-center py-5">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted mb-2">Belum Ada Timeline</h5>
                        <p class="text-muted mb-4">Buat timeline pertama Anda untuk memulai.</p>
                        <a href="{{ route('timeline.create') }}" class="modern-btn modern-btn-primary">
                            <i class="fa fa-plus me-1"></i> Buat Timeline
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-12">
                <div class="modern-table-container mb-4 fade-in-up">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Periode</th>
                                <th>Judul</th>
                                <th>Upload Proposal</th>
                                <th>Review Proposal</th>
                                <th>Revisi Proposal</th>
                                <th>Laporan Kemajuan</th>
                                <th>Laporan Akhir</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($timelines as $key => $timeline)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <span class="status-badge kode">{{ $timeline->period ?? '-' }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold mb-1">{{ $timeline->title ?? 'Timeline' }}</div>
                                    @if($timeline->description)
                                    <div class="text-muted small">
                                        {{ Str::limit($timeline->description, 50) }}
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="small">
                                        <div class="fw-bold text-primary">Start:</div>
                                        <div>{{ \Carbon\Carbon::parse($timeline->upload_start_date)->format('d M Y') }}</div>
                                        <div class="text-muted">{{ \Carbon\Carbon::parse($timeline->upload_start_date)->format('H:i') }}</div>
                                        <div class="fw-bold text-primary mt-2">End:</div>
                                        <div>{{ \Carbon\Carbon::parse($timeline->upload_end_date)->format('d M Y') }}</div>
                                        <div class="text-muted">{{ \Carbon\Carbon::parse($timeline->upload_end_date)->format('H:i') }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small">
                                        <div class="fw-bold text-primary">Start:</div>
                                        <div>{{ \Carbon\Carbon::parse($timeline->review_start_date)->format('d M Y') }}</div>
                                        <div class="text-muted">{{ \Carbon\Carbon::parse($timeline->review_start_date)->format('H:i') }}</div>
                                        <div class="fw-bold text-primary mt-2">End:</div>
                                        <div>{{ \Carbon\Carbon::parse($timeline->review_end_date)->format('d M Y') }}</div>
                                        <div class="text-muted">{{ \Carbon\Carbon::parse($timeline->review_end_date)->format('H:i') }}</div>
                                    </div>
                                </td>
                                <td>
                                    @if($timeline->revision_start_date && $timeline->revision_end_date)
                                    <div class="small">
                                        <div class="fw-bold text-primary">Start:</div>
                                        <div>{{ \Carbon\Carbon::parse($timeline->revision_start_date)->format('d M Y') }}</div>
                                        <div class="text-muted">{{ \Carbon\Carbon::parse($timeline->revision_start_date)->format('H:i') }}</div>
                                        <div class="fw-bold text-primary mt-2">End:</div>
                                        <div>{{ \Carbon\Carbon::parse($timeline->revision_end_date)->format('d M Y') }}</div>
                                        <div class="text-muted">{{ \Carbon\Carbon::parse($timeline->revision_end_date)->format('H:i') }}</div>
                                    </div>
                                    @else
                                    <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($timeline->progress_submission_start_date && $timeline->progress_submission_end_date)
                                    <div class="small">
                                        <div class="fw-bold text-success">Pengajuan:</div>
                                        <div>{{ \Carbon\Carbon::parse($timeline->progress_submission_start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($timeline->progress_submission_end_date)->format('d M Y') }}</div>
                                        @if($timeline->progress_review_start_date && $timeline->progress_review_end_date)
                                        <div class="fw-bold text-warning mt-2">Peninjauan:</div>
                                        <div>{{ \Carbon\Carbon::parse($timeline->progress_review_start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($timeline->progress_review_end_date)->format('d M Y') }}</div>
                                        @endif
                                    </div>
                                    @else
                                    <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($timeline->final_submission_start_date && $timeline->final_submission_end_date)
                                    <div class="small">
                                        <div class="fw-bold text-success">Pengajuan:</div>
                                        <div>{{ \Carbon\Carbon::parse($timeline->final_submission_start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($timeline->final_submission_end_date)->format('d M Y') }}</div>
                                        @if($timeline->final_review_start_date && $timeline->final_review_end_date)
                                        <div class="fw-bold text-warning mt-2">Peninjauan:</div>
                                        <div>{{ \Carbon\Carbon::parse($timeline->final_review_start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($timeline->final_review_end_date)->format('d M Y') }}</div>
                                        @endif
                                    </div>
                                    @else
                                    <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($timeline->is_active)
                                        <span class="status-badge selesai">
                                            <i class="fa fa-check-circle me-1"></i> Active
                                        </span>
                                    @else
                                        <span class="status-badge pending">
                                            <i class="fa fa-times-circle me-1"></i> Inactive
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('timeline.edit', $timeline->id) }}" class="modern-btn modern-btn-warning modern-btn-sm">
                                            <i class="fa fa-edit me-1"></i> Ubah
                                        </a>
                                        <button type="button" class="modern-btn modern-btn-danger modern-btn-sm show_confirm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteTimeline" 
                                                data-id-timeline="{{ $timeline->id }}" 
                                                data-title-timeline="{{ $timeline->title ?? 'Timeline' }}">
                                            <i class="fa fa-trash me-1"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <x-slot name="modals">
        <div class="modal fade modern-modal" id="deleteTimeline" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">
                            <i class="fa fa-exclamation-triangle text-warning me-2"></i>
                            Hapus Timeline
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="#">
                        @method('DELETE')
                        @csrf
                        <div class="modal-body">
                            <div class="modern-alert modern-alert-warning">
                                <i class="fa fa-warning me-2"></i>
                                Apakah Anda yakin ingin menghapus timeline <strong class="text-primary"></strong>?
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="modern-btn modern-btn-secondary modern-btn-sm" data-bs-dismiss="modal">
                                <i class="fa fa-times me-1"></i> Batalkan
                            </button>
                            <button type="submit" class="modern-btn modern-btn-danger modern-btn-sm">
                                <i class="fa fa-trash me-1"></i> Hapus
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
    
    <x-slot name="scripts">
        <script type="text/javascript">
            var deleteTimelineModal = document.getElementById('deleteTimeline')
            deleteTimelineModal.addEventListener('show.bs.modal', function (event) {
                // Button that triggered the modal
                var button = event.relatedTarget
                // Extract info from data-bs-* attributes
                var id = button.getAttribute('data-id-timeline')
                var title = button.getAttribute('data-title-timeline')

                var modalBodyInput = deleteTimelineModal.querySelector('.modal-body strong')
                var modalForm = deleteTimelineModal.querySelector('form')

                modalBodyInput.textContent = title
                modalForm.action = "{{ route('timeline.index') }}/" + id
            })
        </script>
    </x-slot>
</x-admin-layout>
