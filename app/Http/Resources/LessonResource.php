<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => ucwords(strtolower($this->name)),
            'description' => $this->description,
            'video' => $this->video,
            'file' => $this->file,
            'published' => $this->published,
            'views' => ViewResource::collection($this->whenLoaded('views')),
        ];
    }
}
