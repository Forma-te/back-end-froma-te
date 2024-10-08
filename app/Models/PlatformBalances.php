<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformBalances extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_value',
        'product_percentage',
        'total_balance',
        'available_balance',
        'pending_balance',
    ];
}
