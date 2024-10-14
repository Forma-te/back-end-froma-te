<?php

namespace App\DTO\Module;

use App\Http\Requests\StoreUpdateModuleRequest;
use Illuminate\Support\Facades\Log;

class UpdateModuleDTO
{
    public function __construct(
        public string $id,
        public int $product_id,
        public string $name,
    ) {
    }

    public static function makeFromRequest(StoreUpdateModuleRequest $request, string $id): self
    {
        return new self(
            $id,
            $request->input('product_id'),
            $request->input('name'),
        );
    }
}
