<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'department' => new DepartmentResource($this->department),
            'courseTitle' => $this->course_title,
            'courseCode' => $this->course_code,
            'slug' => $this->slug,
            'about' => $this->about
        ];
    }
}