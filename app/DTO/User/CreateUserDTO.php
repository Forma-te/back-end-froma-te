<?php

namespace App\DTO\User;

use App\Http\Requests\StoreUpdateUserRequest;
use Illuminate\Support\Facades\Hash;

class CreateUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $device_name
    ) {
    }

    public static function makeFromRequest(StoreUpdateUserRequest $request): self
    {
        $data = $request->json()->all();

        $data['password'] = Hash::make($data['password']);

        return new self(
            $data['name'],
            $data['email'],
            $data['password'],
            $data['device_name']
        );
    }

}
