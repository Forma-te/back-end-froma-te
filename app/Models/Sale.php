<?php

namespace App\Models;

use App\Mail\NewSaleStudent;
use App\Mail\SendMailNewStudentSale;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Sale extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'course_id', 'user_id', 'instrutor_id', 'email_student', 'payment_mode', 'transaction', 'status', 'date_created', 'date_expired'
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
            'email' => 'required|email',
            'bank' => 'nullable',
            'account' => 'nullable',
            'iban' => 'nullable',
            'date_expired' => 'required',

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
            ->where('sales.user_id', auth()->user()->id)
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

    public function mySales($keySearch)
    {
        return $this->join('courses', 'courses.id', '=', 'sales.course_id')
            ->join('users', 'users.id', '=', 'sales.user_id')
            ->select('sales.transaction', 'sales.status', 'sales.date', 'sales.id', 'courses.name as course_name', 'courses.price', 'courses.url', 'courses.image', 'users.name as user_name', 'users.email as student_email', 'users.image as student_image')
            ->Where('sales.email_student', 'LIKE', "%{$keySearch}%")
            ->where('courses.user_id', auth()->user()->id)
            ->where('sales.status', 'approved')
            ->paginate(10);
    }

    public function mySalesExpired()
    {
        return $this->join('courses', 'courses.id', '=', 'sales.course_id')
            ->join('users', 'users.id', '=', 'sales.user_id')
            ->select('sales.transaction', 'sales.status', 'sales.date', 'sales.id', 'courses.name as course_name', 'courses.price', 'courses.url', 'courses.image', 'users.name as user_name', 'users.email as student_email', 'users.image as student_image')
            ->where('courses.user_id', auth()->user()->id)
            ->where('sales.status', 'expired')
            ->get();
    }

    public function myStudents($keySearch)
    {
        return $this->mySales($keySearch);

    }

    public function newSale($data)
    {
        $course = Course::where('code', $data['prod'])->get()->first();
        if ($course == null) {
            return response()->json(['error' => 'Curso nao encontrado'], 404);
        }

        $user = User::where('id', $data['hottok'])->get()->first();

        $bankusers = Bank::where('user_id', $user['id'])->get();

        $Bank_transfer = 'Transferência bancaria';

        if ($user == null) {
            return response()->json(['error' => 'Instrutor nao encontrado'], 404);
        }

        if ($course->user_id != $user->id) {
            return response()->json(['error' => 'Not Permission'], 401);
        }

        if ($data['status'] == 'canceled') {
            $sale = Sale::where('transaction', $data['transaction'])->get()->first();

            if ($sale) {
                Sale::where('transaction', $data['transaction'])->update([
                    'status' => 'canceled',
                ]);
            }
        }
        if ($data['status'] != 'started') {
            return response()->json(['status' => 'Pedido não Liberado'], 200);
        }

        $student = User::where('email', $data['email'])->get()->first();

        if ($student == null) {
            $password = generatePassword();
            $student = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'url' => createUrl($data['name']),
                'password' => bcrypt($password),
            ]);
            Mail::to($data['email'])->send(new SendMailNewStudentSale($student, $course, $password, $bankusers));
        } else {
            Mail::to($data['email'])->send(new NewSaleStudent($student, $course, $bankusers));
        }

        //$date = Carbon::createFromFormat('d/m/Y', $request->purchase_date)->format('Y-m-d');
        $date = Carbon::createFromFormat('d/m/Y', $data['purchase_date'])->format('Y-m-d');
        $newSale = Sale::create([
            'course_id' => $course->id,
            'user_id' => $student->id,
            'instrutor_id' => $user->id,
            'payment_mode' => $Bank_transfer,
            'email_student' => $student->email,
            'transaction' => $data['transaction'],
            'status' => $data['status'],
            'date' => $date,
        ]);

        if ($newSale) {
            return redirect()
                ->route('encomennda.success')
                ->with(['success' => 'Encomenda realizado com sucesso']);
        } else {
            return response()->json(['error' => 'Fail Insert', 500]);
        }
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
