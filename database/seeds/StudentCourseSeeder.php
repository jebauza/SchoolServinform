<?php

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = factory(Course::class, 20)->create();

        $students = factory(Student::class, 40)->create()->each(function ($student) use ($courses){
            $student->courses()->saveMany($courses->random(rand(2, 7)));
        });
    }
}
