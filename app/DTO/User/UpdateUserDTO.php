<?php

namespace App\DTO\User;

use App\Http\Requests\StoreUpdateUserRequest;

class UpdateUserDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $bibliography,
        public string $phone_number,
        public string $bi,
        public $image
    ) {
    }

    public static function makeFromRequest(StoreUpdateUserRequest $request, string $id): self
    {
        $data = $request->all();

        $image = $request->hasFile('image') ? $request->file('image') : null;

        return new self(
            $id ?? $request->id,
            $data['name'],
            $data['email'],
            $data['bibliography'],
            $data['phone_number'],
            $data['bi'],
            $image
        );
    }

}
