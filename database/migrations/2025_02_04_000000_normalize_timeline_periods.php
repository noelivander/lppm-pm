<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $timelines = DB::table('timelines')->select('id', 'period')->get();

        foreach ($timelines as $timeline) {
            if (empty($timeline->period)) {
                continue;
            }

            if (preg_match('/\d{4}/', $timeline->period, $matches)) {
                DB::table('timelines')
                    ->where('id', $timeline->id)
                    ->update(['period' => $matches[0]]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op: original multi-year values cannot be restored reliably
    }
};

