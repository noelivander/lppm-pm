<x-reviewer-layout>
    <x-slot name="header">
        {{ __('Penelitian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-12">
                <h3>Penelitian</h3>
                
                @if ($proposals->isEmpty())
                    <p>Tidak ada proposal penelitian saat ini.</p>
                @else
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Judul</th>
                            <th>Skema</th>
                            <th>Tahun</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proposals as $proposal)
                            @php
                                // Cek apakah proposal ini sudah direview oleh reviewer lain
                                $isReviewedByAnother = $existingReviews->where('penelitian_id', $proposal->id)->where('reviewer_id', '!=', auth()->id())->count() > 0;
                            @endphp
                            <tr>
                                <td>{{ $proposal->judul }}</td>
                                <td>{{ $proposal->skema }}</td>
                                <td>{{ $proposal->created_at->year }}</td>
                                <td>{{ $proposal->status }}</td>
                                <td>
                                    @if (in_array($proposal->id, $reviews))
                                        <a href="{{ route('penelitian-rev.editReview', $proposal->id) }}" class="btn btn-warning">Edit Review</a>
                                    {{-- @elseif ($isReviewedByAnother)
                                        <button class="btn btn-secondary" disabled>Telah Ditinjau</button> --}}
                                    @else
                                        <a href="{{ route('penelitian-rev.review', $proposal->id) }}" class="btn btn-primary">Review</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>                
                @endif
            </div>
        </div>
    </div>
</x-reviewer-layout>
