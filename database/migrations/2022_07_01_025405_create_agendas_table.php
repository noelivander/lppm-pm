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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('tag')->nullable();
            $table->string('judul');
            $table->string('lokasi')->nullable();
            $table->string('slug')->unique();
            $table->timestamp('jadwal')->nullable();
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
        Schema::dropIfExists('agendas');
    }
};
