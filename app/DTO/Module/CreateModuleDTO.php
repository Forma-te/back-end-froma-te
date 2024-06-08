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

        return new self(
            $data['course_id'],
            $data['name'],
            $data['published']
        );
    }
}
