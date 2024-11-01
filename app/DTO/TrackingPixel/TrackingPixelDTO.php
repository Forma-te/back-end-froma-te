<?php

namespace App\DTO\TrackingPixel;

use App\Http\Requests\TrackingPixelRequest;

class TrackingPixelDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $producerId,
        public int $productId,
        public string $pixelType,
        public string $pixelValue,
    ) {
    }
    public static function makeFromRequest(TrackingPixelRequest $request): self
    {
        $data = $request->validated();

        return new self(
            $data['producer_id'],
            $data['product_id'],
            $data['pixel_type'],
            $data['pixel_value']
        );
    }

    public function toArray(): array
    {
        return [
            'producer_id' => $this->producerId,
            'product_id' => $this->productId,
            'pixel_type' => $this->pixelType,
            'pixel_value' => $this->pixelValue,
        ];
    }
}
