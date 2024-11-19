<!-- resources/views/pdf/review_template.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
        }
    </style>
</head>
<body>
    <h2>Formulir Penilaian Proposal Pengabdian</h2>
    <p><strong>Judul Kegiatan:</strong> {{ $review->judul_kegiatan }}</p>
    <p><strong>Ketua Tim Pelaksana:</strong> {{ $review->ketua_tim }}</p>
    
    <table>
        <tr>
            <th>No.</th>
            <th>Kriteria Penilaian</th>
            <th>Skor</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Penguasaan materi terhadap analisis situasi</td>
            <td>{{ $review->skor_1 }}</td>
        </tr>
        <!-- Tambahkan baris untuk kriteria lainnya -->
    </table>

    <p><strong>Komentar Penilai:</strong> {{ $review->komentar }}</p>
</body>
</html>
