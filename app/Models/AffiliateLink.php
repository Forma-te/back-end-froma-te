<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateLink extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'unique_code'];

    // Relacionamento com o usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com as afiliações (produtos afiliados)
    public function affiliates()
    {
        return $this->hasMany(Affiliate::class);
    }
}
