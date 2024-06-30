<?php

namespace App\DTO\Admin\Plan;

use App\Http\Requests\StoreUpdatePlanRequest;

class CreatePlanDTO
{
    public function __construct(
        public string $name,
        public string $url,
        public string $price,
        public string $description,
        public string $quantity,
        public string $published
    ) {
    }

    public static function makeFromRequest(StoreUpdatePlanRequest $request): self
    {
        $data = $request->json()->all();

        $data['published'] = isset($data['published']);

        return new self(
            $data['name'],
            $data['url'],
            $data['price'],
            $data['description'],
            $data['quantity'],
            $data['published']
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
