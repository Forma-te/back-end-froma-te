<?php

namespace App\DTO\Category;

use App\Http\Requests\StoreUpdateCategoryRequest;

class UpdateCategoryDTO
{
    public function __construct(
        public string $id,
        public string $category,
    ) {
    }

    public static function makeFromRequest(StoreUpdateCategoryRequest $request, string $id = null): self
    {
        return new self(
            $id ?? $request->id,
            $request->category,
        );
    }
}
