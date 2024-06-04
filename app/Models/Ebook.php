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
 *     required={"category_id", "user_id", "name"},
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
    * @var double
    */
    private $price;

    protected $fillable = [
        'category_id', 'user_id', 'name', 'url', 'image', 'code', 'price'
    ];

    public static function scopeUserByAuth($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class); // Definindo o relacionamento "has many" com o modelo Sale
    }

    public function ebookContents()
    {
        //Metodo para retornar os EbookContent do ebook relação de um para muitos
        return $this->hasMany(EbookContent::class);
    }
}
