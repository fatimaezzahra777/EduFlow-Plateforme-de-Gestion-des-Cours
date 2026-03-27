<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'description' => $this->description,
            'prix' => $this->prix,

            'teacher' => [
                'id' => $this->teacher->id,
                'name' => $this->teacher->name
            ],

            'created_at' => $this->created_at
        ];
    }
}