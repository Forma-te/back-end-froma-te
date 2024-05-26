<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'identify' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'elegant_font' => $this->elegant_font,
            'data_criacao' => Carbon::make($this->created_at)->format('d-m-Y')
        ];
    }
}
