<?php

namespace App\DTO\Module;

use App\Http\Requests\StoreUpdateModuleRequest;

class CreateModuleDTO
{
    public function __construct(
        public string $product_id,
        public string $name,
        public string $published
    ) {
    }

    public static function makeFromRequest(StoreUpdateModuleRequest $request): self
    {
        $data = $request->all();

        return new self(
            $data['product_id'],
            $data['name'],
            $data['published'],
        );
    }
}
