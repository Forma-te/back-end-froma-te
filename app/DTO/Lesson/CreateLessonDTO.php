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
        public string $free,
        public string $video,
        public string $published,
        public $file,
    ) {
    }

    public static function makeFromRequest(StoreUpdateLessonRequest $request): self
    {
        $data = $request->all();
        $published = isset($data['published']) ? 1 : 0;
        $free = isset($data['published']) ? 1 : 0;
        $url = sprintf('%08X', mt_rand(0, 0xFFFFFFF));

        // Se o file estiver presente na requisição, obtenha o UploadedFile correspondente
        $file = $request->hasFile('file') ? $request->file('file') : null;

        return new self(
            $data['module_id'],
            $data['name'],
            $url,
            $data['description'],
            $free,
            $data['video'],
            $published,
            $file
        );
    }
}
