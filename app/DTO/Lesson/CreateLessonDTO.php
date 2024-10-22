<?php

namespace App\DTO\Lesson;

use App\Http\Requests\StoreUpdateLessonRequest;

class CreateLessonDTO
{
    public function __construct(
        public string $module_id,
        public string $name,
        public string $url,
        public string $description,
        public string $video,
        public string $published
    ) {
    }

    public static function makeFromRequest(StoreUpdateLessonRequest $request): self
    {
        $data = $request->all();
        $url = sprintf('%08X', mt_rand(0, 0xFFFFFFF));

        return new self(
            $data['module_id'],
            $data['name'],
            $url,
            $data['description'],
            $data['video'],
            $data['published']
        );
    }
}
