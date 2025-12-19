<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->enum('type', ['exam','assignment','event','warning','scholarship'])->default('event');
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->string('recipient_type');
            $table->foreignId('recipient_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('sent_at')->useCurrent();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};

