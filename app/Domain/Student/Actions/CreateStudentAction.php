<?php
namespace Domain\Student\Actions;

use Domain\Student\DTO\StudentData;
use Domain\Student\Models\Student;

final class CreateStudentAction
{
    public function __invoke(StudentData $studentData): Student
    {

        $newStudent = Student::create([
                'name' => $studentData->name,
                'surnames' => $studentData->surnames
        ]);

        if ($newStudent) {
            $newStudent->courses()->attach($studentData->courses);
        }

        return $newStudent;
    }
}
