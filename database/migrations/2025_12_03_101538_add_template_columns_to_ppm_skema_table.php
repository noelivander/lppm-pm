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
            $table->string('template_laporan_kemajuan')->nullable()->after('is_shown');
            $table->string('template_laporan_keuangan_tahap_1')->nullable()->after('template_laporan_kemajuan');
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
            $table->dropColumn(['template_laporan_kemajuan', 'template_laporan_keuangan_tahap_1']);
        });
    }
};
