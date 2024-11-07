<?php

namespace App\DTO\Affiliate;

use App\Http\Requests\StoreUpdateSaleRequest;

class SaleAffiliateDTO
{
    public function __construct(
        public string $product_id,
        public ?string $user_id,
        public ?string $producer_id,
        public string $transaction,
        public string $email_member,
        public string $status,
        public string $date_created,
    ) {
    }
    public static function makeFromRequest(StoreUpdateSaleRequest $request): self
    {
        $data = $request->all();

        $transaction = sprintf('%07X', mt_rand(0, 0xFFFFFFF));
        $date_created = now();

        $status = 'A';

        return new self(
            $data['cart_id'],
            $data['user_id'] ?? null,
            $data['producer_id'] ?? null,
            $transaction,
            $data['email_member'],
            $status,
            $date_created,
        );
    }
}
