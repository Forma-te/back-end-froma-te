<?php

namespace App\Services;

use App\DTO\Course\CreateCourseDTO;
use App\DTO\Course\UpdateCourseDTO;
use App\Models\Product;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\PaginationInterface;
use Illuminate\Http\UploadedFile;
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
        if ($dto->image) {
            $customImageName = $dto->code . '.' . $dto->image->getClientOriginalExtension();

            $uploadedFilePath = $this->uploadFile->storeAs($dto->image, 'Products', $customImageName);

            $dto->image = $uploadedFilePath;
        }

        return $this->repository->new($dto);
    }

    public function findById(string $id): object|null
    {
        return $this->repository->findById($id);
    }

    public function update(UpdateCourseDTO $dto): ?Product
    {
        // Buscar a course existente
        $course = $this->repository->findById($dto->id);

        // Verificar instância da classe UploadedFile
        if ($dto->image instanceof UploadedFile) {
            if ($course && $course->image) {
                // Remover o ficheiro existente, se houver
                $this->uploadFile->removeFile($course->image);
            }
            // Processar o novo ficheiro
            $file = $dto->image;
            $customImageName = Str::of($dto->name)->slug('-') . '.' . $file->getClientOriginalExtension();
            // Armazenar o novo ficheiro e obter o caminho do ficheiro armazenado
            $uploadedFilePath = $this->uploadFile->storeAs($dto->image, 'Products', $customImageName);

            // Atualizar o DTO com o caminho relativo do ficheiro armazenado
            $dto->image = $uploadedFilePath;
        } else {
            // Manter o caminho do ficheiro existente, se não houver novo ficheiro
            unset($dto->image);
        }
        // Atualizar a lição no repositório com os dados do DTO
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
