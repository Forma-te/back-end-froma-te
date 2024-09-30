<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $this->loadMissing('modules.lessons');

        return [
            'course_id' => $this->id,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'name' => ucwords(strtolower($this->name)),
            'url' => $this->url,
            'description' => $this->description,
            'code' => $this->code,
            'total_hours' => $this->total_hours,
            'published' => $this->published,
            'free' => $this->free,
            'acceptsMcxPayment' => $this->acceptsMcxPayment,
            'acceptsRefPayment' => $this->acceptsRefPayment,
            'affiliationPercentage' => $this->affiliationPercentage,
            'discount' => $this->discount,
            'price' => $this->price,
            'imagem' => $this->image,
            'modules' => ModuleResource::collection($this->whenLoaded('modules'))
        ];
    }
}
