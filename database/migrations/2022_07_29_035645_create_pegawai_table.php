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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->constrained('users')->unique()->nullable();
            $table->unsignedBigInteger('program_studi_id')->nullable();
            $table->unsignedBigInteger('jabatan_id')->nullable();
            $table->unsignedBigInteger('pangkat_golongan_ruang_id')->nullable();
            $table->string('nama');
            $table->string('email')->nullable();
            $table->string('foto')->nullable();
            $table->string('nip')->nullable()->unique();
            $table->integer('is_shown')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('program_studi_id')->references('id')->on('program_studi');
            $table->foreign('jabatan_id')->references('id')->on('jabatan');
            $table->foreign('pangkat_golongan_ruang_id')->references('id')->on('pangkat_golongan_ruang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawai');
    }
};
