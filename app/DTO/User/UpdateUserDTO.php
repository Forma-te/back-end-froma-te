<?php

namespace App\DTO\User;

use App\Http\Requests\StoreUpdateUserRequest;

class UpdateUserDTO
{
    public function __construct(
        public string $id,
        public ?string $name = null,
        public ?string $email = null,
        public ?string $password = null,
        public ?string $bibliography = null,
        public ?string $phone_number = null,
        public ?string $image = null,
        public ?array $addresses = null
    ) {
    }

    public static function makeFromRequest(StoreUpdateUserRequest $request, string $id): self
    {
        $data = $request->validated();

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        return new self(
            $id,
            $data['name'] ?? null,
            $data['email'] ?? null,
            $data['password'] ?? null,
            $data['bibliography'] ?? null,
            $data['phone_number'] ?? null,
            $data['image'] ?? null,
            $data['addresses'] ?? null
        );
    }
}
