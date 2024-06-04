<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EbookResource extends JsonResource
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
            'name' => $this->name,
            'url' => $this->url,
            'description' => $this->description,
            'code' => $this->code,
            'published' => $this->published,
            'free' => $this->free,
            'price' => $this->price,
            'available' => $this->available,
            'imagem' => $this->image
        ];
    }
}
