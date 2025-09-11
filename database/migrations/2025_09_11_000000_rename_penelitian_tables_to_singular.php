<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop foreign keys that reference penelitians and pengabdians first
        Schema::table('anggotas', function (Blueprint $table) {
            if (Schema::hasColumn('anggotas', 'penelitian_id')) {
                $table->dropForeign('anggotas_penelitian_id_foreign');
            }
        });

        Schema::table('reviews', function (Blueprint $table) {
            if (Schema::hasColumn('reviews', 'penelitian_id')) {
                $table->dropForeign('reviews_penelitian_id_foreign');
            }
            if (Schema::hasColumn('reviews', 'pengabdian_id')) {
                $table->dropForeign('reviews_pengabdian_id_foreign');
            }
        });

        Schema::table('anggota_pengabdians', function (Blueprint $table) {
            if (Schema::hasColumn('anggota_pengabdians', 'pengabdian_id')) {
                $table->dropForeign('anggota_pengabdians_pengabdian_id_foreign');
            }
        });

        // Rename the main tables to singular
        if (Schema::hasTable('penelitians')) {
            Schema::rename('penelitians', 'penelitian');
        }
        if (Schema::hasTable('pengabdians')) {
            Schema::rename('pengabdians', 'pengabdian');
        }

        // Recreate foreign keys referencing the new singular table names
        Schema::table('anggotas', function (Blueprint $table) {
            if (Schema::hasColumn('anggotas', 'penelitian_id')) {
                $table->foreign('penelitian_id')->references('id')->on('penelitian')->onDelete('cascade');
            }
        });

        Schema::table('reviews', function (Blueprint $table) {
            if (Schema::hasColumn('reviews', 'penelitian_id')) {
                $table->foreign('penelitian_id')->references('id')->on('penelitian')->onDelete('cascade');
            }
            if (Schema::hasColumn('reviews', 'pengabdian_id')) {
                $table->foreign('pengabdian_id')->references('id')->on('pengabdian')->onDelete('cascade');
            }
        });

        Schema::table('anggota_pengabdians', function (Blueprint $table) {
            if (Schema::hasColumn('anggota_pengabdians', 'pengabdian_id')) {
                $table->foreign('pengabdian_id')->references('id')->on('pengabdian')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        // Drop foreign keys to singular tables
        Schema::table('anggotas', function (Blueprint $table) {
            if (Schema::hasColumn('anggotas', 'penelitian_id')) {
                $table->dropForeign(['penelitian_id']);
            }
        });
        Schema::table('reviews', function (Blueprint $table) {
            if (Schema::hasColumn('reviews', 'penelitian_id')) {
                $table->dropForeign(['penelitian_id']);
            }
            if (Schema::hasColumn('reviews', 'pengabdian_id')) {
                $table->dropForeign(['pengabdian_id']);
            }
        });
        Schema::table('anggota_pengabdians', function (Blueprint $table) {
            if (Schema::hasColumn('anggota_pengabdians', 'pengabdian_id')) {
                $table->dropForeign(['pengabdian_id']);
            }
        });

        // Rename tables back to plural
        if (Schema::hasTable('penelitian')) {
            Schema::rename('penelitian', 'penelitians');
        }
        if (Schema::hasTable('pengabdian')) {
            Schema::rename('pengabdian', 'pengabdians');
        }

        // Recreate original foreign keys
        Schema::table('anggotas', function (Blueprint $table) {
            if (Schema::hasColumn('anggotas', 'penelitian_id')) {
                $table->foreign('penelitian_id')->references('id')->on('penelitians')->onDelete('cascade');
            }
        });
        Schema::table('reviews', function (Blueprint $table) {
            if (Schema::hasColumn('reviews', 'penelitian_id')) {
                $table->foreign('penelitian_id')->references('id')->on('penelitians')->onDelete('cascade');
            }
            if (Schema::hasColumn('reviews', 'pengabdian_id')) {
                $table->foreign('pengabdian_id')->references('id')->on('pengabdians')->onDelete('cascade');
            }
        });
        Schema::table('anggota_pengabdians', function (Blueprint $table) {
            if (Schema::hasColumn('anggota_pengabdians', 'pengabdian_id')) {
                $table->foreign('pengabdian_id')->references('id')->on('pengabdians')->onDelete('cascade');
            }
        });
    }
};


