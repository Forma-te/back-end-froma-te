<?php

namespace App\DTO\ProductFile;

use App\Http\Requests\StoreUpdateProductCourseImageRequest;

class CreateFileCourseDTO
{
    public function __construct(
        public string $product_id,
        public string $name,
        public $type,
        public $image
    ) {
    }

    public static function makeFromRequest(StoreUpdateProductCourseImageRequest $request): self
    {
        $data = $request->all();

        $image = $request->hasFile('image') ? $request->file('image') : null;

        $type = 'courseImage';

        return new self(
            $data['product_id'],
            $data['name'],
            $type,
            $image
        );
    }

    public function toArray(): array
    {
        return [
            'product_id' => $this->product_id,
            'name' => $this->name,
            'type' => $this->type,
            'image' => $this->image
        ];
    }

}
