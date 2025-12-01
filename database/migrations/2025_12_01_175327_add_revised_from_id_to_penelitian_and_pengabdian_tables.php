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
        Schema::table('penelitian', function (Blueprint $table) {
            if (!Schema::hasColumn('penelitian', 'revised_from_id')) {
                $table->unsignedBigInteger('revised_from_id')->nullable()->after('id');
                $table->foreign('revised_from_id')->references('id')->on('penelitian')->cascadeOnDelete();
            }
        });

        Schema::table('pengabdian', function (Blueprint $table) {
            if (!Schema::hasColumn('pengabdian', 'revised_from_id')) {
                $table->unsignedBigInteger('revised_from_id')->nullable()->after('id');
                $table->foreign('revised_from_id')->references('id')->on('pengabdian')->cascadeOnDelete();
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
        Schema::table('penelitian', function (Blueprint $table) {
            if (Schema::hasColumn('penelitian', 'revised_from_id')) {
                $table->dropForeign(['revised_from_id']);
                $table->dropColumn('revised_from_id');
            }
        });

        Schema::table('pengabdian', function (Blueprint $table) {
            if (Schema::hasColumn('pengabdian', 'revised_from_id')) {
                $table->dropForeign(['revised_from_id']);
                $table->dropColumn('revised_from_id');
            }
        });
    }
};
