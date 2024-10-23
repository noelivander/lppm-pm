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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penelitian_id')->nullable()->constrained()->onDelete('cascade');  // Relasi ke Penelitian
            $table->foreignId('pengabdian_id')->nullable()->constrained()->onDelete('cascade');  // Relasi ke Pengabdian
            $table->string('reviewer_name');
            $table->text('background');
            $table->text('research_objective')->nullable();  // Bisa kosong jika pengabdian
            $table->text('methodology')->nullable();
            $table->text('results')->nullable();
            $table->text('strengths')->nullable();
            $table->text('weaknesses')->nullable();
            $table->text('discussion')->nullable();
            $table->enum('type', ['penelitian', 'pengabdian']);  // Tipe proposal
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
        Schema::dropIfExists('reviews');
    }
};
