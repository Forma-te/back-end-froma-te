<?php

namespace App\DTO\Module;

use App\Http\Requests\StoreUpdateModuleRequest;

class UpdateModuleDTO
{
    public function __construct(
        public string $id,
        public string $course_id,
        public string $name,
        public bool $published
    ) {
    }

    public static function makeFromRequest(StoreUpdateModuleRequest $request, string $id): self
    {
        return new self(
            $id,
            $request->input('course_id'),
            $request->input('name'),
            $request->input('published')
        );
    }
}
