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
            if (!Schema::hasColumn('penelitian', 'is_revised')) {
                $table->boolean('is_revised')->default(false)->after('is_draft');
            }
        });

        Schema::table('pengabdian', function (Blueprint $table) {
            if (!Schema::hasColumn('pengabdian', 'is_revised')) {
                $table->boolean('is_revised')->default(false)->after('is_draft');
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
            if (Schema::hasColumn('penelitian', 'is_revised')) {
                $table->dropColumn('is_revised');
            }
        });

        Schema::table('pengabdian', function (Blueprint $table) {
            if (Schema::hasColumn('pengabdian', 'is_revised')) {
                $table->dropColumn('is_revised');
            }
        });
    }
};
