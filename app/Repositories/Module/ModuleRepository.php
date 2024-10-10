<?php

namespace App\Repositories\Module;

use App\DTO\Module\CreateModuleDTO;
use App\DTO\Module\UpdateModuleDTO;
use App\Models\Product;
use App\Models\Module;
use App\Repositories\Module\ModuleRepositoryInterface;
use App\Repositories\PaginationInterface;
use App\Repositories\PaginationPresenter;
use Illuminate\Support\Facades\Gate;

class ModuleRepository implements ModuleRepositoryInterface
{
    protected $entity;
    protected $product;

    public function __construct(Module $model, Product $product)
    {
        $this->entity = $model;
        $this->product = $product;
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
        return $this->entity->with('lessons')->find($id);
    }

    public function createModule(): ?array
    {
        $courses = $this->product->userByAuth()->pluck('name', 'id');

        return $courses->toArray();
    }

    public function getModulesByCourseId(string $courseId): object|null
    {
        $course = $this->product->find($courseId);

        if (!$course) {
            return null;
        }

        if (Gate::authorize('owner-course', $course)) {
            return $course->modules()->with('lessons')->get();
        }

        return null; // Autorização falhou

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
        $module = $this->entity->find($id);

        $course =  $module->course;

        if (Gate::authorize('owner-course', $course)) {
            $module->delete();
        } else {
            abort(403, 'Unauthorized'); // Aborta com código 403 se a autorização falhar
        }
    }
}
