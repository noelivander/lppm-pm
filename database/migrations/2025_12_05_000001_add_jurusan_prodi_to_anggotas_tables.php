<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('anggotas', function (Blueprint $table) {
            $table->foreignId('jurusan_id')->nullable()->after('telepon')->constrained('jurusan')->nullOnDelete();
            $table->foreignId('program_studi_id')->nullable()->after('jurusan_id')->constrained('program_studi')->nullOnDelete();
        });

        Schema::table('anggota_pengabdians', function (Blueprint $table) {
            $table->foreignId('jurusan_id')->nullable()->after('telepon')->constrained('jurusan')->nullOnDelete();
            $table->foreignId('program_studi_id')->nullable()->after('jurusan_id')->constrained('program_studi')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('anggota_pengabdians', function (Blueprint $table) {
            $table->dropConstrainedForeignId('program_studi_id');
            $table->dropConstrainedForeignId('jurusan_id');
        });

        Schema::table('anggotas', function (Blueprint $table) {
            $table->dropConstrainedForeignId('program_studi_id');
            $table->dropConstrainedForeignId('jurusan_id');
        });
    }
};

