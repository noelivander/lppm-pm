<x-admin-layout>
    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h2 class="fw-bold text-center mb-4">📅 Set Timeline</h2>
            <form action="{{ route('admin.timeline.store') }}" method="POST" onsubmit="return validateTimeline()">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="upload_start_date" class="form-label">📆 Upload Start Date & Time</label>
                        <input type="datetime-local" name="upload_start_date" id="upload_start_date" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="upload_end_date" class="form-label">⏳ Upload End Date & Time</label>
                        <input type="datetime-local" name="upload_end_date" id="upload_end_date" class="form-control" required>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="review_start_date" class="form-label">📝 Review Start Date & Time</label>
                        <input type="datetime-local" name="review_start_date" id="review_start_date" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="review_end_date" class="form-label">✅ Review End Date & Time</label>
                        <input type="datetime-local" name="review_end_date" id="review_end_date" class="form-control" required>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Timeline</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function validateTimeline() {
            let uploadStart = new Date(document.getElementById("upload_start_date").value);
            let uploadEnd = new Date(document.getElementById("upload_end_date").value);
            let reviewStart = new Date(document.getElementById("review_start_date").value);
            let reviewEnd = new Date(document.getElementById("review_end_date").value);

            // Validasi Upload Start vs Upload End
            if (uploadEnd <= uploadStart) {
                alert("⚠ Upload End Date & Time harus lebih besar dari Upload Start Date & Time.");
                return false;
            }

            // Validasi Upload End vs Review Start
            if (reviewStart <= uploadEnd) {
                alert("⚠ Review Start Date & Time harus lebih besar dari Upload End Date & Time.");
                return false;
            }

            // Validasi Review Start vs Review End
            if (reviewEnd <= reviewStart) {
                alert("⚠ Review End Date & Time harus lebih besar dari Review Start Date & Time.");
                return false;
            }

            return true;
        }
    </script>

    <style>
        .card {
            border-radius: 10px;
            max-width: 700px;
            margin: auto;
        }
    </style>
</x-admin-layout>
