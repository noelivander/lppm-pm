<?php

use Illuminate\Support\Facades\DB;
use App\Models\LaporanAkhir;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== RESETTING LAPORAN AKHIR REVIEWS ===\n";

DB::statement('SET FOREIGN_KEY_CHECKS=0;');

echo "Truncating laporan_akhir_review_items...\n";
DB::table('laporan_akhir_review_items')->truncate();

echo "Truncating laporan_akhir_reviews...\n";
DB::table('laporan_akhir_reviews')->truncate();

DB::statement('SET FOREIGN_KEY_CHECKS=1;');

// Reset Laporan Akhir Status to 'Pending' (Optional, but good for consistency)
echo "Resetting Laporan Akhir Status to 'Pending'...\n";
LaporanAkhir::where('status', '!=', 'Pending')->update(['status' => 'Pending']);

echo "DONE.\n";
