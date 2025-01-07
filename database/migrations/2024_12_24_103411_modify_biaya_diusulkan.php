<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk menggunakan DB

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Ubah kolom 'biaya_diusulkan' menjadi tipe TEXT
        DB::statement('ALTER TABLE pengabdians MODIFY COLUMN biaya_diusulkan TEXT');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Kembalikan kolom 'biaya_diusulkan' ke tipe DECIMAL
        DB::statement('ALTER TABLE pengabdians MODIFY COLUMN biaya_diusulkan DECIMAL(15, 2)');
    }
};
