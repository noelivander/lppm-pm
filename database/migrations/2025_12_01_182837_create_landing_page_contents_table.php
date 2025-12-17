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
    // Tambahkan pengecekan ini
    if (!Schema::hasTable('landing_page_contents')) {
        Schema::create('landing_page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('section')->nullable();
            $table->longText('value')->nullable(); // Sesuaikan dengan kodingan asli Anda
            $table->timestamps();
        });
    }
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('landing_page_contents');
    }
};
