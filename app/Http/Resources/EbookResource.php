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
            'product_id' => $this->id,
            'category_id' => $this->category_id,
            'code' => $this->code,
            'user_id' => $this->user_id,
            'name' => ucwords(strtolower($this->name)),
            'url' => $this->url,
            'description' => $this->description,
            'total_hours' => $this->total_hours,
            'published' => $this->published,
            'free' => $this->free,
            'acceptsMcxPayment' => $this->acceptsMcxPayment,
            'acceptsRefPayment' => $this->acceptsRefPayment,
            'affiliationPercentage' => $this->affiliationPercentage,
            'discount' => $this->discount,
            'price' => $this->price,
            'allowDownload' => $this->allow_download,
            'imagem' => $this->image,
            'product_type' => $this->product_type,
            'files' => ProductFileResource::collection($this->whenLoaded('files')),
            'producer' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
