<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = ['affiliate_id', 'affiliate_link_id', 'amount', 'status'];

    /**
     * Relacionamento com o modelo Affiliate.
     * Cada comissão pertence a um afiliado específico.
     */
    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    /**
     * Relacionamento com o modelo AffiliateLink.
     * Cada comissão é gerada a partir de um link de afiliação específico.
     */
    public function affiliateLink()
    {
        return $this->belongsTo(AffiliateLink::class);
    }

    /**
     * Escopo para comissões pendentes.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Escopo para comissões pagas.
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }
}
