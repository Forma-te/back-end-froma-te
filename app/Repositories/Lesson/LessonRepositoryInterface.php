<?php

namespace App\Repositories\Lesson;

use App\DTO\Lesson\CreateFileLessonDTO;
use App\DTO\Lesson\CreateLessonDTO;
use App\DTO\Lesson\CreateNameLessonDTO;
use App\DTO\Lesson\UpdateEditNameLessonDTO;
use App\DTO\Lesson\UpdateFileLessonDTO;
use App\DTO\Lesson\UpdateLessonDTO;
use App\Models\Lesson;
use App\Models\LessonFile;
use App\Repositories\PaginationInterface;
use Illuminate\Database\Eloquent\Collection;

interface LessonRepositoryInterface
{
    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface;
    public function findById(string $id): object|null;
    public function findByIdFileLesson(string $lessonId): object|null;
    public function getLessonByModuleId(string $lessonId): ?Collection;
    public function new(CreateLessonDTO $dto): ?Lesson;
    public function update(UpdateLessonDTO $dto): ?Lesson;
    public function editNameLesson(UpdateEditNameLessonDTO $dto): ?Lesson;
    public function createNameLesson(CreateNameLessonDTO $dto): ?Lesson;
    public function createFileLesson(CreateFileLessonDTO $dto): ?LessonFile;
    public function updateFileLesson(UpdateFileLessonDTO $dto): ?LessonFile;
    public function markLessonViewed(int $lessonId);
    public function delete(string $id): void;
}
