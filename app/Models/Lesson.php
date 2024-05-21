<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id', 'name', 'file', 'url', 'description', 'free', 'video',

    ];

    public function rules($id = '')
    {
        return [
            'module_id' => 'required',
            'name' => 'required|min:5|max:100',
            'file' => 'nullable|file|mimes:pdf',
            'url' => "nullable|min:3|max:100|unique:lessons,url,{$id},id",
            'description' => 'nullable',
            'video' => 'nullable',

        ];
    }

    public function views()
    {
        return $this->hasMany(View::class)
            ->where(function ($query) {
                if (auth()->check()) {
                    return $query->where('user_id', auth()->user()->id);
                }
            });
    }

    public function modules()
    {
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }

    public function supports()
    {
        return $this->hasMany(Support::class);
    }

    protected function getFileAttribute($value)
    {
        return $value ? Storage::url($value) : null;
    }
}
