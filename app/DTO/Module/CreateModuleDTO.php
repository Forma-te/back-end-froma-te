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
        $data = $request->all();
        $published = isset($data['published']) ? 1 : 0;

        return new self(
            $data['course_id'],
            $data['name'],
            $published
        );
    }
}
