<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ModuleProducerResource",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The ID of the module"
 *     ),
 *     @OA\Property(
 *         property="course_id",
 *         type="integer",
 *         description="The ID of the course"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the module"
 *     ),
 *     @OA\Property(
 *         property="published",
 *         type="boolean",
 *         description="The published status of the module"
 *     )
 * )
 */

class ModuleProducerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'identify' => $resource->id ?? null,
            'course_id' => $resource->course_id ?? null,
            'name' => isset($resource->name) ? ucwords(strtolower($resource->name)) : null,
            'published' => $resource->published ?? null,
            'lessons' => LessonResource::collection($this->whenLoaded('lessons')),

        ];
    }
}
