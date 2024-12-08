<?php

namespace App\Repositories\Course;

use App\DTO\Course\CreateCourseDTO;
use App\DTO\Course\UpdateCourseDTO;
use App\DTO\Course\UpdatePublishedDTO;
use App\Models\Product;
use App\Repositories\PaginationInterface;
use stdClass;

interface CourseRepositoryInterface
{
    public function paginate(int $page = 1, int $totalPerPage  = 10, string $filter = null): PaginationInterface;
    public function getProducts(
        int $page = 1,
        int $totalPerPage = 10,
        string $type = '',
        string $startDate = null,
        string $endDate = null,
        string $filter = null,
    ): PaginationInterface;

    public function getAllProducts();
    public function fetchAllCoursesByProducers(int $page = 1, int $totalPerPage  = 10, string $filter = null, $producerName = null, string $categoryName = null): PaginationInterface;
    public function findById(string $id): object|null;
    public function new(CreateCourseDTO $dto): Product;
    public function update(UpdateCourseDTO $dto): ?Product;
    public function publishedCourse(UpdatePublishedDTO $dto): ?Product;
    public function delete(string $id): void;
    public function getCoursesForModuleCreation(): array;
    public function getCourseById(string $id): object|null;
    public function getProductsByUrl(string $url): ?Product;
    public function getCourseByUrl(string $url): ?Product;
}
