<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'identify' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'profile_photo_path' => $this->profile_photo_path,
            'bibliography' => $this->bibliography,
            'phone_number' => $this->phone_number,
            'bi' => $this->bi,
            'titular' => $this->titular,
            'bank' => $this->bank,
            'account_number' => $this->account_number,
            'whatsapp' => $this->whatsapp,
            'iban' => $this->iban,
            'foreign_iban' => $this->foreign_iban,
            'wise' => $this->wise,
            'paypal' => $this->paypal,
            'user_facebook' => $this->user_facebook,
            'user_instagram' => $this->user_instagram,
            'proof_path' => $this->proof_path
        ];
    }
}
