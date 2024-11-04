<?php

namespace App\DTO\OrderBump;

use App\Http\Requests\StoreUpdateOrderBumpRequest;

class CreateOrderBumpDTO
{
    public function __construct(
        public string $product_id,
        public string $producer_id,
        public string $offer_product_id,
        public string $call_to_action,
        public string $title,
        public string $description,
        public string $show_image
    ) {
    }

    public static function makeFromRequest(StoreUpdateOrderBumpRequest $request): self
    {
        $data = $request->json()->all();

        return new self(
            $data['product_id'],
            $data['producer_id'],
            $data['offer_product_id'],
            $data['call_to_action'],
            $data['title'],
            $data['description'],
            $data['show_image']
        );
    }

    public function toArray(): array
    {
        return [
            'product_id' => $this->product_id,
            'user_id' => $this->producer_id,
            'offer_product_id' => $this->offer_product_id,
            'call_to_action' => $this->call_to_action,
            'title' => $this->title,
            'description' => $this->description,
            'show_image' => $this->show_image,
        ];
    }

}
