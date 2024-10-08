<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SaleSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'producer_id', 'plan_id', 'quantity', 'total', 'date_start', 'date_the_end', 'status',
    ];

    public function getDateStartAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getDateTheEndAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public static function scopeUserByAuth($query)
    {
        return $query->where('producer_id', Auth::user()->id);
    }

    public function producer()
    {
        return $this->belongsTo(User::class, 'producer_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
