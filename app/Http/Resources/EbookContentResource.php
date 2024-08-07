<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="EbookContentResource",
 *     type="object",
 *     title="Ebook Content Resource",
 *     description="Resource representation of Ebook Content",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The ID of the ebook content"
 *     ),
 *     @OA\Property(
 *         property="ebook_id",
 *         type="integer",
 *         description="The ID of the associated ebook"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the ebook content"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="The description of the ebook content"
 *     ),
 *     @OA\Property(
 *         property="file",
 *         type="string",
 *         description="The file associated with the ebook content"
 *     ),
 *     @OA\Property(
 *         property="free",
 *         type="boolean",
 *         description="Indicates if the ebook content is free"
 *     ),
 *     @OA\Property(
 *         property="published",
 *         type="boolean",
 *         description="Indicates if the ebook content is published"
 *     )
 * )
 */

class EbookContentResource extends JsonResource
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
            'ebook_id' => $resource->ebook_id ?? null,
            'name' => isset($resource->name) ? ucwords(strtolower($resource->name)) : null,
            'description' => $resource->description ?? null,
            'file' => $resource->file ?? null,
            'free' => $resource->free ?? null,
            'published' => $resource->published ?? null
        ];
    }
}
