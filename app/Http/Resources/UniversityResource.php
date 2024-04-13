<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UniversityResource extends JsonResource
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
            'name' => $this->name,
            'acronym' => $this->acronym,
            'slug' => $this->slug,
            'country' => $this->country,
            'state' => $this->state,
            'region' => $this->region,
            'website' => $this->website,
            'emailExtention' => $this->email_extention,
            'gradePointSystem' => $this->grade_point_system_id,
            'isActive' => $this->is_active,
            'enabled' => $this->enabled,
            'createdAt' => $this->created_at,
            'updatedAt'=> $this->updated_at,
            'deletedAt'=> $this->deleted_at,
        ];
    }
}