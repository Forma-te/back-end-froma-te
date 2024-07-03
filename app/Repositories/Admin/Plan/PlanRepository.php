<?php

namespace App\Repositories\Admin\Plan;

use App\DTO\Admin\Plan\CreatePlanDTO;
use App\DTO\Admin\Plan\UpdatePlanDTO;
use App\Models\Plan;
use App\Repositories\PaginationPresenter;
use App\Repositories\PaginationInterface;
use Illuminate\Http\Request;

class PlanRepository implements PlanRepositoryInterface
{
    public function __construct(
        protected Plan $model
    ) {
    }

    public function paginate(int $page = 1, int $totalPerPage  = 15, string $filter = null): PaginationInterface
    {
        $result = $this->model
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('name', $filter);
                    $query->orWhere('name', 'like', "%{$filter}%");
                }
            })
            ->paginate($totalPerPage, ['*'], 'page', $page);
        return new PaginationPresenter($result);
    }

    public function store(CreatePlanDTO $dto)
    {
        $this->model->create($dto->toArray());
    }

    public function show(string $url)
    {
        $plan = $this->model->where('url', $url)->first();

        return $plan ? (object) $plan->toArray() : null;
    }

    public function edit(string $url)
    {
        $plan = $this->model->where('url', $url)->first();

        return $plan ? (object) $plan->toArray() : null;
    }

    public function update(UpdatePlanDTO $dto)
    {
        $plan = $this->model->where('url', $dto->url)->first();

        if ($plan) {
            $plan->update($dto->toArray());
        }
    }

    public function delete(string $url)
    {
        $plan = $this->model->where('url', $url)->first();

        if ($plan) {
            $plan->delete();
        }
    }
}
