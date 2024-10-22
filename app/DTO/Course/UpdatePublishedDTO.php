<?php

namespace App\DTO\Course;

use App\Http\Requests\UpdatePublishedRequest;

class UpdatePublishedDTO
{
    public function __construct(
        public string $id,
        public string $published,
    ) {
    }

    public static function makeFromRequest(UpdatePublishedRequest $request, string $id = null): self
    {
        $data = $request->all();

        return new self(
            $id ?? $request->id,
            $data['published'],
        );
    }
}
