<?php

      use Illuminate\Database\Migrations\Migration;
      use Illuminate\Database\Schema\Blueprint;
      use Illuminate\Support\Facades\Schema;

      return new class extends Migration
      {
          public function up(): void
          {
              Schema::create('students', function (Blueprint $table) {
                  $table->id();
                  $table->unsignedBigInteger('user_id');
                  $table->unsignedBigInteger('class_id');
                  $table->enum('gender', ['male', 'female']);
                  $table->timestamps();

                  $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                  $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
              });
          }

          public function down(): void
          {
              Schema::dropIfExists('students');
          }
      };