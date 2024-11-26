<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Category",
 *     type="object",
 *     title="Category",
 *     description="Category model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the category",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the category",
 *         example="Science"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the category",
 *         example="Courses related to scientific subjects"
 *     ),
 *     @OA\Property(
 *         property="elegant_font",
 *         type="string",
 *         description="Elegant font associated with the category",
 *         example="Serif"
 *     )
 * )
 */

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'elegant_font',
    ];

    /**
     * Define the validation rules for the Category model.
     *
     * @param string $id Optional ID for the category, used for unique validation rules.
     * @return array Validation rules
     */

    public function rules($id = '')
    {
        return [
            'name' => 'required|min:3|max:150',
            'description' => 'required|min:3|max:2000',
            'elegant_font' => 'required|min:3|max:100',
        ];
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
