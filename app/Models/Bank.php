<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'bank', 'account', 'iban', 'phone_number',
    ];

    public function rules($id = '') 
    {
        return [

            'bank' => 'required',
            'account' => 'required|unique:banks',
            'iban' => 'required|unique:banks',
            'phone_number' => 'required',
        ];
    }
}
