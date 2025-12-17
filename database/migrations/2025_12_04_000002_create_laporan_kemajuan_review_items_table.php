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
        Schema::create('laporan_kemajuan_review_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_kemajuan_review_id')
                ->constrained('laporan_kemajuan_reviews')
                ->onDelete('cascade');
            $table->foreignId('form_penilaian_laporan_kemajuan_id')
                ->constrained('form_penilaian_laporan_kemajuan')
                ->onDelete('cascade');
            $table->foreignId('form_penilaian_laporan_kemajuan_sub_id')
                ->nullable()
                ->constrained('form_penilaian_laporan_kemajuan_sub')
                ->onDelete('cascade');
            $table->text('komentar')->nullable();
            $table->decimal('nilai', 8, 2)->nullable();
            $table->timestamps();

            $table->unique(
                [
                    'laporan_kemajuan_review_id',
                    'form_penilaian_laporan_kemajuan_id',
                    'form_penilaian_laporan_kemajuan_sub_id',
                ],
                'laporan_kemajuan_review_items_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan_kemajuan_review_items');
    }
};