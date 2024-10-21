<?php

namespace App\Repositories\OrderBump;

use App\DTO\OrderBump\CreateOrderBumpDTO;
use App\DTO\OrderBump\UpdateOrderBumpDTO;
use App\Models\OrderBump;
use stdClass;

class OrderBumpRepository implements OrderBumpRepositoryInterface
{
    public function __construct(
        protected OrderBump $model
    ) {
    }

    public function getAll(string $filter = '')
    {
        $orderBump = $this->model
                    ->where(function ($query) use ($filter) {
                        if ($filter) {
                            $query->orWhere('title', 'LIKE', "%{$filter}%");
                        }
                    })
                      ->with('product')
                      ->get();
        return $orderBump;
    }

    public function findOne(string $id): ?stdClass
    {
        $orderBump = $this->model->find($id);
        if (!$orderBump) {
            return null;
        }
        return (object) $orderBump->toArray();
    }

    public function create(CreateOrderBumpDTO $dto): stdClass
    {
        $orderBump = $this->model->create($dto->toArray());

        return (object) $orderBump->toArray();
    }

    public function update(UpdateOrderBumpDTO $dto): stdClass|null
    {
        $orderBump = $this->model->find($dto->id);

        if ($orderBump) {
            $orderBump->update((array) $dto);
            return (object) $orderBump->toArray();
        }

        return null;
    }

    public function delete(string $id): void
    {
        $this->model->findOrFail($id)->delete();
    }
}
