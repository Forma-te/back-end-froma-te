<?php

namespace App\Repositories\Course;

use App\DTO\Course\CreateCourseDTO;
use App\DTO\Course\UpdateCourseDTO;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\PaginationPresenter;
use App\Repositories\PaginationInterface;
use Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;

class CourseRepository implements CourseRepositoryInterface
{
    protected $entity;

    public function __construct(Product $model)
    {
        $this->entity = $model;
    }

    public function paginate(int $page = 1, int $totalPerPage  = 15, string $filter = null): PaginationInterface
    {
        // Construir a consulta inicial com as relações necessárias e o tipo 'CURSO'
        $query = $this->entity
                      ->where('product_type', 'course')
                      ->with('user', 'users', 'sales')
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

    public function getProducts(int $page = 1, int $totalPerPage  = 15, string $filter = null): PaginationInterface
    {
        // Construir a consulta inicial com as relações necessárias e o tipo 'CURSO'
        $query = $this->entity
                      ->with('user', 'users', 'sales')
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

    public function fetchAllCoursesByProducers(int $page = 1, int $totalPerPage  = 15, string $filter = null, $producerName = null, string $categoryName = null): PaginationInterface
    {
        // Construir a consulta inicial com as relações necessárias e o tipo 'CURSO'
        $query = $this->entity
                    ->where('product_type', 'course')
                    ->where('published', 1)
                    ->with(['user:id,name,email,profile_photo_path', 'category:id,name'])
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

    public function getCourseById(string $id): object|null
    {
        return $this->entity->with('modules.lessons')->findOrFail($id);
    }

    public function getCoursesForModuleCreation(): array
    {
        return $this->entity
                    ->userByAuth()
                    ->pluck('name', 'id')
                    ->all()->toArray();
    }

    public function getCoursesForAuthenticatedUser(): array
    {
        if (Auth::check()) {
            $loggedInUserId = Auth::id();

            return $this->entity->whereHas('users', function ($query) use ($loggedInUserId) {
                $query->where('users.id', $loggedInUserId);
            })->whereHas('sales', function ($query) {

                $query->where('sales.status', 'approved');
            })->with('modules.lessons.views')->get();

        } else {
            return [];
        }
    }

}
