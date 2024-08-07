<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CartPlanResource",
 *     type="object",
 *     title="Cart Plan Resource",
 *     properties={
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="Basic Plan"),
 *         @OA\Property(property="price", type="number", format="float", example=19.99),
 *         @OA\Property(property="description", type="string", example="This is a basic plan."),
 *         @OA\Property(property="published", type="boolean", example=true)
 *     }
 * )
 */
class cartPlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->url,
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'published' => $this->published
        ];
    }
}
