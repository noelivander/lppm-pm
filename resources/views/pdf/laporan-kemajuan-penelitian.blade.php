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
            margin-bottom: 15px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 5px;
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
        FORM PENILAIAN LAPORAN KEMAJUAN PENELITIAN
    </div>

    <hr>

    <!-- Informasi Penelitian -->
    <table class="no-border-table">
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
            <td>Jurusan/Prodi</td>
            <td>:</td>
            <td>{{ $jurusanProdi }}</td>
        </tr>
        <tr>
            <td>Lama Penelitian</td>
            <td>:</td>
            <td>{{ $lamaPenelitian }}</td>
        </tr>
    </table>

    <div class="section-title">Ketua Peneliti:</div>
    <table class="no-border-table">
        @if($ketuaPeneliti)
        <tr>
            <td style="width: 30%; padding-left: 20px;">Nama Lengkap</td>
            <td style="width: 2%;">:</td>
            <td>{{ $ketuaPeneliti->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding-left: 20px;">NIDN</td>
            <td>:</td>
            <td>{{ $ketuaPeneliti->nidn ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding-left: 20px;">Jabatan Fungsional</td>
            <td>:</td>
            <td>{{ $ketuaPeneliti->jabatan ?? '-' }}</td>
        </tr>
        @else
        <tr>
            <td colspan="3" style="padding-left: 20px;">-</td>
        </tr>
        @endif
    </table>

    <hr>

    <!-- Penilaian -->
    <div class="section-title">PENILAIAN LAPORAN KEMAJUAN</div>
    <table class="bordered-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 55%;">Komponen Penilaian</th>
                <th style="width: 40%;">Komentar Reviewer</th>
            </tr>
        </thead>
        <tbody>
            @foreach($formPenelitian as $index => $item)
                @php
                    $reviewItem = $existingReview->items->firstWhere('form_penilaian_laporan_kemajuan_id', $item->id);
                    $komentar = $reviewItem ? $reviewItem->komentar : '-';
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $item->komponen_penilaian }}</td>
                    <td style="text-align: justify;">{{ $komentar }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Catatan Tambahan -->
    @if($existingReview->catatan_umum)
    <div class="section-title">Catatan Tambahan:</div>
    <p style="text-align: justify; margin-top: 5px;">
        {{ $existingReview->catatan_umum }}
    </p>
    @endif

    <br><br>

    <!-- Tanda Tangan -->
    <table class="no-border-table" style="margin-top: 20px;">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%; text-align: center;">
                <p>Parepare, {{ $existingReview->submitted_at ? $existingReview->submitted_at->format('d F Y') : date('d F Y') }}</p>
                <p>Reviewer,</p>
                <br><br><br>
                <p style="text-decoration: underline;">{{ Auth::user()->name }}</p>
            </td>
        </tr>
    </table>
</body>
</html>

