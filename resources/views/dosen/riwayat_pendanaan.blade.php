<x-dosen-layout>
    <x-slot name="title">
        {{ __('Riwayat Pendanaan') }}
    </x-slot>

    <div class="container-fluid py-4">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h4 class="mb-1 text-primary fw-bold">Riwayat Pendanaan</h4>
                <p class="mb-0 text-muted">Daftar proposal yang telah disetujui pendanaannya.</p>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('dosen.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fa fa-arrow-left me-2"></i>Kembali ke Dashboard
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-uppercase text-secondary small">
                            <tr>
                                <th class="ps-4 py-3">Judul Kegiatan</th>
                                <th class="py-3">Jenis</th>
                                <th class="py-3">Tahun</th>
                                <th class="py-3 text-end pe-4">Dana Disetujui</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($fundedProposals as $proposal)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="fw-bold text-dark">{{ $proposal->judul }}</div>
                                    </td>
                                    <td class="py-3">
                                        @if($proposal->type == 'Penelitian')
                                            <span class="badge bg-info-subtle text-info rounded-pill px-3">Penelitian</span>
                                        @else
                                            <span
                                                class="badge bg-warning-subtle text-warning rounded-pill px-3">Pengabdian</span>
                                        @endif
                                    </td>
                                    <td class="py-3">{{ $proposal->created_at->format('Y') }}</td>
                                    <td class="py-3 text-end pe-4">
                                        <span class="fw-bold text-success">
                                            Rp {{ number_format($proposal->biaya_disetujui, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <img src="{{ asset('img/no-data.svg') }}" alt="No Data"
                                            style="height: 100px; opacity: 0.5;">
                                        <p class="text-muted mt-3 mb-0">Belum ada proposal yang didanai.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <td colspan="3" class="text-end fw-bold py-3">Total Pendanaan:</td>
                                <td class="text-end fw-bold text-success pe-4 py-3">
                                    Rp {{ number_format($fundedProposals->sum('biaya_disetujui'), 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-dosen-layout>