<?php

namespace App\DTO\Course;

use App\Http\Requests\StoreUpdateCourseRequest;
use Illuminate\Support\Facades\Auth;

class CreateCourseDTO
{
    public function __construct(
        public string $category_id,
        public string $user_id,
        public string $name,
        public string $url,
        public string $description,
        public string $code,
        public string $total_hours,
        public string $published,
        public string $free,
        public string $price,
        public  $image,
    ) {
    }

    public static function makeFromRequest(StoreUpdateCourseRequest $request): self
    {
        $data = $request->all();
        $url = sprintf('%08X', mt_rand(0, 0xFFFFFFF));
        $codigo = sprintf('%07X', mt_rand(0, 0xFFFFFFF));

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
            $data['description'],
            $codigo,
            $data['total_hours'],
            $data['published'],
            $data['free'],
            $data['price'],
            $image,
        );
    }
}
