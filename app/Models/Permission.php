<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description',
    ];

    public function rules()
    {
        return [
            'name' => 'required|min:3|max:60',
            'description' => 'required|min:3|max:200',

        ];
    }

    public function profiles()
    {
        return $this->belongsToMany(Profile::class);
    }
}
