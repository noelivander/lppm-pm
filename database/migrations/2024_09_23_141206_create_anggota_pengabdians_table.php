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
        Schema::create('anggota_pengabdians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengabdian_id')->constrained()->onDelete('cascade');
            $table->string('nama');
            $table->string('peran'); // 'Dosen' atau 'Mahasiswa'
            $table->string('email');
            $table->string('telepon');
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
        Schema::dropIfExists('anggota_pengabdians');
    }
};
