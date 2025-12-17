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
        Schema::create('laporan_akhir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penelitian_id')->nullable()->constrained('penelitian')->onDelete('cascade');
            $table->foreignId('pengabdian_id')->nullable()->constrained('pengabdian')->onDelete('cascade');
            $table->string('laporan_akhir')->nullable();
            $table->string('laporan_keuangan_tahap_2')->nullable();
            $table->string('status')->default('Pending');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Index
            $table->index(['penelitian_id', 'pengabdian_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan_akhir');
    }
};
