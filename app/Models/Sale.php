<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *     schema="Sale",
 *     title="Sale",
 *     description="Model representing a sale.",
 *     @OA\Property(
 *         property="course_id",
 *         type="integer",
 *         description="ID of the course related to the sale"
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="ID of the user who made the purchase"
 *     ),
 *     @OA\Property(
 *         property="instrutor_id",
 *         type="integer",
 *         description="ID of the instructor related to the course"
 *     ),
 *     @OA\Property(
 *         property="email_student",
 *         type="string",
 *         description="Email of the student who made the purchase"
 *     ),
 *     @OA\Property(
 *         property="payment_mode",
 *         type="string",
 *         description="Payment mode used for the purchase"
 *     ),
 *     @OA\Property(
 *         property="transaction",
 *         type="string",
 *         description="Transaction ID related to the purchase"
 *     ),
 *     @OA\Property(
 *         property="blocked",
 *         type="boolean",
 *         description="Indicates if the sale is blocked or not"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Status of the sale. Possible values: S (Iniciado, Aguardar Validação), A (Aprovado), E (Expirado), P (Pendente)",
 *         enum={"S", "A", "E", "P"},
 *         example="S"
 *     ),
 *     @OA\Property(
 *         property="date_created",
 *         type="string",
 *         format="date-time",
 *         description="Date and time when the sale was created"
 *     ),
 *     @OA\Property(
 *         property="date_expired",
 *         type="string",
 *         format="date-time",
 *         description="Date and time when the sale expires"
 *     )
 * )
 */

class Sale extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'course_id', 'user_id', 'instrutor_id', 'email_student', 'payment_mode', 'transaction', 'blocked', 'status', 'date_created', 'date_expired'
    ];

    public $statusOptions = [
        'C' => 'Iniciado, Aguardar Validação',
        'A' => 'Aprovado',
        'E' => 'Expirado',
        'P' => 'Pendente'
    ];

    public function getDateCreatedAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getDateExpiredAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function rules()
    {
        return [
            'course_id' => 'required',
            'name' => 'required',
            'email_student' => 'required|email',
            'bank' => 'nullable',
            'account' => 'nullable',
            'iban' => 'nullable',
            'date_expired' => 'required'
        ];
    }

    public static function scopeUserByAuth($query)
    {
        return $query->where('instrutor_id', auth()->user()->id);
    }


    public function getCourseForLoggedInStudent()
    {
        $studentId = Auth::id(); // Obtém o ID do aluno logado

        return $this->where('user_id', $studentId)
            ->where('status', 'approved')
            ->with('course')
            ->first()
            ->course;
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function instrutor()
    {
        return $this->belongsTo(User::class, 'instrutor_id');
    }
}
