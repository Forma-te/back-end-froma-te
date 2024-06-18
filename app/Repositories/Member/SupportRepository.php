<?php

namespace App\Repositories\Member;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Support;
use App\Repositories\Traits\RepositoryTrait;

class SupportRepository extends Controller
{
    use RepositoryTrait;

    protected $entity;

    public function __construct(Support $model)
    {
        $this->entity = $model;
    }

    public function createNewSupport(array $data): Support
    {
        // Recuperar a lição pelo ID
        $lesson = Lesson::findOrFail($data['lesson']);

        // Verificar se a lição tem um módulo associado
        $module = $lesson->modules;
        if (!$module) {
            throw new \Exception("Module not found for the given lesson ID.");
        }

        // Verificar se o módulo tem um curso associado
        $course = $module->course;
        if (!$course) {
            throw new \Exception("Course not found for the given module ID.");
        }

        // Obter o instrutor associado ao curso
        $instructor = $course->user;
        if (!$instructor) {
            throw new \Exception("Instructor not found for the given course ID.");
        }

        $support = $this->getUserAuth()
                ->supports()
                ->create([
                    'lesson_id' => $data['lesson'],
                    'instrutor_id' => $instructor->id,
                    'description' => $data['description'],
                    'status' => $data['status'],
                ]);

        return $support;
    }

}
