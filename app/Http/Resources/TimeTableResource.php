<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeTableResource extends JsonResource
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
            'course' => new CourseResource($this->course),
            'user' => new UserResource($this->user),
            // 'user' => $this->user_id,
            'venue' => $this->venue,
            'dayOfWeek' => $this->day_of_week,
            'startTime' => $this->start_time,
            'endTime' => $this->end_time,
            'created_at' => $this->created_at,
            'updated_at'=> $this->updated_at
        ];
    }
}
