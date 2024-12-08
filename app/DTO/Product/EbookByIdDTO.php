<?php

namespace App\DTO\Product;

class EbookByIdDTO
{
    public function __construct(
        public int $id,
        public string $ebook,
        public string $allow_download,
        public string $producer,
        public string $product_type,
        public ?string $image,
        public ?string $ebookFile
    ) {
    }

    public static function fromModel($ebook): self
    {
        return new self(
            $ebook->id,
            $ebook->name,
            $ebook->allow_download,
            $ebook->user->name,
            $ebook->product_type,
            $ebook->files->pluck('image')->filter()->first(),
            $ebook->files->pluck('file')->filter()->first()
        );
    }
}
