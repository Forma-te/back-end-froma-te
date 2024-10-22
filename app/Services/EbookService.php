<?php

namespace App\Services;

use App\DTO\Ebook\CreateEbookDTO;
use App\DTO\Ebook\UpdateEbookDTO;
use App\Models\Product;
use App\Repositories\Ebook\EbookRepositoryInterface;
use App\Repositories\PaginationInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
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

    public function fetchAllEbooksByProducers(
        int $page = 1,
        int $totalPerPage  = 15,
        string $filter = null,
        string $producerName = null,
        string $categoryName = null
    ): PaginationInterface {
        return $this->repository->fetchAllEbooksByProducers(
            page: $page,
            totalPerPage: $totalPerPage,
            filter: $filter,
            producerName: $producerName,
            categoryName: $categoryName
        );
    }

    public function new(CreateEbookDTO $dto): Product
    {
        // Criar o produto utilizando o repositório
        return $this->repository->new($dto);
    }

    public function findById(string $id): object|null
    {
        return $this->repository->findById($id);
    }

    public function update(UpdateEbookDTO $dto): ?Product
    {
        $ebook = $this->repository->findById($dto->id);

        if ($ebook && Gate::allows('owner-ebook', $ebook)) {
            // Atualizar imagem se uma nova foi enviada

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
