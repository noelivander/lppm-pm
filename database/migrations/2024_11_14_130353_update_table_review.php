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
        Schema::table('reviews', function (Blueprint $table) {
            // Menambahkan kolom baru
            $table->string('jabatan')->nullable();
            $table->string('scopus')->nullable();
            $table->string('anggota')->nullable();

            // Menghapus kolom yang tidak diperlukan
            $table->dropColumn([
                'skor_6',
                'jurusan',
                'program_studi',
                'jangka_waktu',
                'sumber_dana_ith',
                'sumber_dana_lainnya'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Menghapus kolom yang baru ditambahkan
            $table->dropColumn(['jabatan', 'scopus', 'anggota']);

            // Menambahkan kembali kolom yang dihapus
            $table->integer('skor_6')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('program_studi')->nullable();
            $table->string('jangka_waktu')->nullable();
            $table->string('sumber_dana_ith')->nullable();
            $table->string('sumber_dana_lainnya')->nullable();
        });
    }
};
