<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            ['name' => 'John Doe'],
            ['name' => 'Jane Smith'],
            ['name' => 'Michael Johnson'],
            ['name' => 'Sara Wilson'],
            ['name' => 'David Brown'],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
