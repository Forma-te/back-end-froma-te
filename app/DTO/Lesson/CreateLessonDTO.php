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
        public bool $is_presentation,
        public string|bool $published,
        public $file = null
    ) {
    }

    public static function makeFromRequest(StoreUpdateLessonRequest $request): self
    {
        $data = $request->all();
        $url = sprintf('%08X', mt_rand(0, 0xFFFFFFF));

        // Se o file estiver presente na requisição, obtenha o UploadedFile correspondente
        $file = $request->hasFile('file') ? $request->file('file') : null;

        return new self(
            $data['module_id'],
            $data['name'],
            $url,
            $data['description'],
            $data['video'],
            $data['is_presentation'],
            $data['published'],
            $file
        );
    }
}
