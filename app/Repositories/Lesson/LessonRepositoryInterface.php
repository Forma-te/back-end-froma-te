<?php

namespace App\Repositories\Lesson;

use App\DTO\Lesson\CreateLessonDTO;
use App\DTO\Lesson\UpdateLessonDTO;
use App\Models\Lesson;
use App\Repositories\PaginationInterface;

interface LessonRepositoryInterface
{
    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface;
    public function findById(string $id): object|null;
    public function getLessonByModuleId(string $lessonId): ?array;
    public function new(CreateLessonDTO $dto): Lesson;
    public function update(UpdateLessonDTO $dto): ?Lesson;
    public function delete(string $id): void;

}
