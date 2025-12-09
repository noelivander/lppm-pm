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

        .bordered-table th, .bordered-table td {
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
<body></body>
    <div class="header-title">
        BORANG PENILAIAN MONITORING DAN EVALUASI KEMAJUAN PENELITIAN<br>
        HIBAH INTERNAL ITH TAHUN {{ $proposal->created_at ? $proposal->created_at->format('Y') : ($proposal->revisionParent && $proposal->revisionParent->created_at ? $proposal->revisionParent->created_at->format('Y') : date('Y')) }}
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
            <td>{{ $lamaPenelitian }}</td>
        </tr>
    </table>

    <!-- Tabel Penilaian -->
    <table class="bordered-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 50%;">Komponen Penilaian</th>
                <th style="width: 45%;">Komentar Reviewer</th>
            </tr>
        </thead>
        <tbody>
            @foreach($formPenelitian as $index => $item)
                @php
                    $reviewItem = $existingReview->items->firstWhere('form_penilaian_laporan_kemajuan_id', $item->id);
                    $komentar = $reviewItem ? $reviewItem->komentar : '';
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $item->komponen_penilaian }}</td>
                    <td>{{ $komentar }}</td>
                </tr>
            @endforeach
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
            <p style="margin: 5px 0;">Parepare, {{ $existingReview->submitted_at ? $existingReview->submitted_at->format('d F Y') : '...................... ' . ($proposal->created_at ? $proposal->created_at->format('Y') : date('Y')) }}</p>
            <p style="margin: 5px 0;">Reviewer,</p>
            <br><br><br>
            <p style="margin: 5px 0;">({{ Auth::user()->name }})</p>
        </div>
    </div>
</body>
</html>

