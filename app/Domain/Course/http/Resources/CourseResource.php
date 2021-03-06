<?php
namespace Domain\Course\http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'students' => $this->students,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
