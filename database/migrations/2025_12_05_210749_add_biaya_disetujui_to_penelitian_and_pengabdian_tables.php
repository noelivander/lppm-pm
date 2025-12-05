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
        // Add biaya_disetujui to penelitian table
        if (Schema::hasTable('penelitian')) {
            Schema::table('penelitian', function (Blueprint $table) {
                if (!Schema::hasColumn('penelitian', 'biaya_disetujui')) {
                    $table->decimal('biaya_disetujui', 15, 2)->nullable()->after('admin_comment');
                }
            });
        }

        // Add biaya_disetujui to pengabdian table
        if (Schema::hasTable('pengabdian')) {
            Schema::table('pengabdian', function (Blueprint $table) {
                if (!Schema::hasColumn('pengabdian', 'biaya_disetujui')) {
                    $table->decimal('biaya_disetujui', 15, 2)->nullable()->after('admin_comment');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('penelitian')) {
            Schema::table('penelitian', function (Blueprint $table) {
                if (Schema::hasColumn('penelitian', 'biaya_disetujui')) {
                    $table->dropColumn('biaya_disetujui');
                }
            });
        }

        if (Schema::hasTable('pengabdian')) {
            Schema::table('pengabdian', function (Blueprint $table) {
                if (Schema::hasColumn('pengabdian', 'biaya_disetujui')) {
                    $table->dropColumn('biaya_disetujui');
                }
            });
        }
    }
};
