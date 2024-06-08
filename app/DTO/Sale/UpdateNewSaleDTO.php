<?php

namespace App\DTO\Sale;

use App\Http\Requests\StoreUpdateSaleRequest;

class UpdateNewSaleDTO
{
    public function __construct(
        public string $id,
        public string $course_id,
        public string $user_id,
        public string $instrutor_id,
        public string $transaction,
        public string $email_student,
        public string $status,
        public string $blocked,
        public string $date_created,
        public string $date_expired
    ) {
    }
    public static function makeFromRequest(StoreUpdateSaleRequest $request, string $id = null): self
    {
        $data = $request->all();

        return new self(
            $id ?? $request->id,
            $data['course_id'],
            $data['user_id'],
            $data['instrutor_id'],
            $data['transaction'],
            $data['email_student'],
            $data['status'],
            $data['blocked'],
            $data['date_created'],
            $data['date_expired']
        );
    }
}
