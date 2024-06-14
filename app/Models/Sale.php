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
        'S' => 'Iniciado, Aguardar Validação',
        'A' => 'Aprovado',
        'E' => 'Expirado',
        'P' => 'Pendente'
    ];

    public function getDateAttribute($value)
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

    public function myCourses()
    {
        return $this->join('courses', 'courses.id', '=', 'sales.course_id')
            ->join('users', 'users.id', '=', 'sales.user_id')
            ->leftJoin('modules', 'modules.course_id', '=', 'courses.id')
            ->leftJoin('lessons', 'lessons.module_id', '=', 'modules.id')
            ->select('sales.id', 'courses.name', 'courses.image as course_image', 'courses.url', 'courses.description', 'users.image as student_image')
            ->selectSub(function ($query) {
                $query->selectRaw('COUNT(lessons.id)')
                    ->from('lessons')
                    ->join('modules', 'lessons.module_id', '=', 'modules.id')
                    ->join('courses', 'modules.course_id', '=', 'courses.id')
                    ->whereColumn('courses.id', 'sales.course_id');
            }, 'lesson_count')
            ->where('sales.instrutor_id', auth()->user()->id)
            ->where('sales.status', 'approved')
            ->where('courses.type', 'CURSO')
            ->distinct()
            ->get();
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

    public function myEbook()
    {
        return $this->join('courses', 'courses.id', '=', 'sales.course_id')
            ->select('sales.id', 'courses.name', 'courses.image', 'courses.url', 'courses.description')
            ->where('sales.user_id', auth()->user()->id)
            ->where('sales.status', 'approved')
            ->where('courses.type', 'E-BOOK')
            ->get();
    }

    public function mySales()
    {
        return $this->join('courses', 'courses.id', '=', 'sales.course_id')
            ->join('users', 'users.id', '=', 'sales.user_id')
            ->select('sales.transaction', 'sales.status', 'sales.date', 'sales.id', 'courses.name as course_name', 'courses.price', 'courses.url', 'courses.image', 'users.name as user_name', 'users.email as student_email', 'users.image as student_image')
            ->where('courses.user_id', auth()->user()->id)
            ->where('sales.status', 'approved')
            ->paginate(10);
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
