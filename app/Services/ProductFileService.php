<?php

namespace App\Services;

use App\DTO\ProductFile\CreateDocFileDTO;
use App\DTO\ProductFile\CreateFileCourseDTO;
use App\DTO\ProductFile\CreateFileEbookDTO;
use App\DTO\ProductFile\CreateImageEbookDTO;
use App\DTO\ProductFile\CreateImageFileDTO;
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
        // Verifica se já existe uma imagem associada ao produto com o tipo 'ebookImage'
        $existingFile = $this->repository->findByProductId($dto->product_id, 'ebookImage');

        // Se já existir uma imagem, elimina o ficheiro da S3
        if ($existingFile && $existingFile->image) {
            $this->uploadFile->removeFile($existingFile->image);
        }

        // Upload da nova imagem, se fornecida
        if ($dto->image) {
            // Gera um nome de imagem único com slug do nome e extensão original
            $customImageName = Str::of($dto->name)->slug('-') . '-' . $dto->product_id . '.' . $dto->image->getClientOriginalExtension();

            // Armazena o ficheiro da imagem e obtém o caminho
            $uploadedFilePath = $this->uploadFile->storeAs($dto->image, 'products/images/ebooks', $customImageName);

            // Verifica se o upload foi bem-sucedido
            if (!$uploadedFilePath) {
                throw new \Exception('Falha ao fazer o upload da imagem.');
            }

            // Atualiza o caminho da imagem no DTO
            $dto->image = $uploadedFilePath;
        }

        // Cria o registo da imagem do ebook na base de dados
        return $this->repository->createImageEbook($dto);
    }

    public function createFileEbook(CreateFileEbookDTO $dto)
    {
        // Verifica se já existe um ficheiro ou imagem para o produto do tipo 'ebookFile'
        $existingFile = $this->repository->findByProductId($dto->product_id, 'ebookFile');

        // Se já existir, elimina o ficheiro anterior da S3
        if ($existingFile && $existingFile->file) {
            $this->uploadFile->removeFile($existingFile->file);
        }

        // Upload do novo ficheiro, se fornecido
        if ($dto->file) {
            // Gera um nome único para o ficheiro com slug, id do produto e extensão
            $customImageName = Str::of($dto->name)->slug('-') . '-' . $dto->product_id . '.' . $dto->file->getClientOriginalExtension();

            // Armazena o ficheiro e retorna o caminho
            $uploadedFilePath = $this->uploadFile->storeAs($dto->file, 'products/files/ebooks', $customImageName);

            // Verifica se o upload foi bem-sucedido
            if (!$uploadedFilePath) {
                throw new \Exception('Falha ao fazer o upload do ficheiro.');
            }

            // Atualiza o caminho do ficheiro no DTO
            $dto->file = $uploadedFilePath;
        }

        // Cria o registo do ebook na base de dados
        return $this->repository->createFileEbook($dto);
    }

    public function createImageFile(CreateImageFileDTO $dto)
    {
        // Verifica se já existe uma imagem associada ao produto com o tipo 'ebookImage'
        $existingFile = $this->repository->findByProductId($dto->product_id, 'ebookImage');

        // Se já existir uma imagem, elimina o ficheiro da S3
        if ($existingFile && $existingFile->image) {
            $this->uploadFile->removeFile($existingFile->image);
        }

        // Upload da nova imagem, se fornecida
        if ($dto->image) {
            // Gera um nome de imagem único com slug do nome e extensão original
            $customImageName = Str::of($dto->name)->slug('-') . '-' . $dto->product_id . '.' . $dto->image->getClientOriginalExtension();

            // Armazena o ficheiro da imagem e obtém o caminho
            $uploadedFilePath = $this->uploadFile->storeAs($dto->image, 'products/images/files', $customImageName);

            // Verifica se o upload foi bem-sucedido
            if (!$uploadedFilePath) {
                throw new \Exception('Falha ao fazer o upload da imagem.');
            }

            // Atualiza o caminho da imagem no DTO
            $dto->image = $uploadedFilePath;
        }

        // Cria o registo da imagem do ebook na base de dados
        return $this->repository->createImageFile($dto);
    }

    public function createDocFile(CreateDocFileDTO $dto)
    {
        // Verifica se já existe um ficheiro ou imagem para o produto do tipo 'ebookFile'
        $existingFile = $this->repository->findByProductId($dto->product_id, 'ebookFile');

        // Se já existir, elimina o ficheiro anterior da S3
        if ($existingFile && $existingFile->file) {
            $this->uploadFile->removeFile($existingFile->file);
        }

        // Upload do novo ficheiro, se fornecido
        if ($dto->file) {
            // Gera um nome único para o ficheiro com slug, id do produto e extensão
            $customImageName = Str::of($dto->name)->slug('-') . '-' . $dto->product_id . '.' . $dto->file->getClientOriginalExtension();

            // Armazena o ficheiro e retorna o caminho
            $uploadedFilePath = $this->uploadFile->storeAs($dto->file, 'products/files/docs', $customImageName);

            // Verifica se o upload foi bem-sucedido
            if (!$uploadedFilePath) {
                throw new \Exception('Falha ao fazer o upload do ficheiro.');
            }

            // Atualiza o caminho do ficheiro no DTO
            $dto->file = $uploadedFilePath;
        }

        // Cria o registo do ebook na base de dados
        return $this->repository->createDocFile($dto);
    }

}
