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
        Schema::table('timelines', function (Blueprint $table) {
            if (!Schema::hasColumn('timelines', 'revision_review_start_date')) {
                $table->dateTime('revision_review_start_date')->nullable()->after('revision_end_date');
            }
            if (!Schema::hasColumn('timelines', 'revision_review_end_date')) {
                $table->dateTime('revision_review_end_date')->nullable()->after('revision_review_start_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timelines', function (Blueprint $table) {
            if (Schema::hasColumn('timelines', 'revision_review_start_date')) {
                $table->dropColumn('revision_review_start_date');
            }
            if (Schema::hasColumn('timelines', 'revision_review_end_date')) {
                $table->dropColumn('revision_review_end_date');
            }
        });
    }
};
