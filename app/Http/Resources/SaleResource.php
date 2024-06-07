<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'sale_id' => $this->id,
            'course_id' => $this->course_id,
            'user_id' => $this->user_id,
            'instrutor_id' => $this->instrutor_id,
            'email_student' => $this->email_student,
            'transaction' => $this->transaction,
            'date_expired' => $this->date_expired,
            'status' => $this->status,
            'payment_mode' => $this->payment_mode,
            'date_created' => $this->date_created
        ];
    }
}
