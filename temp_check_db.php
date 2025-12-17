<?php

use App\Models\FormPenilaianLaporanKemajuan;
use App\Models\FormPenilaianLaporanKemajuanSub;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "--- Form Penilaian Laporan Kemajuan ---\n";
$forms = FormPenilaianLaporanKemajuan::where('jenis', 'penelitian')->get();
foreach ($forms as $form) {
    echo "ID: {$form->id}, Komponen: {$form->komponen_penilaian}, Active: {$form->is_active}\n";
    $subs = FormPenilaianLaporanKemajuanSub::where('form_penilaian_id', $form->id)->get();
    echo "  Sub-Components Count: " . $subs->count() . "\n";
    foreach ($subs as $sub) {
        echo "    - Sub ID: {$sub->id}, Keterangan: {$sub->sub_komponen}, Nilai: {$sub->nilai}\n";
    }
}
echo "--------------------------------------\n";
