<?php

namespace App\DTO\Sale;

use App\Http\Requests\StoreUpdateSaleRequest;
use Carbon\Carbon;

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
            self::formatDate($data['date_created']),
            self::formatDate($data['date_expired'])
        );
    }

    /**
    * Formata a data para o formato 'Y-m-d'.
    *
    * @param string $date
    * @return string
    */
    private static function formatDate(string $date): string
    {
        return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    }
}
