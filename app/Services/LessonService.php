<?php

namespace App\Services;

use App\DTO\Lesson\CreateLessonDTO;
use App\DTO\Lesson\UpdateLessonDTO;
use App\Models\Lesson;
use App\Repositories\Lesson\LessonRepositoryInterface;
use App\Repositories\PaginationInterface;
use Illuminate\Support\Str;

class LessonService
{
    public function __construct(
        protected LessonRepositoryInterface $repository,
        protected UploadFile $uploadFile
    ) {
    }
    public function paginate(
        int $page = 1,
        int $totalPerPage  = 15,
        string $filter = null
    ): PaginationInterface {
        return $this->repository->paginate(
            page: $page,
            totalPerPage: $totalPerPage,
            filter: $filter,
        );
    }

    public function findById(string $id): object|Null
    {
        return $this->repository->findById($id);
    }

    public function getLessonByModuleId(string $Lesson): ?array
    {
        return $this->repository->getLessonByModuleId($Lesson);
    }

    public function new(CreateLessonDTO $dto): Lesson
    {
        if ($dto->file) {
            $file = $dto->file;
            $customImageName = Str::of($dto->name)->slug('-') . '.' . $file->getClientOriginalExtension();

            $uploadedFilePath = $this->uploadFile->storeAs($dto->file, 'lessonPdf', $customImageName);

            $dto->file = $uploadedFilePath;
        }

        return $this->repository->new($dto);
    }

    public function update(UpdateLessonDTO $dto): Lesson
    {
        return $this->repository->update($dto);
    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }



}
