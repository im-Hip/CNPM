<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Kiểm tra foreign key cho classes
        $classesFK = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_NAME = 'classes' 
            AND CONSTRAINT_NAME = 'classes_room_id_foreign'
            AND TABLE_SCHEMA = DATABASE()
        ");
        
        if (empty($classesFK)) {
            Schema::table('classes', function (Blueprint $table) {
                $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            });
        }

        // Chỉ thêm foreign key cho schedules nếu bảng đã tồn tại
        if (Schema::hasTable('schedules')) {
            $schedulesFK = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_NAME = 'schedules' 
                AND CONSTRAINT_NAME = 'schedules_room_id_foreign'
                AND TABLE_SCHEMA = DATABASE()
            ");
            
            if (empty($schedulesFK)) {
                Schema::table('schedules', function (Blueprint $table) {
                    $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Xóa foreign keys nếu cần rollback
        Schema::table('classes', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
        });
        
        if (Schema::hasTable('schedules')) {
            Schema::table('schedules', function (Blueprint $table) {
                $table->dropForeign(['room_id']);
            });
        }
    }
};