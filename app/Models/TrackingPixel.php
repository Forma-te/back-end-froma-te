<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingPixel extends Model
{
    use HasFactory;

    protected $fillable = [
        'producer_id',
        'pixel_type',
        'pixel_value',
    ];

    public function producer()
    {
        return $this->belongsTo(User::class, 'producer_id');
    }
}
