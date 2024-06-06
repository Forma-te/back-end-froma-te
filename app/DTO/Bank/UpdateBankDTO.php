<?php

namespace App\DTO\Bank;

use App\Http\Requests\StoreUpdateUserRequest;

class UpdateBankDTO
{
    public function __construct(
        public string $id,
        public string $user_id,
        public string $bank,
        public string $account,
        public string $iban,
        public string $phone_number
    ) {
    }

    public static function makeFromRequest(StoreUpdateUserRequest $request, string $id): self
    {
        $data = $request->json()->all();

        return new self(
            $id ?? $request->id,
            $data['user_id'],
            $data['bank'],
            $data['account'],
            $data['iban'],
            $data['phone_number']
        );
    }

}
