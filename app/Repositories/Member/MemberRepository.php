<?php

namespace App\Repositories\Member;

use App\DTO\Product\CourseByIdDTO;
use App\DTO\Product\CourseDTO;
use App\DTO\Product\EbookByIdDTO;
use App\DTO\Product\EbookDTO;
use App\DTO\Product\FileByIdDTO;
use App\DTO\Product\FileDTO;
use App\Models\Product;
use App\Repositories\PaginationInterface;
use App\Repositories\PaginationPresenter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MemberRepository
{
    protected $entity;

    public function __construct(Product $model)
    {
        $this->entity = $model;
    }

    public function getAllProductsMember(
        int $page = 1,
        int $totalPerPage = 10,
        string $filter = null
    ): PaginationInterface {
        if (!Auth::check()) {
            // Retorna uma instância vazia de PaginationPresenter se o utilizador não estiver autenticado
            return new PaginationPresenter(collect([])->paginate($totalPerPage, ['*'], 'page', $page));
        }

        $loggedInUserId = Auth::id();

        $query = $this->entity
            ->whereHas('users', function ($query) use ($loggedInUserId) {
                $query->where('users.id', $loggedInUserId);
            });

        // Aplica o filtro, se fornecido
        if ($filter) {
            $query->where('name', 'like', "%{$filter}%");
        }

        // Carrega os relacionamentos necessários
        $query->with(['files', 'modules.lessons.views']);

        // Pagina os resultados
        $result = $query->paginate($totalPerPage, ['*'], 'page', $page);

        // Transforma os produtos em DTOs com base no tipo
        $data = $result->getCollection()->map(function ($product) {
            return match ($product->product_type) {
                'course' => CourseDTO::fromModel($product),
                'ebook' => EbookDTO::fromModel($product),
                'file' => FileDTO::fromModel($product),
                default => null,
            };
        })->filter();

        // Substitui a coleção paginada pelos DTOs processados
        $result->setCollection($data);

        // Retorna os resultados paginados usando o PaginationPresenter
        return new PaginationPresenter($result);
    }


    public function getProductByIdMember(string $identify)
    {
        if (!Auth::check()) {
            return [];
        }

        $loggedInUserId = Auth::id();

        $result = $this->entity
                        ->where('id', $identify)
                        ->whereHas('users', function ($query) use ($loggedInUserId) {
                            $query->where('users.id', $loggedInUserId);
                        })
                        ->with('files', 'user')
                        ->get();

        return $result->map(function ($product) {
            // Carrega modules.lessons.views apenas para produtos do tipo 'course'
            if ($product->product_type === 'course') {
                $product->load('modules.lessons.views');
            }

            return match ($product->product_type) {
                'course' => CourseByIdDTO::fromModel($product),
                'ebook' => EbookByIdDTO::fromModel($product),
                'file' => FileByIdDTO::fromModel($product),
                default => null,
            };
        })->filter()->toArray();
    }

}
