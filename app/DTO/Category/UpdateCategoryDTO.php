<?php

namespace App\DTO\Category;

use App\Http\Requests\StoreUpdateCategoryRequest;

class UpdateCategoryDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public string $elegant_font
    ) {
    }

    public static function makeFromRequest(StoreUpdateCategoryRequest $request, string $id = null): self
    {
        return new self(
            $id ?? $request->id,
            $request->name,
            $request->description,
            $request->elegant_font,
        );
    }
}
