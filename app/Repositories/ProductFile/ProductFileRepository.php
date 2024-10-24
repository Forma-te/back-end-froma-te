<?php

namespace App\Repositories\ProductFile;

use App\DTO\ProductFile\CreateDocFileDTO;
use App\DTO\ProductFile\CreateFileCourseDTO;
use App\DTO\ProductFile\CreateFileEbookDTO;
use App\DTO\ProductFile\CreateImageEbookDTO;
use App\DTO\ProductFile\CreateImageFileDTO;
use App\Models\ProductFile;

class ProductFileRepository implements ProductFileRepositoryInterface
{
    public function __construct(
        protected ProductFile $entity,
    ) {
    }

    public function findByProductId(int $productId, string $type): ?ProductFile
    {
        return $this->entity
                    ->where('product_id', $productId)
                    ->where('type', $type)
                    ->first();
    }

    public function createFileCourse(CreateFileCourseDTO $dto): ?ProductFile
    {
        $existingCourseFile = $this->entity->where('product_id', $dto->product_id)->first();

        // Se já existir, elimina o ficheiro
        if ($existingCourseFile) {
            $existingCourseFile->delete();
        }

        return $this->entity->create($dto->toArray());
    }

    public function createImageEbook(CreateImageEbookDTO $dto): ?ProductFile
    {
        $existingCourseFile = $this->entity->where('product_id', $dto->product_id)
                                            ->where('type', 'ebookImage')
                                            ->first();

        // Se já existir, elimina o ficheiro
        if ($existingCourseFile) {
            $existingCourseFile->delete();
        }

        return $this->entity->create($dto->toArray());
    }

    public function createFileEbook(CreateFileEbookDTO $dto): ?ProductFile
    {
        $existingCourseFile = $this->entity->where('product_id', $dto->product_id)
                                            ->where('type', 'ebookFile')
                                            ->first();

        // Se já existir, elimina o ficheiro
        if ($existingCourseFile) {
            $existingCourseFile->delete();
        }

        return $this->entity->create($dto->toArray());
    }

    public function createImageFile(CreateImageFileDTO $dto): ?ProductFile
    {
        $existingCourseFile = $this->entity->where('product_id', $dto->product_id)
                                ->where('type', 'fileImage')
                                ->first();

        // Se já existir, elimina o ficheiro
        if ($existingCourseFile) {
            $existingCourseFile->delete();
        }

        return $this->entity->create($dto->toArray());
    }

    public function createDocFile(CreateDocFileDTO $dto): ?ProductFile
    {
        $existingCourseFile = $this->entity->where('product_id', $dto->product_id)
                                ->where('type', 'docFile')
                                ->first();

        // Se já existir, elimina o ficheiro
        if ($existingCourseFile) {
            $existingCourseFile->delete();
        }

        return $this->entity->create($dto->toArray());

    }
}
