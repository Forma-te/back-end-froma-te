<?php

namespace App\DTO\TrackingPixel;

use App\Http\Requests\TrackingPixelRequest;

class UpdateTrackingPixelDTO
{
    public function __construct(
        public int $id,
        public int $producer_id,
        public int $product_id,
        public string $pixel_type,
        public string $pixel_value,
    ) {
    }
    public static function makeFromRequest(TrackingPixelRequest $request, $id = null): self
    {
        return new self(
            $id ?? $request->id,
            $request->producer_id,
            $request->product_id,
            $request->pixel_type,
            $request->pixel_value,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'producer_id' => $this->producer_id,
            'product_id' => $this->product_id,
            'pixel_type' => $this->pixel_type,
            'pixel_value' => $this->pixel_value,
        ];
    }
}
