<?php

use App\Models\LaporanAkhirReview;
use App\Models\LaporanAkhirReviewItem;
use App\Models\FormPenilaianLaporanAkhir;
use App\Models\LaporanAkhir;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$result = [];

// Check Reviews
$count = LaporanAkhirReview::count();
$result['total_reviews'] = $count;
$result['reviews'] = [];

if ($count > 0) {
    $reviews = LaporanAkhirReview::with(['reviewer', 'items'])->take(5)->get();
    foreach ($reviews as $r) {
        $rData = [
            'id' => $r->id,
            'laporan_akhir_id' => $r->laporan_akhir_id,
            'reviewer_id' => $r->reviewer_id,
            'status' => $r->status,
            'items_count' => $r->items->count(),
            'item_sample' => []
        ];

        if ($r->items->count() > 0) {
            $firstItem = $r->items->first();
            $rData['item_sample'] = [
                'form_penilaian_id' => $firstItem->form_penilaian_id,
                'sub_id_status' => $firstItem->sub_id_status,
                'nilai' => $firstItem->nilai
            ];

            $form = FormPenilaianLaporanAkhir::find($firstItem->form_penilaian_id);
            $rData['item_sample']['form_question'] = $form ? $form->komponen_penilaian : "NOT FOUND (ID: $firstItem->form_penilaian_id)";
        }
        $result['reviews'][] = $rData;
    }
}

// Check FormPenilaianLaporanAkhir
$forms = FormPenilaianLaporanAkhir::where('jenis', 'penelitian')->with('subKomponen')->get();
$result['total_forms'] = $forms->count();
$result['forms'] = [];
foreach ($forms as $f) {
    $result['forms'][] = [
        'id' => $f->id,
        'komponen' => $f->komponen_penilaian,
        'sub_count' => $f->subKomponen->count(),
        'sub_sample' => $f->subKomponen->first() ? $f->subKomponen->first()->keterangan : 'N/A'
    ];
}

echo json_encode($result, JSON_PRETTY_PRINT);
