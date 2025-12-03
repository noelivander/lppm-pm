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
        Schema::create('laporan_kemajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penelitian_id')->nullable()->constrained('penelitian')->onDelete('cascade');
            $table->foreignId('pengabdian_id')->nullable()->constrained('pengabdian')->onDelete('cascade');
            $table->string('laporan_kemajuan')->nullable();
            $table->string('laporan_keuangan_tahap_1')->nullable();
            $table->integer('tahap')->default(1);
            $table->string('status')->default('Pending');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Ensure only one of penelitian_id or pengabdian_id is set
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
        Schema::dropIfExists('laporan_kemajuan');
    }
};
