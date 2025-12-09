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
            margin-bottom: 15px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 5px;
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
        FORM PENILAIAN LAPORAN KEMAJUAN PENGABDIAN
    </div>

    <hr>

    <!-- Informasi Pengabdian -->
    <table class="no-border-table">
        <tr>
            <td style="width: 30%;">Judul Kegiatan</td>
            <td style="width: 2%;">:</td>
            <td>{{ $proposal->judul ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jumlah Anggota Tim</td>
            <td>:</td>
            <td>{{ $jumlahAnggotaTim }} orang</td>
        </tr>
        <tr>
            <td>Dana Disetujui</td>
            <td>:</td>
            <td>
                @if($danaDisetujui != '-')
                    Rp {{ number_format($danaDisetujui, 0, ',', '.') }}
                @else
                    {{ $danaDisetujui }}
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title">Identitas Ketua Tim Pelaksana:</div>
    <table class="no-border-table">
        @if($ketuaTim)
        <tr>
            <td style="width: 30%; padding-left: 20px;">Nama Ketua</td>
            <td style="width: 2%;">:</td>
            <td>{{ $ketuaTim->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding-left: 20px;">NIDN/NIDK</td>
            <td>:</td>
            <td>{{ $ketuaTim->nidn ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding-left: 20px;">Jurusan/Prodi</td>
            <td>:</td>
            <td>{{ $jurusanProdi }}</td>
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

