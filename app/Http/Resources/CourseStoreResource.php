<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CourseStoreResource",
 *     @OA\Property(property="id", type="integer", description="The ID of the course"),
 *     @OA\Property(property="category_id", type="integer", description="The ID of the category"),
 *     @OA\Property(property="user_id", type="integer", description="The ID of the user"),
 *     @OA\Property(property="name", type="string", description="The name of the course"),
 *     @OA\Property(property="url", type="string", description="The URL of the course"),
 *     @OA\Property(property="description", type="string", description="The description of the course"),
 *     @OA\Property(property="code", type="string", description="The code of the course"),
 *     @OA\Property(property="total_hours", type="string", description="The total hours of the course"),
 *     @OA\Property(property="published", type="boolean", description="The published status of the course"),
 *     @OA\Property(property="free", type="boolean", description="The free status of the course"),
 *     @OA\Property(property="price", type="number", format="float", description="The price of the course"),
 *     @OA\Property(property="available", type="boolean", description="The availability of the course"),
 *     @OA\Property(property="image", type="string", description="The image of the course")
 * )
 */

class CourseStoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'course_id' => $this->id,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'name' => $this->name,
            'url' => $this->url,
            'description' => $this->description,
            'code' => $this->code,
            'total_hours' => $this->total_hours,
            'published' => $this->published,
            'free' => $this->free,
            'price' => $this->price,
            'available' => $this->available,
            'imagem' => $this->image,
            'discount' => $this->discount,
            'acceptsMcxPayment' => $this->acceptsMcxPayment,
            'acceptsRefPayment' => $this->acceptsRefPayment,
            'affiliationPercentage' => $this->affiliationPercentage,
        ];
    }
}
