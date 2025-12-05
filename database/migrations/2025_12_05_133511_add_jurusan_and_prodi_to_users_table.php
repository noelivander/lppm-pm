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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('jurusan_id')->nullable()->after('role');
            $table->unsignedBigInteger('program_studi_id')->nullable()->after('jurusan_id');
            
            $table->foreign('jurusan_id')->references('id')->on('jurusan')->onDelete('set null');
            $table->foreign('program_studi_id')->references('id')->on('program_studi')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']);
            $table->dropForeign(['program_studi_id']);
            $table->dropColumn(['jurusan_id', 'program_studi_id']);
        });
    }
};
