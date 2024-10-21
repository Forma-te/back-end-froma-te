<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderBumpResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->product_id,
            'offer_product_id' => $this->offer_product_id,
            'call_to_action' => $this->call_to_action,
            'title' => $this->title,
            'description' => $this->description,
            'show_image' => $this->show_image
        ];
    }
}
