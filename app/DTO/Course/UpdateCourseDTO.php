<?php

namespace App\DTO\Course;

use App\Http\Requests\StoreUpdateCourseRequest;

class UpdateCourseDTO
{
    public function __construct(
        public string $id,
        public string $category_id,
        public string $name,
        public string $description,
        public string $total_hours,
        public string $published,
        public string $free,
        public string $price,
        public string $discount,
        public string $acceptsMcxPayment,
        public string $acceptsRefPayment,
        public string $affiliationPercentage,
        public $image,
    ) {
    }

    public static function makeFromRequest(StoreUpdateCourseRequest $request, string $id = null): self
    {
        $data = $request->all();

        // Se a imagem estiver presente na requisição, obtenha o UploadedFile correspondente
        $image = $request->hasFile('image') ? $request->file('image') : null;

        return new self(
            $id ?? $request->id,
            $data['category_id'],
            $data['name'],
            $data['description'],
            $data['total_hours'],
            $data['published'],
            $data['free'],
            $data['price'],
            $data['discount'],
            $data['acceptsMcxPayment'],
            $data['acceptsRefPayment'],
            $data['affiliationPercentage'],
            $image
        );
    }
}
