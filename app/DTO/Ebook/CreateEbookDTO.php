<?php

namespace App\DTO\Ebook;

use App\Http\Requests\StoreUpdateEbookRequest;
use Illuminate\Support\Facades\Auth;

class CreateEbookDTO
{
    public function __construct(
        public string $category_id,
        public string $user_id,
        public string $name,
        public string $url,
        public string $code,
        public string $price,
        public  $image
    ) {
    }

    public static function makeFromRequest(StoreUpdateEbookRequest $request): self
    {
        $data = $request->all();
        $url = sprintf('%08X', mt_rand(0, 0xFFFFFFF));
        $code = sprintf('%07X', mt_rand(0, 0xFFFFFFF));

        $user = Auth::user();
        if (!$user) {
            throw new \Exception('User not authenticated');
        }

        $userId = $user->id;

        // Se a imagem estiver presente na requisição, obtenha o UploadedFile correspondente
        $image = $request->hasFile('image') ? $request->file('image') : null;

        return new self(
            $data['category_id'],
            $userId,
            $data['name'],
            $url,
            $code,
            $data['price'],
            $image
        );
    }
}
