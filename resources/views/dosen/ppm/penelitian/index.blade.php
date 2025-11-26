<x-dosen-layout>
    <x-slot name="header">
        {{ __('Penelitian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3 fade-in-up">
                    <h3 class="mb-3">
                        <i class="fa fa-flask me-2"></i>Proposal Penelitian
                    </h3>
                        @if (!$timeline)
                            <div class="modern-alert modern-alert-danger"><i class="fa fa-exclamation-circle me-2"></i>No upload schedule available. You cannot upload a proposal.</div>
                        @else
                            @if ($currentDate < $timeline->upload_start_date)
                                <div class="modern-alert modern-alert-warning"><i class="fa fa-clock me-2"></i>Upload period will start in <span id="countdown"></span>.</div>
                                <script>
                                    var countdownDate = new Date("{{ $timeline->upload_start_date }}").getTime();
                                </script>
                            @elseif ($currentDate >= $timeline->upload_start_date && $currentDate <= $timeline->upload_end_date)
                                <div class="modern-alert modern-alert-info"><i class="fa fa-info-circle me-2"></i>Upload period is open. It will close in <span id="countdown"></span>.</div>
                                <script>
                                    var countdownDate = new Date("{{ $timeline->upload_end_date }}").getTime();
                                </script>
                            @else
                                <div class="modern-alert modern-alert-danger"><i class="fa fa-times-circle me-2"></i>The upload period has ended.</div>
                            @endif
                        @endif
                        @if ($penelitian->isEmpty())
                            <div class="modern-alert modern-alert-info">
                                <i class="fa fa-info-circle me-2"></i>Belum ada proposal penelitian.
                            </div>
                        @else
                        <div class="modern-table-container mb-3">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Judul</th>
                                        <th>Skema</th>
                                        <th>Tahun</th>
                                        <th>Status</th>
                                        <th>Dokumen Proposal</th>
                                        <th>Dokumen Review</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penelitian as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="fw-bold">{{ $item->judul }}</div>
                                            </td>
                                            <td>
                                                <span class="status-badge skema">{{ $item->skema }}</span>
                                            </td>
                                            <td>{{ $item->created_at->year }}</td>
                                            <td>
                                                <span class="status-badge
                                                    @if ($item->status === 'Pending') pending
                                                    @elseif ($item->status === 'Diproses') diproses
                                                    @elseif ($item->status === 'Selesai') selesai
                                                    @endif">
                                                    {{ $item->status }}
                                                </span>
                                            </td>
                                            
                                            <td>
                                                @if ($item->dokumen_proposal)
                                                    <a href="{{ route('penelitian.downloadProposal', $item->id) }}" class="modern-btn modern-btn-primary modern-btn-sm">
                                                        <i class="fas fa-file-download me-1"></i> Download PDF
                                                    </a>
                                                @else
                                                    <span class="text-muted">Tidak ada file</span>
                                                @endif
                                            </td>
                                            
                                            <td>
                                                <a class="modern-btn modern-btn-secondary modern-btn-sm" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $item->id }}">
                                                    <i class="fas fa-search me-1"></i> Hasil Review
                                                </a>
                                            </td>

                                        <!-- Modal untuk Review -->
                                        <div class="modal fade" id="reviewModal{{ $item->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content modern-card">
                                                    <div class="modal-header modern-card-header">
                                                        <h5 class="modal-title mb-0">
                                                            <i class="fa fa-search me-2"></i>Hasil Review Penelitian
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body modern-card-body">
                                                        @php
                                                            $reviews = \App\Models\Review::where('penelitian_id', $item->id)->get();
                                                        @endphp

                                                        @if ($reviews->count() > 0)
                                                            <div class="row">
                                                                @foreach ($reviews as $index => $review)
                                                                    <div class="col-md-6 mb-3">
                                                                        <div class="modern-card">
                                                                            <div class="modern-card-body text-center">
                                                                                <i class="fa fa-file-alt fa-3x text-primary mb-3"></i>
                                                                                <h6 class="mb-2">Review {{ $index + 1 }}</h6>
                                                                                <p class="text-muted small mb-3">Klik untuk melihat detail review</p>
                                                                                <a href="{{ route('penelitian-dos.view-reviews', ['penelitian_id' => $item->id, 'review_number' => $index + 1]) }}" 
                                                                                   class="modern-btn modern-btn-primary">
                                                                                    <i class="fa fa-eye me-1"></i> Lihat Review
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <div class="text-center py-4">
                                                                <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                                                <h6 class="text-muted">Review belum tersedia</h6>
                                                                <p class="text-muted">Review akan muncul setelah proposal direview oleh reviewer</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer modern-card-footer">
                                                        <button type="button" class="modern-btn modern-btn-secondary" data-bs-dismiss="modal">
                                                            <i class="fa fa-times me-1"></i> Tutup
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @endif

                        @php($uploadOpen = $timeline && $currentDate >= $timeline->upload_start_date && $currentDate <= $timeline->upload_end_date)
                        @if($uploadOpen)
                            <a href="{{ route('penelitian-dos.create') }}" class="modern-btn modern-btn-primary mt-2">
                                <i class="fa fa-plus me-2"></i> Tambah Usulan Baru
                            </a>
                        @else
                            <button class="modern-btn modern-btn-primary mt-2" disabled>
                            <i class="fa fa-plus me-2"></i> Tambah Usulan Baru
                        </button>
                        @endif
                </div>
            </div>
        </div>
    </div>

    <script>
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
                    el.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
                }

            if (distance < 0) {
                clearInterval(x);
                    if (el) {
                        el.innerHTML = "EXPIRED";
                    }
            }
        }, 1000);
        }
    </script>
    
</x-dosen-layout>
