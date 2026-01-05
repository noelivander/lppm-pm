<?php

use App\Models\LaporanAkhirReview;
use App\Models\LaporanAkhirReviewItem;
use App\Models\FormPenilaianLaporanAkhir;
use App\Models\LaporanAkhir;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking Laporan Akhir Reviews...\n";
$count = LaporanAkhirReview::count();
echo "Total Reviews: $count\n";

if ($count > 0) {
    echo "First 5 Reviews:\n";
    $reviews = LaporanAkhirReview::with(['reviewer', 'items'])->take(5)->get();
    foreach ($reviews as $r) {
        echo "ID: {$r->id}, LaporanAkhirID: {$r->laporan_akhir_id}, Jenis: {$r->jenis}, ReviewerID: {$r->reviewer_id}, Status: {$r->status}, Items: " . $r->items->count() . "\n";

        // Check Items content
        if ($r->items->count() > 0) {
            $firstItem = $r->items->first();
            echo "  First Item FormID: {$firstItem->form_penilaian_id}, SubIDStatus: {$firstItem->sub_id_status}, Nilai: {$firstItem->nilai}\n";

            // Check if FormID exists in FormPenilaianLaporanAkhir
            $form = FormPenilaianLaporanAkhir::find($firstItem->form_penilaian_id);
            if ($form) {
                echo "  -> Form Question: {$form->komponen_penilaian}\n";
            } else {
                echo "  -> Form Question NOT FOUND in FormPenilaianLaporanAkhir table!\n";
            }
        }
    }
} else {
    echo "No Reviews Found. Use the App to reproduce the issue.\n";
}

echo "\nChecking FormPenilaianLaporanAkhir...\n";
$forms = FormPenilaianLaporanAkhir::where('jenis', 'penelitian')->get();
echo "Total Forms (Penelitian): " . $forms->count() . "\n";
foreach ($forms as $f) {
    echo "ID: {$f->id}, Komponen: {$f->komponen_penilaian}\n";
}
