<?php

namespace App\Repositories\Ebook;

use App\DTO\Ebook\CreateEbookDTO;
use App\DTO\Ebook\UpdateEbookDTO;
use App\Models\Ebook;

use App\Repositories\PaginationPresenter;
use App\Repositories\PaginationInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EbookRepository implements EbookRepositoryInterface
{
    protected $entity;

    public function __construct(Ebook $model)
    {
        $this->entity = $model;
    }

    public function paginate(int $page = 1, int $totalPerPage  = 15, string $filter = null): PaginationInterface
    {
        // Construir a consulta inicial com as relações necessárias e o tipo 'CURSO'
        $query = $this->entity
                ->userByAuth();

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

    public function new(CreateEbookDTO $dto): Ebook
    {
        return $this->entity->create((array) $dto);

    }

    public function update(UpdateEbookDTO $dto): ?Ebook
    {
        $ebook = $this->entity->find($dto->id);

        Gate::authorize('owner-ebook', $ebook);

        if ($ebook) {
            $ebook->update((array) $dto);
            return $ebook;
        }

        return null;
    }

    public function findById(string $id): object|null
    {
        return $this->entity->find($id);
    }

    public function delete(string $id): void
    {
        $this->entity->findOrFail($id)->delete();

    }

}
