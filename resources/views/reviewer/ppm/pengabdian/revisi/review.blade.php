<x-reviewer-layout>
    <x-slot name="header">
        {{ __('Review Revisi Pengabdian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0"><i class="fa fa-clipboard me-2"></i>Peninjauan Revisi Proposal Pengabdian</h3>
                    <a href="{{ route('pengabdian-rev.revisi.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                @php
                    $hasRevisionWindow = $timeline && $timeline->revision_review_start_date && $timeline->revision_review_end_date;
                    $isWithinRevisionReview = $hasRevisionWindow && $currentDate->between($timeline->revision_review_start_date, $timeline->revision_review_end_date);
                @endphp

                @if (!$timeline)
                    <div class="modern-alert modern-alert-danger mb-3">
                        <i class="fa fa-exclamation-circle me-2"></i>Tidak ada jadwal peninjauan revisi yang aktif saat ini.
                    </div>
                @elseif (!$hasRevisionWindow)
                    <div class="modern-alert modern-alert-warning mb-3">
                        <i class="fa fa-exclamation-triangle me-2"></i>Periode peninjauan revisi belum ditentukan oleh admin.
                    </div>
                @else
                    @if ($currentDate < $timeline->revision_review_start_date)
                        <div class="modern-alert modern-alert-warning mb-3">
                            <i class="fa fa-clock me-2"></i>Periode peninjauan revisi akan dimulai pada
                            <strong>{{ $timeline->revision_review_start_date->format('d M Y H:i') }}</strong>.
                        </div>
                    @elseif($isWithinRevisionReview)
                        <div class="modern-alert modern-alert-info mb-3">
                            <i class="fa fa-info-circle me-2"></i>Periode peninjauan revisi sedang berlangsung hingga
                            <strong>{{ $timeline->revision_review_end_date->format('d M Y H:i') }}</strong>.
                        </div>
                    @else
                        <div class="modern-alert modern-alert-danger mb-3">
                            <i class="fa fa-times-circle me-2"></i>Periode peninjauan revisi telah berakhir pada
                            <strong>{{ $timeline->revision_review_end_date->format('d M Y H:i') }}</strong>.
                        </div>
                    @endif
                @endif

                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <h3>Dokumen Proposal</h3>
                        <h5 class="mb-3">"{{ $judul }}"</h5>
                        <iframe src="{{ $fileUrl }}" style="width:100%; height:700px;"></iframe>
                    </div>
                </div>

                {{-- Komentar Admin dari proses seleksi awal --}}
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <h3 class="mb-3"><i class="fa fa-comment-dots me-2"></i>Komentar Admin</h3>
                        @php
                            $adminComment = $originalProposal->admin_comment ?? null;
                        @endphp
                        @if($adminComment)
                            <p class="text-muted mb-0">{{ $adminComment }}</p>
                        @else
                            <div class="modern-alert modern-alert-info mb-0">
                                <i class="fa fa-info-circle me-2"></i>Tidak ada komentar admin yang tercatat untuk proposal ini.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Ringkasan hasil review dua reviewer sebelumnya --}}
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <h3 class="mb-3"><i class="fa fa-file-alt me-2"></i>Ringkasan Review Reviewer</h3>

                        @if(($allReviews ?? collect())->count())
                            <div class="row">
                                @foreach($allReviews as $index => $rev)
                                    <div class="col-md-6 mb-4">
                                        <div class="modern-card h-100">
                                            <div class="modern-card-body">
                                                <h5 class="mb-3">Review {{ $index + 1 }}</h5>
                                                <p class="text-muted mb-2">
                                                    <strong>Reviewer:</strong> {{ $rev->reviewer->name ?? $rev->reviewer_name ?? 'Tidak diketahui' }}
                                                </p>

                                                <div class="modern-table-container mb-3">
                                                    <table class="modern-table">
                                                        <thead>
                                                        <tr>
                                                            <th>Kriteria</th>
                                                            <th>Bobot</th>
                                                            <th>Skor</th>
                                                            <th>Nilai</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>Penguasaan materi dan keterkaitan</td>
                                                            <td>20%</td>
                                                            <td>{{ $rev->skor_1 ?? '-' }}</td>
                                                            <td>{{ $rev->skor_1 ? ($rev->skor_1 * 20) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Kesesuaian latar belakang dan tujuan</td>
                                                            <td>20%</td>
                                                            <td>{{ $rev->skor_2 ?? '-' }}</td>
                                                            <td>{{ $rev->skor_2 ? ($rev->skor_2 * 20) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Metode</td>
                                                            <td>20%</td>
                                                            <td>{{ $rev->skor_3 ?? '-' }}</td>
                                                            <td>{{ $rev->skor_3 ? ($rev->skor_3 * 20) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Peta jalan</td>
                                                            <td>10%</td>
                                                            <td>{{ $rev->skor_4 ?? '-' }}</td>
                                                            <td>{{ $rev->skor_4 ? ($rev->skor_4 * 10) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Potensi luaran</td>
                                                            <td>30%</td>
                                                            <td>{{ $rev->skor_5 ?? '-' }}</td>
                                                            <td>{{ $rev->skor_5 ? ($rev->skor_5 * 30) : '-' }}</td>
                                                        </tr>
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td class="fw-bold">Total</td>
                                                            <td class="fw-bold">100%</td>
                                                            <td class="fw-bold">
                                                                {{ ($rev->skor_1 ?? 0) + ($rev->skor_2 ?? 0) + ($rev->skor_3 ?? 0) + ($rev->skor_4 ?? 0) + ($rev->skor_5 ?? 0) }}
                                                            </td>
                                                            <td class="fw-bold">
                                                                {{ (($rev->skor_1 ?? 0) * 20) + (($rev->skor_2 ?? 0) * 20) + (($rev->skor_3 ?? 0) * 20) + (($rev->skor_4 ?? 0) * 10) + (($rev->skor_5 ?? 0) * 30) }}
                                                            </td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

                                                @if($rev->komentar)
                                                    <div class="mb-2">
                                                        <h6 class="mb-1">Komentar Reviewer</h6>
                                                        <p class="text-muted mb-0">{{ $rev->komentar }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="modern-alert modern-alert-info mb-3">
                                <i class="fa fa-info-circle me-2"></i>Belum ada data review reviewer yang tersedia.
                            </div>
                        @endif
                    </div>
                </div>

                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <h3>Informasi Proposal</h3>

                        <div class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex flex-column p-3 border rounded-3 h-100">
                                        <span class="text-muted text-uppercase small fw-semibold">Skema</span>
                                        <span class="fw-bold">{{ $proposal->skema ?? '-' }}</span>

                                        <span class="text-muted text-uppercase small fw-semibold mt-3">Luaran Wajib</span>
                                        <span class="fw-bold">{{ $proposal->luaran_wajib ?? '-' }}</span>

                                        <span class="text-muted text-uppercase small fw-semibold mt-3">Luaran Tambahan</span>
                                        <span class="fw-bold">{{ $proposal->luaran_tambahan ?? '–' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-column p-3 border rounded-3 h-100">
                                        <span class="text-muted text-uppercase small fw-semibold">Durasi</span>
                                        <span class="fw-bold">{{ $proposal->lama_penelitian ?? '-' }}</span>

                                        <span class="text-muted text-uppercase small fw-semibold mt-3">Biaya Diusulkan</span>
                                        <span class="fw-bold">Rp {{ number_format($biayaUsulan ?? 0, 0, ',', '.') }}</span>

                                        <span class="text-muted text-uppercase small fw-semibold mt-3">Status</span>
                                        <span class="fw-bold">{{ $proposal->status ?? 'Belum ditentukan' }}</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-3 border rounded-3">
                                        <span class="text-muted text-uppercase small fw-semibold d-block mb-2">Ringkasan Proposal</span>
                                        <p class="mb-0 text-muted">{{ $proposal->ringkasan_proposal ?? 'Ringkasan belum tersedia.' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="mb-0"><i class="fa fa-users me-2"></i>Tim Pelaksana</h4>
                                <span class="text-muted small">{{ $anggotaList->count() }} anggota</span>
                            </div>
                            @if ($anggotaList->count())
                                <div class="modern-table-container">
                                    <table class="modern-table">
                                        <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Peran</th>
                                            <th>Jabatan</th>
                                            <th>NIDN/NIM</th>
                                            <th>Email</th>
                                            <th>Telepon</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($anggotaList as $anggota)
                                            <tr>
                                                <td>{{ $anggota->nama ?? '-' }}</td>
                                                <td>{{ ucfirst($anggota->peran ?? '-') }}</td>
                                                <td>{{ $anggota->jabatan ?? '-' }}</td>
                                                <td>{{ $anggota->nidn ?? $anggota->nim ?? '-' }}</td>
                                                <td>{{ $anggota->email ?? '-' }}</td>
                                                <td>{{ $anggota->telepon ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="modern-alert modern-alert-info">
                                    <i class="fa fa-info-circle me-2"></i>Belum ada data anggota pelaksana.</div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="mb-0"><i class="fa fa-money-bill-wave me-2"></i>Rencana Anggaran Biaya (RAB)</h4>
                            </div>
                            @if ($rabItems->count())
                                <div class="modern-table-container">
                                    <table class="modern-table">
                                        <thead>
                                        <tr>
                                            <th>Kelompok RAB</th>
                                            <th>Komponen</th>
                                            <th>Item</th>
                                            <th>Satuan</th>
                                            <th class="text-end">Volume</th>
                                            <th class="text-end">Harga Satuan</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $totalRab = 0; @endphp
                                        @foreach ($rabItems as $rab)
                                            @php
                                                $volume = (float) ($rab->volume ?? 0);
                                                $harga = (float) ($rab->harga_satuan ?? 0);
                                                $subtotal = $volume * $harga;
                                                $totalRab += $subtotal;
                                            @endphp
                                            <tr>
                                                <td>{{ $rab->kelompok ?? '-' }}</td>
                                                <td>{{ $rab->komponen ?? '-' }}</td>
                                                <td>{{ $rab->item ?? '-' }}</td>
                                                <td>{{ $rab->satuan ?? '-' }}</td>
                                                <td class="text-end">{{ $volume ?: '-' }}</td>
                                                <td class="text-end">Rp {{ number_format($harga, 0, ',', '.') }}</td>
                                                <td class="text-end">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="6" class="text-end fw-bold">Total</td>
                                            <td class="text-end fw-bold">Rp {{ number_format($totalRab, 0, ',', '.') }}</td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @else
                                <div class="modern-alert modern-alert-info">
                                    <i class="fa fa-info-circle me-2"></i>Belum ada data RAB.</div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-reviewer-layout>


