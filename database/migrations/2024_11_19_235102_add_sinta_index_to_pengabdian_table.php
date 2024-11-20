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
        Schema::table('pengabdians', function (Blueprint $table) {
            $table->string('sinta_index')->nullable(); // Kolom untuk menyimpan level Sinta
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengabdians', function (Blueprint $table) {
            //
        });
    }
};
