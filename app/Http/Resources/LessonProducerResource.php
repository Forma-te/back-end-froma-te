<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="LessonProducerResource",
 *     @OA\Property(property="id", type="integer", description="The ID of the lesson"),
 *     @OA\Property(property="name", type="string", description="The name of the lesson"),
 *     @OA\Property(property="description", type="string", description="The description of the lesson"),
 *     @OA\Property(property="video", type="string", description="The video associated with the lesson"),
 *     @OA\Property(property="file", type="string", description="The file associated with the lesson")
 * )
 */

class LessonProducerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resource = is_array($this->resource) ? (object) $this->resource : $this->resource;

        return [
            'id' => $resource->id ?? null,
            'name' => isset($resource->name) ? ucwords(strtolower($resource->name)) : null,
            'description' => $resource->description ?? null,
            'video' => $resource->video ?? null,
            'file' => $resource->file ?? null,
            'published' => $resource->published ?? null
        ];
    }
}
