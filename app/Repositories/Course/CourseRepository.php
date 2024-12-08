<?php

namespace App\Repositories\Course;

use App\DTO\Course\CreateCourseDTO;
use App\DTO\Course\UpdateCourseDTO;
use App\DTO\Course\UpdatePublishedDTO;
use App\Enum\ProductTypeEnum;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\PaginationPresenter;
use App\Repositories\PaginationInterface;
use Carbon\Carbon;
use Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;

class CourseRepository implements CourseRepositoryInterface
{
    public function __construct(
        protected Product $entity,
        protected Category $category
    ) {
    }

    public function paginate(int $page = 1, int $totalPerPage  = 10, string $filter = null): PaginationInterface
    {
        // Construir a consulta inicial com as relações necessárias e o tipo 'CURSO'
        $query = $this->entity
                      ->where('product_type', 'course')
                      ->with('user', 'users', 'sales', 'files')
                      ->userByAuth();

        // Aplicar o filtro se fornecido
        if ($filter) {
            $query->where(function ($query) use ($filter) {
                $query->where('name', 'like', "%{$filter}%");
            });
        }

        // Paginar os resultados
        $result = $query->paginate($totalPerPage, ['*'], 'page', $page);

        // Retornar os resultados paginados usando o PaginationPresenter
        return new PaginationPresenter($result);
    }

    public function getProducts(
        int $page = 1,
        int $totalPerPage  = 10,
        string $type = '',
        string $startDate = null,
        string $endDate = null,
        string $filter = null
    ): PaginationInterface {
        // Inicializa a consulta com as relações necessárias
        $query = $this->entity
                      ->with(['files'])
                      ->userByAuth();

        // Aplicar filtro por status
        if ($type) {
            $statusEnum = ProductTypeEnum::tryFrom($type);

            if ($statusEnum) {
                $query->where('product_type', $statusEnum->name);
            }
        }

        // Converter datas para o formato americano (yyyy-mm-dd)
        if ($startDate) {
            $startDate = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
        }

        // Filtro por intervalo de datas (se start_date e end_date forem fornecidos)
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->where('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }

        // Filtro pelo nome do usuário
        if ($filter) {
            $query->where('name', 'like', "%{$filter}%");
        };

        // Realiza a paginação com os parâmetros fornecidos
        $result = $query->paginate($totalPerPage, ['*'], 'page', $page);

        $totalUsers = 0;

        // Processa cada produto para adicionar os cálculos necessários
        $products = $result->getCollection()->map(function ($product) use (&$totalUsers) {
            // Calcula o total de membros
            $totalMembers = $product->users->count();

            // Soma o total de utilizadores
            $totalUsers += $totalMembers;

            // Calcula o preço de venda (considera o primeiro valor de sales)
            $salePrice = $product->sales->first()->sale_price ?? 0;

            // Calcula a receita total
            $totalRevenue = $totalMembers * $salePrice;

            // Filtra e categoriza imagens por tipo
            $files = $product->files
                            ->filter(fn ($file) => in_array($file->type, ['ebookImage', 'courseImage', 'fileImage']))
                            ->map(fn ($file) => [
                                'id' => $file->id,
                                'type' => $file->type,
                                'image' => $file->image,
                            ])
                            ->values()
                            ->toArray();

            return (object) [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'product_type' => $product->product_type,
                'created_at' => $product->created_at,
                'files' => $files,
                'total_members' => $totalMembers,
                'sale_price' => $salePrice,
                'total_revenue' => $totalRevenue,
            ];
        });

        // Substitui a coleção original com os produtos processados
        $result->setCollection($products);

        $result->total_users = $totalUsers;

        // Retorna os resultados paginados usando o PaginationPresenter
        return new PaginationPresenter($result);
    }

    public function getAllProducts()
    {
        return $this->entity
                    ->userByAuth()
                    ->with('files')
                    ->select(
                        'id',
                        'name',
                        'user_id',
                        'price',
                        'discount',
                        'product_type',
                    )
                    ->get();
    }

    public function getCourseById(string $id): object|null
    {
        return $this->entity
                    ->userByAuth()
                    ->where('product_type', 'course')
                    ->with('modules.lessons', 'user', 'files')
                    ->find($id);
    }

    public function getProductsByUrl(string $url): ?Product
    {
        return $this->entity
                    ->where('url', $url)
                    ->with('user', 'files')
                    ->first();
    }

    public function getCourseByUrl(string $url): ?Product
    {
        return $this->entity
                    ->where('url', $url)
                    ->where('product_type', 'course')
                    ->with('modules.lessons', 'user', 'files')
                    ->first();

    }

    public function fetchAllCoursesByProducers(int $page = 1, int $totalPerPage  = 10, string $filter = null, $producerName = null, string $categoryName = null): PaginationInterface
    {
        // Construir a consulta inicial com as relações necessárias e o tipo 'CURSO'
        $query = $this->entity
                    ->where('product_type', 'course')
                    ->where('published', 1)
                    ->with(['user:id,name,email,profile_photo_path', 'files'])
                    ->select(
                        'id',
                        'name',
                        'url',
                        'user_id',
                        'category_id',
                        'total_hours',
                        'published',
                        'price',
                        'affiliationPercentage',
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

    public function new(CreateCourseDTO $dto): Product
    {
        return $this->entity->create((array) $dto);
    }

    public function update(UpdateCourseDTO $dto): ?Product
    {
        $course = $this->findById($dto->id);

        if ($course) {
            $course->update((array) $dto);
            return $course;
        }

        return null;
    }

    public function publishedCourse(UpdatePublishedDTO $dto): ?Product
    {
        $course = $this->findById($dto->id);

        if ($course) {
            $course->update((array) $dto);
            return $course;
        }

        return null;
    }

    public function findById(string $id): object|null
    {
        return $this->entity->find($id);
    }

    public function delete(string $id): void
    {
        try {
            $course = $this->entity->findOrFail($id);

            if (Gate::authorize('owner-course', $course)) {
                $course->delete();
            }
        } catch (ModelNotFoundException $e) {

            throw new FileNotFoundException("Curso não encontrado");

        } catch (Exception $e) {
            throw new Exception("Erro ao eliminar o curso");
        }
    }


    public function getCoursesForModuleCreation(): array
    {
        return $this->entity
                    ->userByAuth()
                    ->pluck('name', 'id')
                    ->all()->toArray();
    }

}
