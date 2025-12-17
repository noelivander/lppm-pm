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
        Schema::create('form_penilaian_laporan_akhir_subs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_penilaian_laporan_akhir_id')
                ->constrained('form_penilaian_laporan_akhirs', 'fpla_subs_fpla_id_foreign')
                ->onDelete('cascade');
            $table->string('keterangan'); // Label
            $table->decimal('skor', 5, 2)->default(0); // Value (80 or 100 or 10)
            $table->string('tipe')->default('standard'); // 'standard', 'status', 'bobot_item'
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_penilaian_laporan_akhir_subs');
    }
};
