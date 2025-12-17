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
    echo "ID: " . $proposal->id . "\n";
    echo "Judul: " . $proposal->judul . "\n";
    echo "Biaya Diusulkan: " . $proposal->biaya_diusulkan . "\n";
    echo "Biaya Disetujui: " . $proposal->biaya_disetujui . "\n";
} else {
    echo "Proposal not found.\n";
}
