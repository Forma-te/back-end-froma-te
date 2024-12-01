<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreUpdateSaleRequest",
 *     required={"course_id", "name", "email_student", "blocked", "status", "date_expired"},
 *     @OA\Property(property="course_id", type="integer", description="ID of the course"),
 *     @OA\Property(property="user_id", type="integer", nullable=true, description="ID of the user"),
 *     @OA\Property(property="name", type="string", description="Name of the sale"),
 *     @OA\Property(property="instrutor_id", type="integer", nullable=true, description="ID of the instructor"),
 *     @OA\Property(property="transaction", type="string", nullable=true, description="Transaction ID"),
 *     @OA\Property(property="email_student", type="string", format="email", description="Email of the student"),
 *     @OA\Property(property="payment_mode", type="string", nullable=true, description="Payment mode"),
 *     @OA\Property(property="blocked", type="boolean", description="Blocked status"),
 *     @OA\Property(property="status", type="string", description="Status of the sale"),
 *     @OA\Property(property="date_expired", type="string", format="date", description="Expiration date of the sale")
 * )
 */

class StoreUpdateCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cart_id' => 'required|exists:carts,id',
            'user_id' => 'nullable',
            'name' => 'sometimes|required',
            'producer_id' => 'nullable',
            'transaction' => 'nullable',
            'email_member' => 'required|email',
            'payment_mode' => 'nullable',
            'blocked' => 'nullable',
            'status' => 'nullable',
        ];
    }
}
