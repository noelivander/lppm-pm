<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_penilaian_laporan_kemajuan', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', ['penelitian', 'pengabdian']);
            $table->text('komponen_penilaian');
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
        Schema::dropIfExists('form_penilaian_laporan_kemajuan');
    }
};
