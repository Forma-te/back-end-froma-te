<?php

namespace App\Services;

use App\DTO\File\CreateFileDTO;
use App\DTO\File\UpdateFileDTO;
use App\Models\Product;
use App\Repositories\File\FileRepositoryInterface;
use App\Repositories\PaginationInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class FileService
{
    public function __construct(
        protected FileRepositoryInterface $repository,
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

    public function fetchAllFilesByProducers(
        int $page = 1,
        int $totalPerPage  = 15,
        string $filter = null,
        string $producerName = null,
        string $categoryName = null
    ): PaginationInterface {
        return $this->repository->fetchAllFilesByProducers(
            page: $page,
            totalPerPage: $totalPerPage,
            filter: $filter,
            producerName: $producerName,
            categoryName: $categoryName
        );
    }

    public function new(CreateFileDTO $dto): Product
    {
        // Processar imagem se existir
        if ($dto->image) {
            $customImageName = Str::of($dto->name)->slug('-') . '.' . $dto->image->getClientOriginalExtension();
            $uploadedImagePath = $this->uploadFile->storeAs($dto->image, 'Products/ImagesFiles', $customImageName);
            $dto->image = $uploadedImagePath;
        }

        // Processar ficheiro se existir
        if ($dto->file) {
            $customFileName = Str::of($dto->name)->slug('-') . '.' . $dto->file->getClientOriginalExtension();
            $uploadedFilePath = $this->uploadFile->storeAs($dto->file, 'Products/Files', $customFileName);
            $dto->file = $uploadedFilePath;
        }

        // Criar o produto utilizando o repositório
        return $this->repository->new($dto);
    }

    public function findById(string $id): object|null
    {
        return $this->repository->findById($id);
    }

    public function update(UpdateFileDTO $dto): ?Product
    {
        $file = $this->repository->findById($dto->id);

        if ($file && Gate::allows('owner-file', $file)) {
            // Atualizar imagem se uma nova foi enviada

            if ($dto->image instanceof UploadedFile) {
                if ($file && $file->image) {
                    // Remover o ficheiro existente, se houver
                    $this->uploadFile->removeFile($file->image);
                }

                // Processar o novo ficheiro
                $image = $dto->image;
                $customImageName = Str::of($dto->name)->slug('-') . '.' . $image->getClientOriginalExtension();

                // Armazenar o novo ficheiro e obter o caminho do ficheiro armazenado
                $uploadedFilePath = $this->uploadFile->storeAs($dto->image, 'Products/ImagesFiles', $customImageName);

                // Atualizar o DTO com o caminho relativo do ficheiro armazenado
                $dto->image = $uploadedFilePath;
            } else {
                // Manter o caminho do ficheiro existente, se não houver novo ficheiro
                unset($dto->image);
            }

            if ($dto->file instanceof UploadedFile) {
                if ($file && $file->file) {
                    // Remover o ficheiro existente, se houver
                    $this->uploadFile->removeFile($file->file);
                }

                // Processar o novo ficheiro
                $file = $dto->file;
                $customFileName = Str::of($dto->name)->slug('-') . '.' . $file->getClientOriginalExtension();

                // Armazenar o novo ficheiro e obter o caminho do ficheiro armazenado
                $uploadedFilePath = $this->uploadFile->storeAs($dto->file, 'Products/Files', $customFileName);

                // Atualizar o DTO com o caminho relativo do ficheiro armazenado
                $dto->file = $uploadedFilePath;
            } else {
                // Manter o caminho do ficheiro existente, se não houver novo ficheiro
                unset($dto->file);
            }

            // Atualizar o ebook com as novas informações
            return $this->repository->update($dto);
        }

        return null;
    }

    public function delete(string $id)
    {
        return $this->repository->delete($id);
    }
}
