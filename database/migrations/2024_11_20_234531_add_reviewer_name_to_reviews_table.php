<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReviewerNameToReviewsTable extends Migration
{
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->string('reviewer_name')->after('reviewer_id'); // Menambahkan kolom reviewer_name
        });
    }

    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('reviewer_name'); // Menghapus kolom reviewer_name jika migrasi dibatalkan
        });
    }
}