<?php

namespace App\Repositories\EbookContent;

use App\DTO\EbookContent\CreateEbookContentDTO;
use App\DTO\EbookContent\UpdateEbookContentDTO;
use App\Repositories\PaginationInterface;
use App\Repositories\PaginationPresenter;
use App\Models\Ebook;
use App\Models\EbookContent;
use Illuminate\Support\Facades\Gate;

class EbookContentRepository implements EbookContentRepositoryInterface
{
    protected $entity;
    protected $ebook;

    public function __construct(EbookContent $model, Ebook $ebook)
    {
        $this->entity = $model;
        $this->ebook = $ebook;
    }

    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface
    {
        $query = $this->entity;

        // Aplicar o filtro se fornecido
        if ($filter) {
            $query->where(function ($query) use ($filter) {
                $query->where('name', $filter)
                      ->orWhere('name', 'like', "%{$filter}%");
            });
        }

        // Paginar os resultados
        $result = $query->paginate($totalPerPage, ['*'], 'page', $page);

        // Retornar os resultados paginados usando o PaginationPresenter
        return new PaginationPresenter($result);
    }

    public function findById(string $id): object|null
    {
        return $this->entity->find($id);
    }

    public function getContentByEbookId(string $ebookId): ?array
    {
        $ebook = $this->ebook->find($ebookId);

        if (is_null($ebook)) {
            return [];
        }

        $ebookContent = $ebook->ebookContents()->get();

        return $ebookContent->toArray();

    }

    public function new(CreateEbookContentDTO $dto): EbookContent
    {
        return $this->entity->create((array) $dto);

    }

    public function update(UpdateEbookContentDTO $dto): ?EbookContent
    {
        $ebookContent = $this->entity->find($dto->id);

        if ($ebookContent) {
            $ebookContent->update((array) $dto);
            return $ebookContent;
        }

        return null;
    }

    public function delete(string $id): void
    {
        $this->entity->findOrFail($id)->delete();
    }

}
