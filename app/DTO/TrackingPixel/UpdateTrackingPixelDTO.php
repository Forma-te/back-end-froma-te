<?php

namespace App\DTO\TrackingPixel;

use App\Http\Requests\TrackingPixelRequest;

class UpdateTrackingPixelDTO
{
    public function __construct(
        public int $id,
        public int $producerId,
        public int $productId,
        public string $pixelType,
        public string $pixelValue,
    ) {
    }
    public static function makeFromRequest(TrackingPixelRequest $request, $id = null): self
    {
        return new self(
            $id ?? $request->id,
            $request->producer_id,
            $request->product_id,
            $request->pixelType,
            $request->pixelValue,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'producer_id' => $this->producerId,
            'product_id' => $this->productId,
            'pixel_type' => $this->pixelType,
            'pixel_value' => $this->pixelValue,
        ];
    }
}
