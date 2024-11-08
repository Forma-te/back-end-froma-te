<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Affiliate extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'affiliate_link_id', 'product_id', 'product_url', 'status'];

    public static function scopeUserByAuth($query)
    {
        return $query->where('user_id', Auth::user()->id);
    }


    // Relacionamento com o link de afiliação
    public function affiliateLink()
    {
        return $this->belongsTo(AffiliateLink::class);
    }

    // Relacionamento com o usuário (afiliado)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com o produto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
