<?php

namespace App\DTO\OrderBump;

use App\Http\Requests\StoreUpdateOrderBumpRequest;

class UpdateOrderBumpDTO
{
    public function __construct(
        public string $id,
        public string $product_id,
        public string $producer_id,
        public string $offer_product_id,
        public string $call_to_action,
        public string $title,
        public string $description,
        public string $show_image
    ) {
    }

    public static function makeFromRequest(StoreUpdateOrderBumpRequest $request, $id = null): self
    {
        return new self(
            $id ?? $request->id,
            $request->product_id,
            $request->producer_id,
            $request->offer_product_id,
            $request->call_to_action,
            $request->title,
            $request->description,
            $request->show_image
        );
    }

}
