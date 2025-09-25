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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            
            // Cột tách riêng để kiểm soát
            $table->char('block', 1);              // A - I
            $table->tinyInteger('floor');          // 1 - 2
            $table->tinyInteger('room_no');        // 1 - 10
            
            // Cột name ghép (vd: B207)
            $table->string('name', 10)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
