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

    /**
     * @OA\Property(
     *     description="The ID of the lesson",
     *     example=1
     * )
     *
     * @var int
     */
    private $id;

    /**
     * @OA\Property(
     *     description="The ID of the module",
     *     example=10
     * )
     *
     * @var int
     */
    private $module_id;

    /**
     * @OA\Property(
     *     description="The name of the lesson",
     *     example="Introduction to Biology"
     * )
     *
     * @var string
     */
    private $name;

    /**
     * @OA\Property(
     *     description="The file associated with the lesson",
     *     example="path/to/file.pdf"
     * )
     *
     * @var string
     */
    private $file;

    /**
     * @OA\Property(
     *     description="The URL of the lesson",
     *     example="http://example.com/lesson"
     * )
     *
     * @var string
     */
    private $url;

    /**
     * @OA\Property(
     *     description="The description of the lesson",
     *     example="0F380364"
     * )
     *
     * @var string
     */
    private $description;

    /**
     * @OA\Property(
     *     description="Indicates if the lesson is free",
     *     example=true
     * )
     *
     * @var bool
     */
    private $free;

    /**
     * @OA\Property(
     *     description="The video associated with the lesson",
     *     example="http://example.com/video.mp4"
     * )
     *
     * @var string
     */
    private $video;

    protected $fillable = [
        'module_id', 'name', 'file', 'url', 'description', 'video', 'published'
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
