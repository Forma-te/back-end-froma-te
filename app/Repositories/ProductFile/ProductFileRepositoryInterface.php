<?php

namespace App\Repositories\ProductFile;

use App\DTO\ProductFile\CreateFileCourseDTO;
use App\DTO\ProductFile\CreateFileEbookDTO;
use App\DTO\ProductFile\CreateImageEbookDTO;
use App\Models\productFile;

interface ProductFileRepositoryInterface
{
    public function findByProductId(int $productId, string $type): ?productFile;
    public function createFileCourse(CreateFileCourseDTO $dto): ?productFile;
    public function createImageEbook(CreateImageEbookDTO $dto): ?productFile;
    public function createFileEbook(CreateFileEbookDTO $dto): ?productFile;
    public function delete(int $id): void;
}
