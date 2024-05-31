<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

use OpenApi\Annotations as OA;

/**
 * Class Course.
 *
 * @OA\Schema(
 *     description="Course model",
 *     title="Course model",
 *     required={"category_id", "name"},
 *     @OA\Xml(
 *         name="Course"
 *     )
 * )
 */

class Course extends Model
{
    use HasFactory;


    /**
    * @OA\Property(
    *    title="category_id",
    *    type="integer"
    * )
    */

    /**
     * @OA\Property(
     *    title="user_id",
     *    type="integer"
     * )
     */

    /**
     * @OA\Property(
     *    title="name",
     *    type="string"
     * )
     */

    /**
    * @OA\Property(
    *    title="url",
    *    type="string"
    * )
    */

    /**
     * @OA\Property(
     *    title="description",
     *    type="string"
     * )
     */

    /**
    * @OA\Property(
    *    title="image",
    *    type="string"
    * )
    */

    /**
    * @OA\Property(
    *    title="code",
    *    type="string"
    * )
    */

    /**
    * @OA\Property(
    *    title="total_hours",
    *    type="integer"
    * )
    */

    /**
    * @OA\Property(
    *    title="free",
    *    type="boolean"
    * )
    */

    /**
    * @OA\Property(
    *    title="published",
    *    type="boolean"
    * )
    */

    /**
    * @OA\Property(
    *    title="price",
    *    type="number",
    *    format="float"
    * )
    */


    protected $fillable = [
        'category_id', 'user_id', 'name', 'url', 'description', 'image', 'code', 'total_hours', 'published', 'free', 'price'
    ];

    public static function scopeUserByAuth($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class); // Definindo o relacionamento "has many" com o modelo Sale
    }

    public function modules()
    {
        //Metodo para retornar os modulos dos cursos relação de um para muitos
        return $this->hasMany(Module::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function usersCourse()
    {
        return $this->belongsToMany(User::class, 'sales', 'course_id', 'user_id')
            ->select('sales.course_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'sales', 'course_id', 'user_id')
            ->where('sales.status', 'approved');
    }

    public function usersEnrolled()
    {
        return $this->belongsToMany(User::class, 'sales', 'course_id', 'user_id')
            ->where('sales.status', 'expired');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    protected function getImageAttribute($value)
    {
        return $value ? Storage::url($value) : null;
    }
}
