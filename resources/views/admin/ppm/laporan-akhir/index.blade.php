<x-admin-layout>
    <x-slot name="header">
        {{ __('Monitoring Laporan Akhir') }}
    </x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="mb-3 fade-in-up">
                <h3 class="mb-4">
                    <i class="fa fa-chart-line me-2"></i>Monitoring Laporan Akhir
                </h3>

                @if(session('success'))
                    <div class="modern-alert modern-alert-success">
                        <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="modern-alert modern-alert-danger">
                        <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                    </div>
                @endif

                @if ($laporanAkhir->count() === 0)
                    <div class="modern-alert modern-alert-info">
                        <i class="fa fa-info-circle me-2"></i>Tidak ada laporan akhir yang ditemukan.
                    </div>
                @else
                    <div class="modern-table-container mb-3">
                        <table class="modern-table modern-table-fixed">
                            <thead>
                                <tr>
                                    <th class="col-no text-center">#</th>
                                    <th class="col-judul">Judul Kegiatan</th>
                                    <th class="text-center">Skema</th>
                                    <th class="text-center">Tahun</th>
                                    <th class="text-center">Disubmit Pada</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporanAkhir as $index => $laporan)
                                    @php
                                        $proposal = $laporan->penelitian ?? $laporan->pengabdian;
                                    @endphp
                                    <tr>
                                        <td class="col-no text-center">{{ $index + 1 }}</td>
                                        <td class="col-judul">
                                            <div class="fw-bold proposal-title">{{ $proposal->judul ?? '-' }}</div>
                                            <small class="text-muted">Oleh: {{ $laporan->user->name ?? '-' }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="status-badge skema">
                                                {{ $proposal->skema ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ $laporan->created_at->year }}</td>
                                        <td class="text-center">
                                            {{ $laporan->created_at->format('d M Y') }}
                                        </td>
                                        <td class="text-center">
                                            <!-- Action buttons placeholder -->
                                            <a href="{{ route('admin.laporan-akhir.show', $laporan->id) }}"
                                                class="modern-btn modern-btn-primary modern-btn-sm">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>