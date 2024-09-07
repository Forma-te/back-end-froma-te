<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *     schema="Support",
 *     type="object",
 *     title="Support",
 *     description="Support model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the support request",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Status of the support request",
 *         example="P",
 *         enum={"P", "A", "C"}
 *     ),
 *     @OA\Property(
 *         property="status_label",
 *         type="string",
 *         description="Human-readable status label",
 *         example="Pendente, Aguardar Professor"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the support request",
 *         example="The lesson field is required. (and 2 more errors)"
 *     ),
 *     @OA\Property(
 *         property="lesson_id",
 *         type="integer",
 *         description="ID of the associated lesson",
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="user",
 *         type="object",
 *         ref="#/components/schemas/User"
 *     ),
 *     @OA\Property(
 *         property="lesson",
 *         type="object",
 *         ref="#/components/schemas/Lesson"
 *     ),
 *     @OA\Property(
 *         property="dt_updated",
 *         type="string",
 *         description="Date and time when the support request was last updated",
 *         example="17/06/2024 22:50:36"
 *     )
 * )
 */

class Support extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'status', 'description', 'producer_id',  'lesson_id'];

    public $statusOptions = [
        'P' => 'Pendente, Aguardar Professor',
        'A' => 'Aguardar Aluno',
        'C' => 'Finalizado',
    ];

    public static function scopeOwnedByAuthUser($query)
    {
        return $query->where('producer_id', Auth::user()->id);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function replies()
    {
        return $this->hasMany(ReplySupport::class);
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

}
