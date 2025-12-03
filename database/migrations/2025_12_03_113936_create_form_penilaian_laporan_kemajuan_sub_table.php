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
        Schema::create('form_penilaian_laporan_kemajuan_sub', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_penilaian_id');
            $table->text('sub_komponen');
            $table->decimal('nilai', 5, 2)->default(0);
            $table->integer('urutan')->default(0);
            $table->timestamps();
            
            $table->foreign('form_penilaian_id', 'fplk_sub_fk')
                  ->references('id')
                  ->on('form_penilaian_laporan_kemajuan')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_penilaian_laporan_kemajuan_sub');
    }
};
