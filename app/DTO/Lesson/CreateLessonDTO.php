<?php

namespace App\DTO\Lesson;

use App\Http\Requests\StoreUpdateLessonRequest;

class CreateLessonDTO
{
    public function __construct(
        public string $module_id,
        public string $name,
        public bool $file,
        public string $url,
        public string $description,
        public bool $free,
        public bool $video,
        public bool $published
    ) {
    }

    public static function makeFromRequest(StoreUpdateLessonRequest $request): self
    {
        $data = $request->all();
        $published = isset($data['published']) ? 1 : 0;
        $free = isset($data['published']) ? 1 : 0;

        return new self(
            $data['course_id'],
            $data['name'],
            $data['file'],
            $data['url'],
            $data['description'],
            $free,
            $data['video'],
            $published
        );
    }
}
