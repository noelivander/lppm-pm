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
        Schema::table('announcements', function (Blueprint $table) {
            $table->string('cover')->nullable();
            $table->string('tag')->nullable();
        });

        Schema::table('agendas', function (Blueprint $table) {
            $table->timestamp('jadwal_akhir')->nullable();
            $table->string('cover')->nullable();
        });


        Schema::create('sub_agendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenda_id')->constrained('agendas');
            $table->string('judul');
            $table->string('lokasi')->nullable();
            $table->timestamp('jadwal')->nullable();
            $table->timestamp('jadwal_akhir')->nullable();
            $table->string('deskripsi')->nullable();
            $table->integer('is_shown')->default(0);
            $table->string('tautan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_agendas');
    }
};
