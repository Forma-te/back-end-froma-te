<?php

namespace App\DTO\Bank;

use App\Http\Requests\StoreUpdateBankRequest;
use Illuminate\Support\Facades\Auth;

class CreateBankDTO
{
    public function __construct(
        public string $user_id,
        public string $bank,
        public string $account,
        public string $iban,
        public string $phone_number
    ) {
    }

    public static function makeFromRequest(StoreUpdateBankRequest $request): self
    {
        $data = $request->json()->all();

        $user = Auth::user();
        if (!$user) {
            throw new \Exception('User not authenticated');
        }

        $userId = $user->id;

        return new self(
            $userId,
            $data['bank'],
            $data['account'],
            $data['iban'],
            $data['phone_number']
        );
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'bank' => $this->bank,
            'account' => $this->account,
            'iban' => $this->iban,
            'phone_number' => $this->phone_number,
        ];
    }

}
