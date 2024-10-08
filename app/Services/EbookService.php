<?php

namespace App\Services;

use App\DTO\Ebook\CreateEbookDTO;
use App\DTO\Ebook\UpdateEbookDTO;
use App\Models\Product;
use App\Repositories\Ebook\EbookRepositoryInterface;
use App\Repositories\PaginationInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class EbookService
{
    public function __construct(
        protected EbookRepositoryInterface $repository,
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

    public function new(CreateEbookDTO $dto): Product
    {
         // Processar imagem se existir
         if ($dto->image) {
            $customImageName = $dto->code . '.' . $dto->image->getClientOriginalExtension();
            $uploadedImagePath = $this->uploadFile->storeAs($dto->image, 'Products/Images', $customImageName);
            $dto->image = $uploadedImagePath;
        }

        // Processar ficheiro se existir
        if ($dto->file) {
            $customFileName = $dto->code . '.' . $dto->file->getClientOriginalExtension();
            $uploadedFilePath = $this->uploadFile->storeAs($dto->file, 'Products/Files', $customFileName);
            $dto->file = $uploadedFilePath;
        }

        // Criar o produto
        return $this->repository->new($dto);
    }

    public function findById(string $id): object|null
    {
        return $this->repository->findById($id);
    }

    public function update(UpdateEbookDTO $dto): ?Product
    {
        // Buscar a lição existente
        $ebook = $this->repository->findById($dto->id);

        // Verificar instância da classe UploadedFile
        if ($dto->image instanceof UploadedFile) {
            if ($ebook && $ebook->image) {
                // Remover o ficheiro existente, se houver
                $this->uploadFile->removeFile($ebook->image);
            }
            // Processar o novo ficheiro
            $file = $dto->image;
            $customImageName = Str::of($dto->name)->slug('-') . '.' . $file->getClientOriginalExtension();
            // Armazenar o novo ficheiro e obter o caminho do ficheiro armazenado
            $uploadedFilePath = $this->uploadFile->storeAs($dto->image, 'lessonPdf', $customImageName);

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
}
