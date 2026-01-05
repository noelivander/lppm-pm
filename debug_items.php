<?php

use App\Models\LaporanAkhirReview;
use App\Models\LaporanAkhirReviewItem;
use App\Models\FormPenilaianLaporanAkhir;
use App\Models\LaporanAkhir;
use App\Models\Penelitian;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Debugging Items & Links ===\n";

// 1. Check for Orphaned Items
$totalItems = LaporanAkhirReviewItem::count();
$itemsWithValidForm = LaporanAkhirReviewItem::whereHas('formPenilaian')->count();
$orphans = $totalItems - $itemsWithValidForm;

echo "Total Review Items: $totalItems\n";
echo "Items with Valid Form Parent: $itemsWithValidForm\n";
echo "Orphaned Items (Broken Links): $orphans\n";

if ($orphans > 0) {
    echo "WARNING: Found $orphans items pointing to non-existent Form IDs.\n";
    $badItem = LaporanAkhirReviewItem::doesntHave('formPenilaian')->first();
    if ($badItem) {
        echo "Example Bad Item: ID {$badItem->id} points to FormID {$badItem->form_penilaian_id}\n";
    }
}

// 2. Check Laporan Akhir Versions for a sample Proposal
$sampleReview = LaporanAkhirReview::latest()->first();
if ($sampleReview) {
    $lap = LaporanAkhir::find($sampleReview->laporan_akhir_id);
    if ($lap && $lap->penelitian_id) {
        $proposalId = $lap->penelitian_id;
        echo "\n=== Probing Proposal ID: $proposalId ===\n";

        $allLaporans = LaporanAkhir::where('penelitian_id', $proposalId)->get();
        echo "Total Laporan Akhir versions found: " . $allLaporans->count() . "\n";

        foreach ($allLaporans as $l) {
            echo "  [ID: {$l->id}] Created: {$l->created_at} | Status: {$l->status}\n";
            $revCount = LaporanAkhirReview::where('laporan_akhir_id', $l->id)->count();
            echo "    -> Reviews Attached: $revCount\n";

            // Check items for this specific report's reviews
            if ($revCount > 0) {
                $revs = LaporanAkhirReview::where('laporan_akhir_id', $l->id)->get();
                foreach ($revs as $r) {
                    $iCount = $r->items()->count();
                    echo "       - Review ID {$r->id} (Jeins: {$r->jenis}, Status: {$r->status}) has $iCount items.\n";
                }
            }
        }
    }
}
