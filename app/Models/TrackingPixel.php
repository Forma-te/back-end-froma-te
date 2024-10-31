<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingPixel extends Model
{
    use HasFactory;

    protected $fillable = [
        'producer_id',
        'facebook_pixel',
        'tiktok_pixel',
        'google_analytics_id',
        'google_ads_id',
        'linkedin_pixel',
        'twitter_pixel',
    ];

    public function producer()
    {
        return $this->belongsTo(User::class);
    }
}
