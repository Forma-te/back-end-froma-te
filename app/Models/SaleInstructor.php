<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class SaleInstructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id', 'plan_id', 'transaction', 'quantity', 'status', 'date', 'price', 'total', 'email',
    ];

    public $items = [];

    public function __construct()
    {
        if (Session::has('cartPlan')) {
            $cartPlan = Session::get('cartPlan');
            $this->items = $cartPlan->items;
        }
    }

    public static function scopeUserByAuth($query)
    {
        return $query->where('instructor_id', auth()->user()->id);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
