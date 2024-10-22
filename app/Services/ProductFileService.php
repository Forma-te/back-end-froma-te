<?php

namespace App\Services;

use App\DTO\ProductFile\CreateFileCourseDTO;
use App\DTO\ProductFile\CreateFileEbookDTO;
use App\DTO\ProductFile\CreateImageEbookDTO;
use App\Repositories\ProductFile\ProductFileRepositoryInterface;
use Illuminate\Support\Str;

class ProductFileService
{
    public function __construct(
        protected ProductFileRepositoryInterface $repository,
        protected UploadFile $uploadFile
    ) {
    }

    public function createFileCourse(CreateFileCourseDTO $dto)
    {
        // Verifica se já existe um ficheiro ou imagem para o produto
        $existingFile = $this->repository->findByProductId($dto->product_id, 'course');

        // Se já existir, elimina o ficheiro da S3
        if ($existingFile && $existingFile->image) {
            $this->uploadFile->removeFile($existingFile->image);

            // Elimina também o registo da base de dados
            $this->deleteExistingFile($existingFile);
        }

        if ($dto->image) {
            $customImageName = Str::of($dto->name)->slug('-') . '.' . $dto->image->getClientOriginalExtension();

            $uploadedFilePath = $this->uploadFile->storeAs($dto->image, 'products/images/courses', $customImageName);

            $dto->image = $uploadedFilePath;
        }

        return $this->repository->createFileCourse($dto);
    }

    public function createImageEbook(CreateImageEbookDTO $dto)
    {
        // Verifica se já existe um ficheiro ou imagem para o produto
        $existingFile = $this->repository->findByProductId($dto->product_id, 'ebookImage');

        // Se já existir, elimina o ficheiro da S3
        if ($existingFile && $existingFile->image) {
            $this->uploadFile->removeFile($existingFile->image);

            // Elimina também o registo da base de dados
            $this->deleteExistingFile($existingFile);
        }

        // Upload da imagem
        if ($dto->image) {
            $customImageName = Str::of($dto->name)->slug('-') . '.' . $dto->image->getClientOriginalExtension();
            $uploadedFilePath = $this->uploadFile->storeAs($dto->image, 'products/images/ebooks', $customImageName);
            $dto->image = $uploadedFilePath;
        }

        // Cria o registo do ebook na base de dados
        return $this->repository->createImageEbook($dto);
    }

    public function createFileEbook(CreateFileEbookDTO $dto)
    {
        // Verifica se já existe um ficheiro ou imagem para o produto
        $existingFile = $this->repository->findByProductId($dto->product_id, 'ebookFile');

        // Se já existir, elimina o ficheiro da S3
        if ($existingFile && $existingFile->file) {
            $this->uploadFile->removeFile($existingFile->file);

            // Elimina também o registo da base de dados
            $this->deleteExistingFile($existingFile);
        }

        // Upload da imagem
        if ($dto->file) {
            $customImageName = Str::of($dto->name)->slug('-') . '.' . $dto->file->getClientOriginalExtension();
            $uploadedFilePath = $this->uploadFile->storeAs($dto->file, 'products/files/ebooks', $customImageName);
            $dto->file = $uploadedFilePath;
        }

        // Cria o registo do ebook na base de dados
        return $this->repository->createFileEbook($dto);
    }

    protected function deleteExistingFile($existingFile): void
    {
        $this->repository->delete($existingFile->id);
    }
}
