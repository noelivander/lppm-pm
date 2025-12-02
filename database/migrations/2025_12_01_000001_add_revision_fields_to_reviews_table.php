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
        Schema::table('reviews', function (Blueprint $table) {
            // Kolom untuk menyimpan keputusan reviewer terhadap revisi proposal
            $table->enum('revision_decision', ['approved', 'rejected'])
                ->nullable()
                ->after('komentar');
            $table->text('revision_comment')
                ->nullable()
                ->after('revision_decision');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['revision_decision', 'revision_comment']);
        });
    }
};


