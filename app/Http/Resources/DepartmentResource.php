<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            'slug' => $this->slug,
            'degreeType' => $this->degree_type,
            'duration' => $this->duration,
            'semester_per_year' => $this->semester_per_year,
            'createdAt' => $this->created_at,
            'updatedAt'=> $this->updated_at,
            'deletedAt'=> $this->deleted_at,
        ];

    }
}