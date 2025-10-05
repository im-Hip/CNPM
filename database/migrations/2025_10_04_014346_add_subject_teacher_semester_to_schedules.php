<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('subject_id')->nullable()->after('class_id');
            $table->unsignedBigInteger('teacher_id')->nullable()->after('subject_id');
            $table->integer('semester')->default(1)->after('end_time');
            $table->year('year')->default(now()->year)->after('semester');

            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('set null');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropForeign(['subject_id', 'teacher_id']);
            $table->dropColumn(['subject_id', 'teacher_id', 'semester', 'year']);
        });
    }
};