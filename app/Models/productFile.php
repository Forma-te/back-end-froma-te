<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class productFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'file',
        'image',
        'type'
    ];

    // Relacionamento com o model Product (Curso)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    protected function getImageAttribute($value)
    {
        return $value ? Storage::url($value) : null;
    }

    protected function getFileAttribute($value)
    {
        return $value ? Storage::url($value) : null;
    }
}
