<?php

namespace App\DTO\Lesson;

use App\Http\Requests\StoreUpdateEditNameLessonRequest;

class CreateNameLessonDTO
{
    public function __construct(
        public string $module_id,
        public string $name,
        public string $url
    ) {
    }

    public static function makeFromRequest(StoreUpdateEditNameLessonRequest $request): self
    {
        $data = $request->all();
        $url = sprintf('%08X', mt_rand(0, 0xFFFFFFF));

        return new self(
            $data['module_id'],
            $data['name'],
            $url
        );
    }
}
