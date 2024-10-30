<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Sale extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'product_id', 'user_id', 'producer_id', 'email_member', 'payment_mode', 'transaction', 'blocked', 'status', 'date_created',
        'date_expired', 'discount', 'sale_price', 'sales_channel', 'product_type'
    ];

    public $statusOptions = [
        'C' => 'Iniciado, Aguardar Validação',
        'A' => 'Aprovado',
        'E' => 'Expirado',
        'P' => 'Pendente'
    ];

    public function setEmailMemberAttribute($value)
    {
        $this->attributes['email_member'] = strtolower($value);
    }

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
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ];
    }

    public static function scopeUserByAuth($query)
    {
        return $query->where('producer_id', Auth::user()->id);
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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function producer()
    {
        return $this->belongsTo(User::class, 'producer_id');
    }
}
