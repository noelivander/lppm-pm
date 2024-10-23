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
        Schema::create('ppm_hibah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_hibah_id');
            $table->string('nama');
            $table->string('singkatan')->nullable();
            $table->string('perihal')->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('is_shown')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('jenis_hibah_id')->references('id')->on('ppm_jenis_skema');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ppm_hibah');
    }
};