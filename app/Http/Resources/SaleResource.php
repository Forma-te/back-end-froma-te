<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'sale_id' => $this->id,
            'product_id' => $this->product_id,
            'user_id' => $this->user_id,
            'user_name' => $this->member->name,
            'producer_id' => $this->instrutor_id,
            'producer_name' => $this->producer->name,
            'email_member' => $this->email_member,
            'transaction' => $this->transaction,
            'date_expired' => $this->date_expired,
            'status' => $this->status,
            'blocked' => $this->blocked,
            'payment_mode' => $this->payment_mode,
            'date_created' => $this->date_created,
            'discount' => $this->discount,
            'sale_price' => $this->sale_price,
            'product_type' => $this->product_type
        ];
    }
}
