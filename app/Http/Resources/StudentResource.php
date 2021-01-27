<?php

namespace App\Http\Resources;

use App\Http\Resources\CourseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'surnames' => $this->surnames,
            'courses' => CourseResource::collection($this->courses),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
