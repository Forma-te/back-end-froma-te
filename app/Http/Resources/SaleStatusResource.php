<?php

namespace App\Http\Resources;

use App\Enum\statusEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        $user = collect($this->user);
        $product = collect($this->product);

        return collect([
            'id' => $this->id,
            'member' => $user->get('name'),
            'phone_number' => $user->get('phone_number'),
            'email_member' => $this->email_member,
            'product_name' => $product->get('name'),
            'product_type' => $this->product_type,
            'status' => $this->status,
            'sales_channel' => $this->sales_channel,
            'payment_mode' => $this->payment_mode,
            'date_created' => $this->date_created,
            'transaction' => $this->transaction,
            'price' => $product->get('price'),
            'sale_price' => $this->sale_price,
            'files' => $product->get('files'),
        ])->toArray();
    }
}
