<?php

namespace App\DTO\Ebook;

use App\Http\Requests\StoreUpdateEbookRequest;
use Illuminate\Http\UploadedFile;

class UpdateEbookDTO
{
    public function __construct(
        public string $id,
        public string $category_id,
        public string $name,
        public ?string $description,
        public string $code,
        public int $published, // Tratado como 0 ou 1
        public int $free, // Tratado como 0 ou 1
        public ?string $price,
        public ?string $discount,
        public int $acceptsMcxPayment, // Tratado como 0 ou 1
        public int $acceptsRefPayment, // Tratado como 0 ou 1
        public ?string $affiliationPercentage,
        public int $allow_download, // Tratado como 0 ou 1
        public string $product_type,
        public $image,
        public $file
    ) {
    }

    public static function makeFromRequest(StoreUpdateEbookRequest $request, string $id = null): self
    {
        $data = $request->json()->all();

        // Processa o ficheiro de imagem, se existir
        $image = $request->hasFile('image') ? $request->file('image') : null;

        // Processa o ficheiro do produto, se existir
        $file = $request->hasFile('file') ? $request->file('file') : null;

        // Mantém o código e o URL atuais ou cria novos, se necessário
        $code = $data['code'] ?? sprintf('%07X', mt_rand(0, 0xFFFFFFF));

        $product_type = 'ebook';

        return new self(
            $id ?? $request->id,
            $data['category_id'],
            $data['name'],
            $data['description'] ?? null,
            $code,
            (int) $data['published'], // Converte para 0 ou 1
            (int) $data['free'], // Converte para 0 ou 1
            $data['price'] ?? null,
            $data['discount'] ?? null,
            (int) $data['acceptsMcxPayment'], // Converte para 0 ou 1
            (int) $data['acceptsRefPayment'], // Converte para 0 ou 1
            $data['affiliationPercentage'] ?? null,
            (int) $data['allow_download'], // Converte para 0 ou 1
            $product_type,
            $image,
            $file
        );
    }
}
