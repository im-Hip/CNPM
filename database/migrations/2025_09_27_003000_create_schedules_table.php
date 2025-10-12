<?php

      use Illuminate\Database\Migrations\Migration;
      use Illuminate\Database\Schema\Blueprint;
      use Illuminate\Support\Facades\Schema;

      return new class extends Migration
      {
          public function up(): void
          {
              Schema::create('schedules', function (Blueprint $table) {
                  $table->id();
                  $table->unsignedBigInteger('teacher_id');
                  $table->unsignedBigInteger('class_id');
                  $table->unsignedBigInteger('room_id');
                  $table->enum('day_of_week', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']);
                  $table->string('class_period');
                  $table->string('note')->nullable();
                  $table->timestamps();

                  $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
                  $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
                  $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
              });
          }

          public function down(): void
          {
              Schema::dropIfExists('schedules');
          }
      };