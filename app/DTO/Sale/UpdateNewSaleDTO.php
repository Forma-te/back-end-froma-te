<?php

namespace App\DTO\Sale;

use App\Http\Requests\StoreUpdateSaleRequest;

class UpdateNewSaleDTO
{
    public function __construct(
        public string $id,
        public string $status,
        public string $date_created,
        public string $date_expired,
    ) {
    }
    public static function makeFromRequest(StoreUpdateSaleRequest $request, string $id = null): self
    {
        $data = $request->all();

        return new self(
            $id ?? $request->id,
            $data['status'],
            $data['date_created'],
            $data['date_expired']
        );
    }
}
