<?php

use App\Models\LaporanAkhir;
use App\Models\LaporanAkhirReview;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$ids = [1, 3, 4];

echo "=== Inspecting Laporan Akhir IDs: " . implode(', ', $ids) . " ===\n";

foreach ($ids as $id) {
    $lap = LaporanAkhir::find($id);
    if ($lap) {
        echo "ID: $id\n";
        echo "  - Created: {$lap->created_at}\n";
        echo "  - Proposal ID: {$lap->penelitian_id} (Penelitian) / {$lap->pengabdian_id} (Pengabdian)\n";
        echo "  - User ID: {$lap->user_id}\n";
        echo "  - Status: {$lap->status}\n";
        echo "  - Reviews Count: " . $lap->reviews()->count() . "\n";
    } else {
        echo "ID: $id NOT FOUND\n";
    }
}
