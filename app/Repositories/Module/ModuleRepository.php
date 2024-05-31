<?php

namespace App\Repositories\Module;

use App\DTO\Module\CreateModuleDTO;
use App\DTO\Module\UpdateModuleDTO;
use App\Models\Course;
use App\Models\Module;
use App\Repositories\Module\ModuleRepositoryInterface;
use App\Repositories\PaginationInterface;
use App\Repositories\PaginationPresenter;
use stdClass;

class ModuleRepository implements ModuleRepositoryInterface
{
    protected $entity;
    protected $course;

    public function __construct(Module $model, Course $course)
    {
        $this->entity = $model;
        $this->course = $course;
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
        $result = $query->paginate($totalPerPage, ['*'], 'page', $page);

        // Retornar os resultados paginados usando o PaginationPresenter
        return new PaginationPresenter($result);
    }

    public function findById(string $id): object|null
    {
        return $this->entity->find($id);
    }

    public function getModulesByCourseId(string $courseId): ?array
    {
        $course = $this->course->find($courseId);

        $modules = $course->modules()->get();

        if ($modules->isEmpty()) {
            return null;
        }

        return $modules->toArray();

    }

    public function new(CreateModuleDTO $dto): Module
    {
        return $this->entity->create((array) $dto);

    }

    public function update(UpdateModuleDTO $dto): ?Module
    {
        $module = $this->entity->find($dto->id);

        if ($module) {
            $module->update((array) $dto);
            return $module;
        }

        return null;
    }

    public function delete(string $id): void
    {
        $this->entity->findOrFail($id)->delete();
    }

    public function getModulesCourseById(string $courseId)
    {
        return $this->entity
                    ->with('lessons.views')
                    ->where('course_id', $courseId)
                    ->get();
    }

}
