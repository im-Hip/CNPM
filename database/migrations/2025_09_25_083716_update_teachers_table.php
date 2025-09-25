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
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn('subject_id');
        });

        Schema::table('teachers', function (Blueprint $table) {
            $table->unsignedBigInteger('subject_id')->after('teacher_id');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->dropForeign(['subject_id']);
                $table->dropColumn('subject_id');
            });

            Schema::table('teachers', function (Blueprint $table) {
                $table->unsignedBigInteger('subject_id'); // quay lại mặc định ở cuối
                $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            });
        });
    }
};
