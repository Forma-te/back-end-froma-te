<?php

namespace App\DTO\EbookContent;

use App\Http\Requests\StoreUpdateEbookContentRequest;

class CreateEbookContentDTO
{
    public function __construct(
        public string $ebook_id,
        public string $name,
        public string $description,
        public string $free,
        public string $published,
        public  $file
    ) {
    }

    public static function makeFromRequest(StoreUpdateEbookContentRequest $request): self
    {
        $data = $request->all();

        $published = isset($data['published']) ? 1 : 0;
        $free = isset($data['free']) ? 1 : 0;

        // Se a imagem estiver presente na requisição, obtenha o UploadedFile correspondente
        $file = $request->hasFile('file') ? $request->file('file') : null;

        return new self(
            $data['ebook_id'],
            $data['name'],
            $data['description'],
            $free,
            $published,
            $file
        );
    }
}
