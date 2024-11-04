<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateLink extends Model
{
    use HasFactory;

    protected $fillable = ['affiliate_id', 'unique_code'];

    /**
      * Relacionamento com o modelo Affiliate.
      * Um link de afiliação pertence a um afiliado específico.
      */
    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    /**
     * Gera um código de link de afiliação único.
     *
     * Este método pode ser utilizado para gerar códigos de forma padronizada.
     */
    public static function generateUniqueCode()
    {
        return strtoupper(uniqid('AFFILIATE-'));
    }
}
