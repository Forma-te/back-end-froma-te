<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'bank', 'account', 'iban', 'phone_number', 'nif',
    ];

    public function rules($id = '')
    {
        return [
            'name' => 'required|min:5|max:255',
            'description' => 'nullable',
            'bank' => 'required',
            'account' => 'required|unique:banks',
            'iban' => 'required|unique:banks',
            'phone_number' => 'required',
            'nif' => 'required',
        ];
    }
}
