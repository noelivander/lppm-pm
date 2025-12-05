<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penelitian', function (Blueprint $table) {
            $table->string('bidang_penelitian_nama')->nullable()->after('bidang_penelitian_id');
        });

        Schema::table('anggotas', function (Blueprint $table) {
            $table->string('jurusan_nama')->nullable()->after('jurusan_id');
            $table->string('program_studi_nama')->nullable()->after('program_studi_id');
        });

        Schema::table('anggota_pengabdians', function (Blueprint $table) {
            $table->string('jurusan_nama')->nullable()->after('jurusan_id');
            $table->string('program_studi_nama')->nullable()->after('program_studi_id');
        });

        // Backfill nama fields so existing relasi tetap terbaca tanpa join
        DB::statement("
            UPDATE penelitian p
            JOIN bidang_penelitian b ON b.id = p.bidang_penelitian_id
            SET p.bidang_penelitian_nama = b.nama
        ");

        DB::statement("
            UPDATE anggotas a
            LEFT JOIN jurusan j ON j.id = a.jurusan_id
            LEFT JOIN program_studi ps ON ps.id = a.program_studi_id
            SET a.jurusan_nama = j.nama,
                a.program_studi_nama = ps.nama
        ");

        DB::statement("
            UPDATE anggota_pengabdians a
            LEFT JOIN jurusan j ON j.id = a.jurusan_id
            LEFT JOIN program_studi ps ON ps.id = a.program_studi_id
            SET a.jurusan_nama = j.nama,
                a.program_studi_nama = ps.nama
        ");
    }

    public function down(): void
    {
        Schema::table('anggota_pengabdians', function (Blueprint $table) {
            $table->dropColumn(['program_studi_nama', 'jurusan_nama']);
        });

        Schema::table('anggotas', function (Blueprint $table) {
            $table->dropColumn(['program_studi_nama', 'jurusan_nama']);
        });

        Schema::table('penelitian', function (Blueprint $table) {
            $table->dropColumn('bidang_penelitian_nama');
        });
    }
};

