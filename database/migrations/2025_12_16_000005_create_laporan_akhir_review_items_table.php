<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Table created manually via debug script due to foreign key issues.
        // This empty block satisfies artisan migrate.
        if (!Schema::hasTable('laporan_akhir_review_items')) {
            Schema::create('laporan_akhir_review_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('laporan_akhir_review_id')->constrained('laporan_akhir_reviews')->onDelete('cascade');
                $table->foreignId('form_penilaian_id')->constrained('form_penilaian_laporan_akhirs')->onDelete('cascade');

                // Manual FK definition to avoid long name issues
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
            // Schema::create(...) code was here
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan_akhir_review_items');
    }
};
