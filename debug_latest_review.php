<?php

use App\Models\LaporanAkhirReview;
use App\Models\LaporanAkhir;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== LATEST 5 REVIEWS ===\n";

$reviews = LaporanAkhirReview::orderByDesc('updated_at')->take(5)->get();

foreach ($reviews as $r) {
    echo "ID: {$r->id}\n";
    echo "  - Reviewer ID: {$r->reviewer_id}\n";
    echo "  - Laporan ID: {$r->laporan_akhir_id}\n";
    echo "  - Jenis: {$r->jenis}\n";
    echo "  - Status: '{$r->status}'\n";
    echo "  - Updated: {$r->updated_at}\n";

    $lap = LaporanAkhir::find($r->laporan_akhir_id);
    if ($lap) {
        echo "  - [Laporan] Proposal ID: " . ($lap->penelitian_id ? "Pen-{$lap->penelitian_id}" : "Peng-{$lap->pengabdian_id}") . "\n";
    }
}
