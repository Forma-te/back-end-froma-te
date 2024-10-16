<?php

namespace App\DTO\Lesson;

use App\Http\Requests\StoreUpdateEditFileLessonRequest;

class CreateFileLessonDTO
{
    public function __construct(
        public string $lesson_id,
        public string $url,
        public $file
    ) {
    }

    public static function makeFromRequest(StoreUpdateEditFileLessonRequest $request): self
    {
        $data = $request->all();

        $url = sprintf('%08X', mt_rand(0, 0xFFFFFFF));
        $file = $request->hasFile('file') ? $request->file('file') : null;

        return new self(
            $data['lesson_id'],
            $url,
            $file,
        );
    }
}
