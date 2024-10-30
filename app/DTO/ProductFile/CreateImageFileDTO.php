<?php

namespace App\DTO\ProductFile;

use App\Http\Requests\StoreUpdateProductFileRequest;

class CreateImageFileDTO
{
    public function __construct(
        public string $product_id,
        public string $name,
        public $type,
        public $image,
    ) {
    }

    public static function makeFromRequest(StoreUpdateProductFileRequest $request): self
    {
        $data = $request->all();

        $image = $request->hasFile('image') ? $request->file('image') : null;

        $type = 'fileImage';

        return new self(
            $data['product_id'],
            $data['name'],
            $type,
            $image,
        );
    }

    public function toArray(): array
    {
        return [
            'product_id' => $this->product_id,
            'name' => $this->name,
            'type' => $this->type,
            'image' => $this->image,
        ];
    }

}
