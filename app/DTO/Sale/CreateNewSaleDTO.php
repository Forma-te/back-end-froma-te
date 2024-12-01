<?php

namespace App\DTO\Sale;

use App\Http\Requests\StoreUpdateCartRequest;

class CreateNewSaleDTO
{
    public function __construct(
        public string $cart_id,
        public ?string $user_id,
        public ?string $producer_id,
        public string $transaction,
        public string $email_member,
        public string $status,
        public string $sales_channel,
        public string $date_created,
    ) {
    }
    public static function makeFromRequest(StoreUpdateCartRequest $request): self
    {
        $data = $request->all();

        $transaction = sprintf('%07X', mt_rand(0, 0xFFFFFFF));
        $date_created = now();

        $status = 'A';
        $sales_channel = 'VP';

        return new self(
            $data['cart_id'],
            $data['user_id'] ?? null,
            $data['producer_id'] ?? null,
            $transaction,
            $data['email_member'],
            $status,
            $sales_channel,
            $date_created,
        );
    }
}
