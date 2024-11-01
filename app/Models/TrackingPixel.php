<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TrackingPixel extends Model
{
    use HasFactory;

    protected $fillable = [
        'producer_id',
        'product_id',
        'pixel_type',
        'pixel_value',
    ];

    public function producer()
    {
        return $this->belongsTo(User::class, 'producer_id');
    }

    public static function scopeProducerByAuth($query)
    {
        return $query->where('producer_id', Auth::user()->id);
    }

}
