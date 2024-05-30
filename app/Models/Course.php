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
 * @author  Moises Bumba <doniysa@gmail.com>
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
    * )
    *
    * @var int
    */
    private $category_id;

    /**
     * @OA\Property(
     *    title="category_id",
     * )
     *
     * @var int
     */

    private $user_id;

    /**
     * @OA\Property(
     *    title="name",
     * )
     *
     * @var string
     */

    private $name;

    /**
    * @OA\Property(
    *    title="url",
    * )
    *
    * @var string
    */

    private $url;

    /**
     * @OA\Property(
     *    title="description",
     * )
     *
     * @var text
     */
    private $description;

    /**
    * @OA\Property(
    *    title="image",
    * )
    *
    * @var string
    */
    private $image;

    /**
    * @OA\Property(
    *    title="code",
    * )
    *
    * @var string
    */
    private $code;

    /**
    * @OA\Property(
    *    title="total_hours",
    * )
    *
    * @var time
    */
    private $total_hours;


    /**
    * @OA\Property(
    *    title="free",
    * )
    *
    * @var boolean
    */
    private $free;

    /**
    * @OA\Property(
    *    title="published",
    * )
    *
    * @var boolean
    */
    private $published;

    /**
    * @OA\Property(
    *    title="price",
    * )
    *
    * @var double
    */
    private $price;


    protected $fillable = [
        'category_id', 'user_id', 'name', 'url', 'description', 'image', 'code', 'total_hours', 'published', 'free',
        'price'
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
