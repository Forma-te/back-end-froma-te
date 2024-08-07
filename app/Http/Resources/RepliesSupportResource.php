<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RepliesSupportResource extends JsonResource
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
           'status' => $this->status,
           'status_label' => $this->statusOptions[$this->status] ?? 'Not Found Status',
           'description' => $this->description,
           'user' => UserResource::collection($this->whenLoaded('user')),
           'lesson' => new LessonResource($this->lesson),
           'replies' => ReplySupportResource::collection($this->whenLoaded('replies')),
           'dt_updated' => Carbon::make($this->updated_at)->format('d/m/Y H:i:s'),
        ];
    }
}
