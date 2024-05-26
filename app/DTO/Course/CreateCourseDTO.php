<?php

namespace App\DTO\Course;

use App\Http\Requests\StoreUpdateCourseRequest;

class CreateCourseDTO
{
    public function __construct(
        public string $category_id,
        public string $user_id,
        public string $short_name,
        public string $name,
        public string $url,
        public string $description,
        public string $type,
        public string $code,
        public string $total_hours,
        public string $published,
        public string $free,
        public string $price,
        public string $available,
        public $image,
    ) {
    }

    public static function makeFromRequest(StoreUpdateCourseRequest $request): self
    {
        $data = $request->json()->all();
        $short_name = createUrl($data['short_name']);
        $codigo = sprintf('%07X', mt_rand(0, 0xFFFFFFF));

        $userId = $data['user_id'] = auth()->user()->id;
        $published = isset($data['published']);
        $free = isset($data['free']);
        $type = 'CURSO';

        // Se a imagem estiver presente na requisição, obtenha o UploadedFile correspondente
        $image = $request->hasFile('image') ? $request->file('image') : null;

        return new self(
            $data['category_id'],
            $userId,
            $short_name,
            $data['name'],
            $data['url'],
            $data['description'],
            $type,
            $codigo,
            $data['total_hours'],
            $published,
            $free,
            $data['price'],
            $data['available'],
            $image,
        );
    }
}
