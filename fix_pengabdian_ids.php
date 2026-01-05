<?php

use App\Models\Pengabdian;
use App\Models\LaporanAkhir;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DIAGNOSING PENGABDIAN LAPORAN AKHIR ===\n";

// Find Pengabdian proposals that have LaporanAkhir
$proposals = Pengabdian::whereHas('laporanAkhir')->with('laporanAkhir')->get();

foreach ($proposals as $p) {
    echo "Pengabdian Proposal ID: {$p->id} | Judul: {$p->judul}\n";
    foreach ($p->laporanAkhir as $lap) {
        echo "  - Laporan ID: {$lap->id}\n";
        echo "    - Penelitian ID: " . ($lap->penelitian_id ?? 'NULL') . "\n";
        echo "    - Pengabdian ID: " . ($lap->pengabdian_id ?? 'NULL') . "\n";

        if (is_null($lap->pengabdian_id)) {
            echo "    [!] PROBLEM: pengabdian_id is NULL. Fixing...\n";
            $lap->pengabdian_id = $p->id;
            // Ensure penelitian_id is null if it was incorrectly set (optional, but safer)
            // $lap->penelitian_id = null; 
            $lap->save();
            echo "    [+] FIXED. Set pengabdian_id to {$p->id}\n";
        } elseif ($lap->pengabdian_id != $p->id) {
            echo "    [!] MISMATCH: pengabdian_id ({$lap->pengabdian_id}) != Proposal ID ({$p->id})\n";
        }
    }
    echo "----------------------------------------\n";
}

echo "Done.\n";
