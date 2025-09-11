<x-reviewer-layout>
    <x-slot name="header">
        {{ __('Penelitian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h3>Proposal Penelitian</h3>

                        @if (!$timeline)
                            <div class="alert alert-danger">Tidak ada jadwal review.</div>
                        @elseif ($currentDate < $timeline->review_start_date)
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
                                        <td>
                                            <span class="badge
                                                @if ($proposal->status === 'Pending') bg-warning
                                                @elseif ($proposal->status === 'Diproses') bg-info
                                                @elseif ($proposal->status === 'Selesai') bg-success
                                                @endif">
                                                {{ $proposal->status }}
                                            </span>
                                        </td>
                                        <td>
                                            @php($inWindow = $timeline && $currentDate >= $timeline->review_start_date && $currentDate <= $timeline->review_end_date)
                                            @if (in_array($proposal->id, $reviews))
                                                <a href="{{ route('penelitian-rev.editReview', $proposal->id) }}" class="btn btn-sm btn-outline-warning @if(!$inWindow) disabled @endif"><i class="fas fa-edit"></i> Edit Review</a>
                                                <a href="{{ route('penelitian-rev.view_pdf', $proposal->id) }}" class="btn btn-sm btn-outline-danger"><i class="fas fa-file-download"></i> Lihat PDF</a>
                                            @else
                                                <a href="{{ route('penelitian-rev.review', $proposal->id) }}" class="btn btn-sm btn-outline-primary @if(!$inWindow) disabled @endif"><i class="fas fa-file"></i> Review</a>
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