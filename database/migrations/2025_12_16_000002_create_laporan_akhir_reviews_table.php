<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_akhir_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_akhir_id')->constrained('laporan_akhir')->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');
            $table->enum('jenis', ['penelitian', 'pengabdian']);
            $table->text('catatan_umum')->nullable();
            $table->string('status')->default('Pending'); // Pending, Approved
            $table->timestamp('submitted_at')->nullable();
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
        Schema::dropIfExists('laporan_akhir_reviews');
    }
};
