<x-reviewer-layout>
    <x-slot name="header">
        {{ __('Review Penelitian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row mt-3">
            <div class="col-md-12">
                <h3>Review Proposal Penelitian: {{ $proposal->judul }}</h3>
                <iframe src="{{ Storage::url($proposal->dokumen_proposal) }}" style="width:100%; height:700px;"></iframe>
                
                <form method="POST" action="{{ route('penelitian-rev.submitReview', $proposal->id) }}">
                    @csrf
                    <br>
                    <div class="row">
                        <div class="col-md-6"> <!-- Kolom kiri -->
                            <div class="form-group">
                                <label for="reviewer_name">Nama Reviewer:</label>
                                <input type="text" class="form-control" id="reviewer_name" name="reviewer_name" required value="{{ Auth::user()->name }}" readonly>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="title">Judul Proposal:</label>
                                <input type="text" class="form-control" id="title" name="title" required value="{{ $proposal->judul }}" readonly>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="background">Latar Belakang:</label>
                                <textarea class="form-control" id="background" name="background" rows="3" required></textarea>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="research_objective">Tujuan Penelitian:</label>
                                <textarea class="form-control" id="research_objective" name="research_objective" rows="3" required></textarea>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="methodology">Metode Penelitian:</label>
                                <textarea class="form-control" id="methodology" name="methodology" rows="3" required></textarea>
                            </div>
                            <br>
                        </div>
                        <div class="col-md-6"> <!-- Kolom kanan -->
                            <div class="form-group">
                                <label for="results">Hasil Penelitian:</label>
                                <textarea class="form-control" id="results" name="results" rows="3" required></textarea>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="strengths">Kelebihan Penelitian:</label>
                                <textarea class="form-control" id="strengths" name="strengths" rows="3" required></textarea>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="weaknesses">Kekurangan Penelitian:</label>
                                <textarea class="form-control" id="weaknesses" name="weaknesses" rows="3" required></textarea>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="discussion">Diskusi/Rekomendasi:</label>
                                <textarea class="form-control" id="discussion" name="discussion" rows="4" required></textarea>
                            </div>
                            <br>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-3" id="submitProposal">Submit Review</button>
                </form>
            </div>
        </div>
    </div>
</x-reviewer-layout>
