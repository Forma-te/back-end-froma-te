<?php

namespace App\Services;

use App\DTO\EbookContent\CreateEbookContentDTO;
use App\DTO\EbookContent\UpdateEbookContentDTO;
use App\Models\EbookContent;
use App\Repositories\EbookContent\EbookContentRepositoryInterface;
use App\Repositories\PaginationInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class EbookContentService
{
    public function __construct(
        protected EbookContentRepositoryInterface $repository,
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

    public function getContentByEbookId(string $ebookId): ?array
    {
        return $this->repository->getContentByEbookId($ebookId);
    }

    public function new(CreateEbookContentDTO $dto): EbookContent
    {

        if ($dto->file) {

            $file = $dto->file;
            $customFileName = Str::of($dto->name)->slug('-') . '.' . $file->getClientOriginalExtension();
            $uploadedFilePath = $this->uploadFile->storeAs($dto->file, 'EbookPdf', $customFileName);

            $dto->file = $uploadedFilePath;
        }
        return $this->repository->new($dto);
    }

    public function update(UpdateEbookContentDTO $dto): EbookContent
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
            $customFileName = Str::of($dto->name)->slug('-') . '.' . $file->getClientOriginalExtension();
            // Armazenar o novo ficheiro e obter o caminho do ficheiro armazenado
            $uploadedFilePath = $this->uploadFile->storeAs($dto->file, 'EbookPdf', $customFileName);

            // Atualizar o DTO com o caminho relativo do ficheiro armazenado
            $dto->file = $uploadedFilePath;
        } else {
            // Manter o caminho do ficheiro existente, se não houver novo ficheiro
            unset($dto->file);
        }
        // Atualizar a lição no repositório com os dados do DTO
        return $this->repository->update($dto);
    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }

}
