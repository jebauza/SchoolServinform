<?php
namespace Domain\Student\DTO;

use Domain\Student\http\Requests\StudentRequest;
use Spatie\DataTransferObject\DataTransferObject;

class StudentData extends DataTransferObject
{
    /** @var string */
    public $name;

    /** @var string */
    public $surnames;

    /** @var int[] */
    public $courses;

    public static function fromRequest(StudentRequest $request): StudentData
    {
        return new self([
            'name' => $request->name,
            'surnames' => $request->surnames,
            'courses' => $request->courses
        ]);
    }
}
