<?php

use App\Models\LaporanAkhir;
use App\Models\Penelitian;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DUMPING LAPORAN AKHIR DATA ===\n";

$laporans = LaporanAkhir::all();
foreach ($laporans as $l) {
    echo "Laporan ID: {$l->id} (Created: {$l->created_at})\n";
    echo "  - Penelitian ID: " . ($l->penelitian_id ?? 'NULL') . "\n";
    echo "  - Pengabdian ID: " . ($l->pengabdian_id ?? 'NULL') . "\n";

    // Check Inverse
    if ($l->penelitian_id) {
        $p = Penelitian::find($l->penelitian_id);
        if ($p)
            echo "  - [Check] Prop {$p->id} exists. Title: " . substr($p->judul, 0, 20) . "...\n";
        else
            echo "  - [Check] Prop {$l->penelitian_id} NOT FOUND.\n";
    }
    echo "---------------------------------\n";
}
