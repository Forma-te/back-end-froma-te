<?php

namespace App\DTO\Category;

use App\Http\Requests\StoreUpdateCategoryRequest;

class CreateCategoryDTO
{
    public function __construct(
        public string $name,
        public string $description,
        public string $elegant_font
    ) {
    }

    public static function makeFromRequest(StoreUpdateCategoryRequest $request): self
    {
        $data = $request->json()->all();

        return new self(
            $data['name'],
            $data['description'],
            $data['elegant_font']
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'elegant_font' => $this->elegant_font,
        ];
    }
}
