<?php

namespace App\Services;

use App\DTO\Lesson\CreateFileLessonDTO;
use App\DTO\Lesson\CreateLessonDTO;
use App\DTO\Lesson\CreateNameLessonDTO;
use App\DTO\Lesson\UpdateEditNameLessonDTO;
use App\DTO\Lesson\UpdateFileLessonDTO;
use App\DTO\Lesson\UpdateLessonDTO;
use App\Models\Lesson;
use App\Models\LessonFile;
use App\Repositories\Lesson\LessonRepositoryInterface;
use App\Repositories\PaginationInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
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

    public function findById(string $id): object|null
    {
        return $this->repository->findById($id);
    }

    public function findByIdFileLesson(string $id): object|null
    {
        return $this->repository->findByIdFileLesson($id);
    }

    public function getLessonByModuleId(string $Lesson): ?Collection
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

    public function update(UpdateLessonDTO $dto)
    {
        // Buscar a lição existente
        $lesson = $this->repository->findById($dto->id);

        // Verificar instância da classe UploadedFile
        if ($dto->file instanceof UploadedFile) {
            if ($lesson && $lesson->file) {
                // Remover o ficheiro existente, se houver
                $this->uploadFile->removeFile($lesson->file);
            }
            // Processar o novo ficheiro
            $file = $dto->file;
            $customImageName = Str::of($dto->name)->slug('-') . '.' . $file->getClientOriginalExtension();
            // Armazenar o novo ficheiro e obter o caminho do ficheiro armazenado
            $uploadedFilePath = $this->uploadFile->storeAs($dto->file, 'lessonPdf', $customImageName);

            // Atualizar o DTO com o caminho relativo do ficheiro armazenado
            $dto->file = $uploadedFilePath;
        } else {
            // Manter o caminho do ficheiro existente, se não houver novo ficheiro
            unset($dto->file);
        }
        // Atualizar a lição no repositório com os dados do DTO
        return $this->repository->update($dto);
    }

    public function editNameLesson(UpdateEditNameLessonDTO $dto)
    {
        return $this->repository->editNameLesson($dto);
    }

    public function createNameLesson(CreateNameLessonDTO $dto)
    {
        return $this->repository->createNameLesson($dto);
    }

    public function createFileLesson(CreateFileLessonDTO $dto)
    {
        // Verifica se já existe um ficheiro de lição para esta lição
        $existingLessonFile = LessonFile::where('lesson_id', $dto->lesson_id)->first();

        // Se já existir, elimina o ficheiro da S3
        if ($existingLessonFile && $existingLessonFile->file) {
            $this->uploadFile->removeFile($existingLessonFile->file);
        }

        if ($dto->file) {
            $file = $dto->file;
            $customImageName = Str::of($dto->name)->slug('-') . '.' . $file->getClientOriginalExtension();
            $uploadedFilePath = $this->uploadFile->storeAs($dto->file, 'lessonPdf', $customImageName);

            $dto->file = $uploadedFilePath;
        }

        return $this->repository->createFileLesson($dto);
    }

    public function updateFileLesson(UpdateFileLessonDTO $dto)
    {

        // Buscar a lição existente
        $lessonFile = $this->repository->findById($dto->id);

        // Verificar instância da classe UploadedFile
        if ($dto->file instanceof UploadedFile) {
            if ($lessonFile && $lessonFile->file) {
                // Remover o ficheiro existente, se houver
                $this->uploadFile->removeFile($lessonFile->file);
            }
            // Processar o novo ficheiro
            $file = $dto->file;
            $customImageName = Str::of($dto->lesson_id . '.' . $dto->url)->slug('-') . '.' . $file->getClientOriginalExtension();
            // Armazenar o novo ficheiro e obter o caminho do ficheiro armazenado
            $uploadedFilePath = $this->uploadFile->storeAs($dto->file, 'lessonPdf', $customImageName);

            // Atualizar o DTO com o caminho relativo do ficheiro armazenado
            $dto->file = $uploadedFilePath;
        } else {
            // Manter o caminho do ficheiro existente, se não houver novo ficheiro
            unset($dto->file);
        }
        // Atualizar a lição no repositório com os dados do DTO
        return $this->repository->updateFileLesson($dto);

    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }



}
