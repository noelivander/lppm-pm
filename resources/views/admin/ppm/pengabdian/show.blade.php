<x-admin-layout>
    <x-slot name="header">
        {{ __('Detail Proposal Pengabdian') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0"><i class="fa fa-clipboard me-2"></i>Detail Proposal Pengabdian</h3>
                    <a href="{{ route('pengabdian-adm.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                @if(session('error'))
                    <div class="modern-alert modern-alert-danger mb-3">
                        <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                    </div>
                @endif

                @if ($timeline && $timeline->admin_decision_start_date && $timeline->admin_decision_end_date)
                    @php
                        $matchPeriod = isset($proposalYear) && (string) $timeline->period === (string) $proposalYear;
                    @endphp
                    @if (!$matchPeriod)
                        <div class="modern-alert modern-alert-warning mb-3">
                            <i class="fa fa-lock me-2"></i>Proposal ini berada pada periode {{ $proposalYear ?? '-' }}, sedangkan periode penyetujuan aktif adalah {{ $timeline->period }}. Penyetujuan tidak dapat dilakukan.
                        </div>
                    @elseif ($currentDate < $timeline->admin_decision_start_date)
                        <div class="modern-alert modern-alert-warning mb-3">
                            <i class="fa fa-clock me-2"></i>Periode penyetujuan admin akan dimulai pada <strong>{{ $timeline->admin_decision_start_date->format('d F Y H:i') }}</strong>.
                        </div>
                    @elseif ($currentDate > $timeline->admin_decision_end_date)
                        <div class="modern-alert modern-alert-danger mb-3">
                            <i class="fa fa-times-circle me-2"></i>Periode penyetujuan admin telah berakhir pada <strong>{{ $timeline->admin_decision_end_date->format('d F Y H:i') }}</strong>. Anda tidak dapat melakukan perubahan keputusan.
                        </div>
                    @else
                        <div class="modern-alert modern-alert-info mb-3">
                            <i class="fa fa-info-circle me-2"></i>Periode penyetujuan admin sedang berlangsung. Akan berakhir pada <strong>{{ $timeline->admin_decision_end_date->format('d F Y H:i') }}</strong>.
                        </div>
                    @endif
                @endif

                <!-- Informasi Proposal -->
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <h3 class="mb-3"><i class="fa fa-info-circle me-2"></i>Informasi Proposal</h3>
                        <h5 class="mb-4">"{{ $proposal->judul }}"</h5>
                        
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
                                    <span class="fw-bold">Rp {{ number_format($proposal->biaya_diusulkan ?? 0, 0, ',', '.') }}</span>

                                    
                                    <span class="text-muted text-uppercase small fw-semibold mt-3">Dosen Pengusul</span>
                                    <span class="fw-bold">{{ $proposal->user->name ?? '-' }}</span>
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
                </div>

                <!-- Tim Pelaksana -->
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0"><i class="fa fa-users me-2"></i>Tim Pelaksana</h4>
                            <span class="text-muted small">{{ $anggotaList->count() }} anggota</span>
                        </div>
                        @if($anggotaList->count())
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
                                        @foreach($anggotaList as $anggota)
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
                                <i class="fa fa-info-circle me-2"></i>Belum ada data anggota pelaksana.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- RAB -->
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0"><i class="fa fa-money-bill-wave me-2"></i>Rencana Anggaran Biaya</h4>
                        </div>
                        @if($rabItems->count())
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
                                        @foreach($rabItems as $rab)
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
                                <i class="fa fa-info-circle me-2"></i>Belum ada data RAB.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Dokumen Proposal -->
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <h3 class="mb-3">Dokumen Proposal</h3>
                        <iframe src="{{ $fileUrl }}" style="width:100%; height:700px; border: 1px solid #ddd; border-radius: 8px;"></iframe>
                    </div>
                </div>

                <!-- Dokumen Review -->
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <h3 class="mb-3"><i class="fa fa-file-alt me-2"></i>Dokumen Review</h3>
                        <div class="row">
                            @foreach($reviews as $index => $review)
                                <div class="col-md-6 mb-4">
                                    <div class="modern-card">
                                        <div class="modern-card-body">
                                            <h5 class="mb-3">Review {{ $index + 1 }}</h5>
                                            <p class="text-muted mb-2">
                                                <strong>Reviewer:</strong> {{ $review->reviewer->name ?? $review->reviewer_name ?? 'Tidak diketahui' }}
                                            </p>
                                            
                                            <div class="mb-3">
                                                
                                                <div class="modern-table-container">
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
                                                            @if($review->reviewKriteria && $review->reviewKriteria->count() > 0)
                                                                {{-- Dynamic form review - display from reviewKriteria --}}
                                                                @foreach($review->reviewKriteria->filter(function($rk) { return $rk->formPenilaianReview !== null; })->sortBy('formPenilaianReview.urutan') as $reviewKriteria)
                                                                    <tr>
                                                                        <td>{!! nl2br(e($reviewKriteria->formPenilaianReview->kriteria_penilaian ?? '-')) !!}</td>
                                                                        <td>{{ $reviewKriteria->formPenilaianReview->bobot == floor($reviewKriteria->formPenilaianReview->bobot) ? number_format($reviewKriteria->formPenilaianReview->bobot, 0) : number_format($reviewKriteria->formPenilaianReview->bobot, 2) }}%</td>
                                                                        <td>{{ $reviewKriteria->skor ?? '-' }}</td>
                                                                        <td>{{ $reviewKriteria->nilai ?? '-' }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                {{-- Fallback to hardcoded form --}}
                                                                <tr>
                                                                    <td>Penguasaan materi dan keterkaitan</td>
                                                                    <td>20%</td>
                                                                    <td>{{ $review->skor_1 ?? '-' }}</td>
                                                                    <td>{{ $review->skor_1 ? ($review->skor_1 * 20) : '-' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Kesesuaian latar belakang dan tujuan</td>
                                                                    <td>20%</td>
                                                                    <td>{{ $review->skor_2 ?? '-' }}</td>
                                                                    <td>{{ $review->skor_2 ? ($review->skor_2 * 20) : '-' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Metode Penelitian</td>
                                                                    <td>20%</td>
                                                                    <td>{{ $review->skor_3 ?? '-' }}</td>
                                                                    <td>{{ $review->skor_3 ? ($review->skor_3 * 20) : '-' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Peta jalan penelitian</td>
                                                                    <td>10%</td>
                                                                    <td>{{ $review->skor_4 ?? '-' }}</td>
                                                                    <td>{{ $review->skor_4 ? ($review->skor_4 * 10) : '-' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Potensi tercapainya luaran</td>
                                                                    <td>30%</td>
                                                                    <td>{{ $review->skor_5 ?? '-' }}</td>
                                                                    <td>{{ $review->skor_5 ? ($review->skor_5 * 30) : '-' }}</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td class="fw-bold">Total</td>
                                                                <td class="fw-bold">100%</td>
                                                                <td class="fw-bold">
                                                                    @if($review->reviewKriteria && $review->reviewKriteria->count() > 0)
                                                                        {{ $review->reviewKriteria->sum('skor') }}
                                                                    @else
                                                                        {{ ($review->skor_1 ?? 0) + ($review->skor_2 ?? 0) + ($review->skor_3 ?? 0) + ($review->skor_4 ?? 0) + ($review->skor_5 ?? 0) }}
                                                                    @endif
                                                                </td>
                                                                <td class="fw-bold">
                                                                    @if($review->reviewKriteria && $review->reviewKriteria->count() > 0)
                                                                        {{ number_format($review->reviewKriteria->sum('nilai'), 2) }}
                                                                    @else
                                                                        {{ (($review->skor_1 ?? 0) * 20) + (($review->skor_2 ?? 0) * 20) + (($review->skor_3 ?? 0) * 20) + (($review->skor_4 ?? 0) * 10) + (($review->skor_5 ?? 0) * 30) }}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                            
                                            @if($review->komentar)
                                                <div class="mb-3">
                                                    <h6 class="mb-2">Komentar Reviewer</h6>
                                                    <p class="text-muted">{{ $review->komentar }}</p>
                                                </div>
                                            @endif
                                            
                                            @if($review->disarankan)
                                                <div class="mb-3">
                                                    <h6 class="mb-2">Disarankan</h6>
                                                    <p class="text-muted">{{ $review->disarankan }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Form Acc/Tolak -->
                <div class="modern-card mb-4 fade-in-up">
                    <div class="modern-card-body">
                        <h3 class="mb-3"><i class="fa fa-check-circle me-2"></i>Penyetujuan Admin</h3>
                        
                        @if($proposal->admin_status)
                            <div class="modern-alert {{ $proposal->admin_status === 'approved' ? 'modern-alert-success' : 'modern-alert-danger' }} mb-3">
                                <i class="fa fa-{{ $proposal->admin_status === 'approved' ? 'check' : 'times' }}-circle me-2"></i>
                                Proposal telah <strong>{{ $proposal->admin_status === 'approved' ? 'disetujui' : 'ditolak' }}</strong>
                                @if($proposal->admin_comment)
                                    <p class="mb-0 mt-2"><strong>Komentar:</strong> {{ $proposal->admin_comment }}</p>
                                @endif
                            </div>
                        @endif

                        @php
                            $matchPeriod = isset($proposalYear) && $timeline && (string) $timeline->period === (string) $proposalYear;
                            $canMakeDecision = $matchPeriod &&
                                $timeline && 
                                $timeline->admin_decision_start_date && 
                                $timeline->admin_decision_end_date &&
                                $currentDate >= $timeline->admin_decision_start_date && 
                                $currentDate <= $timeline->admin_decision_end_date;
                        @endphp

                        <form action="{{ route('pengabdian-adm.approve-reject', $proposal->id) }}" method="POST">
                            @csrf
                            
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="modern-form-label"><i class="fa fa-check-circle me-2"></i>Status Keputusan</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="admin_status" id="approved" value="approved" {{ $proposal->admin_status === 'approved' ? 'checked' : '' }} @if(!$canMakeDecision) disabled @endif>
                                            <label class="form-check-label" for="approved">
                                                <i class="fa fa-check text-success me-1"></i> Setujui
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="admin_status" id="rejected" value="rejected" {{ $proposal->admin_status === 'rejected' ? 'checked' : '' }} @if(!$canMakeDecision) disabled @else required @endif>
                                            <label class="form-check-label" for="rejected">
                                                <i class="fa fa-times text-danger me-1"></i> Tolak
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="admin_comment" class="modern-form-label"><i class="fa fa-comment-dots me-2"></i>Komentar Admin <span class="text-danger">*</span></label>
                                <textarea id="admin_comment" class="modern-form-textarea" name="admin_comment" rows="4" placeholder="Masukkan komentar atau catatan untuk proposal ini..." @if(!$canMakeDecision) disabled @else required @endif>{{ $proposal->admin_comment ?? '' }}</textarea>
                                <small class="text-muted">Komentar ini akan ditampilkan kepada dosen pengusul. <span class="text-danger">Wajib diisi.</span></small>
                            </div>

                            @if($canMakeDecision)
                                <button type="submit" class="modern-btn modern-btn-primary">
                                    <i class="fa fa-save me-1"></i> Simpan Keputusan
                                </button>
                            @else
                                <button type="button" class="modern-btn modern-btn-secondary" disabled>
                                    <i class="fa fa-lock me-1"></i> Periode Keputusan Tidak Aktif
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

