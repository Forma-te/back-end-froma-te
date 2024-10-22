<?php

namespace App\DTO\ProductFile;

use App\Http\Requests\StoreUpdateProductFileRequest;

class CreateFileEbookDTO
{
    public function __construct(
        public string $product_id,
        public string $name,
        public $type,
        public $file
    ) {
    }

    public static function makeFromRequest(StoreUpdateProductFileRequest $request): self
    {
        $data = $request->all();

        $file = $request->hasFile('file') ? $request->file('file') : null;

        $type = 'ebookFile';

        return new self(
            $data['product_id'],
            $data['name'],
            $type,
            $file
        );
    }

    public function toArray(): array
    {
        return [
            'product_id' => $this->product_id,
            'name' => $this->name,
            'type' => $this->type,
            'file' => $this->file
        ];
    }

}
