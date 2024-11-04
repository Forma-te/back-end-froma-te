<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'course_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function links()
    {
        return $this->hasMany(AffiliateLink::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }
}
