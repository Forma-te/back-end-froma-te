<?php

namespace App\DTO\Product;

class FileByIdDTO
{
    public function __construct(
        public int $id,
        public string $fileName,
        public string $producer,
        public string $product_type,
        public ?string $image,
        public ?string $file
    ) {
    }

    public static function fromModel($file): self
    {
        return new self(
            $file->id,
            $file->name,
            $file->user->name,
            $file->product_type,
            $file->files->pluck('image')->filter()->first(),
            $file->files->pluck('file')->filter()->first()
        );
    }
}
