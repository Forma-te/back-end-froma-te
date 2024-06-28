<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInstructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'producer_id', 'plan_id', 'transaction', 'quantity', 'status', 'date', 'price', 'total', 'email',
    ];

    public static function scopeUserByAuth($query)
    {
        return $query->where('producer_id', auth()->user()->id);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
