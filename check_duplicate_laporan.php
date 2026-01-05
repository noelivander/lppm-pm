<?php

use App\Models\Penelitian;
use App\Models\LaporanAkhir;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CHECKING FOR DUPLICATE LAPORAN AKHIR ===\n";

$proposals = Penelitian::whereHas('laporanAkhir')->get();

foreach ($proposals as $p) {
    $count = LaporanAkhir::where('penelitian_id', $p->id)->count();
    if ($count > 1) {
        echo "[!] DUPLICATE DETECTED for Proposal ID: {$p->id} ({$p->judul})\n";
        echo "    Count: {$count}\n";
        $laporans = LaporanAkhir::where('penelitian_id', $p->id)->get();
        foreach ($laporans as $lap) {
            echo "    - Laporan ID: {$lap->id} (Created: {$lap->created_at})\n";
        }
    }
}
echo "Done.\n";
