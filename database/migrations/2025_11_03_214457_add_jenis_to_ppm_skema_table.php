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
        Schema::table('ppm_skema', function (Blueprint $table) {
            if (!Schema::hasColumn('ppm_skema', 'jenis')) {
                $table->enum('jenis', ['penelitian', 'pengabdian'])->after('perihal')->default('penelitian');
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
        Schema::table('ppm_skema', function (Blueprint $table) {
            if (Schema::hasColumn('ppm_skema', 'jenis')) {
                $table->dropColumn('jenis');
            }
        });
    }
};
