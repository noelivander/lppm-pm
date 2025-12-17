<?php

use App\Models\Pengabdian;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$proposals = Pengabdian::where('judul', 'like', '%Tes Proposal Pengabdian Rev%')->get();

foreach ($proposals as $p) {
    echo "ID: " . $p->id .
        " | Revised: " . ($p->is_revised ? 'Yes' : 'No') .
        " | ParentID: " . ($p->revision_parent_id ?? 'NULL') .
        " | Biaya Disetujui: " . $p->biaya_disetujui . "\n";
}
