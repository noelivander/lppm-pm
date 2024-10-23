<x-reviewer-layout>
    <x-slot name="header">
        {{ __('Edit Review Pengabdian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row mt-3">
            <div class="col-md-12">
                <h3>Edit Review Proposal Pengabdian: {{ $proposal->judul }}</h3>
                <iframe src="{{ Storage::url($proposal->dokumen_proposal) }}" style="width:100%; height:700px;"></iframe>
                <form method="POST" action="{{ route('pengabdian-rev.updateReview', $review->id) }}">
                    @csrf
                    @method('PUT')
                    <br>
                    <div class="row">
                        <div class="col-md-6"> <!-- Kolom kiri -->
                            <div class="form-group">
                                <label for="reviewer_name">Nama Reviewer:</label>
                                <input type="text" class="form-control" id="reviewer_name" name="reviewer_name" required value="{{ $review->reviewer_name }}" readonly>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="title">Judul Proposal:</label>
                                <input type="text" class="form-control" id="title" name="title" required value="{{ $proposal->judul }}" readonly>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="background">Latar Belakang:</label>
                                <textarea class="form-control" id="background" name="background" rows="3" required>{{ $review->background }}</textarea>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="research_objective">Tujuan Penelitian:</label>
                                <textarea class="form-control" id="research_objective" name="research_objective" rows="3" required>{{ $review->research_objective }}</textarea>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="methodology">Metode Penelitian:</label>
                                <textarea class="form-control" id="methodology" name="methodology" rows="3" required>{{ $review->methodology }}</textarea>
                            </div>
                            <br>
                        </div>
                        <div class="col-md-6"> <!-- Kolom kanan -->
                            <div class="form-group">
                                <label for="results">Hasil Penelitian:</label>
                                <textarea class="form-control" id="results" name="results" rows="3" required>{{ $review->results }}</textarea>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="strengths">Kelebihan Penelitian:</label>
                                <textarea class="form-control" id="strengths" name="strengths" rows="3" required>{{ $review->strengths }}</textarea>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="weaknesses">Kekurangan Penelitian:</label>
                                <textarea class="form-control" id="weaknesses" name="weaknesses" rows="3" required>{{ $review->weaknesses }}</textarea>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="discussion">Diskusi/Rekomendasi:</label>
                                <textarea class="form-control" id="discussion" name="discussion" rows="4" required>{{ $review->discussion }}</textarea>
                            </div>
                            <br>
                        </div>
                    </div>
                    <!-- Form fields for editing review -->
                    <button type="submit" class="btn btn-primary mt-3" id="updateReview">Update Review</button>
                </form>
            </div>
        </div>
    </div>
</x-reviewer-layout>
