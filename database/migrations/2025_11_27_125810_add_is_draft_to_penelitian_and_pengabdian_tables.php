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
        // Check if table exists before modifying
        if (Schema::hasTable('penelitians')) {
            Schema::table('penelitians', function (Blueprint $table) {
                if (!Schema::hasColumn('penelitians', 'is_draft')) {
                    $table->boolean('is_draft')->default(false)->after('status');
                }
            });
        }
        
        if (Schema::hasTable('penelitian')) {
            Schema::table('penelitian', function (Blueprint $table) {
                if (!Schema::hasColumn('penelitian', 'is_draft')) {
                    $table->boolean('is_draft')->default(false)->after('status');
                }
            });
        }

        if (Schema::hasTable('pengabdian')) {
            Schema::table('pengabdian', function (Blueprint $table) {
                if (!Schema::hasColumn('pengabdian', 'is_draft')) {
                    $table->boolean('is_draft')->default(false)->after('status');
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
        if (Schema::hasTable('penelitians') && Schema::hasColumn('penelitians', 'is_draft')) {
            Schema::table('penelitians', function (Blueprint $table) {
                $table->dropColumn('is_draft');
            });
        }
        
        if (Schema::hasTable('penelitian') && Schema::hasColumn('penelitian', 'is_draft')) {
            Schema::table('penelitian', function (Blueprint $table) {
                $table->dropColumn('is_draft');
            });
        }

        if (Schema::hasTable('pengabdian') && Schema::hasColumn('pengabdian', 'is_draft')) {
            Schema::table('pengabdian', function (Blueprint $table) {
                $table->dropColumn('is_draft');
            });
        }
    }
};
