<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 0.85rem;
            line-height: 1.5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            border: none;
            padding: 3px 0;
            vertical-align: top;
        }
        .bordered-table, .bordered-table th, .bordered-table td {
            border: 1px solid black;
        }
        .bordered-table th, .bordered-table td {
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }
        .bordered-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .header-line {
            border: none;
            border-top: 2px solid #000;
            margin: 5px 0 15px 0;
        }
        .catatan-section {
            margin-top: 15px;
            margin-bottom: 15px;
        }
        .dotted-line {
            border: none;
            border-bottom: 1px dotted #000;
            margin: 5px 0;
        }
        .signature-section {
            margin-top: 30px;
        }
        .signature-box {
            text-align: right;
            margin-right: 50px;
        }
    </style>
</head>
<body>
    <div class="header-title">
        BORANG PENILAIAN LAPORAN AKHIR<br>
        PENGABDIAN KEPADA MASYARAKAT
    </div>

    <hr class="header-line">

    <!-- Informasi Pengabdian -->
    <table class="info-table">
        <tr>
            <td style="width: 30%;">Judul Kegiatan</td>
            <td style="width: 2%;">:</td>
            <td>{{ $proposal->judul ?? '-' }}</td>
        </tr>
        <tr>
            <td colspan="3"><strong>Identitas Ketua Tim Pelaksana</strong></td>
        </tr>
        @if($ketuaTim)
        <tr>
            <td>Nama Ketua</td>
            <td>:</td>
            <td>{{ $ketuaTim->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td>NIDN / NIDK</td>
            <td>:</td>
            <td>{{ $ketuaTim->nidn ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jurusan / Program Studi</td>
            <td>:</td>
            <td>{{ $jurusanProdi }}</td>
        </tr>
        @endif
        <tr>
            <td>Jumlah Anggota Tim</td>
            <td>:</td>
            <td>{{ $jumlahAnggotaTim ?? '-' }} orang</td>
        </tr>
        <tr>
            <td>Dana Disetujui</td>
            <td>:</td>
            <td>Rp {{ number_format((float)($danaDisetujui ?? 0), 0, ',', '.') }}</td>
        </tr>
    </table>

    <!-- Tabel Penilaian dengan 2 penilai -->
    <table class="bordered-table" style="margin-top: 15px;">
        <thead>
            <tr>
                <th style="width: 5%; text-align:center; vertical-align: middle;" rowspan="2">No</th>
                <th style="width: 30%; text-align:center; vertical-align: middle;" rowspan="2">Komponen</th>
                <th style="width: 30%; text-align:center; vertical-align: middle;" rowspan="2">Sub Komponen</th>
                <th style="width: 10%; text-align:center; vertical-align: middle;" rowspan="2">Nilai</th>
                <th style="width: 25%; text-align:center; vertical-align: middle;" colspan="2">Penilai</th>
            </tr>
            <tr>
                <th style="width: 12.5%; text-align:center; vertical-align: middle;">Penilai 1</th>
                <th style="width: 12.5%; text-align:center; vertical-align: middle;">Penilai 2</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $rowNumber = 1; 
                $totalReviewer1 = 0;
                $totalReviewer2 = 0;
            @endphp
            @foreach($formPengabdian as $kategori => $komponenList)
                @php
                    $kategoriTotalRows = 1;
                    foreach ($komponenList as $komponen) {
                        $subCount = $komponen->subKomponen->count();
                        $kategoriTotalRows += $subCount > 0 ? $subCount : 1;
                    }
                @endphp
                <tr class="kategori-header">
                    <td rowspan="{{ $kategoriTotalRows }}">{{ $rowNumber }}</td>
                    <td colspan="5" style="text-align: center;">
                        <strong>{{ $kategori ?? '-' }}</strong>
                    </td>
                </tr>
                @foreach($komponenList as $komponen)
                    @php
                        $subKomponenCount = $komponen->subKomponen->count();
                        $komponenRowspan = $subKomponenCount > 0 ? $subKomponenCount : 1;
                        $komponenFirstRow = true;
                    @endphp
                    @if($subKomponenCount > 0)
                        @foreach($komponen->subKomponen as $sub)
                            @php
                                // Note: Using firstWhere column check - ensure Controller eager loads items correctly
                                // For LaporanAkhirReviewItem, sub_id relates to FormPenilaianLaporanAkhirSub
                                $nilai1 = $review1 ? optional($review1->items->firstWhere('sub_id', $sub->id))->nilai : null;
                                $nilai2 = $review2 ? optional($review2->items->firstWhere('sub_id', $sub->id))->nilai : null;
                                if($nilai1) $totalReviewer1 += $nilai1;
                                if($nilai2) $totalReviewer2 += $nilai2;
                            @endphp
                            <tr>
                                @if($komponenFirstRow)
                                    <td rowspan="{{ $komponenRowspan }}"><strong>{{ $komponen->komponen_penilaian }}</strong></td>
                                    @php $komponenFirstRow = false; @endphp
                                @endif
                                <td>{{ $sub->keterangan }}</td>
                                <td style="text-align: center;">{{ number_format($sub->skor, 2) }}</td>
                                <td style="text-align: center;">{{ $nilai1 !== null ? number_format($nilai1, 2) : '' }}</td>
                                <td style="text-align: center;">{{ $nilai2 !== null ? number_format($nilai2, 2) : '' }}</td>
                            </tr>
                        @endforeach
                    @else
                        @php
                            // Check if item is linked directly to form_penilaian_id (unlikely for nested structure but good fallback)
                            // In this system, Pengabdian usually goes down to sub_id level. 
                            // But if subKomponen is empty, strict mapping might fail unless we check items by form_penilaian_id
                            $nilai1 = $review1 ? optional($review1->items->where('form_penilaian_id', $komponen->id)->first())->nilai : null;
                            $nilai2 = $review2 ? optional($review2->items->where('form_penilaian_id', $komponen->id)->first())->nilai : null;
                            if($nilai1) $totalReviewer1 += $nilai1;
                            if($nilai2) $totalReviewer2 += $nilai2;
                        @endphp
                        <tr>
                            <td><strong>{{ $komponen->komponen_penilaian }}</strong></td>
                            <td>-</td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;">{{ $nilai1 !== null ? number_format($nilai1, 2) : '' }}</td>
                            <td style="text-align: center;">{{ $nilai2 !== null ? number_format($nilai2, 2) : '' }}</td>
                        </tr>
                    @endif
                @endforeach
                @php $rowNumber++; @endphp
            @endforeach
            <tr class="total-row">
                <td colspan="4" style="text-align: right; padding-right: 10px;">
                    <strong>TOTAL NILAI:</strong>
                </td>
                <td style="text-align: center;">
                    <strong>{{ number_format($totalReviewer1, 2) }}</strong>
                </td>
                <td style="text-align: center;">
                    <strong>{{ $review2 ? number_format($totalReviewer2, 2) : '-' }}</strong>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Catatan -->
    <div class="catatan-section">
        <strong>Catatan:</strong>
        <div style="margin-top: 5px;">
            @if($review1 && $review1->catatan_umum)
                <div><em>Penilai 1:</em> {{ $review1->catatan_umum }}</div>
            @endif
            @if($review2 && $review2->catatan_umum)
                <div><em>Penilai 2:</em> {{ $review2->catatan_umum }}</div>
            @endif
            @if((!$review1 || !$review1->catatan_umum) && (!$review2 || !$review2->catatan_umum))
                <hr class="dotted-line">
                <hr class="dotted-line">
                <hr class="dotted-line">
            @endif
        </div>
    </div>

    <!-- Tanda Tangan -->
    <table class="info-table" style="margin-top: 25px;">
        <tr>
            <td style="width: 45%;"></td>
            <td style="width: 10%;"></td>
            <td style="width: 45%; text-align: right; font-weight: bold;">
                Parepare, {{ $ttdDate }}
            </td>
        </tr>
        <tr>
            <td style="width: 45%; text-align: center; vertical-align: top;">
                <div style="font-weight: bold; font-size: 0.9rem;">Penilai 1</div>
                <br><br><br>
                <div style="font-size: 0.95rem;">({{ $reviewer1Name }})</div>
                <div style="margin-top: 4px;">NIDN. {{ $reviewer1Nidn }}</div>
            </td>
            <td style="width: 10%;"></td>
            <td style="width: 45%; text-align: center; vertical-align: top;">
                <div style="font-weight: bold; font-size: 0.9rem;">Penilai 2</div>
                <br><br><br>
                <div style="font-size: 0.95rem;">({{ $reviewer2Name }})</div>
                <div style="margin-top: 4px;">NIDN. {{ $reviewer2Nidn }}</div>
            </td>
        </tr>
    </table>

    <div class="signature-section" style="margin-top: 30px; text-align: center;">
        <div style="font-weight: bold;">Mengetahui</div>
        <div style="font-weight: bold;">Kepala LPPM-PM ITH</div>
        <br><br><br>
        <div style="font-weight: bold;">Prof. Dr. Eng. Ir. Intan Sari Areni, S.T., M.T., IPU.</div>
        <div style="font-weight: bold;">NIDN. 0003027508</div>
    </div>
</body>
</html>
