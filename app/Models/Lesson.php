<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use OpenApi\Annotations as OA;

/**
 * Class Lesson.
 *
 * @OA\Schema(
 *     description="Lesson model",
 *     title="Lesson model",
 *     required={"module_id", "name"},
 *     @OA\Xml(
 *         name="Course"
 *     )
 * )
 */

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id', 'name', 'file', 'url', 'description', 'video', 'published', 'is_presentation'
    ];

    public function views()
    {
        return $this->hasMany(View::class)
            ->where(function ($query) {
                if (Auth::check()) {
                    return $query->where('user_id', Auth::user()->id);
                }
            });
    }

    public function modules()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function files()
    {
        return $this->hasMany(LessonFile::class, 'lesson_id');
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
