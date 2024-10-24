<?php

namespace App\DTO\Lesson;

use App\Http\Requests\StoreUpdateFileLessonRequest;

class CreateFileLessonDTO
{
    public function __construct(
        public string $lesson_id,
        public string $name,
        public $file = null
    ) {
    }

    public static function makeFromRequest(StoreUpdateFileLessonRequest $request): self
    {
        $data = $request->all();

        $file = $request->hasFile('file') ? $request->file('file') : null;

        return new self(
            $data['lesson_id'],
            $data['name'],
            $file,
        );
    }
}
