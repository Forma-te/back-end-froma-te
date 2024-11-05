<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
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
