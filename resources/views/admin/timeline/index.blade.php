<x-admin-layout>
    <div class="container mt-5">
        <h1 class="fw-bold text-center mb-4">📅 Timeline Management</h1>

        @if(count($timelines) == 0)
            <div class="text-center mb-4">
                <a href="{{ route('admin.timeline.create') }}" class="btn btn-primary">
                    <i class="fas fa-calendar-plus"></i> Set New Timeline
                </a>
            </div>
        @endif

        <div class="timeline-container">
            @foreach($timelines as $timeline)
            <div class="timeline-card">
                <div class="timeline-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="timeline-content">
                    <h5 class="fw-bold">Proposal Submission Period</h5>
                    <p>📆 Upload Start: <strong>{{ \Carbon\Carbon::parse($timeline->upload_start_date)->format('d M Y - H:i') }}</strong></p>
                    <p>⏳ Upload End: <strong>{{ \Carbon\Carbon::parse($timeline->upload_end_date)->format('d M Y - H:i') }}</strong></p>
                    <p>📝 Review Start: <strong>{{ \Carbon\Carbon::parse($timeline->review_start_date)->format('d M Y - H:i') }}</strong></p>
                    <p>✅ Review End: <strong>{{ \Carbon\Carbon::parse($timeline->review_end_date)->format('d M Y - H:i') }}</strong></p>

                    <div class="timeline-actions">
                        <a href="{{ route('admin.timeline.edit', $timeline->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $timeline->id }}">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function () {
                    let timelineId = this.getAttribute('data-id');
                    if (confirm("Are you sure you want to delete this timeline?")) {
                        fetch(`/admin/timeline/${timelineId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }).then(response => location.reload());
                    }
                });
            });
        });
    </script>

    <style>
        .timeline-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .timeline-card {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            position: relative;
        }

        .timeline-icon {
            width: 60px;
            height: 60px;
            background: #007bff;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            font-size: 24px;
            margin-right: 20px;
        }

        .timeline-content {
            flex-grow: 1;
        }

        .timeline-actions {
            display: flex;
            gap: 10px;
        }

        .timeline-actions .btn {
            font-size: 14px;
            padding: 5px 10px;
        }
    </style>
</x-admin-layout>
