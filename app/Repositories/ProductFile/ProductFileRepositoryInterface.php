<?php

namespace App\Repositories\ProductFile;

use App\DTO\ProductFile\CreateDocFileDTO;
use App\DTO\ProductFile\CreateFileCourseDTO;
use App\DTO\ProductFile\CreateFileEbookDTO;
use App\DTO\ProductFile\CreateImageEbookDTO;
use App\DTO\ProductFile\CreateImageFileDTO;
use App\Models\ProductFile;

interface ProductFileRepositoryInterface
{
    public function findByProductId(int $productId, string $type): ?ProductFile;
    public function createFileCourse(CreateFileCourseDTO $dto): ?ProductFile;
    public function createImageEbook(CreateImageEbookDTO $dto): ?ProductFile;
    public function createFileEbook(CreateFileEbookDTO $dto): ?ProductFile;

    public function createImageFile(CreateImageFileDTO $dto): ?ProductFile;
    public function createDocFile(CreateDocFileDTO $dto): ?ProductFile;
}
