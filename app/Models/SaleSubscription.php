<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function producer()
    {
        return $this->belongsTo(User::class, 'producer_id');
    }

    public function my_plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
