<?php

namespace App\DTO\User;

use App\Http\Requests\StoreCustomerDetailsRequest;
use Illuminate\Support\Facades\Hash;

class CreateCustomerDetailsDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $phone_number,
        public string $device_name
    ) {
    }
    public static function makeFromRequest(StoreCustomerDetailsRequest $request): self
    {
        $data = $request->all();

        //$data['password'] = Hash::make($data['password']);

        return new self(
            $data['name'],
            $data['email'],
            $data['password'],
            $data['phone_number'],
            $data['device_name']
        );
    }
}
