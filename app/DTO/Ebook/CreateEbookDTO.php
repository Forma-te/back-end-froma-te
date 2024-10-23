<?php

namespace App\DTO\Ebook;

use App\Http\Requests\StoreUpdateEbookRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;

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
        public string $free,
        public string $price,
        public string $discount,
        public string $acceptsMcxPayment,
        public string $acceptsRefPayment,
        public string $affiliationPercentage,
        public string $allow_download,
        public string $product_type,
        public string|UploadedFile|null $image = null, // Permitir tanto string (caminho) quanto UploadedFile
        public string|UploadedFile|null $file = null   // Permitir tanto string (caminho) quanto UploadedFile
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
            $data['free'],
            $data['price'],
            $data['discount'],
            $data['acceptsMcxPayment'],
            $data['acceptsRefPayment'],
            $data['affiliationPercentage'],
            $data['allow_download'],
            $product_type,
            $image,
            $file
        );
    }
}
