<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReplySupportAdapterResource extends JsonResource
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
            'status' => $this->status,
            'status_label' => $this->statusOptions[$this->status] ?? 'Not Found Status',
            'description' => $this->description,
            'member' => new SupportUserResource($this->user),
            'lesson' => new SupportLessonResource($this->lesson),
            'dt_updated' => Carbon::make($this->updated_at)->format('d/m/Y H:i:s'),
         ];
    }
}
