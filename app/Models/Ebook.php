<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * Class Ebook.
 *
 * @OA\Schema(
 *     description="Ebook model",
 *     title="Ebook model",
 *     required={"category_id", "name"},
 *     @OA\Xml(
 *         name="Ebook"
 *     )
 * )
 */

class Ebook extends Model
{
    use HasFactory;

    /**
    * @OA\Property(
    *
    * )
    *
    * @var int
    */
    private $category_id;

    /**
     * @OA\Property(
     *
     * )
     *
     * @var int
     */

    private $user_id;

    /**
     * @OA\Property(
     *
     * )
     *
     * @var string
     */

    private $name;

    /**
    * @OA\Property(
    *
    * )
    *
    * @var string
    */

    private $url;

    /**
     * @OA\Property(
     *
     * )
     *
     * @var string
     */
    private $description;

    /**
    * @OA\Property(
    *
    * )
    *
    * @var string
    */
    private $image;

    /**
    * @OA\Property(
    *
    * )
    *
    * @var string
    */
    private $code;

    /**
    * @OA\Property(
    * )
    *
    * @var boolean
    */
    private $free;

    /**
    * @OA\Property(
    *
    * )
    *
    * @var boolean
    */
    private $published;

    /**
    * @OA\Property(
    * )
    *
    * @var double
    */
    private $price;



    protected $fillable = [
        'category_id', 'user_id', 'name', 'url','description', 'image', 'code', 'published', 'free',
        'price'
    ];

    public static function scopeUserByAuth($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }
}
