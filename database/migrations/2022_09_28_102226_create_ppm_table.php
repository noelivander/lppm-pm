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
        Schema::create('ppm', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bidang_id')->nullable();
            $table->unsignedBigInteger('hibah_id')->nullable();
            $table->unsignedBigInteger('pegawai_id')->nullable();
            $table->unsignedBigInteger('luaran_id')->nullable();
            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->unsignedBigInteger('skema_id')->nullable();


            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->integer('jumlah_dana')->nullable();
            $table->string('tahapan')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bidang_id')->references('id')->on('ppm_fokus_bidang');
            $table->foreign('hibah_id')->references('id')->on('ppm_hibah');
            $table->foreign('luaran_id')->references('id')->on('ppm_luaran');
            $table->foreign('skema_id')->references('id')->on('ppm_skema');
            $table->foreign('jurusan_id')->references('id')->on('jurusan');
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
        Schema::dropIfExists('ppm');
    }
};
