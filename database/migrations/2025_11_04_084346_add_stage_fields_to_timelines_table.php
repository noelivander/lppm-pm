<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('timelines', function (Blueprint $table) {
            // Add revision dates for proposal revision
            $table->dateTime('revisi_proposal_start_date')->nullable()->after('review_end_date');
            $table->dateTime('revisi_proposal_end_date')->nullable()->after('revisi_proposal_start_date');
            
            // Add dates for progress report
            $table->dateTime('laporan_kemajuan_start_date')->nullable()->after('revisi_proposal_end_date');
            $table->dateTime('laporan_kemajuan_end_date')->nullable()->after('laporan_kemajuan_start_date');
            $table->dateTime('laporan_kemajuan_review_start_date')->nullable()->after('laporan_kemajuan_end_date');
            $table->dateTime('laporan_kemajuan_review_end_date')->nullable()->after('laporan_kemajuan_review_start_date');
            
            // Add dates for final report
            $table->dateTime('laporan_akhir_start_date')->nullable()->after('laporan_kemajuan_review_end_date');
            $table->dateTime('laporan_akhir_end_date')->nullable()->after('laporan_akhir_start_date');
            $table->dateTime('laporan_akhir_review_start_date')->nullable()->after('laporan_akhir_end_date');
            $table->dateTime('laporan_akhir_review_end_date')->nullable()->after('laporan_akhir_review_start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timelines', function (Blueprint $table) {
            $table->dropColumn([
                'revisi_proposal_start_date',
                'revisi_proposal_end_date',
                'laporan_kemajuan_start_date',
                'laporan_kemajuan_end_date',
                'laporan_kemajuan_review_start_date',
                'laporan_kemajuan_review_end_date',
                'laporan_akhir_start_date',
                'laporan_akhir_end_date',
                'laporan_akhir_review_start_date',
                'laporan_akhir_review_end_date'
            ]);
        });
    }
};
