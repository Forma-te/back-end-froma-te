<?php

namespace App\DTO\Ebook;

use App\Http\Requests\StoreUpdateEbookRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

class CreateEbookDTO
{
    public function __construct(
        public string $category_id,
        public string $user_id,
        public string $name,
        public string $url,
        public string $description,
        public string $code,
        public string $published,
        public string $price,
        public string $discount,
        public string $acceptsMcxPayment,
        public string $acceptsRefPayment,
        public string $affiliationPercentage,
        public string $allowDownload,
        public string $product_type,
        public $image = null,
        public $file = null
    ) {
    }

    public static function makeFromRequest(StoreUpdateEbookRequest $request): self
    {
        $data = $request->all();

        $url = sprintf('%08X', mt_rand(0, 0xFFFFFFF));
        $codigo = sprintf('%07X', mt_rand(0, 0xFFFFFFF));

        $user = Auth::user();
        if (!$user) {
            throw new AuthorizationException('User not authenticated');
        }

        $userId = $user->id;

        $product_type = 'ebook';

        // Se a imagem estiver presente na requisição, obtenha o UploadedFile correspondente
        $image = $request->hasFile('image') ? $request->file('image') : null;
        $file = $request->hasFile('file') ? $request->file('file') : null;

        return new self(
            $data['category_id'],
            $userId,
            $data['name'],
            $url,
            $data['description'],
            $codigo,
            $data['published'],
            $data['price'],
            $data['discount'],
            $data['acceptsMcxPayment'],
            $data['acceptsRefPayment'],
            $data['affiliationPercentage'],
            $data['allowDownload'],
            $product_type,
            $image,
            $file
        );
    }
}
