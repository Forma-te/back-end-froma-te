<?php

namespace App\DTO\Lesson;

use App\Http\Requests\StoreUpdateLessonRequest;

class UpdateLessonDTO
{
    public function __construct(
        public string $id,
        public ?string $module_id,
        public ?string $name,
        public ?string $url,
        public ?string $description,
        public ?string $free,
        public ?string $video,
        public ?string $published,
        public $file = null,
    ) {
    }

    public static function makeFromRequest(StoreUpdateLessonRequest  $request, string $id = null): self
    {
        $data = $request->all();
        $published = isset($data['published']) ? 1 : 0;
        $free = isset($data['free']) ? 1 : 0;

        // Se o file estiver presente na requisição, obtenha o UploadedFile correspondente
        $file = $request->hasFile('file') ? $request->file('file') : null;

        return new self(
            $id ?? $request->id,
            $data['module_id'],
            $data['name'],
            $data['url'],
            $data['description'],
            $free,
            $data['video'],
            $published,
            $file
        );
    }
}