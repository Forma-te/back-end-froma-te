<?php

namespace App\Repositories\Eloquent;

use App\DTO\Module\CreateModuleDTO;
use App\DTO\Module\UpdateModuleDTO;
use App\Models\Module;
use App\Repositories\Module\ModuleRepositoryInterface;
use App\Repositories\PaginationInterface;
use App\Repositories\PaginationPresenter;
use stdClass;

class ModuleRepository implements ModuleRepositoryInterface
{
    protected $entity;

    public function __construct(Module $model)
    {
        $this->entity = $model;
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

    public function create(CreateModuleDTO $dto): stdClass
    {
        $module = $this->entity->create((array) $dto);

        return (object) $module->toArray();
    }

    public function update(UpdateModuleDTO $dto): stdClass|null
    {
        $module = $this->entity->find($dto->id);

        if (!$module) {
            return null;
        }

        $module->update((array) $dto);

        return (object) $module->toArray();
    }

    public function delete(string $id): void
    {
        $this->entity->findOrFail($id)->delete();
    }

    public function findById(string $id): stdClass|null
    {
        $module = $this->entity->find($id);

        if (!$module) {
            return null;
        }

        return (object) $module->toArray();
    }

    public function getModulesCourseById(string $courseId)
    {
        return $this->entity
                    ->with('lessons.views')
                    ->where('course_id', $courseId)
                    ->get();
    }

}
