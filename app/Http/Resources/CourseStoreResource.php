<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseStoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'nameCourse' => $this->name,
            'url' => $this->url,
            'description' => $this->description,
            'quantidade' => $this->code,
            'total_hours' => $this->total_hours,
            'published' => $this->published,
            'free' => $this->free,
            'price' => $this->price,
            'available' => $this->available,
            'imagem' => $this->image
        ];
    }
}
