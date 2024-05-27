<?php

namespace App\DTO\Module;

use App\Http\Requests\StoreUpdateModuleRequest;

class CreateModuleDTO
{
    public function __construct(
        public string $course_id,
        public string $name,
        public bool $published
    ) {
    }

    public static function makeFromRequest(StoreUpdateModuleRequest $request): self
    {
        return new self(
            $request->input('course_id'),
            $request->input('name'),
            $request->input('published', false)
        );
    }
}
