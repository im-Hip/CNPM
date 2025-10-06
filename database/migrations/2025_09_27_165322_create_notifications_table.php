<?php

      use Illuminate\Database\Migrations\Migration;
      use Illuminate\Database\Schema\Blueprint;
      use Illuminate\Support\Facades\Schema;

      return new class extends Migration
      {
          public function up(): void
          {
              Schema::create('notifications', function (Blueprint $table) {
                  $table->id();
                  $table->string('title');
                  $table->text('content');
                  $table->enum('type', ['exam', 'assignment', 'event', 'warning', 'scholarship'])->default('event');
                  $table->unsignedBigInteger('sender_id');
                  $table->morphs('recipient');
                  $table->timestamp('sent_at')->useCurrent();
                  $table->timestamps();

                  $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
              });
          }

          public function down(): void
          {
              Schema::dropIfExists('notifications');
          }
      };