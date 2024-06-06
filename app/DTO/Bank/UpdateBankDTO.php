<?php

namespace App\DTO\Bank;

use App\Http\Requests\StoreUpdateBankRequest;

class UpdateBankDTO
{
    public function __construct(
        public string $id,
        public string $bank,
        public string $account,
        public string $iban,
        public string $phone_number
    ) {
    }

    public static function makeFromRequest(StoreUpdateBankRequest $request, $id = null): self
    {
        return new self(
            $id ?? $request->id,
            $request->bank,
            $request->account,
            $request->iban,
            $request->phone_number
        );
    }

}
