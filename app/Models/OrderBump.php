<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class OrderBump extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'offer_product_id',
        'call_to_action',
        'title',
        'description',
        'show_image',
    ];

    /**
    * Relacionamento: Um OrderBump pertence a um Product.
    * Relacionamento com o produto principal
    */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relacionamento com o produto de oferta
    public function offerProduct()
    {
        return $this->belongsTo(Product::class, 'offer_product_id');
    }

    public static function scopeUserByAuth($query)
    {
        return $query->where('user_id', Auth::user()->id);
    }
}
