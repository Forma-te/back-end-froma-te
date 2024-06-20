<?php

namespace App\Repositories\Member;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Support;
use App\Repositories\Traits\RepositoryTrait;

class SupportRepository implements SupportRepositoryInterface
{
    use RepositoryTrait;

    protected $entity;

    public function __construct(Support $model)
    {
        $this->entity = $model;
    }

    public function getByStatus(string $status): array
    {
        $supports = $this->entity
                        ->ownedByAuthUser()
                        ->where('status', $status)
                        ->with(['user', 'lesson'])
                        ->get();

        return $supports->toArray();
    }

    public function findById(string $id): object|null
    {
        return $this->entity
                    ->ownedByAuthUser()
                    ->with([
                        'user',
                        'lesson',
                        'replies.user',
                        'replies.producer'
                        ])
                    ->find($id);
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
        $producer = $course->user;
        if (!$producer) {
            throw new \Exception("Instructor not found for the given course ID.");
        }

        $support = $this->getUserAuth()
                ->supports()
                ->create([
                    'lesson_id' => $data['lesson'],
                    'producer_id' => $producer->id,
                    'description' => $data['description'],
                    'status' => $data['status'],
                ]);

        return $support;
    }

    public function getMySupports(array $filters = [])
    {
        $filters['user'] = true;
        return $this->getSupports($filters);
    }

    public function getSupports(array $filters = [])
    {
        return $this->entity
                    ->where(function ($query) use ($filters) {
                        if (isset($filters['lesson'])) {
                            $query->where('lesson_id', $filters['lesson']);
                        }

                        if (isset($filters['status'])) {
                            $query->where('status', $filters['status']);
                        }

                        if (isset($filters['filter'])) {
                            $filters = $filters['filter'];
                            $query->where('description', 'LIKE', "%{$filters}%");
                        }

                        if (isset($filters['user'])) {
                            $user = $this->getUserAuth();
                            $query->where('user_id', $user->id);
                        }

                    })

                    ->with('replies')
                    ->orderBy('updated_at')
                    ->get();
    }

}
