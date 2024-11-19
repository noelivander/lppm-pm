<x-reviewer-layout>
    <x-slot name="header">
        {{ __('Pengabdian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h3>Proposal Pengabdian</h3>
                        
                        @if ($proposals->isEmpty())
                            <p>Tidak ada proposal pengabdian saat ini.</p>
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
                                        $isReviewedByAnother = $existingReviews->where('pengabdian_id', $proposal->id)->where('reviewer_id', '!=', auth()->id())->count() > 0;
                                    @endphp
                                    <tr>
                                        <td class="judul">{{ $proposal->judul }}</td>
                                        <td class="skema">{{ $proposal->skema }}</td>
                                        <td>{{ $proposal->created_at->year }}</td>
                                        <td>{{ $proposal->status }}</td>
                                        <td>
                                            @if (in_array($proposal->id, $reviews))
                                                <a href="{{ route('pengabdian-rev.editReview', $proposal->id) }}" class="btn btn-sm btn-outline-warning" target="_blank"><i class="fas fa-edit"></i> Edit Review</a>
                                            {{-- @elseif ($isReviewedByAnother)
                                                <button class="btn btn-secondary" disabled>Telah Ditinjau</button> --}}
                                            @else
                                                <a href="{{ route('pengabdian-rev.review', $proposal->id) }}" class="btn btn-sm btn-outline-primary" target="_blank"><i class="fas fa-file"></i> Review</a>
                                            @endif
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
