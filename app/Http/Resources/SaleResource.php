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
            'user_name' => $this->user->name,
            'email_member' => $this->email_member,
            'producer_name' => $this->producer->name,
            'transaction' => $this->transaction,
            'status' => $this->status,
            'payment_mode' => $this->payment_mode,
            'date_created' => $this->date_created,
            'date_expired' => $this->date_expired,
            'discount' => $this->discount,
            'sale_price' => $this->sale_price,
            'product_type' => $this->product_type
        ];
    }
}
