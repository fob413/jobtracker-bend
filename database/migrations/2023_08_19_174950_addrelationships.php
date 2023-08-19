<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->unsignedBigInteger('stage_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('stage_id')->references('id')->on('stages');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('stages', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropForeign(['user_id', 'stage_id']);
            $table->dropColumn('user_id');
            $table->dropColumn('stage_id');
        });

        Schema::table('stages', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
