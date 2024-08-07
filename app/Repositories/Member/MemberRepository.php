<?php

namespace App\Repositories\Member;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MemberRepository
{
    protected $entity;

    public function __construct(Course $model)
    {
        $this->entity = $model;
    }

    public function getAllCourseMember()
    {
        if (Auth::check()) {
            $loggedInUserId = Auth::id();

            return $this->entity->whereHas('users', function ($query) use ($loggedInUserId) {
                $query->where('users.id', $loggedInUserId);
            })->whereHas('sales', function ($query) {
                $query->where('sales.status', 'A');
            })->with('modules.lessons.views')->get();
        } else {
            return [];
        }
    }

    public function getCourseByIdMember(string $identify)
    {
        // Tenta encontrar o curso pelo ID
        $course = $this->entity->findOrFail($identify);

        // Verifica se o curso tem usuários associados e vendas com status "A"
        $course = $this->entity->where('id', $identify)
                               ->whereHas('users', function ($query) {
                               })
                               ->whereHas('sales', function ($query) {
                                   $query->where('sales.status', 'A');
                               })
                               ->with('modules.lessons')
                               ->first();

        // Retorna o resultado ou um array vazio se não encontrar nada
        return $course ?: [];
    }

}
