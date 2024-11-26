<?php

namespace App\DTO\User;

use App\Http\Requests\UpdatePasswordUserRequest;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordUserDTO
{
    public function __construct(
        public string $id,
        public string $password,
    ) {
    }

    public static function makeFromRequest(UpdatePasswordUserRequest $request, string $id = null): self
    {
        $data = $request->all();

        $data['password'] = Hash::make($data['password']);

        return new self(
            $id ?? $request->id,
            $data['password'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'password' => $this->password,
        ];
    }
}
