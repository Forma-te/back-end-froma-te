<?php

namespace App\DTO\Category;

use App\Http\Requests\StoreUpdateCategoryRequest;

class CreateCategoryDTO
{
    public function __construct(
        public string $category
    ) {
    }

    public static function makeFromRequest(StoreUpdateCategoryRequest $request): self
    {
        $data = $request->json()->all();

        return new self(
            $data['category']
        );
    }
}
