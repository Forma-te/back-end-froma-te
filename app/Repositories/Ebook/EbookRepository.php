<?php

namespace App\Repositories\Ebook;

use App\DTO\Ebook\CreateEbookDTO;
use App\DTO\Ebook\UpdateEbookDTO;
use App\Models\Product;
use App\Repositories\PaginationPresenter;
use App\Repositories\PaginationInterface;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class EbookRepository implements EbookRepositoryInterface
{
    protected $entity;

    public function __construct(Product $model)
    {
        $this->entity = $model;
    }

    public function paginate(int $page = 1, int $totalPerPage  = 15, string $filter = null): PaginationInterface
    {
        // Construir a consulta inicial com as relações necessárias e o tipo 'Ebook'
        $query = $this->entity
                    ->where('product_type', 'ebook')
                    ->userByAuth();

        // Aplicar o filtro se fornecido
        if ($filter) {
            $query->where(function ($query) use ($filter) {
                $query->where('name', 'like', "%{$filter}%");
            });
        }
        // Paginar os resultados
        $result = $query->with('user', 'users', 'sales', 'files')->paginate($totalPerPage, ['*'], 'page', $page);


        // Retornar os resultados paginados usando o PaginationPresenter
        return new PaginationPresenter($result);
    }

    public function fetchAllEbooksByProducers(int $page = 1, int $totalPerPage  = 15, string $filter = null, $producerName = null, string $categoryName = null): PaginationInterface
    {
        // Construir a consulta inicial com as relações necessárias e o tipo 'CURSO'
        $query = $this->entity
                    ->where('product_type', 'ebook')
                    ->where('published', 1)
                    ->with(['user:id,name,email,profile_photo_path', 'category:id,name', 'files'])
                    ->select(
                        'id',
                        'name',
                        'user_id',
                        'category_id',
                        'image',
                        'total_hours',
                        'published',
                        'price',
                        'discount',
                        'product_type',
                        'created_at'
                    )
                    ->orderBy('updated_at', 'desc');

        // Filtrar pelo nome do curso (se fornecido)
        if ($filter) {
            $query->where('name', 'like', "%{$filter}%");
        }

        // Filtrar pelo nome do produtor (user)
        if ($producerName) {
            $query->whereHas('user', function ($query) use ($producerName) {
                $query->where('name', 'like', "%{$producerName}%");
            });
        }

        // Filtrar pelo nome da categoria
        if ($categoryName) {
            $query->whereHas('category', function ($query) use ($categoryName) {
                $query->where('name', 'like', "%{$categoryName}%");
            });
        }

        // Paginar os resultados
        $result = $query->paginate($totalPerPage, ['*'], 'page', $page);

        // Retornar os resultados paginados usando o PaginationPresenter
        return new PaginationPresenter($result);
    }

    public function new(CreateEbookDTO $dto): Product
    {
        return $this->entity->create((array) $dto);

    }

    public function update(UpdateEbookDTO $dto): ?Product
    {
        $ebook = $this->getEbookById($dto->id);

        if ($ebook) {
            $ebook->update((array) $dto);
            return $ebook;
        }

        return null; // Retorna null se o eBook não for encontrado
    }

    public function getEbookById(string $id): object|null
    {
        return $this->entity
                    ->userByAuth()
                    ->where('product_type', 'ebook')
                    ->with('user', 'files')
                    ->find($id);
    }

    public function getEbookByUrl(string $url): ?Product
    {
        return $this->entity
                    ->where('url', $url)
                    ->where('product_type', 'ebook')
                    ->with('user', 'files')
                    ->first();
    }

    public function findById(string $id): object|null
    {
        return $this->entity->find($id);
    }

    public function delete(string $id): void
    {
        try {
            $ebook = $this->entity->findOrFail($id);

            if (Gate::authorize('owner-ebook', $ebook)) {
                $ebook->delete();
            }

        } catch (ModelNotFoundException $e) {

            throw new FileNotFoundException("Curso não encontrado");

        } catch (Exception $e) {
            throw new Exception("Erro ao eliminar o curso");
        }

    }

}
