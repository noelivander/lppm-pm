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
        Schema::create('rab_pengabdians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengabdian_id')->constrained('pengabdian')->onDelete('cascade');
            $table->string('kelompok'); // Honorarium, Perjalanan, Operasional, Peralatan, Lainnya
            $table->string('komponen'); // SDM, Material, Jasa, Transportasi, Lainnya
            $table->string('item');
            $table->string('satuan');
            $table->integer('volume');
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('total', 15, 2);
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
        Schema::dropIfExists('rab_pengabdians');
    }
};
