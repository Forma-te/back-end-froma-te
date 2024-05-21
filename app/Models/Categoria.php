<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'url', 'description', 'image',
    ];

    public function rules($id = '')
    {
        return [
            'name' => 'required|min:3|max:100',
            'url' => "required|min:3|max:100|unique:categorias,url,{$id},id",
            'description' => 'required|min:3|max:200',
            'image' => 'image',
        ];
    }

    public function posts()
    {
        //Metodo para retornar os posts da categoria com a relação de um para muitos
        return $this->hasMany(Post::class, 'categorias_id');
    }
}
