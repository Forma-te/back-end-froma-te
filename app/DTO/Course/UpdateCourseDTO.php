<?php

namespace App\DTO\Course;

use App\Http\Requests\StoreUpdateCourseRequest;

class UpdateCourseDTO
{
    public function __construct(
        public string $id,
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
    ) {
    }

    public static function makeFromRequest(StoreUpdateCourseRequest $request, string $id = null): self
    {
        return new self(
            $id ?? $request->id,
            $request->category_id,
            $request->user_id,
            $request->short_name,
            $request->name,
            $request->url,
            $request->description,
            $request->type,
            $request->code,
            $request->total_hours,
            $request->published,
            $request->free,
            $request->price,
            $request->available
        );
    }
}
