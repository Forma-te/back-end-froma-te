<?php

namespace App\Services;

use App\DTO\Course\CreateCourseDTO;
use App\DTO\Course\UpdateCourseDTO;
use App\Models\Course;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\PaginationInterface;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use stdClass;

class CourseService
{
    public function __construct(
        protected CourseRepositoryInterface $repository,
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

    public function new(CreateCourseDTO $dto): Course
    {
        if ($dto->image) {
            $customImageName = $dto->code . '.' . $dto->image->getClientOriginalExtension();

            $uploadedFilePath = $this->uploadFile->storeAs($dto->image, 'course', $customImageName);

            $dto->image = $uploadedFilePath;
        }

        return $this->repository->new($dto);
    }

    public function findById(string $id): object|null
    {
        return $this->repository->findById($id);
    }

    public function update(UpdateCourseDTO $dto): ?Course
    {
        return $this->repository->update($dto);
    }

    public function delete(string $id)
    {
        return $this->repository->delete($id);
    }

    public function getCoursesForModuleCreation(): array
    {
        return $this->repository->getCoursesForModuleCreation();
    }

    public function getCoursesForAuthenticatedUser(string $id)
    {
        return $this->repository->getCoursesForAuthenticatedUser($id);
    }

    public function getCourseById(string $id)
    {
        return $this->repository->getCourseById($id);
    }
}
