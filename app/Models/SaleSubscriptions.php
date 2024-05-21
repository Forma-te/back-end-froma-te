<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SaleSubscriptions extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id', 'plan_id', 'quantity', 'total', 'date_start', 'date_the_end', 'status',
    ];

    public function getDateStartAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getDateTheEndAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function scopeFirstRecordPerUser($query)
    {
        return $query->select('instructor_id', DB::raw('MIN(created_at) AS created_at'))
        ->groupBy('instructor_id')
        ->orderBy('created_at', 'asc');
    }

    public static function scopeUserByAuth($query)
    {
        return $query->where('instructor_id', auth()->user()->id);
    }

    public function my_plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }


}
