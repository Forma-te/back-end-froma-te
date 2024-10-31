<?php

namespace App\DTO\User;

use App\Http\Requests\StoreCustomerDetailsRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CreateCustomerDetailsDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $phone_number,
        public string $password,
    ) {
    }
    public static function makeFromRequest(StoreCustomerDetailsRequest $request): self
    {
        $data = $request->all();

        $password = generatePassword();

        Log::info('Senha gerada (hash):', ['password_hash' => ($password)]);

        return new self(
            $data['name'],
            $data['email'],
            $data['phone_number'],
            $password,
        );
    }
}
