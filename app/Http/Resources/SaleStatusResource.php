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
        $statusLabel = statusEnum::tryFrom($this->status)?->label() ?? 'Desconhecido';

        return collect($this->resource)
            ->merge([
                'status' => $statusLabel,

            ]);
    }
}
