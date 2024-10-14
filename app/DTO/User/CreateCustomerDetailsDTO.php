<?php

namespace App\DTO\User;

use App\Http\Requests\StoreCustomerDetailsRequest;
use Illuminate\Support\Facades\Hash;

class CreateCustomerDetailsDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $phone_number,
        public string $password,
        public string $device_name
    ) {
    }
    public static function makeFromRequest(StoreCustomerDetailsRequest $request): self
    {
        $data = $request->all();

        $password = generatePassword();

        return new self(
            $data['name'],
            $data['email'],
            $data['phone_number'],
            $password,
            $data['device_name']
        );
    }
}
