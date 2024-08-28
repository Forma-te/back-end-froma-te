<?php

namespace App\DTO\Lesson;

use App\Http\Requests\StoreUpdateEditNameLessonRequest;

class UpdateEditNameLessonDTO
{
    public function __construct(
        public string $id,
        public string $name
    ) {
    }

    public static function makeFromRequest(StoreUpdateEditNameLessonRequest $request, string $id = null): self
    {
        return new self(
            $id,
            $request->input('name')
        );
    }
}
