<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 0.85rem;
        }

        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 3px;
            text-transform: uppercase;
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

        .bordered-table {
            border: 1px solid black;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .bordered-table th,
        .bordered-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        .bordered-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
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

        .header-line {
            border: none;
            border-top: 2px solid #000;
            margin: 5px 0 15px 0;
        }

        hr {
            border: none;
            border-top: 1px solid #000;
            margin: 3px 0;
        }
    </style>
</head>

<body>
    <div class="header-title">
        BORANG PENILAIAN LAPORAN AKHIR PENGABDIAN KEPADA MASYARAKAT<br>
        HIBAH INTERNAL ITH TAHUN
        {{ $proposal->created_at ? $proposal->created_at->format('Y') : ($proposal->revisionParent && $proposal->revisionParent->created_at ? $proposal->revisionParent->created_at->format('Y') : date('Y')) }}
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
            <td colspan="3" style="height: 10px;"></td>
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
            <td>{{ $jumlahAnggotaTim ?? '-' }}</td>
        </tr>
        <tr>
            <td>Dana Disetujui</td>
            <td>:</td>
            <td>Rp {{ number_format((float) $danaDisetujui, 0, ',', '.') }}</td>
        </tr>
    </table>

    <!-- Tabel Penilaian -->
    <table class="bordered-table" style="margin-top: 15px;">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 35%;">Komponen</th>
                <th style="width: 40%;">Sub Komponen</th>
                <th style="width: 10%;">Nilai</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @php $rowNumber = 1; @endphp
            @foreach($formPengabdian as $kategori => $komponenList)
                @php
                    // Calculate total rows for this kategori
                    $kategoriTotalRows = 1;
                    foreach ($komponenList as $komponen) {
                        $subCount = $komponen->subKomponen->count();
                        $kategoriTotalRows += $subCount > 0 ? $subCount : 1;
                    }
                @endphp
                {{-- Kategori Header Row --}}
                <tr class="kategori-header-row" style="background-color: #e9ecef;">
                    <td rowspan="{{ $kategoriTotalRows }}" style="text-align: center; vertical-align: top;">{{ $rowNumber }}
                    </td>
                    <td colspan="4" style="text-align: center; font-weight: bold;">
                        {{ $kategori ?? '-' }}
                    </td>
                </tr>
                @foreach($komponenList as $komponen)
                    @php
                        $subKomponenCount = $komponen->subKomponen->count();
                        $komponenRowspan = $subKomponenCount > 0 ? $subKomponenCount : 1;
                        $komponenFirstRow = true;

                        // Find selected sub komponen
                        // LaporanAkhirReviewItem uses form_penilaian_id
                        $selectedItem = $existingReview->items->firstWhere('form_penilaian_id', $komponen->id);
                    @endphp
                    @if($subKomponenCount > 0)
                        @foreach($komponen->subKomponen as $sub)
                            <tr>
                                @if($komponenFirstRow)
                                    <td rowspan="{{ $komponenRowspan }}"><strong>{{ $komponen->komponen_penilaian }}</strong></td>
                                    @php $komponenFirstRow = false; @endphp
                                @endif
                                <td>{{ $sub->keterangan }}</td>
                                <td style="text-align: center;">{{ number_format($sub->skor, 2) }}</td>
                                <td style="text-align: center;">
                                    @if($selectedItem && $selectedItem->sub_id == $sub->id)
                                        {{ number_format($sub->skor, 2) }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td><strong>{{ $komponen->komponen_penilaian }}</strong></td>
                            <td>-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;"></td>
                        </tr>
                    @endif
                @endforeach
                @php $rowNumber++; @endphp
            @endforeach
            {{-- Total Row --}}
            <tr class="total-row" style="background-color: #f8f9fa;">
                <td colspan="3" style="text-align: right; padding-right: 10px;">
                    <strong>TOTAL NILAI:</strong>
                </td>
                <td colspan="2" style="text-align: center;">
                    <strong>{{ number_format($totalNilai ?? 0, 2) }}</strong>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Catatan -->
    <div class="catatan-section">
        <strong>Catatan:</strong>
        <div style="margin-top: 5px;">
            @if($existingReview->catatan_umum)
                {{ $existingReview->catatan_umum }}
            @else
                <hr class="dotted-line">
                <hr class="dotted-line">
                <hr class="dotted-line">
            @endif
        </div>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature-section">
        <div class="signature-box">
            <p style="margin: 5px 0;">Parepare,
                {{ $existingReview->submitted_at ? $existingReview->submitted_at->format('d F Y') : '...................... ' }}
            </p>
            <p style="margin: 5px 0;">Reviewer,</p>
            <br><br><br>
            <p style="margin: 5px 0;">({{ $reviewerName }})</p>
        </div>
    </div>
</body>

</html>