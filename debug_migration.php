<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

echo "Debug Migration...\n";

try {
    if (Schema::hasTable('laporan_akhir_review_items')) {
        echo "Table exists. Dropping...\n";
        Schema::drop('laporan_akhir_review_items');
    }

    echo "Creating table...\n";
    Schema::create('laporan_akhir_review_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('laporan_akhir_review_id')->constrained('laporan_akhir_reviews')->onDelete('cascade');
        $table->foreignId('form_penilaian_id')->constrained('form_penilaian_laporan_akhirs')->onDelete('cascade');

        $table->unsignedBigInteger('sub_id_status')->nullable();
        $table->foreign('sub_id_status', 'lari_sub_status_fk')->references('id')->on('form_penilaian_laporan_akhir_subs');

        $table->unsignedBigInteger('sub_id_bobot')->nullable();
        $table->foreign('sub_id_bobot', 'lari_sub_bobot_fk')->references('id')->on('form_penilaian_laporan_akhir_subs');

        $table->unsignedBigInteger('sub_id')->nullable();
        $table->foreign('sub_id', 'lari_sub_fk')->references('id')->on('form_penilaian_laporan_akhir_subs');

        $table->decimal('nilai', 8, 2)->default(0);
        $table->text('catatan')->nullable();
        $table->timestamps();
    });
    echo "Success!\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
