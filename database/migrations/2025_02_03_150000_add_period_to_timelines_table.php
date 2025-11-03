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
            $table->string('period')->after('id'); // e.g., "2025/2026"
            $table->string('title')->after('period'); // e.g., "Proposal Submission", "Report Submission"
            $table->text('description')->nullable()->after('title');
            $table->boolean('is_active')->default(true)->after('description');
            $table->integer('order')->default(0)->after('is_active'); // For sorting
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timelines', function (Blueprint $table) {
            $table->dropColumn(['period', 'title', 'description', 'is_active', 'order']);
        });
    }
};
