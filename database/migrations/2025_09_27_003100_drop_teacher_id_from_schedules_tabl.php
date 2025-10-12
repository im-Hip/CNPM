<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  return new class extends Migration
  {
      public function up(): void
      {
          Schema::table('schedules', function (Blueprint $table) {
              if (Schema::hasColumn('schedules', 'teacher_id')) {
                  $table->dropForeign(['teacher_id']);
                  $table->dropColumn('teacher_id');
              }
          });
      }

      public function down(): void
      {
          Schema::table('schedules', function (Blueprint $table) {
              $table->unsignedBigInteger('teacher_id')->after('id');
              $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
          });
      }
  };