<x-reviewer-layout>
    <x-slot name="header">
        {{ __('Pengabdian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3 fade-in-up">
                    <h3 class="mb-3"><i class="fa fa-hands-helping me-2"></i>Proposal Pengabdian</h3>
                        @if (!$timeline)
                            <div class="modern-alert modern-alert-danger">
                                <i class="fa fa-exclamation-circle me-2"></i>Tidak ada jadwal review.
                            </div>
                        @elseif ($currentDate < $timeline->review_start_date)
                            <div class="modern-alert modern-alert-warning">
                                <i class="fa fa-clock me-2"></i>Review period will start in <span id="countdown"></span>.
                            </div>
                            <script>
                                var countdownDate = new Date("{{ $timeline->review_start_date }}").getTime();
                            </script>
                        @elseif ($currentDate > $timeline->review_end_date)
                            <div class="modern-alert modern-alert-danger">
                                <i class="fa fa-times-circle me-2"></i>The review period has ended.
                            </div>
                        @else
                            <div class="modern-alert modern-alert-info">
                                <i class="fa fa-info-circle me-2"></i>Review period is open. It will close in <span id="countdown"></span>.
                            </div>
                            <script>
                                var countdownDate = new Date("{{ $timeline->review_end_date }}").getTime();
                            </script>
                        @endif
                        
                        @if ($proposals->isEmpty())
                            <div class="modern-alert modern-alert-info">
                                <i class="fa fa-info-circle me-2"></i>Tidak ada proposal pengabdian saat ini.
                            </div>
                        @else
                        <div class="modern-table-container mb-4">
                        <table class="modern-table">
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

                            <thead>
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
                                        $isReviewedByAnother = $existingReviews->where('pengabdian_id', $proposal->id)->where('reviewer_id', '!=', auth()->id())->count() > 0;
                                    @endphp
                                    <tr>
                                        <td class="judul"><div class="fw-bold">{{ $proposal->judul }}</div></td>
                                        <td class="skema">
                                            <span class="status-badge skema">{{ $proposal->skema }}</span>
                                        </td>
                                        <td>{{ $proposal->created_at->year }}</td>
                                        <td>
                                            <span class="status-badge
                                                @if ($proposal->status === 'Pending') pending
                                                @elseif ($proposal->status === 'Diproses') diproses
                                                @elseif ($proposal->status === 'Selesai') selesai
                                                @endif">
                                                {{ $proposal->status }}
                                            </span>
                                        </td>
                                        <td>
                                            @php($inWindow = $timeline && $currentDate >= $timeline->review_start_date && $currentDate <= $timeline->review_end_date)
                                            <div class="d-flex gap-2">
                                            @if (in_array($proposal->id, $reviews))
                                                <a href="{{ route('pengabdian-rev.editReview', $proposal->id) }}" class="modern-btn modern-btn-warning modern-btn-sm @if(!$inWindow) disabled @endif" @if(!$inWindow) aria-disabled="true" tabindex="-1" @endif><i class="fa fa-edit me-1"></i> Edit Review</a>
                                                <a href="{{ route('pengabdian-rev.view_pdf', $proposal->id) }}" class="modern-btn modern-btn-danger modern-btn-sm"><i class="fa fa-file-download me-1"></i> Lihat PDF</a>
                                            {{-- @elseif ($isReviewedByAnother)
                                                <button class="btn btn-secondary" disabled>Telah Ditinjau</button> --}}
                                            @else
                                                <a href="{{ route('pengabdian-rev.review', $proposal->id) }}" class="modern-btn modern-btn-primary modern-btn-sm @if(!$inWindow) disabled @endif" @if(!$inWindow) aria-disabled="true" tabindex="-1" @endif><i class="fa fa-file me-1"></i> Review</a>
                                            @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                </div>                
                @endif
            </div>
        </div>
    </div>
</x-reviewer-layout>
<script>
    // Countdown Timer (uses countdownDate set in the alert block above)
    if (typeof countdownDate !== 'undefined') {
        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countdownDate - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            var el = document.getElementById('countdown');
            if (el) {
                el.innerHTML = days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's ';
            }

            if (distance < 0) {
                clearInterval(x);
                if (el) {
                    el.innerHTML = 'EXPIRED';
                }
            }
        }, 1000);
    }
</script>
