<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FacultyResource extends JsonResource
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
            // 'university' => new UniversityResource($this->university),
            'lastName' => $this->last_name,
            'name' => $this->name,
            'slug' => $this->slug,
            'isActive' => $this->is_active,
            'createdAt' => $this->created_at,
            'updatedAt'=> $this->updated_at,
            'deletedAt'=> $this->deleted_at,
        ];
    }
}
