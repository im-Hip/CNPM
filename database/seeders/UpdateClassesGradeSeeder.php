<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateClassesGradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = DB::table('classes')->orderBy('id')->get();

        foreach ($classes as $index => $class) {
            if($index < 7) {
                $grade = '10';
            }
            else if($index < 14) {
                $grade = '11';
            }
            else {
                $grade = '12';
            }

            DB::table('classes')->where('id', $class->id)->update([
                'grade' => $grade
            ]);
        }

        $this->command->info("success");
    }
}
