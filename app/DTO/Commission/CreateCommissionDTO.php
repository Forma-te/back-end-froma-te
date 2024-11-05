<?php

namespace App\DTO\Commission;

use App\Http\Requests\StoreCommissionRequest;

class CreateCommissionDTO
{
    public function __construct(
        public string $affiliate_id,
        public ?string $amount,
        public string $status,
    ) {
    }

    public static function makeFromRequest(StoreCommissionRequest $request): self
    {
        $data = $request->all();

        $status = 'pending';

        return new self(
            $data['affiliate_id'],
            $data['amount'],
            $status,
        );
    }

    public function toArray(): array
    {
        return [
            'affiliate_id' => $this->affiliate_id,
            'amount' => $this->amount,
            'status' => $this->status,
        ];
    }
}
