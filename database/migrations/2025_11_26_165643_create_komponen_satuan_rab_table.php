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
        Schema::create('komponen_satuan_rab', function (Blueprint $table) {
            $table->id();
            $table->foreignId('komponen_rab_id')->constrained('komponen_rab')->onDelete('cascade');
            $table->foreignId('satuan_rab_id')->constrained('satuan_rab')->onDelete('cascade');
            $table->timestamps();
            
            // Ensure unique combination
            $table->unique(['komponen_rab_id', 'satuan_rab_id'], 'komponen_satuan_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('komponen_satuan_rab');
    }
};
