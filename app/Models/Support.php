<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Support extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'status', 'description', 'producer_id',  'lesson_id'];

    public $statusOptions = [
        'P' => 'Pendente, Aguardar Produtor',
        'A' => 'Aguardar Membro',
        'C' => 'Finalizado',
    ];

    public static function scopeOwnedByAuthUser($query)
    {
        return $query->where('producer_id', Auth::user()->id);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function replies()
    {
        return $this->hasMany(ReplySupport::class);
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

}
