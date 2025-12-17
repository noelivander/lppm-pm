<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Using raw SQL to avoid doctrine/dbal dependency issues
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE form_penilaian_laporan_akhir_subs MODIFY keterangan TEXT');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE form_penilaian_laporan_akhir_subs MODIFY keterangan VARCHAR(255)');
    }
};
