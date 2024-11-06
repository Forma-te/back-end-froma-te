<?php

namespace App\DTO\Affiliate;

use App\Http\Requests\StoreAffiliateRequest;

class CreateAffiliateDTO
{
    public function __construct(
        public string $product_url,
        public string $product_id,
        public ?string $user_id,
        public string $status,
    ) {
    }

    public static function makeFromRequest(StoreAffiliateRequest $request): self
    {
        $data = $request->all();

        $status = 'active';

        return new self(
            $data['product_url'],
            $data['product_id'],
            $data['user_id'],
            $status,
        );
    }

    public function toArray(): array
    {
        return [
            'product_url' => $this->product_url,
            'product_id' => $this->product_id,
            'user_id' => $this->user_id,
            'status' => $this->status,
        ];
    }
}
