<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengabdianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengabdian', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('luaran_wajib');
            $table->string('lama_penelitian');
            $table->decimal('biaya_diusulkan', 15, 2);
            $table->string('skema');
            $table->string('luaran_tambahan')->nullable();
            $table->text('ringkasan_proposal');
            $table->string('dokumen_proposal');
            $table->string('status')->default('Pending');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('pengabdian');
    }
}

