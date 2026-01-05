<?php

use App\Models\Penelitian;
use App\Models\LaporanAkhir;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== VERIFYING CONTROLLER LOGIC ===\n";

$id = 102; // "Tes Penelitian Setelah Revisi"

echo "Loading Proposal ID: $id\n";

// Mimic Controller Query EXACTLY
$proposal = Penelitian::with([
    'laporanAkhir' => function ($query) {
        $query->orderByDesc('created_at');
    },
    'revisionParent.reviews',
    'reviews',
    'user',
    'anggota',
    'bidangPenelitian',
])
    ->where('id', $id)
    ->where('is_revised', true)
    ->whereHas('laporanAkhir')
    ->first();

if (!$proposal) {
    echo "Proposal NOT FOUND with Controller constraints!\n";
    exit;
}

echo "Found Proposal: {$proposal->judul}\n";

// Test Relationship Access
echo "Accessing ->laporanAkhir (property)...\n";
$report = $proposal->laporanAkhir;

if ($report) {
    echo "Result ID: {$report->id}\n";
    echo "Result Penelitian ID: {$report->penelitian_id}\n";

    if ($report->id == 1)
        echo "FAILED: Returned Laporan 1 (Wrong)!\n";
    elseif ($report->id == 4)
        echo "SUCCESS: Returned Laporan 4 (Correct).\n";
    else
        echo "WARNING: Returned Unknown Laporan {$report->id}\n";
} else {
    echo "Result: NULL\n";
}

// Test Old Logic (Just to see)
echo "Accessing ->laporanAkhir->first() (Old Logic)...\n";
try {
    // Note: On a Model, ->first() works if it's treated as a query builder? 
    // If it's a model instance, ->first() is invalid method? can we call it?
    // If hasOne returns a Model, calling ->first() on it... 
    // Model delegates to new query? Yes.
    $reportOld = $proposal->laporanAkhir->first();
    echo "Old Logic ID: {$reportOld->id}\n";
} catch (\Exception $e) {
    echo "Old Logic Error: " . $e->getMessage() . "\n";
}
