<?php

use App\Models\Penelitian;
use App\Models\Pengabdian;
use App\Models\LaporanAkhir;
use App\Models\LaporanAkhirReview;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Helper to inspect proposal
function inspectProposal($type, $id)
{
    echo "\n=== Inspecting $type ID: $id ===\n";

    $model = $type === 'Penelitian' ? Penelitian::find($id) : Pengabdian::find($id);
    if (!$model) {
        echo "Proposal Not Found!\n";
        return;
    }

    echo "Judul: " . substr($model->judul, 0, 50) . "...\n";

    // Get ALL Laporan Akhir for this proposal
    $laporans = LaporanAkhir::where(strtolower($type) . '_id', $id)->get();
    echo "Found " . $laporans->count() . " Laporan Akhir records.\n";

    foreach ($laporans as $lap) {
        echo "  [Laporan ID: {$lap->id}] Created: {$lap->created_at} | Status: {$lap->status}\n";

        // Count Reviews directly via Query (ignoring relationship scope for a moment)
        $reviews = LaporanAkhirReview::where('laporan_akhir_id', $lap->id)->get();
        echo "    -> Direct DB Reviews Found: " . $reviews->count() . "\n";
        foreach ($reviews as $r) {
            echo "       - ReviewID: {$r->id} | Reviewer: {$r->reviewer_id} | Jenis: {$r->jenis} | Status: {$r->status}\n";
        }

        // Count via Relationship
        $lap->load('reviews');
        echo "    -> Via Eloquent Relationship Found: " . $lap->reviews->count() . "\n";
    }
}

// Find a proposal that actually has reviews
$review = LaporanAkhirReview::latest()->first();
if ($review) {
    echo "Found latest review ID: {$review->id} (LaporanID: {$review->laporan_akhir_id})\n";
    $lap = LaporanAkhir::find($review->laporan_akhir_id);
    if ($lap) {
        if ($lap->penelitian_id) {
            inspectProposal('Penelitian', $lap->penelitian_id);
        } elseif ($lap->pengabdian_id) {
            inspectProposal('Pengabdian', $lap->pengabdian_id);
        } else {
            echo "Laporan Orphaned (No parent ID)\n";
        }
    } else {
        echo "Laporan Akhir Not Found for this review!\n";
    }
} else {
    echo "No reviews found in DB.\n";
}
