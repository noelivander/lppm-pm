<x-admin-layout>
    <div class="container mt-5">
        <h1 class="fw-bold">✏️ Edit Timeline</h1>

        <div class="card shadow-lg p-4">
            <form action="{{ route('admin.timeline.update', $timeline->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">📅 Upload Start</label>
                    <input type="datetime-local" name="upload_start_date" class="form-control" required
                           value="{{ date('Y-m-d\TH:i', strtotime($timeline->upload_start_date)) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">⏳ Upload End</label>
                    <input type="datetime-local" name="upload_end_date" class="form-control" required
                           value="{{ date('Y-m-d\TH:i', strtotime($timeline->upload_end_date)) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">📝 Review Start</label>
                    <input type="datetime-local" name="review_start_date" class="form-control" required
                           value="{{ date('Y-m-d\TH:i', strtotime($timeline->review_start_date)) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">✅ Review End</label>
                    <input type="datetime-local" name="review_end_date" class="form-control" required
                           value="{{ date('Y-m-d\TH:i', strtotime($timeline->review_end_date)) }}">
                </div>

                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Changes</button>
                <a href="{{ route('admin.timeline.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
            </form>
        </div>
    </div>
</x-admin-layout>
