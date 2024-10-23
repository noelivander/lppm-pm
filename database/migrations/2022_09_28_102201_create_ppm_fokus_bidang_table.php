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
        Schema::create('ppm_fokus_bidang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pegawai_id')->nullable();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('singkatan')->nullable();
            $table->string('cover')->nullable();
            $table->string('icon')->nullable();
            $table->string('perihal')->nullable();
            $table->string('deskripsi_file')->nullable();
            $table->integer('is_shown')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pegawai_id')->references('id')->on('pegawai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ppm_fokus_bidang');
    }
};
