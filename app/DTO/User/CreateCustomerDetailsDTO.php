<?php

namespace App\DTO\User;

use App\Http\Requests\StoreCustomerDetailsRequest;

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

        // Gera uma senha apenas se não estiver definida no pedido
        $password = $data['password'] ?? generatePassword();

        // Log::info('Senha gerada (hash):', ['password_hash' => ($password)]);

        return new self(
            $data['name'],
            $data['email'],
            $data['phone_number'],
            $password,
        );
    }
}
