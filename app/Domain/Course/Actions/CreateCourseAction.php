<?php
namespace Domain\Course\Actions;

use Domain\Course\DTO\CourseData;
use Domain\Course\Models\Course;

final class CreateCourseAction
{
    public function __invoke(CourseData $courseData): Course
    {

        $newCourse = Course::create([
                'name' => $courseData->name
        ]);

        if ($newCourse) {
            $newCourse->students()->attach($courseData->students);
        }

        return $newCourse;
    }
}
