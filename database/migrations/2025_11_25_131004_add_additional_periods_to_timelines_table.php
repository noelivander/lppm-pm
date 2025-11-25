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
            // Periode Revisi Proposal
            $table->dateTime('revision_start_date')->nullable()->after('review_end_date');
            $table->dateTime('revision_end_date')->nullable()->after('revision_start_date');
            
            // Periode Laporan Kemajuan - Pengajuan
            $table->dateTime('progress_submission_start_date')->nullable()->after('revision_end_date');
            $table->dateTime('progress_submission_end_date')->nullable()->after('progress_submission_start_date');
            
            // Periode Laporan Kemajuan - Peninjauan/Revisi
            $table->dateTime('progress_review_start_date')->nullable()->after('progress_submission_end_date');
            $table->dateTime('progress_review_end_date')->nullable()->after('progress_review_start_date');
            
            // Periode Laporan Akhir - Pengajuan
            $table->dateTime('final_submission_start_date')->nullable()->after('progress_review_end_date');
            $table->dateTime('final_submission_end_date')->nullable()->after('final_submission_start_date');
            
            // Periode Laporan Akhir - Peninjauan/Revisi
            $table->dateTime('final_review_start_date')->nullable()->after('final_submission_end_date');
            $table->dateTime('final_review_end_date')->nullable()->after('final_review_start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timelines', function (Blueprint $table) {
            $table->dropColumn([
                'revision_start_date',
                'revision_end_date',
                'progress_submission_start_date',
                'progress_submission_end_date',
                'progress_review_start_date',
                'progress_review_end_date',
                'final_submission_start_date',
                'final_submission_end_date',
                'final_review_start_date',
                'final_review_end_date',
            ]);
        });
    }
};
