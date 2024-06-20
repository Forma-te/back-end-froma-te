<?php

namespace App\Repositories\Course;

use App\DTO\Course\CreateCourseDTO;
use App\DTO\Course\UpdateCourseDTO;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\PaginationPresenter;
use App\Repositories\PaginationInterface;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use stdClass;

class CourseRepository implements CourseRepositoryInterface
{
    protected $entity;

    public function __construct(Course $model)
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
        $result = $query->with('users')->paginate($totalPerPage, ['*'], 'page', $page);

        // Retornar os resultados paginados usando o PaginationPresenter
        return new PaginationPresenter($result);
    }

    public function new(CreateCourseDTO $dto): Course
    {
        return $this->entity->create((array) $dto);
    }

    public function update(UpdateCourseDTO $dto): ?Course
    {
        $course = $this->entity->find($dto->id);

        if ($course && Gate::authorize('owner-course', $course)) {
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
            // Lidar com o caso onde o curso não foi encontrado
            // Pode-se lançar uma exceção personalizada ou apenas registrar o erro
            throw new FileNotFoundException("Curso não encontrado");
        } catch (\Exception $e) {
            // Lidar com outras possíveis exceções
            // Pode-se lançar uma exceção personalizada ou apenas registrar o erro
            throw new \Exception("Erro ao eliminar o curso");
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
