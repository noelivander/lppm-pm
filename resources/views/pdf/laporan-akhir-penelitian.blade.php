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
        BORANG PENILAIAN LAPORAN AKHIR PENELITIAN<br>
        HIBAH INTERNAL ITH TAHUN
        {{ $proposal->created_at ? $proposal->created_at->format('Y') : ($proposal->revisionParent && $proposal->revisionParent->created_at ? $proposal->revisionParent->created_at->format('Y') : date('Y')) }}
    </div>

    <hr class="header-line">

    <!-- Informasi Penelitian -->
    <table class="info-table">
        <tr>
            <td style="width: 30%;">Judul Penelitian</td>
            <td style="width: 2%;">:</td>
            <td>{{ $proposal->judul ?? '-' }}</td>
        </tr>
        <tr>
            <td>Bidang Penelitian</td>
            <td>:</td>
            <td>{{ $bidangPenelitian }}</td>
        </tr>
        <tr>
            <td>Skema</td>
            <td>:</td>
            <td>{{ $skema }}</td>
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
        @if($ketuaPeneliti)
            <tr>
                <td style="padding-left: 30px;">Nama Lengkap</td>
                <td>:</td>
                <td>{{ $ketuaPeneliti->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding-left: 30px;">NIDN</td>
                <td>:</td>
                <td>{{ $ketuaPeneliti->nidn ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding-left: 30px;">Jabatan Fungsional</td>
                <td>:</td>
                <td>{{ $ketuaPeneliti->jabatan ?? '-' }}</td>
            </tr>
        @endif
        <tr>
            <td>Lama Penelitian Keseluruhan</td>
            <td>:</td>
            <td>{{ $lamaPenelitian }}</td>
        </tr>
    </table>

    <!-- Tabel Penilaian -->
    <table class="bordered-table">
        <thead>
            <tr>
                <th style="width: 7%;">No</th>
                <th style="width: 20%;">Komponen Penilaian</th>
                <th style="width: 25%;">Status</th>
                <th style="width: 30%;">Item Penilaian</th>
                <th style="width: 10%;">Bobot</th>
                <th style="width: 10%;">Nilai</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $no = 1; 
                $totalNilai = 0;
            @endphp
            @foreach($formPenelitian as $index => $item)
                @php
                    $reviewItem = $existingReview->items->firstWhere('form_penilaian_id', $item->id);
                    $nilai = $reviewItem ? $reviewItem->nilai : 0;
                    $totalNilai += $nilai;
                    
                    // Status Text
                    $statusText = '-';
                    if ($reviewItem && $reviewItem->statusChoice) {
                        $statusText = $reviewItem->statusChoice->keterangan . ' (' . (float)$reviewItem->statusChoice->skor . ')';
                    }
                        
                    // Bobot Text
                    $bobotText = '-';
                    if ($reviewItem) {
                        if ($reviewItem->bobotChoice) {
                            $bobotText = $reviewItem->bobotChoice->keterangan;
                        } elseif ($reviewItem->sub_id_status && $reviewItem->statusChoice && $reviewItem->statusChoice->skor > 0) {
                            $implied = ($nilai / $reviewItem->statusChoice->skor) * 100;
                            // Format: "Cukup (50%)" or just "50%"
                            // Try to match standard bobot labels if possible or just show %
                            if($implied == 100) $bobotText = "Sangat Baik (100%)";
                            elseif($implied == 75) $bobotText = "Baik (75%)";
                            elseif($implied == 50) $bobotText = "Cukup (50%)";
                            elseif($implied == 25) $bobotText = "Kurang (25%)";
                            else $bobotText = number_format($implied, 0) . '%';
                        }
                    }

                    // Item Penilaian List
                    $itemDescriptions = $item->subKomponen->where('tipe', 'item');
                @endphp
                <tr>
                    <td style="text-align: center; vertical-align: top;">{{ $no++ }}</td>
                    <td style="vertical-align: top;">{{ $item->komponen_penilaian }}</td>
                    <td style="vertical-align: top;">{{ $statusText }}</td>
                    <td style="vertical-align: top;">
                        @if($itemDescriptions->count() > 0)
                            <ul style="margin: 0; padding-left: 15px;">
                                @foreach($itemDescriptions as $desc)
                                    <li>{{ $desc->keterangan }}</li>
                                @endforeach
                            </ul>
                        @else
                            -
                        @endif
                    </td>
                    <td style="vertical-align: top; text-align: center;">{{ $bobotText }}</td>
                    <td style="vertical-align: top; text-align: center;">{{ number_format($nilai, 2) }}</td>
                </tr>
            @endforeach
            <tr style="background-color: #f2f2f2;">
                <td colspan="5" style="text-align: right; font-weight: bold;">TOTAL NILAI</td>
                <td style="font-weight: bold; text-align: center;">{{ number_format($totalNilai, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Catatan -->
    <div class="catatan-section">
        <strong>Catatan Tambahan:</strong>
        <div style="margin-top: 5px; border: 1px solid #000; padding: 10px; min-height: 50px;">
            @if($existingReview->catatan_umum)
                {{ $existingReview->catatan_umum }}
            @else
                -
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