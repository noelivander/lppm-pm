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
        Schema::create('laporan_kemajuan_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_kemajuan_id')->constrained('laporan_kemajuan')->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');
            $table->enum('jenis', ['penelitian', 'pengabdian']);
            $table->enum('status', ['pending', 'draft', 'selesai'])->default('pending');
            $table->text('catatan_umum')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->unique(['laporan_kemajuan_id', 'reviewer_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan_kemajuan_reviews');
    }
};

