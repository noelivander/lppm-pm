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
        Schema::table('ppm_luaran', function (Blueprint $table) {
            $table->enum('jenis', ['penelitian', 'pengabdian'])->after('perihal')->default('penelitian');
            $table->enum('kategori', ['wajib', 'tambahan'])->after('jenis')->default('wajib');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppm_luaran', function (Blueprint $table) {
            $table->dropColumn(['jenis', 'kategori']);
            $table->dropTimestamps();
        });
    }
};
