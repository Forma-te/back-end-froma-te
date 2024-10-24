<?php

namespace App\DTO\ProductFile;

use App\Http\Requests\StoreUpdateProductDocFileRequest;

class CreateDocFileDTO
{
    public function __construct(
        public string $product_id,
        public string $name,
        public $type,
        public $file
    ) {
    }

    public static function makeFromRequest(StoreUpdateProductDocFileRequest $request): self
    {
        $data = $request->all();

        $file = $request->hasFile('file') ? $request->file('file') : null;

        $type = 'docFile';

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
