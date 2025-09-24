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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('teachers');
        Schema::enableForeignKeyConstraints();

        Schema::create('teachers', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('teacher_id')->unique();
            $table->string('level');
            $table->string('subject_group');
            $table->timestamps();

            $table->foreign('id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
