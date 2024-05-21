<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Profile_user extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id', 'user_id'
    ];

  

}
