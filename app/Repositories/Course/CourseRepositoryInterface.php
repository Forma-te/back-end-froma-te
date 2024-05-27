<?php

namespace App\Repositories\Course;

use App\DTO\Course\CreateCourseDTO;
use App\DTO\Course\UpdateCourseDTO;
use App\Models\Course;
use App\Repositories\PaginationInterface;
use stdClass;

interface CourseRepositoryInterface
{
    public function paginate(int $page = 1, int $totalPerPage  = 15, string $filter = null): PaginationInterface;

    public function getAll(string $filter = ''): array;

    public function findById(string $id): object|null;

    public function new(CreateCourseDTO $dto): Course;

    public function update(UpdateCourseDTO $dto): ?Course;

    public function delete(string $id): void;

    public function getCoursesForAuthenticatedUser(): array;

    public function getCourseById(string $id): object|null;

}
