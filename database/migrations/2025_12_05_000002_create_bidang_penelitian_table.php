<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bidang_penelitian', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->string('kode')->nullable();
            $table->unsignedInteger('urutan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('penelitian', function (Blueprint $table) {
            $table->foreignId('bidang_penelitian_id')->nullable()->after('skema')->constrained('bidang_penelitian')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('penelitian', function (Blueprint $table) {
            $table->dropConstrainedForeignId('bidang_penelitian_id');
        });

        Schema::dropIfExists('bidang_penelitian');
    }
};

