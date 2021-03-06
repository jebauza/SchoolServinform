<?php
namespace Domain\Course\DTO;


use Domain\Course\http\Requests\CourseRequest;
use Spatie\DataTransferObject\DataTransferObject;

class CourseData extends DataTransferObject
{
    /** @var string */
    public $name;

    /** @var int[] */
    public $students;

    public static function fromRequest(CourseRequest $request): self
    {
        return new self([
            'name' => $request->name,
            'students' => $request->students
        ]);
    }
}
