<?php

namespace App\DTO\Product;

class EbookDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $allow_download,
        public string $product_type,
        public ?string $image
    ) {
    }

    public static function fromModel($ebook): self
    {
        return new self(
            $ebook->id,
            $ebook->name,
            $ebook->allow_download,
            $ebook->product_type,
            $ebook->files->pluck('image')->filter()->first()
        );
    }
}
