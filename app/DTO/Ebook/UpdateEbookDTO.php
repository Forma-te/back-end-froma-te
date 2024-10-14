<?php

namespace App\DTO\Ebook;

use App\Http\Requests\StoreUpdateEbookRequest;

class UpdateEbookDTO
{
    public function __construct(
        public string $id,
        public string $category_id,
        public string $name,
        public string $description,
        public string $published,
        public string $price,
        public string $discount,
        public string $acceptsMcxPayment,
        public string $acceptsRefPayment,
        public string $affiliationPercentage,
        public string $allow_download,
        public $image = null,
        public $file = null
    ) {
    }

    public static function makeFromRequest(StoreUpdateEbookRequest $request, string $id = null): self
    {
        $data = $request->all();

        // Se a imagem estiver presente na requisição, obtenha o UploadedFile correspondente
        // Se a imagem estiver presente na requisição, obtenha o UploadedFile correspondente
        $image = $request->hasFile('image') ? $request->file('image') : null;
        $file = $request->hasFile('file') ? $request->file('file') : null;

        return new self(
            $id ?? $request->id,
            $data['category_id'],
            $data['name'],
            $data['description'],
            $data['published'],
            $data['price'],
            $data['discount'],
            $data['acceptsMcxPayment'],
            $data['acceptsRefPayment'],
            $data['affiliationPercentage'],
            $data['allow_download'],
            $image,
            $file
        );
    }
}
