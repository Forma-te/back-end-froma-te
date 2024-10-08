<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBalance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_balance',
        'available_balance',
        'pending_balance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
