<?php

namespace App\Services;

use App\DTO\OrderBump\CreateOrderBumpDTO;
use App\DTO\OrderBump\UpdateOrderBumpDTO;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\OrderBump\OrderBumpRepositoryInterface;
use stdClass;

class OrderBumpService
{
    public function __construct(
        protected OrderBumpRepositoryInterface $repository,
        protected CourseRepositoryInterface $productRepository
    ) {
    }

    public function getAll(string $filter = '')
    {
        return $this->repository->getAll($filter);
    }

    public function findOne(string $id): stdClass|null
    {
        return $this->repository->findOne($id);
    }

    public function create(CreateOrderBumpDTO $dto): stdClass
    {
        // Verifica se o produto principal existe
        $product = $this->productRepository->findById($dto->product_id);
        if (!$product) {
            throw new \Exception("Produto principal não encontrado.");
        }

        // Verifica se o produto de oferta existe
        $offerProduct = $this->productRepository->findById($dto->offer_product_id);
        if (!$offerProduct) {
            throw new \Exception("Produto de oferta não encontrado.");
        }

        return $this->repository->create($dto);
    }

    public function update(UpdateOrderBumpDTO $dto): stdClass|null
    {
        return $this->repository->update($dto);
    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }
}
