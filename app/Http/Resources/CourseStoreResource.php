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
            'Categoria' => $this->category_id,
            'user' => $this->user_id,
            'Nome curso' => $this->name,
            'url' => $this->url,
            'description' => $this->description,
            'type' => $this->type,
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
