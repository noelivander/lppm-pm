<?php

use App\Models\LaporanAkhirReview;
use App\Models\FormPenilaianLaporanAkhir;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$reviews = LaporanAkhirReview::with(['reviewer'])->get();
$data = [];

foreach ($reviews as $r) {
    echo "ID: " . $r->id . " | Jenis: " . ($r->jenis ?? 'NULL') . " | Status: " . $r->status . "\n";
}

$forms = FormPenilaianLaporanAkhir::where('jenis', 'penelitian')->get();
echo "Forms Count: " . $forms->count() . "\n";
