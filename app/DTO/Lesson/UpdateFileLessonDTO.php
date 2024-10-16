<?php

namespace App\DTO\Lesson;

use App\Http\Requests\StoreUpdateEditFileLessonRequest;

class UpdateFileLessonDTO
{
    public function __construct(
        public string $id,
        public string $lesson_id,
        public string $url,
        public $file
    ) {
    }

    public static function makeFromRequest(StoreUpdateEditFileLessonRequest $request, string $id = null): self
    {
        $data = $request->all();

        $url = sprintf('%08X', mt_rand(0, 0xFFFFFFF));
        $file = $request->hasFile('file') ? $request->file('file') : null;

        return new self(
            $id,
            $data['lesson_id'],
            $url,
            $file,
        );
    }
}
