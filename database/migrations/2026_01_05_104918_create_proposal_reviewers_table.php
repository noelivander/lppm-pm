<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal_reviewers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('penelitian_id')->nullable()->constrained('penelitian')->onDelete('cascade');
            $table->foreignId('pengabdian_id')->nullable()->constrained('pengabdian')->onDelete('cascade');
            $table->timestamps();

            // Constraint: A reviewer can only be assigned once to a specific proposal
            $table->unique(['user_id', 'penelitian_id']);
            $table->unique(['user_id', 'pengabdian_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposal_reviewers');
    }
};
