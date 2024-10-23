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
        Schema::create('flags', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('filter');
        });

        Schema::create('dokumen_penting', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('judul');
            $table->string('cover')->nullable();
            $table->string('file')->nullable();
            $table->string('folder')->nullable();
            $table->integer('label')->nullable();
            $table->integer('urutan')->nullable();
            $table->integer('is_shown')->default(0);
            $table->integer('is_lock')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dokumen_penting');
        Schema::dropIfExists('flags');
    }
};
