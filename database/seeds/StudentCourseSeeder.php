<?php

use Illuminate\Database\Seeder;
use Domain\Course\Models\Course;
use Domain\Student\Models\Student;

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
