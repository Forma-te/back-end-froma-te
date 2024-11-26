<?php

namespace App\DTO\User;

use App\Http\Requests\StoreUpdateUserRequest;

class UpdateUserDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $bank,
        public string $phone_number,
        //public string $bi,
        public string $titular,
        public string $account_number,
        public string $whatsapp,
        public string $iban,
        public string $foreign_iban,
        public string $wise,
        public string $paypal,
        public string $user_facebook,
        public string $user_instagram,
        public $proof_path = null,
        public $profile_photo_path = null
    ) {
    }

    public static function makeFromRequest(StoreUpdateUserRequest $request, string $id): self
    {
        $data = $request->all();

        $proof_path = $request->hasFile('proof_path') ? $request->file('proof_path') : null;

        $profile_photo_path = $request->hasFile('profile_photo_path') ? $request->file('profile_photo_path') : null;

        return new self(
            $id ?? $request->id,
            $data['name'],
            $data['email'],
            $data['bank'],
            $data['phone_number'],
            //$data['bi'],
            $data['titular'],
            $data['account_number'],
            $data['whatsapp'],
            $data['iban'],
            $data['foreign_iban'],
            $data['wise'],
            $data['paypal'],
            $data['user_facebook'],
            $data['user_instagram'],
            $proof_path,
            $profile_photo_path
        );
    }

}
