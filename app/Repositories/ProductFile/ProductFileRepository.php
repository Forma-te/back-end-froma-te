<?php

namespace App\Repositories\ProductFile;

use App\DTO\ProductFile\CreateFileCourseDTO;
use App\DTO\ProductFile\CreateFileEbookDTO;
use App\DTO\ProductFile\CreateImageEbookDTO;
use App\Models\productFile;

class ProductFileRepository implements ProductFileRepositoryInterface
{
    public function __construct(
        protected productFile $entity,
    ) {
    }

    public function findByProductId(int $productId, string $type): ?ProductFile
    {
        return $this->entity
                    ->where('product_id', $productId)
                    ->where('type', $type)
                    ->first();
    }

    public function createFileCourse(CreateFileCourseDTO $dto): ?productFile
    {
        return $this->entity->create($dto->toArray());
    }

    public function delete(int $id): void
    {
        $this->entity->where('id', $id)->delete();
    }

    public function createImageEbook(CreateImageEbookDTO $dto): ?productFile
    {
        return $this->entity->create($dto->toArray());
    }

    public function createFileEbook(CreateFileEbookDTO $dto): ?productFile
    {
        return $this->entity->create($dto->toArray());
    }
}
