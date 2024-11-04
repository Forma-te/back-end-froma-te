<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->id,
            'name' => $this->name,
            'user_id' => $this->user_id,
            'price' => $this->price,
            'discount' => $this->discount,
            'product_type' => $this->product_type,
            'files' => ProductFileResource::collection($this->whenLoaded('files')),
        ];
    }
}
