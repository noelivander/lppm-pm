<?php

use App\Models\Pengabdian;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$proposal = Pengabdian::where('judul', 'like', '%Tes Proposal Pengabdian Rev%')->first();

if ($proposal) {
    echo "Updating Proposal ID: " . $proposal->id . "\n";
    // Set to 5,000,000 for testing or copy from biaya_diusulkan if logically sound
    $proposal->biaya_disetujui = 5000000;
    $proposal->save();
    echo "Biaya Disetujui updated to: " . $proposal->biaya_disetujui . "\n";
} else {
    echo "Proposal not found.\n";
}
