<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackingPixelResource extends JsonResource
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
            'producer_id' => $this->producer_id,
            'pixel_type' => $this->pixel_type,
            'pixel_value' => $this->pixel_value,
        ];
    }
}
