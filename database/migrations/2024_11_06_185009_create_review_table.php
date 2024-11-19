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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penelitian_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('pengabdian_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('judul_kegiatan')->nullable();
            $table->string('ketua_tim')->nullable();
            $table->string('nidn')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('program_studi')->nullable();
            $table->string('jangka_waktu')->nullable();
            $table->decimal('biaya_usulan', 15, 2)->nullable();
            $table->text('disarankan')->nullable();
            $table->string('sumber_dana_ith')->nullable();
            $table->string('sumber_dana_lainnya')->nullable();
            $table->integer('skor_1')->nullable();
            $table->integer('skor_2')->nullable();
            $table->integer('skor_3')->nullable();
            $table->integer('skor_4')->nullable();
            $table->integer('skor_5')->nullable();
            $table->integer('skor_6')->nullable();
            $table->text('komentar')->nullable();
            $table->enum('type', ['penelitian', 'pengabdian']);
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
        Schema::dropIfExists('reviews');
    }
};
