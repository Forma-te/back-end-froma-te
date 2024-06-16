<?php

namespace App\Repositories\Member;

use App\Models\Course;
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
        try {
            // Obter cursos com módulos, lições e visualizações
            $courses = $this->entity->with('modules.lessons.views')->get();
            // Log dos cursos obtidos
            Log::info('Cursos obtidos: ', $courses->toArray());

            return $courses;
        } catch (\Exception $e) {
            // Registar o erro
            Log::error('Erro ao obter cursos: ' . $e->getMessage());
            // Lançar exceção ou retornar uma resposta adequada
            throw new \Exception('Erro ao obter cursos');
        }
    }

    public function getCourseByIdMember(string $identify)
    {
        return $this->entity->with('modules.lessons')->findOrFail($identify);
    }
}
