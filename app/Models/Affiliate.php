<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Affiliate extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'product_url', 'status'];

    public static function scopeUserByAuth($query)
    {
        return $query->where('user_id', Auth::user()->id);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function affiliateLink()
    {
        return $this->hasOne(AffiliateLink::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }
}
