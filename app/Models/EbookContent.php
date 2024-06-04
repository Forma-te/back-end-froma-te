<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use OpenApi\Annotations as OA;

/**
 * Class EbookContent.
 *
 * @OA\Schema(
 *     description="EbookContent model",
 *     title="EbookContent model",
 *     required={"ebook_id", "name"},
 *     @OA\Xml(
 *         name="EbookContent"
 *     )
 * )
 */

class EbookContent extends Model
{
    use HasFactory;

    /**
    * @OA\Property(
    *
    * )
    *
    * @var int
    */
    private $ebook_id;

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
    private $description;

    /**
    * @OA\Property(
    *
    * )
    *
    * @var string
    */
    private $file;

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


    protected $fillable = [
        'ebook_id', 'name', 'description', 'file', 'published', 'free'
    ];

    // Verifica se o usuário atual é o proprietário do curso
    public function authorize()
    {
        $ebook = course::find($this->get('ebook_id'));

        return Gate::allows('owner-course', $ebook);
    }

    // Definição da relação com o modelo Course
    public function ebook()
    {
        return $this->belongsto(Ebook::class);
    }
}
