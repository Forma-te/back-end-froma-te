<?php

namespace App\DTO\Sale;

use App\Http\Requests\StoreUpdateSaleRequest;

class CreateNewSaleDTO
{
    public function __construct(
        public string $course_id,
        public string $user_id,
        public string $instrutor_id,
        public string $transaction,
        public string $email_student,
        public string $payment_mode,
        public string $blocked,
        public string $status,
        public string $date_created,
        public string $date_expired
    ) {
    }
    public static function makeFromRequest(StoreUpdateSaleRequest $request): self
    {
        $data = $request->all();

        return new self(
            $data['course_id'],
            $data['user_id'],
            $data['instrutor_id'],
            $data['transaction'],
            $data['email_student'],
            $data['payment_mode'],
            $data['blocked'],
            $data['status'],
            $data['date_created'],
            $data['date_expired']
        );
    }
}
