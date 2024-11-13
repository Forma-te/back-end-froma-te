<?php

namespace App\DTO\Affiliate;

use App\Http\Requests\SaleAffiliateRequest;

class SaleAffiliateDTO
{
    public function __construct(
        public string $product_url,
        public string $ref,
        public string $email_member,
        public string $transaction,
        public string $sales_channel,
        public string $status,
        public string $date_created,
    ) {
    }
    public static function makeFromRequest(SaleAffiliateRequest $request): self
    {
        $data = $request->all();

        $transaction = sprintf('%07X', mt_rand(0, 0xFFFFFFF));
        $date_created = now();

        $status = 'A';
        $sales_channel = 'VA';

        return new self(
            $data['product_url'],
            $data['ref'],
            $data['email_member'],
            $transaction,
            $sales_channel,
            $status,
            $date_created,
        );
    }
}
