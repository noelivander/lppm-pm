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
        // Add admin fields to penelitian table
        if (Schema::hasTable('penelitian')) {
            Schema::table('penelitian', function (Blueprint $table) {
                if (!Schema::hasColumn('penelitian', 'admin_status')) {
                    $table->enum('admin_status', ['pending', 'approved', 'rejected'])->nullable()->after('status');
                }
                if (!Schema::hasColumn('penelitian', 'admin_comment')) {
                    $table->text('admin_comment')->nullable()->after('admin_status');
                }
            });
        }

        // Add admin fields to pengabdian table
        if (Schema::hasTable('pengabdian')) {
            Schema::table('pengabdian', function (Blueprint $table) {
                if (!Schema::hasColumn('pengabdian', 'admin_status')) {
                    $table->enum('admin_status', ['pending', 'approved', 'rejected'])->nullable()->after('status');
                }
                if (!Schema::hasColumn('pengabdian', 'admin_comment')) {
                    $table->text('admin_comment')->nullable()->after('admin_status');
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
                if (Schema::hasColumn('penelitian', 'admin_comment')) {
                    $table->dropColumn('admin_comment');
                }
                if (Schema::hasColumn('penelitian', 'admin_status')) {
                    $table->dropColumn('admin_status');
                }
            });
        }

        if (Schema::hasTable('pengabdian')) {
            Schema::table('pengabdian', function (Blueprint $table) {
                if (Schema::hasColumn('pengabdian', 'admin_comment')) {
                    $table->dropColumn('admin_comment');
                }
                if (Schema::hasColumn('pengabdian', 'admin_status')) {
                    $table->dropColumn('admin_status');
                }
            });
        }
    }
};
