<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'categorias_id',
        'title',
        'url',
        'image',
        'file',
        'description',
        'date',
        'hour',
        'featured',
        'free',
        'status',
    ];

    public function rules($id = '')
    {
        return[
            'categorias_id' => 'required',
            'title' => "required|min:3|max:250,unique:posts,title,{$id},id",
            'url' => "required|min:3|max:250,unique:posts,url,{$id},id",
            'description' => 'required|min:50|max:6000',
            'date' => 'required|date',
            'hour' => 'required',
            'status' => 'required|in:A,R',
            'image' => 'image',
            'file' => 'file',

        ];
    }

    public function user()
    {
        //Relacionamento muitos por um
        return $this->belongsTo(User::class);
    }
}
