<?php

use App\Models\FormPenilaianLaporanAkhir;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CHECKING PENELITIAN FORM SCORES ===\n";

$forms = FormPenilaianLaporanAkhir::where('jenis', 'penelitian')->with('subKomponen')->get();

foreach ($forms as $form) {
    echo "Component: {$form->komponen_penilaian} (ID: {$form->id})\n";
    foreach ($form->subKomponen as $sub) {
        echo "  - Sub: {$sub->keterangan} (Type: {$sub->tipe}, Skor: {$sub->skor})\n";
    }
    echo "---------------------------------\n";
}
