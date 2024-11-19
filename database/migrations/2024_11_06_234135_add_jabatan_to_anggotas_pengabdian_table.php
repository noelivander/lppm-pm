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
        Schema::table('anggota_pengabdians', function (Blueprint $table) {
            $table->string('nidn')->nullable()->after('nama'); // menambahkan kolom nidn setelah kolom nama
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anggota_pengabdians', function (Blueprint $table) {
            $table->dropColumn('nidn');
        });
    }
};
