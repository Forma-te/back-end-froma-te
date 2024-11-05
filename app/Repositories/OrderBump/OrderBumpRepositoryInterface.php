<?php

namespace App\Repositories\OrderBump;

use App\DTO\OrderBump\CreateOrderBumpDTO;
use App\DTO\OrderBump\UpdateOrderBumpDTO;
use stdClass;

interface OrderBumpRepositoryInterface
{
    public function getAll();
    public function findOne(string $id): stdClass|null;
    public function create(CreateOrderBumpDTO $dto): stdClass;
    public function update(UpdateOrderBumpDTO $dto): stdClass|null;
    public function delete(string $id): void;
    public function getOrderBumpByproductId(int $productId);
}
