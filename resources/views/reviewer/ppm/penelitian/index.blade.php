<x-reviewer-layout>
    <x-slot name="header">
        {{ __('Penelitian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-12">
                <h3>Proposal Penelitian</h3>

                @if ($currentDate < $timeline->review_start_date)
                    <div class="alert alert-warning">
                        Review period will start in <span id="countdown"></span>.
                    </div>
                @elseif ($currentDate > $timeline->review_end_date)
                    <div class="alert alert-danger">
                        The review period has ended.
                    </div>
                @endif

                @if ($proposals->isEmpty())
                    <p>Tidak ada proposal penelitian saat ini.</p>
                @else
                <table class="table table-hover table-responsive mb-4">
                    <style>
                        .table {
                            width: 100%; /* Gunakan lebar penuh */
                            table-layout: fixed; /* Tabel fleksibel, bukan tetap */
                        }
                        .table th.judul, .table td.judul {
                            width: 30%;
                            text-align: left;
                        }
                        .table colgroup col.judul {
                            width: 35%;
                        }
                    </style>
                    
                    <colgroup>
                        <col class="judul"> 
                    </colgroup>

                    <thead class="thead-light bg-primary text-white">
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
                                <td class="judul">{{ $proposal->judul }}</td>
                                <td class="skema">{{ $proposal->skema }}</td>
                                <td>{{ $proposal->created_at->year }}</td>
                                <td>{{ $proposal->status }}</td>
                                <td>
                                    @if (in_array($proposal->id, $reviews))
                                        <a href="{{ route('penelitian-rev.editReview', $proposal->id) }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i> Edit Review</a>
                                        <a href="{{ route('penelitian-rev.view_pdf', $proposal->id) }}" class="btn btn-sm btn-outline-danger"><i class="fas fa-file-download"></i> Lihat PDF</a>
                                    @else
                                        <a href="{{ route('penelitian-rev.review', $proposal->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-file"></i> Review</a>
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

    <script>
        // Countdown Timer
        var countdownDate = new Date("{{ $timeline->review_start_date }}").getTime();
        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countdownDate - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("countdown").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown").innerHTML = "EXPIRED";
            }
        }, 1000);
    </script>
</x-reviewer-layout>