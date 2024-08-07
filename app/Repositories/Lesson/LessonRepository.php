<?php

namespace App\Repositories\Lesson;

use App\DTO\Lesson\CreateLessonDTO;
use App\DTO\Lesson\UpdateLessonDTO;
use App\Models\Lesson;
use App\Models\Module;
use App\Repositories\PaginationInterface;
use App\Repositories\PaginationPresenter;
use Illuminate\Support\Facades\Gate;

class LessonRepository implements LessonRepositoryInterface
{
    public function __construct(
        protected Lesson $entity,
        protected Module $module
    ) {
    }

    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface
    {
        $query = $this->entity;

        // Aplicar o filtro se fornecido
        if ($filter) {
            $query->where(function ($query) use ($filter) {
                $query->where('name', $filter)
                      ->orWhere('name', 'like', "%{$filter}%");
            });
        }

        // Paginar os resultados
        $result = $query->with('modules')->paginate($totalPerPage, ['*'], 'page', $page);

        // Retornar os resultados paginados usando o PaginationPresenter
        return new PaginationPresenter($result);
    }

    public function findById(string $id): ?object
    {
        return $this->entity->find($id);
    }

    public function getLessonByModuleId(string $moduleId): ?array
    {
        $module = $this->module->find($moduleId);

        $course = $module->course;

        Gate::authorize('owner-course', $course);

        $lessons = $module->lessons()->get();

        if ($lessons->isEmpty()) {
            return null;
        }

        return $lessons->toArray();
    }

    public function new(CreateLessonDTO $dto): Lesson
    {
        return $this->entity->create((array) $dto);
    }

    public function update(UpdateLessonDTO $dto): ?Lesson
    {
        $lesson = $this->entity->find($dto->id);

        if($lesson) {
            $lesson->update((array) $dto);
            return $lesson;
        }

        return null;
    }

    public function delete(string $id): void
    {
        $this->entity->findOrFail($id)->delete();
    }
}
