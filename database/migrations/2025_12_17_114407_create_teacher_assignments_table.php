<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('teacher_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->nullOnDelete();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('note')->nullable();
            $table->timestamps();

            $table->unique(['teacher_id', 'class_id']);
            $table->unique(['subject_id', 'class_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('teacher_assignments');
    }
};

