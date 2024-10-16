<?php

namespace App\DTO\Lesson;

use App\Http\Requests\StoreUpdateLessonRequest;

class UpdateLessonDTO
{
    public function __construct(
        public string $id,
        public string $module_id,
        public string $name,
        public string $description,
        public string $video,
        public bool $published,
        public $file,
    ) {
    }

    public static function makeFromRequest(StoreUpdateLessonRequest  $request, string $id = null): self
    {
        // Se o file estiver presente na requisição, obtenha o UploadedFile correspondente
        $file = $request->hasFile('file') ? $request->file('file') : null;

        return new self(
            $id,
            $request->input('module_id'),
            $request->input('name'),
            $request->input('description'),
            $request->input('video'),
            $request->input('published'),
            $file
        );
    }
}
