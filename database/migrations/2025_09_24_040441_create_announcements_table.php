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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id(); // khóa chính

            $table->string('title');       
            $table->text('content');        
            $table->enum('receiver', ['student', 'teacher', 'all'])
                ->default('all');       // đối tượng nhận thông báo
            $table->dateTime('seeding_time')->nullable();
            
            $table->unsignedBigInteger('schedule_id')->nullable();
            $table->foreign('schedule_id')
                ->references('id')
                ->on('schedules')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
