<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 0.85rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .no-border-table td {
            border: none;
            padding: 3px;
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

        .info-table td {
            border: none;
            padding: 3px 0;
            vertical-align: top;
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

        .kategori-header {
            background-color: #e8e8e8;
            font-weight: bold;
            text-align: center;
        }

        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        hr {
            color: #000000;
            height: 2px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header-title">
        BORANG PENILAIAN MONITORING DAN EVALUASI KEMAJUAN PENGABDIAN<br>
        HIBAH INTERNAL ITH TAHUN {{ date('Y') }}
    </div>

    <hr class="header-line">

    <!-- Informasi Pengabdian -->
    <table class="info-table">
        <tr>
            <td style="width: 30%;">Judul Penelitian</td>
            <td style="width: 2%;">:</td>
            <td>{{ $proposal->judul ?? '-' }}</td>
        </tr>
        <tr>
            <td>Bidang Penelitian</td>
            <td>:</td>
            <td>-</td>
        </tr>
        <tr>
            <td>Skema</td>
            <td>:</td>
            <td>-</td>
        </tr>
        <tr>
            <td>Jurusan / Program Studi</td>
            <td>:</td>
            <td>{{ $jurusanProdi }}</td>
        </tr>
        <tr>
            <td>Ketua Peneliti</td>
            <td>:</td>
            <td></td>
        </tr>
        @if($ketuaTim)
        <tr>
            <td style="padding-left: 30px;">Nama Lengkap</td>
            <td>:</td>
            <td>{{ $ketuaTim->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding-left: 30px;">NIDN</td>
            <td>:</td>
            <td>{{ $ketuaTim->nidn ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding-left: 30px;">Jabatan Fungsional</td>
            <td>:</td>
            <td>-</td>
        </tr>
        @endif
        <tr>
            <td>Nama Mitra (jika ada)</td>
            <td>:</td>
            <td>-</td>
        </tr>
        <tr>
            <td>Institusi Mitra (jika ada)</td>
            <td>:</td>
            <td>-</td>
        </tr>
        <tr>
            <td>Lama Penelitian Keseluruhan</td>
            <td>:</td>
            <td>-</td>
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
                <tr class="kategori-header">
                    <td rowspan="{{ $kategoriTotalRows }}">{{ $rowNumber }}</td>
                    <td colspan="4" style="text-align: center;">
                        <strong>{{ $kategori ?? '-' }}</strong>
                    </td>
                </tr>
                @foreach($komponenList as $komponen)
                    @php
                        $subKomponenCount = $komponen->subKomponen->count();
                        $komponenRowspan = $subKomponenCount > 0 ? $subKomponenCount : 1;
                        $komponenFirstRow = true;
                        
                        // Find selected sub komponen
                        $selectedItem = $existingReview->items->firstWhere('form_penilaian_laporan_kemajuan_id', $komponen->id);
                    @endphp
                    @if($subKomponenCount > 0)
                        @foreach($komponen->subKomponen as $sub)
                            <tr>
                                @if($komponenFirstRow)
                                    <td rowspan="{{ $komponenRowspan }}"><strong>{{ $komponen->komponen_penilaian }}</strong></td>
                                    @php $komponenFirstRow = false; @endphp
                                @endif
                                <td>{{ $sub->sub_komponen }}</td>
                                <td style="text-align: center;">{{ number_format($sub->nilai, 2) }}</td>
                                <td style="text-align: center;">
                                    @if($selectedItem && $selectedItem->form_penilaian_laporan_kemajuan_sub_id == $sub->id)
                                        {{ number_format($sub->nilai, 2) }}
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
            <tr class="total-row">
                <td colspan="3" style="text-align: right; padding-right: 10px;">
                    <strong>TOTAL NILAI:</strong>
                </td>
                <td colspan="2" style="text-align: center;">
                    <strong>{{ number_format($totalNilai, 2) }}</strong>
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
            <p style="margin: 5px 0;">Parepare, {{ $existingReview->submitted_at ? $existingReview->submitted_at->format('d F Y') : '...................... ' . date('Y') }}</p>
            <p style="margin: 5px 0;">Reviewer,</p>
            <br><br><br>
            <p style="margin: 5px 0;">({{ Auth::user()->name }})</p>
        </div>
    </div>
</body>
</html>

