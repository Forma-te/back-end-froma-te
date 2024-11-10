<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Affiliate extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'affiliate_link_id', 'producer_id', 'product_id', 'product_url', 'status'];

    public static function scopeUserByAuth($query)
    {
        return $query->where('user_id', Auth::user()->id);
    }

    public static function scopeProducerByAuth($query)
    {
        return $query->where('producer_id', Auth::user()->id);
    }


    // Relacionamento com o link de afiliação
    public function affiliateLink()
    {
        return $this->belongsTo(AffiliateLink::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function producer()
    {
        return $this->belongsTo(User::class, 'producer_id'); // Define o produtor como o dono
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
