<?php

namespace App\DTO\Sale;

use App\Http\Requests\StoreUpdateSaleRequest;

class CreateNewSaleDTO
{
    public function __construct(
        public string $course_id,
        public ?string $user_id,
        public string $name,
        public ?string $instrutor_id,
        public string $transaction,
        public string $email_student,
        public string $status,
        public string $blocked,
        public string $date_created,
        public string $date_expired,
        public string $product_type
    ) {
    }
    public static function makeFromRequest(StoreUpdateSaleRequest $request): self
    {
        $data = $request->all();

        $transaction = sprintf('%07X', mt_rand(0, 0xFFFFFFF));
        $date_created = now();
        $blocked = 0;
        $status = 'A';

        return new self(
            $data['course_id'],
            $data['user_id'] ?? null,
            $data['name'],
            $data['instrutor_id'] ?? null,
            $transaction,
            $data['email_student'],
            $status,
            $blocked,
            $date_created,
            $data['date_expired'],
            $data['product_type']
        );
    }
}
