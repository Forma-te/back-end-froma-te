<?php

namespace App\Repositories\Member;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Support;
use App\Repositories\PaginationInterface;
use App\Repositories\PaginationPresenter;
use App\Repositories\Traits\RepositoryTrait;

class SupportRepository implements SupportRepositoryInterface
{
    use RepositoryTrait;

    protected $entity;

    public function __construct(Support $model)
    {
        $this->entity = $model;
    }

    public function getSupportProducerByStatus(int $page = 1, int $totalPerPage  = 10, string $status): PaginationInterface
    {
        $query = $this->entity
                        ->ownedByAuthUser()
                        ->with(['user', 'lesson']);

        // Aplicar filtro por status
        if ($status) {
            $query->where('status', $status);
        }

        // Paginar os resultados
        $result = $query->paginate($totalPerPage, ['*'], 'page', $page);
        // Retornar os resultados paginados usando o PaginationPresenter
        return new PaginationPresenter($result);
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
        $lesson = Lesson::findOrFail($data['lessonId']);

        $module = $lesson->modules;
        if (!$module) {
            throw new \Exception("Module not found for the given lesson ID.");
        }

        $course = $module->course;
        if (!$course) {
            throw new \Exception("Course not found for the given module ID.");
        }

        $producer = $course->user;
        if (!$producer) {
            throw new \Exception("Instructor not found for the given course ID.");
        }

        $support = $this->getUserAuth()
                ->supports()
                ->create([
                    'lesson_id' => $data['lessonId'],
                    'producer_id' => $producer->id,
                    'description' => $data['description'],
                    'status' => 'P',
                ]);

        return $support;
    }

    public function getSupportsMember(int $page = 1, int $totalPerPage  = 10, string $status = null, string $filter = null): PaginationInterface
    {
        $query = $this->entity
                    ->with('replies')
                    ->orderBy('updated_at');

        if ($status) {
            $query->where('status', $status);
        }

        if ($filter) {
            $query->where('description', 'LIKE', "%{$filter}%");
        }

        // Paginar os resultados
        $result = $query->paginate($totalPerPage, ['*'], 'page', $page);
        // Retornar os resultados paginados usando o PaginationPresenter
        return new PaginationPresenter($result);
    }
}
