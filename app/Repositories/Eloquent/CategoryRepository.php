<?php

namespace App\Repositories\Eloquent;

use App\DTO\Category\CreateCategoryDTO;
use App\DTO\Category\UpdateCategoryDTO;
use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\PaginationPresenter;
use App\Repositories\PaginationInterface;
use stdClass;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function __construct(
        protected Category $model
    ) {
    }

    public function paginate(int $page = 1, int $totalPerPage  = 15, string $filter = null): PaginationInterface
    {
        $result = $this->model
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('title', $filter);
                    $query->orWhere('title', 'like', "%{$filter}%");
                }
            })

            ->paginate($totalPerPage, ['*'], 'page', $page);

        return new PaginationPresenter($result);

    }

    public function getAll(string $filter = null): array
    {
        return $this->model
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('title', $filter);
                    $query->orWhere('title', 'like', "%{$filter}%");
                }
            })
            ->get()
            ->toArray();
    }

    public function findOne(string $id): ?stdClass
    {
        $category = $this->model->find($id);
        if (!$category) {
            return null;
        }
        return (object) $category->toArray();
    }

    public function new(CreateCategoryDTO $dto): stdClass
    {
        $category = $this->model->create($dto->toArray());

        return (object) $category->toArray();
    }

    public function update(UpdateCategoryDTO $dto): stdClass|null
    {
        $category = $this->model->find($dto->id);

        if ($category) {
            $category->update((array) $dto);
            return (object) $category->toArray();
        }
        return null;
    }

    public function delete(string $id): void
    {
        $this->model->findOrFail($id)->delete();
    }

}
