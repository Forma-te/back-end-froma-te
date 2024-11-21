<?php

namespace App\DTO\User;

use App\Http\Requests\UpdateBibliographyRequest;

class UpdateBibliographyUserDTO
{
    public function __construct(
        public string $id,
        public string $bibliography,
    ) {
    }

    public static function makeFromRequest(UpdateBibliographyRequest $request, string $id = null): self
    {
        $data = $request->all();

        return new self(
            $id ?? $request->id,
            $data['bibliography'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'bibliography' => $this->bibliography,
        ];
    }
}
