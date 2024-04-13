<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'otherName' => $this->other_name,
            'emailAddress' => $this->email,
            'phoneNumber' => $this->phone_number,
            'accountType' => $this->account_type,
            'university' => new UniversityResource($this->university),
            'faculty' => new FacultyResource($this->faculty),
            'department' => new DepartmentResource($this->department),
            'schoolLevel' => new SchoolLevelResource($this->school_level),
            'levelSemester' => new LevelSemesterResource($this->level_semester),
            'createdAt' => $this->created_at,
            'updatedAt'=> $this->updated_at,
        ];
    }
}
