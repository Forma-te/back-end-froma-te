<?php

namespace App\Repositories\Eloquent;

use App\DTO\Course\CreateCourseDTO;
use App\DTO\Course\UpdateCourseDTO;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\PaginationPresenter;
use App\Repositories\PaginationInterface;
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
        $result = $this->entity
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('name', $filter);
                    $query->orWhere('name', 'like', "%{$filter}%");
                }
            })
            ->paginate($totalPerPage, ['*'], 'page', $page);

        return new PaginationPresenter($result);
    }



    public function getAll(string $filter = ''): array
    {
        if (!empty($filter)) {
            return $this->entity->where('name', 'like', "%{$filter}%")->get()->toArray();
        }
        return $this->entity->all()->toArray();
    }

    public function findById(string $id): object|null
    {
        return $this->entity->find($id);
    }

    public function new(CreateCourseDTO $dto): Course
    {
        return $this->entity->new((array) $dto);
    }

    public function update(UpdateCourseDTO $dto): Course
    {
        $course = $this->entity->find($dto->id);

        if ($course) {
            $course->update((array) $dto);
            return $course;
        }

        return null;
    }

    public function delete(string $id): void
    {
        $this->entity->findOrFail($id)->delete();
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

    public function getCourseById(string $id): object|null
    {
        return $this->entity->with('modules.lessons')->findOrFail($id);
    }
}