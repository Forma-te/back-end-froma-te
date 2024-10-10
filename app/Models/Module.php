<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use OpenApi\Annotations as OA;

/**
 * Class Module.
 *
 * @OA\Schema(
 *     description="Module model",
 *     title="Module model",
 *     required={"course_id", "name"},
 *     @OA\Xml(
 *         name="Module"
 *     )
 * )
 */

class Module extends Model
{
    use HasFactory;

    /**
    * @OA\Property(
    *
    * )
    *
    * @var int
    */
    private $course_id;

    /**
    * @OA\Property(
    * )
    *
    * @var string
    */
    private $name;

    /**
    * @OA\Property(
    * )
    *
    * @var boolean
    */
    private $published;

    protected $fillable = [
        'product_id', 'name', 'published'
    ];

    // Verifica se o usuário atual é o proprietário do curso
    public function authorize()
    {
        $course = Product::find($this->get('product_id'));

        return Gate::allows('owner-course', $course);
    }

    // Definição da relação com o modelo Course
    public function course()
    {
        return $this->belongsto(Product::class);
    }

    // Obtém os módulos do usuário autenticado
    public function modulesUser()
    {
        return $this->join('products', 'products.id', '=', 'modules.product_id')
            ->where('products.user_id', Auth::user()->id)
            ->pluck('modules.name', 'modules.id');
    }

    public function lessons()
    {
        // Relação de um para muitos com o modelo Lesson
        return $this->hasMany(Lesson::class);
    }
}
