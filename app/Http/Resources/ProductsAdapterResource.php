<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsAdapterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return collect([
            'product_id' => $this->product_id,
            'name' => $this->name,
            'price' => $this->price,
            'product_type' => $this->product_type,
            'created_at' => $this->created_at,
            'files' => $this->files,
            'total_members' => $this->total_members,
            'total_revenue' => $this->total_revenue,
        ])->toArray();
    }
}
