<?php

namespace App\DTO\Product;

class FileDTO
{
    public function __construct(
        public int $id,
        public string $file,
        public string $product_type,
        public ?string $image
    ) {
    }

    public static function fromModel($file): self
    {
        return new self(
            $file->id,
            $file->name,
            $file->product_type,
            $file->files->pluck('image')->filter()->first()
        );
    }
}
