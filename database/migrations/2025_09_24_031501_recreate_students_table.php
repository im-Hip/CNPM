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
        Schema::dropIfExists('students');
        Schema::enableForeignKeyConstraints();

        Schema::create('students', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('student_id')->unique();
            $table->date('day_of_birth');
            $table->enum('gender', ['male', 'female']);
            $table->unsignedBigInteger('class_id'); // FK tới lớp học
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('class_id')
                ->references('id')
                ->on('classes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
