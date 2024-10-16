<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LessonFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id', 'file'
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }

    protected function getFileAttribute($value)
    {
        return $value ? Storage::url($value) : null;
    }
}
