<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->date('day_of_birth');
            $table->enum('gender', ['male', 'female']);
            $table->foreignId('class_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->foreign('id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};

