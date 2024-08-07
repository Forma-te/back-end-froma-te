<?php

namespace App\DTO\Admin\Plan;

use App\Http\Requests\StoreUpdatePlanRequest;

class UpdatePlanDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $url,
        public string $price,
        public string $description,
        public string $quantity,
        public string $published
    ) {
    }

    public static function makeFromRequest(StoreUpdatePlanRequest $request, string $id = null): self
    {
        $data = $request->validated();

        return new self(
            $id ?? $request->id,
            $data['name'],
            $data['url'],
            $data['price'],
            $data['description'],
            $data['quantity'],
            isset($data['published']) ? '1' : '0'
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'url' => $this->url,
            'price' => $this->price,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'published' => $this->published
        ];
    }
}
