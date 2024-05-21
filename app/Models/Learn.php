<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learn extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'description',

    ];

    public function rules()
    {
        return [

            'course_id' => 'required',
            'description' => 'required|min:3|max:2000',

        ];
    }
}
