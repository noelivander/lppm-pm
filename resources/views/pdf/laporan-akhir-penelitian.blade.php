<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
        }

        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            margin-bottom: 20px;
            text-transform: uppercase;
            line-height: 1.5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            border: none;
            padding: 2px 0;
            vertical-align: top;
            font-size: 11pt;
        }

        .bordered-table {
            border: 1px solid black;
            margin-top: 30px;
            margin-bottom: 20px;
            font-size: 10pt;
        }

        .bordered-table th,
        .bordered-table td {
            border: 1px solid black;
            padding: 5px;
            vertical-align: top;
        }

        .bordered-table th {
            text-align: center;
            font-weight: bold;
        }

        .catatan-section {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .dotted-line {
            border: none;
            border-bottom: 1px dotted #000;
            margin: 5px 0;
        }

        .signature-section {
            margin-top: 50px;
        }

        .signature-box {
            float: right;
            width: 250px;
            text-align: left;
        }

        /* Helper for list in cell */
        ul.alpha-list {
            list-style-type: lower-alpha;
            margin: 0;
            padding-left: 20px;
        }

        ul.alpha-list li {
            margin-bottom: 2px;
        }
    </style>
</head>

<body>
    <div class="header-title">
        BORANG PENILAIAN MONITORING DAN EVALUASI AKHIR PENELITIAN<br>
        HIBAH INTERNAL ITH TAHUN
        {{ $proposal->created_at ? $proposal->created_at->format('Y') : ($proposal->revisionParent && $proposal->revisionParent->created_at ? $proposal->revisionParent->created_at->format('Y') : date('Y')) }}
    </div>

    <!-- Informasi Penelitian -->
    <div style="margin-left: 5px;">
        <table class="info-table">
            <tr>
                <td style="width: 200px;">Judul Penelitian</td>
                <td style="width: 15px;">:</td>
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
                <td>{{ $lamaPenelitian }} Tahun</td>
            </tr>
        </table>
    </div>

    <!-- Tabel Penilaian -->
    <table class="bordered-table">
        <thead>
            <tr>
                <th rowspan="2" style="width: 5%;">No</th>
                <th rowspan="2" style="width: 25%;">Komponen Penilaian</th>
                <th colspan="4">Nilai</th>
            </tr>
            <tr>
                <th style="width: 25%;">Status</th>
                <th style="width: 20%;">Item</th>
                <th style="width: 15%;">Bobot</th>
                <th style="width: 10%;">Nilai (skor x bobot tiap item)</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($formPenelitian as $item)
                @php
                    // Get all review items for this component
                    // $existingReview->items contains LaporanAkhirReviewItem objects
                    $componentReviews = $existingReview->items->where('form_penilaian_id', $item->id);

                    // --- 1. Status Logic ---
                    $statusSubs = $item->subKomponen->where('tipe', 'status')->sortByDesc('skor');

                    // Identify which Status ID is selected
                    // We check if the review item's sub_id matches any of the available status sub_ids
                    $statusSubIds = $statusSubs->pluck('id')->toArray();

                    $selectedStatusReview = $componentReviews->first(function ($val) use ($statusSubIds) {
                        return in_array($val->sub_id, $statusSubIds);
                    });

                    $selectedStatusId = $selectedStatusReview ? $selectedStatusReview->sub_id : null;

                    // Get score from the Sub Component definition
                    $selectedStatusSkor = 0;
                    if ($selectedStatusId) {
                        $selectedSub = $statusSubs->where('id', $selectedStatusId)->first();
                        $selectedStatusSkor = $selectedSub ? $selectedSub->skor : 0;
                    }

                    // --- 2. Item Grades Logic ---
                    $itemSubs = $item->subKomponen->where('tipe', 'item');

                    // Filter reviews that are NOT status (so assume they are items)
                    $gradeReviews = $componentReviews->filter(function ($val) use ($statusSubIds) {
                        return !in_array($val->sub_id, $statusSubIds);
                    });

                    // Row count logic
                    $rowCount = max(1, $itemSubs->count());
                @endphp

                @for($i = 0; $i < $rowCount; $i++)
                    <tr>
                        <!-- Columns 1-3: Displayed only on first row of the component group -->
                        @if($i === 0)
                            <td rowspan="{{ $rowCount }}" style="text-align: center;">{{ $no++ }}</td>
                            <td rowspan="{{ $rowCount }}">{{ $item->komponen_penilaian }}</td>
                            <td rowspan="{{ $rowCount }}">
                                <ul class="alpha-list">
                                    @foreach($statusSubs as $statusOption)
                                        @php
                                            // Loose comparison for IDs
                                            $isSelected = $selectedStatusId == $statusOption->id;
                                            $style = $isSelected ? 'font-weight: bold; text-decoration: underline;' : '';
                                        @endphp
                                        <li style="{{ $style }}">
                                            {{ $statusOption->keterangan }}
                                            (skor = {{ $statusOption->skor }})
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        @endif

                        <!-- Limit items to available subs -->
                        @if($itemSubs->count() > 0 && $i < $itemSubs->count())
                            @php
                                $currentItem = $itemSubs->values()[$i];
                                // Match Sub ID
                                $currentGrade = $gradeReviews->where('sub_id', $currentItem->id)->first();
                                $scoreVal = $currentGrade ? $currentGrade->nilai : 0;

                                $label = '';
                                if ($scoreVal == 100)
                                    $label = 'Sangat Baik (100%)';
                                elseif ($scoreVal == 75)
                                    $label = 'Baik (75%)';
                                elseif ($scoreVal == 50)
                                    $label = 'Cukup Baik (50%)';
                                elseif ($scoreVal == 25)
                                    $label = 'Kurang / tidak baik (25%)';
                                else
                                    $label = $scoreVal > 0 ? "($scoreVal%)" : 'Tidak dinilai (0%)';

                                // Calculate
                                $finalValue = $scoreVal * ($selectedStatusSkor / 100);
                            @endphp
                            <td>{{ $currentItem->keterangan }}</td>
                            <td>{{ $label }}</td>
                            <td style="text-align: center;">{{ $finalValue > 0 ? number_format($finalValue, 0) : '' }}</td>
                        @else
                            <!-- Empty spacer -->
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        @endif
                    </tr>
                @endfor

            @endforeach
        </tbody>
    </table>

    <!-- Catatan -->
    <div class="catatan-section">
        <p>Catatan:</p>
        <div style="margin-top: 5px; border-bottom: 1px dotted #000; min-height: 20px;">
            {{ $existingReview->catatan_umum ?? '' }}
        </div>
        <div style="border-bottom: 1px dotted #000; min-height: 20px; margin-top: 5px;"></div>
        <div style="border-bottom: 1px dotted #000; min-height: 20px; margin-top: 5px;"></div>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature-section">
        <div class="signature-box">
            <p>Parepare, ............................................
                {{ $existingReview->submitted_at ? $existingReview->submitted_at->format('Y') : ($proposal->created_at ? $proposal->created_at->format('Y') : date('Y')) }}
            </p>
            <p>Reviewer,</p>
            <br><br><br><br>
            <p>(...........................................................)</p>
        </div>
    </div>
</body>

</html>