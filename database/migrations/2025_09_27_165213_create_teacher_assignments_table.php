<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  return new class extends Migration
  {
      public function up(): void
      {
          Schema::create('teacher_assignments', function (Blueprint $table) {
              $table->id();
              $table->unsignedBigInteger('teacher_id');
              $table->unsignedBigInteger('class_id');
              $table->enum('status', ['active', 'inactive'])->default('active');
              $table->string('note')->nullable();
              $table->timestamps();

              $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
              $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
              $table->unique(['teacher_id', 'class_id']); // Tránh trùng lặp
          });
      }

      public function down(): void
      {
          Schema::dropIfExists('teacher_assignments');
      }
  };