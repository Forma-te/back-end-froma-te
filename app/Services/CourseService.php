<?php

namespace App\Services;

use App\DTO\Course\CreateCourseDTO;
use App\DTO\Course\UpdateCourseDTO;
use App\DTO\Course\UpdatePublishedDTO;
use App\Models\Product;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\PaginationInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

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

    public function getProducts(
        int $page = 1,
        int $totalPerPage  = 15,
        string $filter = null
    ): PaginationInterface {
        return $this->repository->getProducts(
            page: $page,
            totalPerPage: $totalPerPage,
            filter: $filter,
        );
    }

    public function fetchAllCoursesByProducers(
        int $page = 1,
        int $totalPerPage  = 15,
        string $filter = null,
        string $producerName = null,
        string $categoryName = null
    ): PaginationInterface {
        return $this->repository->fetchAllCoursesByProducers(
            page: $page,
            totalPerPage: $totalPerPage,
            filter: $filter,
            producerName: $producerName,
            categoryName: $categoryName
        );
    }

    public function new(CreateCourseDTO $dto): Product
    {
        return $this->repository->new($dto);
    }

    public function findById(string $id): object|null
    {
        return $this->repository->findById($id);
    }

    public function getCourseById(string $id)
    {
        return $this->repository->getCourseById($id);
    }

    public function update(UpdateCourseDTO $dto): ?Product
    {
        // Buscar a course existente
        $course = $this->repository->findById($dto->id);

        if ($course && Gate::authorize('owner-course', $course)) {

            // Atualizar a lição no repositório com os dados do DTO
            return $this->repository->update($dto);
        }

        return null;
    }

    public function publishedCourse(UpdatePublishedDTO $dto): ?Product
    {
        $course = $this->repository->findById($dto->id);

        if ($course && Gate::authorize('owner-course', $course)) {
            return $this->repository->publishedCourse($dto);
        }

        return null;
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

}
