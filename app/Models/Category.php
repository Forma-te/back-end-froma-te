<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'elegant_font',
    ];

    public function rules($id = '')
    {
        return [
            'name' => 'required|min:3|max:150',
            'description' => 'required|min:3|max:2000',
            'elegant_font' => 'required|min:3|max:100',
        ];
    }
}
