<?php

use Illuminate\Support\Facades\DB;
use App\Models\LaporanAkhirReview;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DUMPING ALL LAPORAN AKHIR REVIEWS ===\n";

$reviews = LaporanAkhirReview::all();

echo "Total Reviews: " . $reviews->count() . "\n";

foreach ($reviews as $r) {
    echo "Review ID: {$r->id}\n";
    echo "  - Laporan ID: {$r->laporan_akhir_id}\n";
    echo "  - Reviewer ID: {$r->reviewer_id}\n";
    echo "  - Jenis: {$r->jenis}\n";
    echo "  - Status: {$r->status}\n";
    echo "  - Items Count: " . $r->items()->count() . "\n";
    echo "----------------------------------------\n";
}
