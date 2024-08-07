<?php

namespace App\DTO\Ebook;

use App\Http\Requests\StoreUpdateEbookRequest;

class UpdateEbookDTO
{
    public function __construct(
        public string $id,
        public string $category_id,
        public string $name,
        public string $url,
        public string $code,
        public string $price,
        public  $image,
    ) {
    }

    public static function makeFromRequest(StoreUpdateEbookRequest $request, string $id = null): self
    {
        $data = $request->all();

        // Se a imagem estiver presente na requisição, obtenha o UploadedFile correspondente
        $image = $request->hasFile('image') ? $request->file('image') : null;

        return new self(
            $id ?? $request->id,
            $data['category_id'],
            $data['name'],
            $data['url'],
            $data['description'],
            $data['code'],
            $data['price'],
            $image
        );
    }
}
